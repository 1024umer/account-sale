<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $can = false;
        if ($user->role_id != 1 && $user->role_id != 2) {
            $can = true;
        }
        if ($can) {
            $totalCategory = Category::where('created_by', $user->id)->count();
        } else {
            $totalCategory = Category::count();
        }
        return view('backend.categories.index', compact('totalCategory'));
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
                $totalData = Category::where('created_by', $user->id)->count();
            } else {
                $totalData = Category::count();
            }
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                if ($can) {
                    $results = Category::where('created_by', $user->id)
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $results = Category::offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                }
            } else {
                $search = $request->input('search.value');
                if ($can) {
                    $results = Category::where('created_by', $user->id)
                        ->search($search)
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $results = Category::search($search)
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
                    $nestedData['action'] = view('backend.categories._actions', [
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
            'name' => 'required',
            'image' => 'required',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->image = $request->image;
        $category->created_by = Auth::user()->id;
        $category->save();

        $per = new Permission();
        $per->name = $category->name;
        $per->type = 'Category';
        $per->save();

        return redirect()->back()->with('success', 'Category added successfull!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
        ]);

        $category = Category::where('id', $request->id)->first();
        $category->name = $request->name;
        if ($request->hasFile('image')) {
            $category->image = $request['image'];
        }
        $category->save();

        return redirect()->back()->with('success', 'Category updated successfull!');
    }

    public function delete($id)
    {
        $user = Auth::user();
        $can = false;
        if ($user->role_id != 1 && $user->role_id != 2) {
            $can = true;
        }
        if ($can) {
            $data = Category::where('created_by', $user->id)->where('id', $id)->first();
        } else {
            $data = Category::where('id', $id)->first();
        }
        $data->delete();
        return response()->json('Success');
    }
}
