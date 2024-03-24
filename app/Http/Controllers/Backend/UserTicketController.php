<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserTicket;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketReplyMail;

class UserTicketController extends Controller
{
    public function index()
    {
        $total = UserTicket::count();
        return view('backend.user_tickets.index', compact('total'));
    }

    public function list(Request $request)
    {
        try {
            $totalData = UserTicket::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                $results = UserTicket::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');

                $results = UserTicket::search($search)
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
                    $nestedData['order_id'] = $row->order_id;
                    $nestedData['name'] = $row->name;
                    $nestedData['email'] = $row->email;
                    $nestedData['status'] = $row->status;
                    $nestedData['action'] = view('backend.user_tickets._actions', [
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

    public function delete($id)
    {
        $data = UserTicket::where('id', $id)->first();
        $data->delete();
        return response()->json('Success');
    }

    public function details($id)
    {
        $ticket = UserTicket::where('id', $id)->first()->toArray();
        return response()->json($ticket);
    }

    public function answer(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'reply' => 'required',
        ]);

        $ticket = UserTicket::where('id', $request->id)->first();
        $ticket->answer = $request->reply;
        $ticket->status = 'answered';
        $ticket->save();

        $email = $ticket->email;
        $subject = $ticket->subject;

        Mail::to($email)->send(new TicketReplyMail($ticket->name, $subject, $request->reply));
        
        return redirect()->back()->with('success', 'User Ticket answered successfully!');
    }
}
