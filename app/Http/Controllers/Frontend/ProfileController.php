<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Models\UserTicket;
use App\Models\EmailChannel;
use Illuminate\Http\Request;
use App\Models\GamingAccount;
use App\Models\Category;
use App\Models\WithDrawRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function tickets()
    {
        $user = Auth::user();
        $data = Store::where('id', '1')->first();
        $categoriesHeader = Category::with('subCategories.subSubCategory')
        ->get();
        $totalProducts = GamingAccount::where('status', 'active')->count();
        $totalCategories = Category::count();
        $tickets = UserTicket::where('email', $user->email)->orderBy('id', 'DESC')->get();
        return view('frontendNew.support', compact('data', 'user', 'tickets','categoriesHeader'));
    }

    public function settings()
    {
        $user = Auth::user();
        $data = Store::where('id', '1')->first();
        $categoriesHeader = Category::with('subCategories.subSubCategory')
        ->get();
        $totalProducts = GamingAccount::where('status', 'active')->count();
        $totalCategories = Category::count();
        return view('frontendNew.setting', compact('data', 'user','categoriesHeader'));
    }

    public function viewAccount($id)
    {
        $user = Auth::user();
        $data = Store::where('id', '1')->first();
        return view('frontend.view_account.auth', compact('data', 'user', 'id'));
    }

    public function showDetails(Request $request)
    {
        $password = $request->password;
        $order_id = $request->order_id;
        $user = Auth::user();
        $data = Store::where('id', '1')->first();
        if(!Hash::check($password, $user->password)) {
            return redirect()->back()->with('error', 'Invalid Password!');
        }

        $order = Order::where('id', $order_id)->first();
        $emailchannels = EmailChannel::where('gaming_account_id',$order->orderable_id)->get();
        $channelIds = explode("@", $order->channel_id);
        $products = EmailChannel::whereIn('id', $channelIds)->get();
        $count = EmailChannel::whereIn('id', $channelIds)->count();

        return view('frontend.view_account.details', compact('data', 'user', 'products', 'count','order','emailchannels'));
    }

    public function downloadAccount(Request $request)
    {
        $password = $request->password;
        $order_id = $request->order_id;
        $user = Auth::user();
        if(!Hash::check($password, $user->password)) {
            return redirect()->back()->with('error', 'Invalid Password!');
        }
        $order = Order::where('id', $order_id)->first();
        $channelIds = explode("@", $order->channel_id);
        $products = EmailChannel::whereIn('id', $channelIds)->get();
        $txt = "";
        foreach($products as $product) {
            $txt .= $product->value1."\n";
            $txt .= $product->value2."\n";
            $txt .= $product->value3."\n";
            $txt .= $product->value4."\n";
            $txt .= $product->value5."\n";
            $txt .= $product->value6."\n";
            $txt .= $product->value7."\n";
            $txt .= $product->value8."\n";
        }

        $headers = [
            'Content-Type' => 'application/plain',
            'Content-Description' => 'Account Details',
            'Content-Disposition' => 'attachment; filename="logs_file.txt"'
        ];

        $contents = $txt;

        return \Response::make($contents, 200, $headers);

    }

    public function purchses()
    {
        $user = Auth::user();
        $data = Store::where('id', '1')->first();
        $categoriesHeader = Category::with('subCategories.subSubCategory')
        ->get();
        $totalProducts = GamingAccount::where('status', 'active')->count();
        $totalCategories = Category::count();
        $orders = Order::where('user_id', $user->id)->orderBy('id', 'DESC')->get();
        return view('frontendNew.profile', compact('data', 'user', 'orders','categoriesHeader'));
    }

    public function referral()
    {
        $user = Auth::user();
        $data = Store::where('id', '1')->first();
        $refferal= User::where('referral',$user->username)->count();
        $refferals = User::where('referral',$user->username)->get();
        $categoriesHeader = Category::with('subCategories.subSubCategory')
        ->get();
        $totalProducts = GamingAccount::where('status', 'active')->count();
        $totalCategories = Category::count();
        $withdraw = WithDrawRequest::where('user_id', $user->id)->orderBy('id', 'DESC')->get();
        return view('frontendNew.refferal', compact('data', 'user', 'refferal', 'refferals', 'withdraw', 'refferals','categoriesHeader'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'nullable|min:8',
            'confirmation_password' => ''. ($request->password != null ? 'same:password|required|min:8' : 'nullable'),
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != null)  {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->back()->with('success', 'Profile updated success');
    }

    public function withDraw(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'referral_balance' => ['required', 'min:1', 'max:' . $user->referral_balance],
            'secret_key' => 'required',
        ]);

        $withDrawRequest = new WithDrawRequest();
        $withDrawRequest->user_id = $user->id;
        $withDrawRequest->amount = $user->referral_balance;
        $withDrawRequest->secret_key = $request->secret_key;
        $withDrawRequest->status = 'pending';
        $withDrawRequest->save();

        $user->balance = $user->balance - $request->referral_balance;
        $user-> referral_balance = $user->referral_balance - $request->referral_balance;
        $user->save();

        return redirect()->back()->with('success', 'With Draw Request Sent to admin!');
    }
}
