<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Models\BalanceTransaction;
use App\Models\EmailChannel;
use App\Models\GamingAccount;
use App\Models\Order;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PerfectMoneyController extends Controller
{
    public function pay(Request $request) {
        if (Auth::check()) {
            $request->validate([
                'product_id' => 'required',
                'product_type' => 'required',
                'quantity' => 'required',
                'payment_method' => 'required',
            ]);
            $user = Auth::user();
        } else {
            $request->validate([
                'product_id' => 'required',
                'product_type' => 'required',
                'quantity' => 'required',
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'payment_method' => 'required',
            ]);
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                $user = new User();
                $user->email = $request->email;
                $user->name = $request->name;
                $nameWithoutSpaces = str_replace(' ', '', $request->name);
                $user->username = $nameWithoutSpaces . substr($request->email, 0, strpos($request->email, '@'));
                $user->password = Hash::make($request->password);
                $user->save();
            }
        }
        $data = Store::where('id', '1')->first();

        $totalPrice = intVal($request->totalPrice);
        $quantity = intVal($request->quantity);
        $product_id = $request->product_id;
        $product_type = $request->product_type;

        $unitPrice = $totalPrice / $quantity;

        if ($user->referral != null) {
            $referral_user = User::where('username', $user->referral)->first();
            $referral_user->referral_balance = $referral_user->referral_balance + ($totalPrice * $data->referral_percentage / 100);
            $referral_user->balance = $referral_user->balance + ($totalPrice * $data->referral_percentage / 100);
            $referral_user->save();
        }
        $account = GamingAccount::where('id', $product_id)
                ->where('status', 'active')
                ->where('product_status', 'available')
                ->with(['emailChannels' => function ($query) {
                    $query->where('status', 'available');
                }])
                ->first();

        if ($account) {
            $availableEmailChannels = $account->emailChannels;
            $availableChannelCount = count($availableEmailChannels);

            if ($availableChannelCount >= $quantity) {
                $emailChannelIds = $availableEmailChannels->take($quantity)->pluck('id');
                $emailChannelsss = '';
                foreach($emailChannelIds as $emailids) {
                    $emailChannelsss .= $emailids.'@';
                }

                $order = new Order();
                $order->status = 'pending';
                $order->user_id = $user->id;
                $order->amount = $totalPrice;
                $order->orderable_id = $product_id;
                $order->channel_id = $emailChannelsss;
                $order->orderable_type = 'App\Models\GamingAccount';
                $order->save();

                $transaction = new Transaction();
                $transaction->user_id = $user->id;
                $transaction->order_id = $order->id;
                $transaction->status = 'pending';
                $transaction->payment_method = 'Perfect Money';
                $transaction->save();

                $emailChannelIds = $availableEmailChannels->take($quantity)->pluck('id');

                $channels = EmailChannel::whereIn('id', $emailChannelIds)->get();
                foreach ($channels as $ch) {
                    $ch->status = 'sold';
                    $ch->save();
                }
                $account = GamingAccount::where('id', $account->id)->with('emailChannels')->first();
                $temp = false;
                foreach ($account->emailChannels as $ch) {
                    if ($ch->status == 'sold') {
                        $temp = true;
                    } else {
                        $temp = false;
                        break;
                    }
                }
                if ($temp) {
                    $account->product_status = 'sold';
                }
                $account->save();

                session([
                    'order_info' => [
                        'order_id' => $order->id,
                        'user_id' => $user->id,
                        'product_type' => $product_type,
                        'transaction_id' => $transaction->id,
                        'product_id' => $product_id,
                        'total_price' => $totalPrice,
                        'quantity' => $quantity,
                        'email_channel_ids' => $emailChannelIds,
                        'type' => 'product'
                    ],
                ]);
                if ($request->payment_method == 'perfectmoney') {
                    $data = Store::where('id', '1')->first();
                    $view_data = [
                        'PAYEE_ACCOUNT' => 'U27825077',
                        'PAYEE_NAME' => 'Web Creator Zone',
                        'PAYMENT_AMOUNT' => $totalPrice,
                        'PAYMENT_UNITS' => 'USD',
                        'PAYMENT_URL' => url('/perfectmoney/thanks'),
                        'NOPAYMENT_URL' => url('/perfectmoney/cancel'),
                    ];
                    return view('frontend.perfectmoney', compact('data'), $view_data);
                } else {
                    $orderInfo = session('order_info');
                    $user = User::where('id', $orderInfo['user_id'])->first();
                    if ($user->referral != null) {
                        $data = Store::where('id', '1')->first();
                        $referral_user = User::where('username', $user->referral)->first();
                        $referral_user->referral_balance = $referral_user->referral_balance - ($orderInfo['total_price'] * $data->referral_percentage / 100);
                        $referral_user->balance = $referral_user->balance - ($orderInfo['total_price'] * $data->referral_percentage / 100);
                        $referral_user->save();
                    }
                    $order = Order::where('id', $orderInfo['order_id'])->first();
                    $transaction = Transaction::where('id', $orderInfo['transaction_id'])->first();
                    $order->status = 'canceled';
                    $order->save();
                    $transaction->status = 'canceled';
                    $transaction->save();

                    if ($orderInfo['product_type'] == 'GamingAccount') {
                        $emailChannelIds = $orderInfo['email_channel_ids'];
                        $channels = EmailChannel::whereIn('id', $emailChannelIds)->get();
                        foreach ($channels as $ch) {
                            $ch->status = 'available';
                            $ch->save();
                        }
                        $product = GamingAccount::where('id', $orderInfo['product_id'])->first();
                        $product->product_status = 'available';
                        $product->save();
                    } 
                    session()->forget('order_info');
                    return redirect()->back()->withErrors(['Error ocurecd' => 'Transaction Error!']);
                }
            } else {
                $orderInfo = session('order_info');
                $user = User::where('id', $orderInfo['user_id'])->first();
                if ($user->referral != null) {
                    $data = Store::where('id', '1')->first();
                    $referral_user = User::where('username', $user->referral)->first();
                    $referral_user->referral_balance = $referral_user->referral_balance - ($orderInfo['total_price'] * $data->referral_percentage / 100);
                    $referral_user->balance = $referral_user->balance - ($orderInfo['total_price'] * $data->referral_percentage / 100);
                    $referral_user->save();
                }
                $order = Order::where('id', $orderInfo['order_id'])->first();
                $transaction = Transaction::where('id', $orderInfo['transaction_id'])->first();
                $order->status = 'canceled';
                $order->save();
                $transaction->status = 'canceled';
                $transaction->save();

                if ($orderInfo['product_type'] == 'GamingAccount') {
                    $emailChannelIds = $orderInfo['email_channel_ids'];
                    $channels = EmailChannel::whereIn('id', $emailChannelIds)->get();
                    foreach ($channels as $ch) {
                        $ch->status = 'available';
                        $ch->save();
                    }
                    $product = GamingAccount::where('id', $orderInfo['product_id'])->first();
                    $product->product_status = 'available';
                    $product->save();
                } 
                session()->forget('order_info');
                return redirect()->back()->withErrors(['Error ocurecd' => 'Transaction Error!']);
            }
        } else {
            $orderInfo = session('order_info');
            $user = User::where('id', $orderInfo['user_id'])->first();
            if ($user->referral != null) {
                $data = Store::where('id', '1')->first();
                $referral_user = User::where('username', $user->referral)->first();
                $referral_user->referral_balance = $referral_user->referral_balance - ($orderInfo['total_price'] * $data->referral_percentage / 100);
                $referral_user->balance = $referral_user->balance - ($orderInfo['total_price'] * $data->referral_percentage / 100);
                $referral_user->save();
            }
            $order = Order::where('id', $orderInfo['order_id'])->first();
            $transaction = Transaction::where('id', $orderInfo['transaction_id'])->first();
            $order->status = 'canceled';
            $order->save();
            $transaction->status = 'canceled';
            $transaction->save();

            if ($orderInfo['product_type'] == 'GamingAccount') {
                $emailChannelIds = $orderInfo['email_channel_ids'];
                $channels = EmailChannel::whereIn('id', $emailChannelIds)->get();
                foreach ($channels as $ch) {
                    $ch->status = 'available';
                    $ch->save();
                }
                $product = GamingAccount::where('id', $orderInfo['product_id'])->first();
                $product->product_status = 'available';
                $product->save();
            } 
            session()->forget('order_info');
            return redirect()->back()->withErrors(['Error ocurecd' => 'Transaction Error!']);
        }
    }

    public function addBalance(Request $request) {
        if (Auth::check()) {
            $request->validate([
                'payment_method' => 'required',
            ]);
            $user = Auth::user();
        } 

        $totalPrice = intVal($request->totalPrice);
        $data = Store::where('id', '1')->first();

        $user->balance = $user->balance + $totalPrice;
        $user->save();

        $quantity = intVal(1);

        $transaction = new BalanceTransaction();
        $transaction->user_id = $user->id;
        $transaction->status = 'pending';
        $transaction->save();

        session([
            'order_info' => [
                'user_id' => $user->id,
                'transaction_id' => $transaction->id,
                'total_price' => $totalPrice,
                'quantity' => $quantity,
                'type' => 'balance',
            ],
        ]);


        if ($request->payment_method == 'perfectmoney') {
            $data = Store::where('id', '1')->first();
            $view_data = [
                'PAYEE_ACCOUNT' => 'U27825077',
                'PAYEE_NAME' => 'Web Creator Zone',
                'PAYMENT_AMOUNT' => $totalPrice,
                'PAYMENT_UNITS' => 'USD',
                'PAYMENT_URL' => url('/perfectmoney/thanks'),
                'NOPAYMENT_URL' => url('/perfectmoney/cancel'),
            ];
            return view('frontend.perfectmoney', compact('data'), $view_data);
        } else {
            $orderInfo = session('order_info');
            $user = User::where('id', $orderInfo['user_id'])->first();
            $transaction = BalanceTransaction::where('id', $orderInfo['transaction_id'])->first();
            $user->balance = $user->balance - $orderInfo['total_price'];
            $user->save();
            $transaction->status = 'canceled';
            $transaction->save();
            
            session()->forget('order_info');
            return redirect()->back()->withErrors(['Error ocurecd' => 'Transaction Error!']);
        }
        
    }

    public function success(Request $request)
    {
        $data = Store::find('1');
        $orderInfo = session('order_info');
        
        $user = User::where('id', $orderInfo['user_id'])->first();
        
        if($orderInfo['type'] == 'balance') {
            $balanceTransaction = BalanceTransaction::where('id', $orderInfo['transaction_id'])->first();
            $balanceTransaction->status = 'success';
            $balanceTransaction->save();
        } else {
            $transaction = Transaction::where('id', $orderInfo['transaction_id'])->first();
            $transaction->status = 'success';
            $transaction->save();
            $order = Order::where('id', $orderInfo['order_id'])->first();
            $order->status = 'success';
            $order->save();
            if ($orderInfo['product_type'] == 'GamingAccount') {
                $emailChannelIds = $orderInfo['email_channel_ids'];
                $channels = EmailChannel::whereIn('id', $emailChannelIds)->get();
                Mail::to($user->email)->send(new OrderMail($channels, $user->name, $orderInfo['product_type']));
            } 
        }
        session()->forget('order_info');
        return view('frontend.thanks', compact('data'));
    }


    public function cancel(Request $request)
    {
        $data = Store::find('1');
        $orderInfo = session('order_info');
        $user = User::where('id', $orderInfo['user_id'])->first();
        
        if($orderInfo['type'] == 'balance') {
            $balanceTransaction = BalanceTransaction::where('id', $orderInfo['transaction_id'])->first();
            $balanceTransaction->status = 'success';
            $balanceTransaction->save();
            $user->balance = $user->balance - $orderInfo['total_price'];
            $user->save();
        } else {
            if ($user->referral != null) {
                $data = Store::where('id', '1')->first();
                $referral_user = User::where('username', $user->referral)->first();
                $referral_user->referral_balance = $referral_user->referral_balance - ($orderInfo['total_price'] * $data->referral_percentage / 100);
                $referral_user->balance = $referral_user->balance - ($orderInfo['total_price'] * $data->referral_percentage / 100);
                $referral_user->save();
            }
            $transaction = Transaction::where('id', $orderInfo['transaction_id'])->first();
            $transaction->status = 'canceled';
            $transaction->save();
            $order = Order::where('id', $orderInfo['order_id'])->first();
            $order->status = 'canceled';
            $order->save();
            if ($orderInfo['product_type'] == 'GamingAccount') {
                $emailChannelIds = $orderInfo['email_channel_ids'];
                $channels = EmailChannel::whereIn('id', $emailChannelIds)->get();
                foreach ($channels as $ch) {
                    $ch->status = 'available';
                    $ch->save();
                }
                $product = GamingAccount::where('id', $orderInfo['product_id'])->first();
                $product->product_status = 'available';
                $product->save();
            } 
        }
        session()->forget('order_info');
        return view('frontend.cancel', compact('data'));
    }

    
}
