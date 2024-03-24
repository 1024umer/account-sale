<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Volume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolumeController extends Controller
{
    public function index()
    {
        return view('backend.volume.index');
    }

    public function add(Request $request)
    {
        foreach ($request->input('quantity') as $key => $quantity) {
            $price = $request->input('price')[$key];
            Volume::create([
                'quantity' => $quantity,
                'price' => $price,
                'created_by' => Auth::user()->id
            ]);
        }
        return redirect()->back()->with('success', 'Saved successfully.');
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
                $totalData = Volume::where('created_by', $user->id)->count();
            } else {
                $totalData = Volume::count();
            }
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                if ($can) {
                    $results = Volume::where('created_by', $user->id)
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $results = Volume::offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                }
            } else {
                $search = $request->input('search.value');

                if ($can) {
                    $results = Volume::where('created_by', $user->id)
                        ->search($search)
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $results = Volume::search($search)
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
                    $nestedData['quantity'] = $row->quantity;
                    $nestedData['price'] = $row->price;
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
