<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Models\Permission;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubCategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $can = false;
        if ($user->role_id != 1 && $user->role_id != 2) {
            $can = true;
        }
        if ($can) {
            $totalCategory = SubCategory::where('created_by', $user->id)->count();
            $categories = Category::where('created_by', $user->id)->get();
        } else {
            $totalCategory = SubCategory::count();
            $categories = Category::all();
        }
        return view('backend.sub_categories.index', compact('totalCategory', 'categories'));
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
                $totalData = SubCategory::where('created_by', $user->id)->count();
            } else {
                $totalData = SubCategory::count();
            }
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                if ($can) {
                    $results = SubCategory::where('created_by', $user->id)
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $results = SubCategory::offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                }
            } else {
                $search = $request->input('search.value');

                if ($can) {
                    $results = SubCategory::where('created_by', $user->id)
                        ->search($search)
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $results = SubCategory::search($search)
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
                    $nestedData['id'] = $row->id;
                    $nestedData['name'] = $row->name;
                    $nestedData['image'] = $row->image;
                    $nestedData['action'] = view('backend.sub_categories._actions', [
                        'row' => $row,
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

    public function add(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'image' => 'required',
        ]);

        $category = new SubCategory();
        $category->category_id = $request->category_id;
        $category->name = $request->name;
        $category->image = $request->image;
        $category->created_by = Auth::user()->id;
        $category->save();

        $per = new Permission();
        $per->name = $category->name;
        $per->type = 'Sub Category';
        $per->save();

        return redirect()->back()->with('success', 'SubCategory added successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
        ]);

        $category = SubCategory::where('id', $request->id)->first();
        $category->name = $request->name;
        if ($request->hasFile('image')) {
            $category->image = $request['image'];
        }
        $category->save();

        return redirect()->back()->with('success', 'SubCategory updated successfully!');
    }

    public function delete($id)
    {
        $data = SubCategory::where('id', $id)->first();
        $data->delete();
        return response()->json('Success');
    }
}
