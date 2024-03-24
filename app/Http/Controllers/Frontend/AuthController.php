<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ForgotPasswordMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function signin()
    {
        $data = Store::where('id', '1')->first();
        return view('frontend.auth.signin', compact('data'));
    }

    public function signup($referal_user = null)
    {
        $data = Store::where('id', '1')->first();
        return view('frontend.auth.signup', compact('data', 'referal_user'));
    }

    public function forgotPassword()
    {
        $data = Store::where('id', '1')->first();
        return view('frontend.auth.forgotPassword', compact('data'));
    }

    public function signinCheck(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password'  => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && $user->status == 'active') {
            $credentials = $request->only('email', 'password', 'remember_token');
            if (Auth::attempt($credentials)) {
                return redirect()->route('home')->with('success', 'Login success.');
            } else {
                return redirect()->back()->withErrors(['email' => __('auth.failed')])->withInput();
            }
        } else {
            return redirect()->back()->withErrors(['email' => __('auth.failed')])->withInput();
        }

    }

    public function signupCheck(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:8',
            'confirmation_password' => 'required|same:password|min:8',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            return redirect()->back()->withErrors(['email' => 'User already exists.'])->withInput();
        }
        $referral_code = $request->referral;
        // $referral_check = 0;
        // if ($referral_code != '') {
        //     $referral_check = User::where('username', $referral_code)->count();
        // }
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->balance = 0;
        $user->password = Hash::make($request->password);
        $nameWithoutSpaces = str_replace(' ', '', $request->name);
        $user->username = $nameWithoutSpaces . substr($request->email, 0, strpos($request->email, '@'));

        $user->referral = $referral_code;
        $user->save();

        return redirect()->route('signin')->with('success', 'Account created.');
    }
    public function forgotPasswordCheck(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if(!$user) {
            return redirect()->back()->withErrors(['email' => 'User not found.'])->withInput();
        }
        $token = Str::random(32);
        $user->password_token = $token;
        $user->save();

        Mail::to($user->email)->send(new ForgotPasswordMail($user->email, $user->name, $token));

        return redirect()->route('signin')->with('success', 'Password reset email send successfully!');
    }

    public function resetPassword($token, $email)
    {
        $user = User::where('password_token', $token)->first();
        if ($user) {
            $data = Store::where('id', '1')->first();
            $email = $user->email;
            return view('frontend.auth.passwordReset', compact('email', 'data'));
        } else {
            return redirect()->route('home');
        }
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:8',
            'confirmation_password' => 'required|same:password|min:8'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'User not found'])->withInput();
        }
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('signin')->with('success', 'Password reset success');
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
            return redirect()->route('home');
        } else {
            return redirect()->back();
        }
    }

    private function generateReferralCode()
    {
        return strtoupper(Str::random(8)); // Adjust the length and format as needed
    }
}
