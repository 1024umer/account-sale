<?php

namespace App\Http\Controllers\Backend;

use App\Models\LicenceKey;
use Illuminate\Http\Request;
use App\Models\GamingAccount;
use App\Models\FeatureProduct;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeatureProductController extends Controller
{
    public function index()
    {
        $total = FeatureProduct::count();
        $gamingAccounts = GamingAccount::where('status', 'active')->where('product_status', 'available')->get();
        $licenceKeys = LicenceKey::where('status', 'active')->where('product_status', 'available')->get();
        return view('backend.feature_products', compact('total', 'gamingAccounts', 'licenceKeys'));
    }

    public function list(Request $request)
    {
        try {
            $totalData = FeatureProduct::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                $results = FeatureProduct::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');

                $results = FeatureProduct::search($search)
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
                    $nestedData['title'] = $row->product->title;
                    $nestedData['action'] = "<div class='btn-group'><button class='btn btn-sm btn-danger delete-btn' data-id='" . $row->id . "'>Remove</button></div>";
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

    public function addAccount(Request $request)
    {
        $request->validate([
            'accountId' => 'required',
        ]);

        $account = GamingAccount::where('id', $request->accountId)->first();
        $fp = new FeatureProduct();
        $fp->created_by = Auth::user()->id;
        $fp->product()->associate($account);
        $fp->save();

        return redirect()->back()->with('success', 'Gaming account added to the feature list!');
    }

    public function addKey(Request $request)
    {
        $request->validate([
            'keyId' => 'required',
        ]);

        $account = LicenceKey::where('id', $request->keyId)->first();
        $fp = new FeatureProduct();
        $fp->created_by = Auth::user()->id;
        $fp->product()->associate($account);
        $fp->save();

        return redirect()->back()->with('success', 'Licence key added to the feature list!');
    }

    public function delete($id)
    {
        $data = FeatureProduct::where('id', $id)->first();
        $data->delete();
        return response()->json('Success');
    }
}
