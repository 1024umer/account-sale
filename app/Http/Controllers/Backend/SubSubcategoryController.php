<?php

namespace App\Http\Controllers\Backend;

use App\Models\Permission;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\SubSubcategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubSubcategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $can = false;
        if ($user->role_id != 1 && $user->role_id != 2) {
            $can = true;
        }
        if ($can) {
            $totalCategory = SubSubCategory::where('created_by', $user->id)->count();
            $categories = SubCategory::where('created_by', $user->id)->get();
        } else {
            $totalCategory = SubSubCategory::count();
            $categories = SubCategory::all();
        }
        return view('backend.sub_subcategories.index', compact('totalCategory', 'categories'));
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
                $totalData = SubSubCategory::where('created_by', $user->id)->count();
            } else {
                $totalData = SubSubCategory::count();
            }
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                if ($can) {
                    $results = SubSubCategory::where('created_by', $user->id)
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $results = SubSubCategory::offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                }
            } else {
                $search = $request->input('search.value');

                if ($can) {
                    $results = SubSubCategory::where('created_by', $user->id)
                        ->search($search)
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $results = SubSubCategory::search($search)
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
                    $nestedData['action'] = view('backend.sub_subcategories._actions', [
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
            'subcategory_id' => 'required',
            'name' => 'required'
        ]);

        $category = new SubSubCategory();
        $category->sub_category_id = $request->subcategory_id;
        $category->name = $request->name;
        $category->created_by = Auth::user()->id;
        $category->save();

        $per = new Permission();
        $per->name = $category->name;
        $per->type = 'Sub Sub Category';
        $per->save();

        return redirect()->back()->with('success', 'Sub SubCategory added successfull!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
        ]);

        $category = SubSubCategory::where('id', $request->id)->first();
        $category->name = $request->name;
        $category->save();

        return redirect()->back()->with('success', 'Sub SubCategory updated successfull!');
    }

    public function delete($id)
    {
        $data = SubSubCategory::where('id', $id)->first();
        $data->delete();
        return response()->json('Success');
    }
}
