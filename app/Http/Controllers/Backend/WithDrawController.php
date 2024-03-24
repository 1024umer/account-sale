<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\TicketReplyMail;
use App\Models\User;
use App\Models\WithDrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WithDrawController extends Controller
{
    public function index()
    {
        $total = WithDrawRequest::count();
        return view('backend.withdraw.index', compact('total'));
    }

    public function list(Request $request)
    {
        try {
            $totalData = WithDrawRequest::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                $results = WithDrawRequest::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');

                $results = WithDrawRequest::search($search)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                $totalFiltered = count($results);
            }

            $data = array();
            if (!empty($results)) {
                foreach ($results as $row) {
                    $user = User::where('id', $row->user_id)->first();
                    $nestedData['id'] = $row->id;
                    $nestedData['name'] = $user->name;
                    $nestedData['amount'] = $row->amount;
                    $nestedData['secret_key'] = $row->secret_key;
                    $nestedData['status'] = $row->status;
                    $nestedData['action'] = view('backend.withdraw._actions', [
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

    public function answer(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required',
        ]);

        $withDrawRequest = WithDrawRequest::where('id', $request->id)->first();
        if ($request->status == 'cancelled') {
            $user = User::where('id', $withDrawRequest->user_id)->first();
            $user->balance = $user->balance + $withDrawRequest->amount;
            $user->referral_balance = $user->referral_balance + $withDrawRequest->amount;
            $user->save();
        }

        $withDrawRequest->status = $request->status;
        $withDrawRequest->save();

        return redirect()->back()->with('success', 'With Draw Request marked successfully!');
    }
}
