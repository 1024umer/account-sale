<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Store;
use GuzzleHttp\Client;
use App\Models\Visiter;
use Illuminate\Http\Request;
use App\Models\CustomRefferal;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\RequestException;

class CustomRefferalController extends Controller
{
    function index()
    {
      $totalData = CustomRefferal::count();
      return view('backend.custom_refferal.index', compact('totalData'));
    }

    public function list(Request $request)
    {
        try {
            $totalData = CustomRefferal::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                $results = CustomRefferal::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');

                $results = CustomRefferal::search($search)
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
                    $nestedData['title'] = $row->title;
                    $nestedData['refferal_name'] = $row->refferal_name;
                    $nestedData['refferal_link'] = $row->refferal_link;
                    $nestedData['action'] = view('backend.custom_refferal._actions', [
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

    function create()
    {
       return view('backend.custom_refferal.create');
    }

    public function add(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'refferal_name' => 'required',
            'refferal_link' => 'required',
        ]);

        $custom_refferal = new CustomRefferal();
        $custom_refferal->title = $request->title;
        $custom_refferal->refferal_name = $request->refferal_name;
        $custom_refferal->refferal_link = $request->refferal_link;
        $custom_refferal->refferal_code = rand(000000, 999999);
        $custom_refferal->save();

        return redirect()->back()->with('success', 'Custom Refferal added successfull!');
    }

    function edit($id)
    {
      $custom_refferal = CustomRefferal::find($id);
      return view('backend.custom_refferal.edit', compact('custom_refferal'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'title' => 'required|string',
            'refferal_name' => 'required|string',
            'refferal_link' => 'required',
        ]);

        $custom_refferal = CustomRefferal::findOrFail($request->id);

        $custom_refferal->update([
            'title' => $request->title,
            'refferal_name' => $request->refferal_name,
            'refferal_link' => $request->refferal_link,
            'refferal_code' => rand(000000, 999999),
        ]);

        return redirect()->back()->with('success', 'Custom Refferal updated successfully!');
    }

    public function delete($id)
    {
        try {
            $custom_refferal = CustomRefferal::findOrFail($id);
            $custom_refferal->delete();

            return response()->json(['message' => 'Success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function get_country($ipaddress)
{
    $ipaddress = '103.149.240.172'; // Get IP
    $apikey = "MjIzMzQ6UjU1bVppV3ZKRnV4eFVLVFRYNFdXUmw4a1gzaDFZNnM="; // API Key
    $country = 'Unknown';

    // cURL request
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://v2.api.iphub.info/ip/" . $ipaddress,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "x-key: " . $apikey
        ),
    ));

    $response = json_decode(curl_exec($curl));
    $err = curl_error($curl);

    curl_close($curl);

    if (!$err && isset($response->countryName)) {
        $country = $response->countryName;
    }

    return $country;
}


public function user_detail($refferal_name)
{
    $customrefferal = CustomRefferal::where('refferal_name', $refferal_name)->first();

    if ($customrefferal) {
        $users = User::where('referral', $customrefferal->refferal_name)->get();
        $totalvisiter = Visiter::get();
        $totalUsers = $users->count();

        if ($users->count() > 0) {
            foreach ($users as $user) {
                // Get country based on IP address
                $user->country = $this->get_country($user->ip_address);
            }

            $firstUser = $users->first();

            if ($firstUser) {
                $country = $firstUser->country;
                return view('backend.custom_refferal.detail', compact('users', 'totalUsers','totalvisiter'));
            } else {
                return "Country not available for the first user.";
            }
        } else {
          return view('backend.custom_refferal.detail', compact('users','totalUsers','totalvisiter'));
        }
    }
}


  }
