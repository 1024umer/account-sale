<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\GiveAway;
use Illuminate\Http\Request;
use App\Helpers\ImageUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GiveAwayController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $can = false;
        if ($user->role_id != 1 && $user->role_id != 2) {
            $can = true;
        }
        if ($can) {
            $totalAccount = GiveAway::where('created_by', $user->id)->count();
        } else {
            $totalAccount = GiveAway::count();
        }
        return view('backend.giveaway.index', compact('totalAccount'));
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
                $totalData = GiveAway::where('created_by', $user->id)->count();
            } else {
                $totalData = GiveAway::count();
            }
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                if ($can) {
                    $results = GiveAway::where('created_by', $user->id)
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $results = GiveAway::offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                }
            } else {
                $search = $request->input('search.value');

                if ($can) {
                    $results = GiveAway::where('created_by', $user->id)
                        ->search($search)
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $results = GiveAway::search($search)
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
                    $nestedData['status'] = $row->status;
                    $nestedData['action'] = view('backend.giveaway._actions', [
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
        return view('backend.giveaway.add');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $can = false;
        if ($user->role_id != 1 && $user->role_id != 2) {
            $can = true;
        }
        if ($can) {
            $giveAway = GiveAway::where('created_by', $user->id)->where('id', $id)->first();
        } else {
            $giveAway = GiveAway::where('id', $id)->first();
        }
        return view('backend.giveaway.edit', compact('giveAway'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $giveAway = new GiveAway();
        $giveAway->title = $request->title;
        $giveAway->description = $request->description;
        $giveAway->status = $request->status;
        $giveAway->image = $request->image;
        $giveAway->created_by = Auth::user()->id;
        $giveAway->save();

        return redirect()->route('admin.giveaway.')->with('success', 'Give Away added successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'images' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $giveAway = GiveAway::find($request->id);
        $giveAway->title = $request->title;
        $giveAway->description = $request->description;
        $giveAway->status = $request->status;
        if($request->hasFile('image')) {
            $giveAway->image = $request->image;
        }
        $giveAway->save();

        return redirect()->route('admin.giveaway.')->with('success', 'Give Away updated successfully!');
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
                $data = GiveAway::where('created_by', $user->id)->where('id',$request->id)->first();
            } else {
                $data = GiveAway::find($request->id);
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
                $data = GiveAway::where('created_by', $user->id)->where('id', $id)->first();
            } else {
                $data = GiveAway::where('id', $id)->first();
            }
            $data->delete();
            return response()->json('Success');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function sendBalance(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        $user->balance = $user->balance + $request->balance;
        $user->referral_balance = $user->referral_balance + $request->balance;
        $user->save();

        return redirect()->route('admin.giveaway.')->with('success', 'Balance sent successfully!');
    }

}
