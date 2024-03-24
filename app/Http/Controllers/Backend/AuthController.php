<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Admin side authentication controller

class AuthController extends Controller
{
    // showing the login form page
    public function login()
    {
        if (Auth::check()) {
            return redirect()->back();
        }
        $pageConfigs = ['myLayout' => 'blank'];
        return view('backend.auth.login', compact('pageConfigs'));
    }

    // post request of the login form
    public function loginCheck(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if(!$user || $user->role_id == 1) {
            return redirect()->back()->withErrors(['email' => __('auth.failed')])->withInput();
        }
        $credentials = $request->only('email', 'password');
        $rem_check = false;
        if ($request->remember_me == 'on') {
            $rem_check = true;
        }
        if (Auth::attempt($credentials, $rem_check)) {
            return redirect()->route('admin.home')->with('success', 'Login successfull!');
        } else {
            return redirect()->back()->withErrors(['email' => __('auth.failed')])->withInput();
        }
    }

    // simple logout route
    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
            return redirect()->route('login');
        } else {
            return redirect()->back();
        }
    }

    public function password()
    {
        return view('backend.auth.password');
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ]);

        $user = User::where('role', 'admin')->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully!!');
    }
}
