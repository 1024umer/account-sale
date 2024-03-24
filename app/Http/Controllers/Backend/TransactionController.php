<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $totalData = Transaction::count();
        return view('backend.transactions.index', compact('totalData'));
    }

    public function list(Request $request)
    {
        try {
            $totalData = Transaction::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                $results = Transaction::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');

                $results = Transaction::search($search)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                $totalFiltered = count($results);
            }

            $data = array();
            if (!empty($results)) {
                foreach ($results as $row) {
                    $nestedData['id'] = $row->id;
                    $nestedData['user'] = $row->user->name;
                    if($row->order_id != null)
                    {
                        $nestedData['order_id'] = $row->order_id;
                        $nestedData['amount'] = $row->order->amount;
                    }
                    else{
                        $nestedData['manual_id'] = $row->id;
                        $nestedData['amount'] = $row->manualpayment->amount;
                    }
                    $nestedData['payment_method'] = $row->payment_method;
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
