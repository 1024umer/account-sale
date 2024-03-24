<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
class ReviewController extends Controller
{
    public function index()
    {
        $users = User::where('id','!=', auth()->user()->id)->get();
        return view('backend.review.index')->with(compact('users'));
    }
    public function store(Request $request){
        if($request->file('file')){
            $path = $request->image->store('review');
        }
        $data = Review::create([
            'product_id'=>$request->product_id,
            'user_id'=>$request->user_id,
            'star' => $request->star,
            'comment' => $request->comment,
            'image' => $request->image?$path:null,
        ]);
        return redirect()->back();
    }
}
