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

class GamingAccountController extends Controller
{
   public function index(Request $request)
  {
      $user = Auth::user();
      $can = false;

      if ($user->role_id != 1 && $user->role_id != 2) {
          $can = true;
      }

      if ($can) {
          $totalAccount = GamingAccount::where('created_by', $user->id)->count();
         
      } else {
          $totalAccount = GamingAccount::count();
      }

      return view('backend.gaming_accounts.index', compact('totalAccount'));
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
                $totalData = GamingAccount::where('created_by', $user->id)->count();
            } else {
                $totalData = GamingAccount::count();
            }
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                if ($can) {
                    $results = GamingAccount::where('created_by', $user->id)
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $results = GamingAccount::offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                }
            } else {
                $search = $request->input('search.value');

                if ($can) {
                    $results = GamingAccount::where('created_by', $user->id)
                        ->search($search)
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $results = GamingAccount::search($search)
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
                    $available_channels_count = $row->emailChannels()->where('status', 'available')->count();

                    $nestedData['id'] = $row->id;
                    $nestedData['title'] = $row->title;
                    $nestedData['price'] = $row->price;
                    $nestedData['category'] = $row->category->name;
                    $nestedData['status'] = $row->status;
                    // $nestedData['product_status'] = $row->product_status;
                    $nestedData['available_channels_count'] = $available_channels_count;
                    $nestedData['action'] = view('backend.gaming_accounts._actions', [
                        'row' => $row,
                        'st' => $st,
                        'status' => $status,
                        'available_channels_count' => $available_channels_count,
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

    public function new(Request $request)
    {
        $user = Auth::user();
        $can = false;
        $categories = [];
        $sub_categories = [];
        $sub_subcategories = [];
        if ($user->role_id != 1 && $user->role_id != 2) {
            $can = true;
        }

           $templates = Template::orderBy('id', 'Desc')->get();

            if ($request->ajax()) {
                $templateId = $request->input('templateId');
                $template = Template::find($templateId);
                $category = $template->category;
                $subCategory = $template->sub_category;
                $subSubCategory = $template->sub_subcategory;

                $emailChannels = MailChannel::where('template_id', $templateId)->get();
                $format = $emailChannels->isEmpty() ? null : $emailChannels->first()->format;
                $checkbox_value = $emailChannels->first()->checkbox_value;
                $stockTxt = '';
                foreach ($emailChannels as $emailChannel) {
                    if ($emailChannel->value1) {
                        $stockTxt .= $emailChannel->value1 . PHP_EOL;
                    }
                }
                $stockTxt = rtrim($stockTxt, ",");

                return response()->json([
                    'title' => $template->title,
                    'description' => $template->description,
                    'price' => $template->price,
                    'discount' => $template->discount,
                    'sku' => $template->sku,
                    'category' => $category->name,
                    'subcategory' => $subCategory->name,
                    'sub_subCategory' => $subSubCategory->name,
                    'status' => $template->status,
                    'options' => $template->options,
                    'main_image' => $template->main_image,
                    'meta_title' => $template->meta_title,
                    'meta_description' => $template->meta_description,
                    'meta_keywords' => $template->meta_keywords,
                    'custom_stock' => $template->custom_stock,
                    'format' => $format,
                    'checkbox_value' => $checkbox_value,
                    'stock_list' => $stockTxt,
                    'manual' => $template->manual,
                    'private' => $template->private,
                ]);
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
        return view('backend.gaming_accounts.add', compact('categories', 'sub_categories', 'sub_subcategories','templates'));
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
        $gamingAccount = GamingAccount::where('id', $id)->with('emailChannels')->with('medias')->first();
        $emailChannels = EmailChannel::where('gaming_account_id', $id)->get();
        $format = $emailChannels->isEmpty() ? null : $emailChannels->first()->format;
        $check_box_value = optional($emailChannels->first())->checkbox_value ? 1 : 0;

        $stockTxt = '';
        foreach ($emailChannels as $emailChannel) {
          if ($emailChannel->value1) {
              $stockTxt .= $emailChannel->value1 . PHP_EOL; // Use PHP_EOL for a newline
          }
      }
        $stockTxt = rtrim($stockTxt, ",");
        return view('backend.gaming_accounts.edit', compact('categories', 'gamingAccount', 'sub_categories', 'sub_subcategories', 'stockTxt','format','check_box_value'));
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
        $gamingAccount = new GamingAccount();
        $gamingAccount->created_by = Auth::user()->id;
        $gamingAccount->temp_id = $request['template'];
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

        $stock_delimiter = $request['stock_delimiter'];
        if ($stock_delimiter == 'comma') {
            $stock_delimiter = ",";
        }else if ($stock_delimiter == 'newline') {
          $stock_delimiter = "\n";
        }else if ($stock_delimiter == 'custom') {
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
                $emailChannel = new EmailChannel();

                $emailChannel->format = $request['format'];
                $emailChannel->value1 = trim($row);
                $emailChannel->delimiter = $stock_delimiter;
                $emailChannel->checkbox_value = $request['check_box_value'] ? 1 : 0;
                $emailChannel->status = "available";

                // Populate other fields as per your existing code

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
                $gamingAccount->emailChannels()->save($emailChannel);
            } else {
                // If there are multiple records, process each one
                foreach ($stock_list as $row) {
                    // Skip empty lines
                    if (empty($row)) {
                        continue;
                    }

                    $emailChannel = new EmailChannel();

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


                    // Populate other fields as per your existing code

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
                    $gamingAccount->emailChannels()->save($emailChannel);
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

        return redirect()->route('admin.gamingaccounts.')->with('success', 'Gaming account added successfully!');
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
            $gamingAccount = GamingAccount::where('id', $request->id)->where('created_by', $user->id)->first();
        } else {
            $gamingAccount = GamingAccount::findOrFail($request->id);
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

        foreach ($gamingAccount->emailChannels as $channel) {
            $filePath = $channel->file;
            if ($filePath != null) {
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
            }
        }

        $gamingAccount->emailChannels()->delete();
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

        $stock_delimiter = $request['stock_delimiter'];
        if ($stock_delimiter == 'comma') {
            $stock_delimiter = ",";
        }else if ($stock_delimiter == 'newline') {
          $stock_delimiter = "\n";
        }else if ($stock_delimiter == 'custom') {
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
                $emailChannel = new EmailChannel();

                $emailChannel->format = $request['format'];
                $emailChannel->value1 = trim($row);
                $emailChannel->delimiter = $stock_delimiter;
                $emailChannel->checkbox_value = $request['check_box_value'] ? 1 : 0;
                $emailChannel->status = "available";

                // Populate other fields as per your existing code

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
                $gamingAccount->emailChannels()->save($emailChannel);
            } else {
                // If there are multiple records, process each one
                foreach ($stock_list as $row) {
                    // Skip empty lines
                    if (empty($row)) {
                        continue;
                    }

                    $emailChannel = new EmailChannel();

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


                    // Populate other fields as per your existing code

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
                    $gamingAccount->emailChannels()->save($emailChannel);
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

        return redirect()->route('admin.gamingaccounts.')->with('success', 'Gaming account updated successfully!');
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
                $data = GamingAccount::where('id', $request->id)->where('created_by', $user->id)->first();
            } else {
                $data = GamingAccount::find($request->id);
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
                $data = GamingAccount::where('id', $id)->where('created_by', $user->id)->first();
            } else {
                $data = GamingAccount::find($id);
            }
            foreach ($data->emailChannels as $channel) {
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
                $gamingAccount = GamingAccount::where('id', $id)->where('created_by', $user->id)->with('emailChannels')->get();
            } else {
                $gamingAccount = GamingAccount::where('id', $id)->with('emailChannels')->get();
            }
            $emailChannelsData = $gamingAccount->pluck('emailChannels')->collapse()->toArray();
            return response()->json($emailChannelsData);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function restock(Request $request)
    {
      $accountId = $request['accountid'];

      $stock_delimiter = $request['stock_delimiter'];
      if ($stock_delimiter == 'comma') {
          $stock_delimiter = ",";
      }else if ($stock_delimiter == 'newline') {
        $stock_delimiter = "\n";
      }else if ($stock_delimiter == 'custom') {
          $stock_delimiter = $request['custom_stock_delimiter'];
      }
      $stock_list_str = $request['stock_list'];
      $gamingAccount = GamingAccount::find($accountId);

      if ($stock_list_str != '') {
          $stock_list = explode("\n", $stock_list_str);

          if (count($stock_list) == 1) {
              $row = $stock_list[0];
              $emailChannel = new EmailChannel();

              $emailChannel->format = $request['format'];
              $emailChannel->value1 = trim($row);
              $emailChannel->delimiter = $stock_delimiter;
              $emailChannel->checkbox_value = $request['check_box_value'] ? 1 : 0;
              $emailChannel->status = "available";

              $gamingAccount->emailChannels()->save($emailChannel);
          }
            else {
              // If there are multiple records, process each one
              foreach ($stock_list as $row) {
                  // Skip empty lines
                  if (empty($row)) {
                      continue;
                  }

                  $emailChannel = new EmailChannel();

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
                  // Save the EmailChannel to the database
                  $gamingAccount->emailChannels()->save($emailChannel);
                }
          }

      }
      return redirect()->route('admin.gamingaccounts.')->with('success', 'Account added successfully!');

    }

}
