<?php

namespace App\Http\Controllers\Backend;

use App\Models\Media;
use App\Models\Category;
use App\Models\KeyChannel;
use App\Models\LicenceKey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LicenceKeyController extends Controller
{
    public function index()
    {
        $totalKeys = LicenceKey::count();
        return view('backend.licence_keys.index', compact('totalKeys'));
    }

    public function list(Request $request)
    {
        try {
            $totalData = LicenceKey::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                $results = LicenceKey::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');

                $results = LicenceKey::search($search)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

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
                    $nestedData['category'] = $row->category->name;
                    $nestedData['status'] = $row->status;
                    $nestedData['product_status'] = $row->product_status;
                    $nestedData['action'] = view('backend.licence_keys._actions', [
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
        $categories = Category::get();
        return view('backend.licence_keys.add', compact('categories'));
    }

    public function edit($id)
    {
        $key = LicenceKey::where('id', $id)->with('keyChannels')->with('medias')->first();
        $categories = Category::get();
        return view('backend.licence_keys.edit', compact('categories', 'key'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'status' => 'required',
            'sku' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            'options' => 'required',
            'category' => 'required',
            'channel_status.*' => 'required',
            'key.*' => 'required',
            'days.*' => 'required',
            'price.*' => 'required',
            'images.*' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
            'main_image' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
            'long_image' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'max:10'
        ]);

        $licenceKey = new LicenceKey();
        $licenceKey->title = $request->title;
        $licenceKey->created_by = Auth::user()->id;
        $licenceKey->sku = $request['sku'];
        $licenceKey->status = $request['status'];
        $licenceKey->product_status = 'available';
        $licenceKey->options = $request['options'];
        $licenceKey->category_id = $request['category'];
        $licenceKey->meta_title = $request['meta_title'];
        $licenceKey->description = $request['description'];
        $licenceKey->meta_keywords = $request['meta_keywords'];
        $licenceKey->meta_description = $request['meta_description'];

        $licenceKey->main_image = $request['main_image'];
        $licenceKey->long_image = $request['long_image'];

        $licenceKey->save();

        $temp = true;
        foreach ($request['key'] as $index => $key) {
            $keyChannel = new KeyChannel();
            $keyChannel->days = $request['days'][$index];
            $keyChannel->status = $request['channel_status'][$index];
            $keyChannel->price = $request['price'][$index];
            $keyChannel->key = $key;
            $licenceKey->keyChannels()->save($keyChannel);
            if ($request['channel_status'][$index] == 'available') {
                $temp = false;
            }
        }

        if ($temp) {
            $licenceKey->product_status = 'sold';
        } else {
            $licenceKey->product_status = 'available';
        }
        $licenceKey->save();

        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                $media = new Media();
                $media->image = $image;
                $licenceKey->medias()->save($media);
            }
        }

        return redirect()->route('admin.licencekeys.')->with('success', 'Licence Key added successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'sku' => 'required',
            'meta_title' => 'required',
            'options' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            'category' => 'required',
            'channel_status.*' => 'required',
            'email.*' => 'required|email',
            'password.*' => 'required|min:6',
            'images.*' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'main_image' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'long_image' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'max:1-',
        ]);

        $licenceKey = LicenceKey::findOrFail($request->id);
        $licenceKey->title = $request->title;
        $licenceKey->sku = $request['sku'];
        $licenceKey->options = $request['options'];
        $licenceKey->status = $request['status'];
        $licenceKey->category_id = $request['category'];
        $licenceKey->meta_title = $request['meta_title'];
        $licenceKey->description = $request['description'];
        $licenceKey->meta_keywords = $request['meta_keywords'];
        $licenceKey->meta_description = $request['meta_description'];

        if($request->hasFile('main_image')) {
            $licenceKey->main_image = $request['main_image'];
        }
        if ($request->hasFile('long_image')) {
            $licenceKey->long_image = $request['long_image'];
        }

        $licenceKey->save();

        $temp = true;
        $licenceKey->keyChannels()->delete();
        foreach ($request['key'] as $index => $key) {
            $keyChannel = new KeyChannel();
            $keyChannel->days = $request['days'][$index];
            $keyChannel->price = $request['price'][$index];
            $keyChannel->status = $request['channel_status'][$index];
            $keyChannel->key = $key;
            $licenceKey->keyChannels()->save($keyChannel);
            if ($request['channel_status'][$index] == 'available') {
                $temp = false;
            }
        }

        if ($temp) {
            $licenceKey->product_status = 'sold';
        } else {
            $licenceKey->product_status = 'available';
        }
        $licenceKey->save();

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
                $licenceKey->medias()->save($media);
            }
        }

        return redirect()->route('admin.licencekeys.')->with('success', 'Licence Key updated successfully!');
    }

    public function status(Request $request)
    {
        try {
            $data = LicenceKey::find($request->id);
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
            $data = LicenceKey::where('id', $id)->first();
            $data->delete();
            return response()->json('Success');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function details($id)
    {
        try {
            $licenceKey = LicenceKey::where('id', $id)->with('keyChannels')->get();
            $keyChannelsData = $licenceKey->pluck('keyChannels')->collapse()->toArray();
            return response()->json($keyChannelsData);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
