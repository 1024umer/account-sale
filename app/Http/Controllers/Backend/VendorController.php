<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $users = User::where('id','!=', auth()->user()->id)->where('role_id',5)->get();
        $totalVendors = $users->count();
        return view('backend.vendors.index')->with(compact('users','totalVendors'));
    }
    public function list(){
        $review = User::where('role_id',5)->get();
        // dd($review);
        return response()->json(['data'=>$review]);
    }
}
