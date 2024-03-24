<?php

namespace App\Http\Controllers\Backend;

use App\Models\Media;
use App\Models\Category;
use App\Models\Template;
use App\Models\OutOfStock;
use App\Models\MailChannel;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use App\Models\EmailChannel;
use Illuminate\Http\Request;
use App\Mail\TicketReplyMail;
use App\Models\GamingAccount;
use App\Models\SubSubcategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
  public function index()
  {
      $user = Auth::user();
      $can = false;
      if ($user->role_id != 1 && $user->role_id != 2) {
          $can = true;
      }
      if ($can) {
          $totalAccount = Template::where('created_by', $user->id)->count();
      } else {
          $totalAccount = Template::count();
      }
      return view('backend.templates.index', compact('totalAccount'));
  }

  public function list(Request $request)
  {
      try {
          $user = Auth::user();
          $can = false;
          if ($user->role_id != 1 && $user->role_id != 2) {
              $can = true;
          }
          if ($can) {
              $totalData = Template::where('created_by', $user->id)->count();
          } else {
              $totalData = Template::count();
          }
          $totalFiltered = $totalData;

          $limit = $request->input('length');
          $start = $request->input('start');
          $order = 'id';
          $dir = $request->input('order.0.dir');
          if (empty($request->input('search.value'))) {
              if ($can) {
                  $results = Template::where('created_by', $user->id)
                      ->offset($start)
                      ->limit($limit)
                      ->orderBy($order, $dir)
                      ->get();
              } else {
                  $results = Template::offset($start)
                      ->limit($limit)
                      ->orderBy($order, $dir)
                      ->get();
              }
          } else {
              $search = $request->input('search.value');

              if ($can) {
                  $results = Template::where('created_by', $user->id)
                      ->search($search)
                      ->offset($start)
                      ->limit($limit)
                      ->orderBy($order, $dir)
                      ->get();
              } else {
                  $results = Template::search($search)
                      ->offset($start)
                      ->limit($limit)
                      ->orderBy($order, $dir)
                      ->get();
              }

              $totalFiltered = count($results);
          }

          $data = array();
          if (!empty($results)) {
              foreach ($results as $row) {
                  if ($row->status == 'active') {
                      $st = 'btn-warning';
                      $status = 'inactive';
                  } elseif ($row->status == 'inactive') {
                      $st = 'btn-success';
                      $status = 'active';
                  }
                  $nestedData['id'] = $row->id;
                  $nestedData['title'] = $row->title;
                  $nestedData['price'] = $row->price;
                  $nestedData['category'] = $row->category->name;
                  $nestedData['status'] = $row->status;
                  $nestedData['product_status'] = $row->product_status;
                  $nestedData['action'] = view('backend.templates._actions', [
                      'row' => $row,
                      'st' => $st,
                      'status' => $status
                  ])->render();
                  $data[] = $nestedData;
              }
          }

          $json_data = array(
              "draw"            => intval($request->input('draw')),
              "recordsTotal"    => intval($totalData),
              "recordsFiltered" => intval($totalFiltered),
              "data"            => $data
          );

          echo json_encode($json_data);
      } catch (\Throwable $th) {
          throw $th;
      } catch (\Exception $e) {
          throw $e;
      }
  }

  public function new()
  {
      $user = Auth::user();
      $can = false;
      $categories = [];
      $sub_categories = [];
      $sub_subcategories = [];
      if ($user->role_id != 1 && $user->role_id != 2) {
          $can = true;
      }
      if ($can) {
          $permissions = $user->role->rolePermissions;
          $categoriesAllowed = [];
          foreach ($permissions as $p) {
              if ($p->permission->type == 'Category') {
                  $categoriesAllowed[] = $p->permission->name;
              }
          }
          $categories = Category::whereIn('name', $categoriesAllowed)->get();
          $categoriesAllowed = [];
          foreach ($permissions as $p) {
              if ($p->permission->type == 'Sub Category') {
                  $categoriesAllowed[] = $p->permission->name;
              }
          }
          $sub_categories = SubCategory::whereIn('name', $categoriesAllowed)->get();
          $categoriesAllowed = [];
          foreach ($permissions as $p) {
              if ($p->permission->type == 'Sub Sub Category') {
                  $categoriesAllowed[] = $p->permission->name;
              }
          }
          $sub_subcategories = SubSubCategory::whereIn('name', $categoriesAllowed)->get();
      } else {
          $categories = Category::get();
          $sub_categories = SubCategory::get();
          $sub_subcategories = SubSubcategory::get();
      }
      return view('backend.templates.add', compact('categories', 'sub_categories', 'sub_subcategories'));
  }

  public function add(Request $request)
  {
      $request->validate([
          'title' => 'required',
          'description' => 'required',
          'price' => 'required',
          'discount' => 'required',
          'status' => 'required',
          'sku' => 'required',
          'meta_title' => 'required',
          'meta_description' => 'required',
          'meta_keywords' => 'required',
          'category' => 'required',
          'sub_category' => 'required',
          'sub_subcategory' => 'required',
          'channel_status.*' => 'required',
          'file_limit' => 'required',
          'min_quantity' => 'required',
          'max_quantity' => 'required',
          'images.*' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
          'main_image' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
          'long_image' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
          'images' => 'max:10'
      ]);

      $gamingAccount = new Template;
      $gamingAccount->created_by = Auth::user()->id;
      $gamingAccount->title = $request->title;
      $gamingAccount->sku = $request['sku'];
      $gamingAccount->price = $request['price'];
      $gamingAccount->discount = $request['discount'];
      $gamingAccount->stock = 0;
      $gamingAccount->status = $request['status'];
      $gamingAccount->custom_stock = $request['custom_stock'];
      $gamingAccount->options = $request['options'];
      $gamingAccount->product_status = 'available';
      $gamingAccount->category_id = $request['category'];
      $gamingAccount->sub_category_id = $request['sub_category'];
      $gamingAccount->sub_subcategory_id = $request['sub_subcategory'];
      $gamingAccount->meta_title = $request['meta_title'];
      $gamingAccount->description = $request['description'];
      $gamingAccount->meta_keywords = $request['meta_keywords'];
      $gamingAccount->meta_description = $request['meta_description'];
      $gamingAccount->file_limit = $request['file_limit'];
      $gamingAccount->min_quantity = $request['min_quantity'];
      $gamingAccount->max_quantity = $request['max_quantity'];

      $gamingAccount->main_image = $request['main_image'];
      $gamingAccount->long_image = $request['long_image'];
      $gamingAccount->manual = $request->has('manual') ? 1 : 0;
      $gamingAccount->private = $request->has('private') ? 1 : 0;
      if ($gamingAccount->private == '1') {
        $gamingAccount->random_string_for_private = Str::random(50);
      }


      $gamingAccount->save();

      // $temp = true;
      // if ($request['email'][0] != null) {
      //     foreach ($request['email'] as $index => $email) {
      //         $emailChannel = new EmailChannel();
      //         $emailChannel->password = $request['password'][$index];
      //         $emailChannel->status = $request['channel_status'][$index];
      //         $emailChannel->email = $email;
      //         $gamingAccount->emailChannels()->save($emailChannel);
      //         if ($request['channel_status'][$index] == 'available') {
      //             $temp = false;
      //         }
      //     }
      // }

      $stock_delimiter = $request['stock_delimiter'];
      if ($stock_delimiter == 'comma') {
          $stock_delimiter = ",";
      } else if ($stock_delimiter == 'newline') {
          $stock_delimiter = "\n";
      } else if ($stock_delimiter == 'custom') {
          $stock_delimiter = $request['custom_stock_delimiter'];
      }
        $stock_list_str = $request['stock_list'];
        $file_count = $request['file_limit'] == -1 ? 1 : $request['file_limit'];

        if ($stock_list_str != '') {
            // Split the input by newline to handle multiple records
            $stock_list = explode("\n", $stock_list_str);

            // If there's only one record, treat it as a single record
            if (count($stock_list) == 1) {
                $row = $stock_list[0];
                $emailChannel = new MailChannel();

                $emailChannel->format = $request['format'];
                $emailChannel->value1 = trim($row);
                $emailChannel->delimiter = $stock_delimiter;
                $emailChannel->checkbox_value = $request['check_box_value'] ? 1 : 0;
                $emailChannel->status = "available";

                // Handle file upload
                if ($request->hasFile('file') && $file_count > 0) {
                    $file = $request->file('file');
                    $fileName = Str::random(8) . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
                    $fileValue = Storage::putFileAs('channel_files/', $file, $fileName);
                    $emailChannel->file = $fileValue;

                    if ($request['file_limit'] != -1) {
                        $file_count--;
                    }
                }
                // Save the EmailChannel to the database
                $gamingAccount->mailChannels()->save($emailChannel);
            } else {
                // If there are multiple records, process each one
                foreach ($stock_list as $row) {
                    // Skip empty lines
                    if (empty($row)) {
                        continue;
                    }

                    $emailChannel = new MailChannel();

                    $emailChannel->format = $request['format'];
                    $emailChannel->value1 = trim($row);
                    $emailChannel->delimiter = $stock_delimiter;
                    $emailChannel->status = "available";

                    $fields = explode($stock_delimiter, $row);

                    if (count($fields) > 1) {
                        $emailChannel->value2 = trim($fields[1]);
                    }
                    if (count($fields) > 2) {
                        $emailChannel->value3 = trim($fields[2]);
                    }
                    if (count($fields) > 3) {
                        $emailChannel->value4 = trim($fields[3]);
                    }
                    if (count($fields) > 4) {
                        $emailChannel->value5 = trim($fields[4]);
                    }
                    if (count($fields) > 5) {
                        $emailChannel->value6 = trim($fields[5]);
                    }
                    if (count($fields) > 6) {
                        $emailChannel->value7 = trim($fields[6]);
                    }
                    if (count($fields) > 7) {
                        $emailChannel->value8 = trim($fields[7]);
                    }

                    // Handle file upload
                    if ($request->hasFile('file') && $file_count > 0) {
                        $file = $request->file('file');
                        $fileName = Str::random(8) . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
                        $fileValue = Storage::putFileAs('channel_files/', $file, $fileName);
                        $emailChannel->file = $fileValue;

                        if ($request['file_limit'] != -1) {
                            $file_count--;
                        }
                    }

                    // Save the EmailChannel to the database
                    $gamingAccount->mailChannels()->save($emailChannel);
                }
            }
        }

      // if ($temp) {
      //     $gamingAccount->product_status = 'sold';
      // } else {
      //     $gamingAccount->product_status = 'available';
      // }
      $gamingAccount->save();

      if ($request->hasFile('images')) {
          foreach ($request->images as $image) {
              $media = new Media();
              $media->image = $image;
              $gamingAccount->medias()->save($media);
          }
      }

      return redirect()->route('admin.templates.')->with('success', 'Template added successfully!');
  }

  public function edit($id)
  {
      $user = Auth::user();
      $can = false;
      $categories = [];
      $sub_categories = [];
      $sub_subcategories = [];
      if ($user->role_id != 1 && $user->role_id != 2) {
          $can = true;
      }
      if ($can) {
          $permissions = $user->role->rolePermissions;
          $categoriesAllowed = [];
          foreach ($permissions as $p) {
              if ($p->permission->type == 'Category') {
                  $categoriesAllowed[] = $p->permission->name;
              }
          }
          $categories = Category::whereIn('name', $categoriesAllowed)->get();
          $categoriesAllowed = [];
          foreach ($permissions as $p) {
              if ($p->permission->type == 'Sub Category') {
                  $categoriesAllowed[] = $p->permission->name;
              }
          }
          $sub_categories = SubCategory::whereIn('name', $categoriesAllowed)->get();
          $categoriesAllowed = [];
          foreach ($permissions as $p) {
              if ($p->permission->type == 'Sub Sub Category') {
                  $categoriesAllowed[] = $p->permission->name;
              }
          }
          $sub_subcategories = SubSubCategory::whereIn('name', $categoriesAllowed)->get();
      } else {
          $categories = Category::get();
          $sub_categories = SubCategory::get();
          $sub_subcategories = SubSubcategory::get();
      }
      $gamingAccount = Template::where('id', $id)->with('mailChannels')->with('medias')->first();
      $emailChannels = mailChannel::where('template_id', $id)->get();
      $format = $emailChannels->isEmpty() ? null : $emailChannels->first()->format;
      $check_box_value = optional($emailChannels->first())->checkbox_value ? 1 : 0;
      $stockTxt = '';
      foreach ($emailChannels as $emailChannel) {
          if ($emailChannel->value1) {
            $stockTxt .= $emailChannel->value1 . PHP_EOL;
          }
      }
      $stockTxt = rtrim($stockTxt, ",");
      return view('backend.templates.edit', compact('categories', 'gamingAccount', 'sub_categories', 'sub_subcategories', 'stockTxt','format','check_box_value'));
  }

  public function update(Request $request)
  {
      $request->validate([
          'id' => 'required',
          'title' => 'required',
          'description' => 'required',
          'price' => 'required',
          'discount' => 'required',
          'status' => 'required',
          'sku' => 'required',
          'meta_title' => 'required',
          'meta_description' => 'required',
          'meta_keywords' => 'required',
          'category' => 'required',
          'sub_category' => 'required',
          'sub_subcategory' => 'required',
          'file_limit' => 'required',
          'min_quantity' => 'required',
          'max_quantity' => 'required',
          'images.*' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
          'main_image' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
          'long_image' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
          'images' => 'max:10',
      ]);

      $user = Auth::user();
      $can = false;
      if ($user->role_id != 1 && $user->role_id != 2) {
          $can = true;
      }
      if ($can) {
          $gamingAccount = Template::where('id', $request->id)->where('created_by', $user->id)->first();
      } else {
          $gamingAccount = Template::findOrFail($request->id);
      }
      $gamingAccount->title = $request->title;
      $gamingAccount->sku = $request['sku'];
      $gamingAccount->price = $request['price'];
      $gamingAccount->discount = $request['discount'];
      $gamingAccount->options = $request['options'];
      $gamingAccount->status = $request['status'];
      $gamingAccount->custom_stock = $request['custom_stock'];
      $gamingAccount->category_id = $request['category'];
      $gamingAccount->sub_category_id = $request['sub_category'];
      $gamingAccount->sub_subcategory_id = $request['sub_subcategory'];
      $gamingAccount->meta_title = $request['meta_title'];
      $gamingAccount->description = $request['description'];
      $gamingAccount->meta_keywords = $request['meta_keywords'];
      $gamingAccount->meta_description = $request['meta_description'];
      $gamingAccount->file_limit = $request['file_limit'];
      $gamingAccount->min_quantity = $request['min_quantity'];
      $gamingAccount->max_quantity = $request['max_quantity'];
      $gamingAccount->manual = $request->has('manual') ? 1 : 0;

      if ($request->hasFile('main_image')) {
          $gamingAccount->main_image = $request['main_image'];
      }
      if ($request->hasFile('long_image')) {
          $gamingAccount->long_image = $request['long_image'];
      }

      $gamingAccount->save();
      $temp = true;

      foreach ($gamingAccount->mailChannels as $channel) {
          $filePath = $channel->file;
          if ($filePath != null) {
              if (Storage::exists($filePath)) {
                  Storage::delete($filePath);
              }
          }
      }

      $gamingAccount->mailChannels()->delete();
      // if ($request['email'][0] != null) {
      //     foreach ($request['email'] as $index => $email) {
      //         $emailChannel = new EmailChannel();
      //         $emailChannel->password = $request['password'][$index];
      //         $emailChannel->status = $request['channel_status'][$index];
      //         $emailChannel->email = $email;
      //         $gamingAccount->emailChannels()->save($emailChannel);
      //         if ($request['channel_status'][$index] == 'available') {
      //             $temp = false;
      //         }
      //     }
      // }

      $stock_delimiter = $request['stock_delimiter'];
      if ($stock_delimiter == 'comma') {
          $stock_delimiter = ",";
      } else if ($stock_delimiter == 'newline') {
          $stock_delimiter = "\n";
      } else if ($stock_delimiter == 'custom') {
          $stock_delimiter = $request['custom_stock_delimiter'];
      }

      $stock_list_str = $request['stock_list'];
      $file_count = $request['file_limit'] == -1 ? 1 : $request['file_limit'];
      if ($stock_list_str != '') {
          $stock_list = explode($stock_delimiter, $stock_list_str);
          foreach ($stock_list as $row) {
              $check = false;
              $fields = explode("|", $row);
              $emailChannel = new mailChannel();
              if (count($fields) > 0) {
                  $emailChannel->value1 = trim($fields[0]);
                  $emailChannel->status = "available";
                  $check = true;
                  $temp = false;
              }
              if (count($fields) > 1) {
                  $emailChannel->value2 = trim($fields[1]);
              }
              if (count($fields) > 2) {
                  $emailChannel->value3 = trim($fields[2]);
              }
              if (count($fields) > 3) {
                  $emailChannel->value4 = trim($fields[3]);
              }
              if (count($fields) > 4) {
                  $emailChannel->value5 = trim($fields[4]);
              }
              if (count($fields) > 5) {
                  $emailChannel->value6 = trim($fields[5]);
              }
              if (count($fields) > 6) {
                  $emailChannel->value7 = trim($fields[6]);
              }
              if (count($fields) > 7) {
                  $emailChannel->value8 = trim($fields[7]);
              }
              if ($check) {
                  if ($request->hasFile('file') && $file_count > 0) {
                      $file = $request->file('file');
                      $fileName = Str::random(8) . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
                      $fileValue = Storage::putFileAs('channel_files/', $file, $fileName);
                      $emailChannel->file = $fileValue;
                      if ($request['file_limit'] != -1) {
                          $file_count--;
                      }
                  }
                  $gamingAccount->mailChannels()->save($emailChannel);
              }
          }
      }

      if (!$temp && $gamingAccount->product_status == 'sold') {
          $outOfStocks = OutOfStock::where('product_id', $gamingAccount->id)->get();
          foreach ($outOfStocks as $outOfStock) {
              Mail::to($outOfStock->email)->send(new TicketReplyMail($gamingAccount->title, $gamingAccount->title . ' is back in stock.', $gamingAccount->title . ' you visited earlier on our website was out of stock is available now.'));
          }
      }

      if ($temp) {
          $gamingAccount->product_status = 'sold';
      } else {
          $gamingAccount->product_status = 'available';
      }
      $gamingAccount->save();

      if ($request->image_to_remove) {
          $imageIds = explode(',', $request->image_to_remove);
          foreach ($imageIds as $imageId) {
              $media = Media::find($imageId);
              if ($media) {
                  $media->delete();
              }
          }
      }

      if ($request->hasFile('images')) {
          foreach ($request->images as $image) {
              $media = new Media();
              $media->image = $image;
              $gamingAccount->medias()->save($media);
          }
      }

      return redirect()->route('admin.templates.')->with('success', 'Templates updated successfully!');
  }

  public function status(Request $request)
  {
      try {
          $user = Auth::user();
          $can = false;
          if ($user->role_id != 1 && $user->role_id != 2) {
              $can = true;
          }
          if ($can) {
              $data = Template::where('id', $request->id)->where('created_by', $user->id)->first();
          } else {
              $data = Template::find($request->id);
          }
          if ($data->status == 'active') {
              $data->status = 'inactive';
          } else {
              $data->status = 'active';
          }
          $data->save();
          return response()->json('Success');
      } catch (\Throwable $th) {
          throw $th;
      }
  }

  public function delete($id)
  {
      try {
          $user = Auth::user();
          $can = false;
          if ($user->role_id != 1 && $user->role_id != 2) {
              $can = true;
          }
          if ($can) {
              $data = Template::where('id', $id)->where('created_by', $user->id)->first();
          } else {
              $data = Template::find($id);
          }
          foreach ($data->mailChannels as $channel) {
              $filePath = $channel->file;
              if ($filePath != null) {
                  if (Storage::exists($filePath)) {
                      Storage::delete($filePath);
                  }
              }
          }
          $data->delete();
          return response()->json('Success');
      } catch (\Throwable $th) {
          throw $th;
      }
  }

  public function details($id)
  {
      try {
          $user = Auth::user();
          $can = false;
          if ($user->role_id != 1 && $user->role_id != 2) {
              $can = true;
          }
          if ($can) {
              $gamingAccount = Template::where('id', $id)->where('created_by', $user->id)->with('mailChannels')->get();
          } else {
              $gamingAccount = Template::where('id', $id)->with('mailChannels')->get();
          }
          $emailChannelsData = $gamingAccount->pluck('mailChannels')->collapse()->toArray();
          return response()->json($emailChannelsData);
      } catch (\Throwable $th) {
          throw $th;
      }
  }
}
