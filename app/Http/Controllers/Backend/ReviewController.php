<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
class ReviewController extends Controller
{
    public function index()
    {
        $users = User::where('id','!=', auth()->user()->id)->get();
        return view('backend.review.index')->with(compact('users'));
    }
}
