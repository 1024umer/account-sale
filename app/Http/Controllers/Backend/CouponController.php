<?php

namespace App\Http\Controllers\Backend;

use App\Models\Coupon;
use App\Models\CouponType;
use Illuminate\Http\Request;
use App\Models\CouponAccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $can = false;
        if ($user->role_id != 1 && $user->role_id != 2) {
            $can = true;
        }
        if ($can) {
            $settings = CouponType::where('created_by', $user->id)->get();
        } else {
            $settings = CouponType::get();
        }
        return view('backend.coupon.index', compact('settings'));
    }

    public function add(Request $request)
    {
        $coupons = new CouponType();
        $coupons->created_by = Auth::user()->id;
        if ($request->coupon_type == 'discount') {
            $coupons->name = $request->name;
            $coupons->type = $request->coupon_type;
            $coupons->value = $request->stock_list;
            $coupons->save();
            return redirect()->back()->with('success', 'Coupon added successfully!');
        } else {
            $coupons->name = $request->name;
            $coupons->type = $request->coupon_type;
            $coupons->save();

            $stock_delimiter = $request['stock_delimiter'];
            if ($stock_delimiter == 'comma') {
                $stock_delimiter = ",";
            } else if ($stock_delimiter == 'newline') {
                $stock_delimiter = "\n";
            } else if ($stock_delimiter == 'custom') {
                $stock_delimiter = $request['custom_stock_delimiter'];
            }

            $stock_list_str = $request['stock_list'];
            if ($stock_list_str != '') {
                $stock_list = explode($stock_delimiter, $stock_list_str);
                foreach ($stock_list as $row) {
                    $check = false;
                    $fields = explode("|", $row);
                    $emailChannel = new CouponAccount();
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
                        $coupons->emailChannels()->save($emailChannel);
                    }
                }
            }
            return redirect()->back()->with('success', 'Coupon added successfully!');
        }
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
                $totalData = CouponType::where('created_by', $user->id)->count();
            } else {
                $totalData = CouponType::count();
            }
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                if ($can) {
                    $results = CouponType::where('created_by', $user->id)
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $results = CouponType::offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                }
            } else {
                $search = $request->input('search.value');
                if ($can) {
                    $results = CouponType::where('created_by', $user->id)
                        ->search($search)
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $results = CouponType::search($search)
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
                    $nestedData['type'] = $row->type;
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
