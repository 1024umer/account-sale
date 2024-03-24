<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    public function index()
    {
        $totalUser = User::count();
        $roles = Role::get();
        return view('backend.users.index', compact('totalUser', 'roles'));
    }

    public function list(Request $request)
    {
        try {
            $totalData = User::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                $results = User::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->with('role')
                    ->get();
            } else {
                $search = $request->input('search.value');

                $results = User::search($search)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->with('role')
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
                    $nestedData['name'] = $row->name;
                    $nestedData['username'] = $row->username;
                    $nestedData['email'] = $row->email;
                    $nestedData['role'] = $row->role->name;
                    $nestedData['referral_balance'] = $row->referral_balance;
                    $nestedData['status'] = $row->status;
                    $nestedData['action'] = view('backend.users._actions', [
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
            // return;
            // return Response::json(['error' => $th->getMessage()], 500);
        } catch (\Exception $e) {
            throw $e;
            // return;
            // return Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'state' => 'required',
            'city' => 'required',
            'country' => 'required',
            'postal_code' => 'required',
            'status' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
            'role' => 'required',
        ]);

        $user = new User();
        $user->created_by = Auth::user()->id;
        $user->name = $request->name;
        $user->city = $request->city;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->state = $request->state;
        $user->role_id = $request->role;
        $user->status = $request->status;
        $user->country = $request->country;
        $user->postal_code = $request->postal_code;
        $user->password = Hash::make($request->password);
        $nameWithoutSpaces = str_replace(' ', '', $request->name);
        $user->username = $nameWithoutSpaces . substr($request->email, 0, strpos($request->email, '@'));
        $user->save();
        return redirect()->back()->with('success', 'User added successfull!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'status' => 'required',
            'role' => 'required',
        ]);

        $user = User::where('id', $request->id)->first();
        $user->name = $request->name;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role_id = $request->role;
        $user->status = $request->status;
        $user->country = $request->country;
        $user->postal_code = $request->postal_code;
        $nameWithoutSpaces = str_replace(' ', '', $request->name);
        $user->username = $nameWithoutSpaces . substr($request->email, 0, strpos($request->email, '@'));
        $user->save();
        return redirect()->back()->with('success', 'User updated successfull!');
    }

    public function security($id)
    {
        $user = User::where('id', $id)->with('orders')->first();
        return view('backend.users.security', compact('user'));
    }

    public function orders($id)
    {
        $user = User::where('id', $id)->with('orders')->first();
        return view('backend.users.orders', compact('user'));
    }

    public function status(Request $request)
    {
        try {
            $user = User::find($request->id);
            if ($user->status == 'active') {
                $user->status = 'inactive';
            } else {
                $user->status = 'active';
            }
            $user->save();
            return response()->json('Success');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        $data = User::find($id);
        $data->delete();
        return response()->json('Success');
    }

    public function details($id)
    {
        $user = User::where('id', $id)->with('orders')->first();
        if ($user) {
          $referralUser = User::where('unique_number', $user->referral)->first();
          $referralUsers = User::where('referral', $user->unique_number)->get();
          $referralUserName = $referralUser ? $referralUser->name : null;
            $roles = Role::get();
            return view('backend.users.details', compact('user', 'roles','referralUserName','referralUsers'));
        } else {
            return redirect()->back();
        }
    }


    public function securityUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        $user = User::where('id', $request->id)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->back()->with('success', 'User password updated successfull!');
    }

    public function ordersList(Request $request, $id)
    {
        try {
            $totalData = Order::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                $results = Order::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->where('user_id', $id)
                    ->get();
            } else {
                $search = $request->input('search.value');

                $results = Order::search($search)
                    ->offset($start)
                    ->limit($limit)
                    ->where('user_id', $id)
                    ->orderBy($order, $dir)
                    ->get();

                $totalFiltered = count($results);
            }

            $data = array();
            if (!empty($results)) {
                foreach ($results as $row) {
                    $nestedData['id'] = $row->id;
                    $nestedData['product_title'] = $row->orderable->title;
                    $nestedData['product_type'] = $row->orderable_type;
                    $nestedData['amount'] = $row->amount;
                    $nestedData['status'] = $row->status;
                    $nestedData['date'] = $row->created_at->format('M, d, Y');
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
}
