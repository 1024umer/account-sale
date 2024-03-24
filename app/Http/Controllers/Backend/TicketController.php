<?php

namespace App\Http\Controllers\Backend;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Mail\TicketReplyMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    public function index()
    {
        $total = Ticket::count();
        return view('backend.tickets.index', compact('total'));
    }

    public function list(Request $request)
    {
        try {
            $totalData = Ticket::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                $results = Ticket::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');

                $results = Ticket::search($search)
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
                    $nestedData['name'] = $row->name;
                    $nestedData['email'] = $row->email;
                    $nestedData['status'] = $row->status;
                    $nestedData['ticketfile'] = $row->ticketfile;
                    $nestedData['action'] = view('backend.tickets._actions', [
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
        $data = Ticket::where('id', $id)->first();
        $data->delete();
        return response()->json('Success');
    }

    public function details($id)
    {
        $ticket = Ticket::where('id', $id)->first()->toArray();
        return response()->json($ticket);
    }

    public function answer(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'reply' => 'required',
        ]);

        $ticket = Ticket::where('id', $request->id)->first();
        $ticket->answer = $request->reply;
        $ticket->status = 'answered';
        $ticket->save();

        $email = $ticket->email;
        $subject = $ticket->subject;

        Mail::to($email)->send(new TicketReplyMail($ticket->name, $subject, $request->reply));
        
        return redirect()->back()->with('success', 'Ticket answered successfully!');
    }
}
