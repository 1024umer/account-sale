<?php

namespace App\Http\Controllers\Frontend;

use Stripe\Stripe;
use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Mail\OrderMail;
use App\Models\KeyChannel;
use App\Models\LicenceKey;
use App\Models\Transaction;
use App\Models\EmailChannel;
use Illuminate\Http\Request;
use App\Models\GamingAccount;
use App\Models\ManualPayment;
use App\Models\BalanceTransaction;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class StripeController extends Controller
{
    public function pay(Request $request)
    {
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

        if ($product_type == 'GamingAccount') {
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
                    if ($user->referral != null) {
                        $referral_user = User::where('username', $user->referral)->first();
                        $referral_user->referral_balance = $referral_user->referral_balance + ($totalPrice * $data->referral_percentage / 100);
                        $referral_user->balance = $referral_user->balance + ($totalPrice * $data->referral_percentage / 100);
                        $referral_user->save();
                    }
                    $emailChannelIds = $availableEmailChannels->take($quantity)->pluck('id');
                    $emailChannelsss = '';
                    foreach ($emailChannelIds as $emailids) {
                        $emailChannelsss .= $emailids . '@';
                    }

                    if ($request->payment_method == 'stripe' || $request->payment_method == 'balance') {
                        $order = new Order();
                        $order->status = 'pending';
                        $order->user_id = $user->id;
                        $order->easy_mode = $request->easy_mode;

                        $order->amount = $totalPrice;
                        $order->orderable_id = $product_id;
                        $order->channel_id = $emailChannelsss;
                        $order->orderable_type = 'App\Models\GamingAccount';
                        $order->save();
                        $transaction = new Transaction();
                        $transaction->user_id = $user->id;
                        $transaction->order_id = $order->id;
                        $transaction->status = 'pending';
                        $transaction->payment_method = 'Stripe';
                        $transaction->save();
                    } else {
                        $manual = new ManualPayment();
                        $manual->status = 'pending';
                        $manual->user_id = $user->id;
                        $manual->easy_mode = $request->easy_mode;

                        $manual->amount = $totalPrice;
                        $manual->orderable_id = $product_id;
                        if ($request->hasFile('payment_proof')) {
                            $uploadedFile = $request->file('payment_proof');
                            $filename = $uploadedFile->getClientOriginalName();
                            $publicDirectory = public_path('assets/paymentproof');
                            $uploadedFile->move($publicDirectory, $filename);
                            $filePath = 'assets/paymentproof/' . $filename;
                            $manual->image = $filePath;
                        }
                        $manual->orderable_type = 'App\Models\GamingAccount';
                        $manual->save();
                        $transaction = new Transaction();
                        $transaction->user_id = $user->id;
                        $transaction->manual_id = $manual->id;
                        $transaction->status = 'pending';
                        $transaction->payment_method = $request->payment_method;
                        $transaction->save();
                    }

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



                    if ($request->payment_method == 'stripe') {
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
                                'payment_method' => $request->payment_method,
                                'type' => 'product'
                            ],
                        ]);
                        try {
                            Stripe::setApiKey($data->stripe_secret);
                            $domain = URL::to('/');
                            $YOUR_DOMAIN = $domain;
                            $session = \Stripe\Checkout\Session::create([
                                'payment_method_types' => ['card'],
                                'line_items' => [
                                    [
                                        'price_data' => [
                                            'currency' => 'usd',
                                            'product_data' => [
                                                'name' => $account->title,
                                            ],
                                            'unit_amount' => intval($totalPrice * 100),
                                        ],
                                        'quantity' => $quantity,
                                    ],
                                ],
                                'mode' => 'payment',
                                'customer_email' => $user->email,
                                'success_url' => $YOUR_DOMAIN . '/thanks',
                                'cancel_url' => $YOUR_DOMAIN . '/cancel',
                            ]);
                            return redirect()->away($session->url);
                        } catch (\Exception $e) {
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
                            } else if ($orderInfo['product_type'] == 'LicenceKey') {
                                $keyChannelIds = $orderInfo['key_channel_ids'];
                                $channels = KeyChannel::whereIn('id', $keyChannelIds)->get();
                                foreach ($channels as $ch) {
                                    $ch->status = 'available';
                                    $ch->save();
                                }
                                $product = LicenceKey::where('id', $orderInfo['product_id'])->first();
                                $product->product_status = 'available';
                                $product->save();
                            }

                            session()->forget('order_info');
                            $errorMessage = $e->getMessage();
                            return redirect()->back()->withErrors(['error' => $errorMessage]);
                        }
                    } else if ($request->payment_method == 'balance') {
                        $transaction->payment_method = 'Balance';
                        $transaction->save();
                        $user->balance = $user->balance - $totalPrice;
                        $user->save();
                        return redirect()->away(URL::to('/') . '/thanks');
                    } else if ($request->payment_method == 'paybis_manual' || $request->payment_method == 'payeer_manual') {
                        session([
                            'order_info' => [
                                'order_id' => $manual->id,
                                'user_id' => $user->id,
                                'product_type' => $product_type,
                                'transaction_id' => $transaction->id,
                                'product_id' => $product_id,
                                'total_price' => $totalPrice,
                                'quantity' => $quantity,
                                'email_channel_ids' => $emailChannelIds,
                                'payment_method' => $request->payment_method,
                                'type' => 'product'
                            ],
                        ]);
                        $transaction->payment_method = $request->payment_method;
                        $transaction->save();
                        return redirect()->away(URL::to('/') . '/thanks');
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
                    } else if ($orderInfo['product_type'] == 'LicenceKey') {
                        $keyChannelIds = $orderInfo['key_channel_ids'];
                        $channels = KeyChannel::whereIn('id', $keyChannelIds)->get();
                        foreach ($channels as $ch) {
                            $ch->status = 'available';
                            $ch->save();
                        }
                        $product = LicenceKey::where('id', $orderInfo['product_id'])->first();
                        $product->product_status = 'available';
                        $product->save();
                    }

                    session()->forget('order_info');
                    return redirect()->back()->withErrors(['quantity' => __('Error occurred. Try with less quantity')])->withInput();
                }
            } else {
                return redirect()->back()->withErrors(['product' => __('Error occurred. Product error.')])->withInput();
            }
        } else if ($product_type == 'LicenceKey') {
            $licenceKey = LicenceKey::where('id', $product_id)
                ->where('status', 'active')
                ->where('product_status', 'available')
                ->with(['keyChannels' => function ($query) use ($unitPrice) {
                    $query->where('price', $unitPrice)->where('status', 'available');
                }])
                ->first();

            if ($licenceKey) {
                $days = $request->days;
                $channels = KeyChannel::where('licence_key_id', $licenceKey->id)
                    ->where('days', $days)
                    ->where('status', 'available')
                    ->get();

                if (count($channels) >= $quantity) {
                    $channels = KeyChannel::where('licence_key_id', $licenceKey->id)
                        ->where('days', $days)
                        ->where('status', 'available')
                        ->take($quantity)
                        ->get();
                    if ($request->payment_method == 'stripe' || $request->payment_method == 'balance') {
                        $order = new Order();
                        $order->status = 'pending';
                        $order->user_id = $user->id;
                        $order->amount = $quantity * $channels[0]->price;
                        $order->orderable_id = $product_id;
                        $order->orderable_type = 'App\Models\LicenceKey';
                        $order->save();

                        $transaction = new Transaction();
                        $transaction->status = 'pending';
                        $transaction->user_id = $user->id;
                        $transaction->order_id = $order->id;
                        $transaction->payment_method = 'Stripe';
                        $transaction->save();
                    } else {
                        $manual = new ManualPayment();
                        $manual->status = 'pending';
                        $manual->user_id = $user->id;
                        $manual->amount = $totalPrice;
                        $manual->orderable_id = $product_id;
                        if ($request->hasFile('payment_proof')) {
                            $uploadedFile = $request->file('payment_proof');
                            $filename = $uploadedFile->getClientOriginalName();
                            $publicDirectory = public_path('assets/paymentproof');
                            $uploadedFile->move($publicDirectory, $filename);
                            $filePath = 'assets/paymentproof/' . $filename;
                            $manual->image = $filePath;
                        }
                        $manual->orderable_type = 'App\Models\GamingAccount';
                        $manual->save();
                        $transaction = new Transaction();
                        $transaction->status = 'pending';
                        $transaction->user_id = $user->id;
                        $transaction->manual_id = $manual->id;
                        $transaction->payment_method = $request->payment_method;
                        $transaction->save();
                    }

                    foreach ($channels as $ch) {
                        $ch->status = 'sold';
                        $ch->save();
                    }

                    $licenceKey = LicenceKey::where('id', $licenceKey->id)->with('keyChannels')->first();
                    $temp = false;
                    foreach ($licenceKey->keyChannels as $ch) {
                        if ($ch->status == 'sold') {
                            $temp = true;
                        } else {
                            $temp = false;
                            break;
                        }
                    }
                    if ($temp) {
                        $licenceKey->product_status = 'sold';
                    }
                    $licenceKey->save();

                    if ($request->payment_method == 'stripe') {
                        session([
                            'order_info' => [
                                'order_id' => $order->id,
                                'user_id' => $user->id,
                                'product_type' => $product_type,
                                'product_id' => $product_id,
                                'total_price' => $totalPrice,
                                'quantity' => $quantity,
                                'transaction_id' => $transaction->id,
                                'key_channel_ids' => $channels->pluck('id'),
                                'type' => 'product',
                            ],
                        ]);
                        try {
                            Stripe::setApiKey($data->stripe_secret);
                            $domain = URL::to('/');
                            $YOUR_DOMAIN = $domain;
                            $session = \Stripe\Checkout\Session::create([
                                'payment_method_types' => ['card'],
                                'line_items' => [
                                    [
                                        'price_data' => [
                                            'currency' => 'usd',
                                            'product_data' => [
                                                'name' => $licenceKey->title,
                                            ],
                                            'unit_amount' => intval($channels[0]->price * 100),
                                        ],
                                        'quantity' => $quantity,
                                    ],
                                ],
                                'mode' => 'payment',
                                'customer_email' => $user->email,
                                'success_url' => $YOUR_DOMAIN . '/thanks',
                                'cancel_url' => $YOUR_DOMAIN . '/cancel',
                            ]);
                            return redirect()->away($session->url);
                        } catch (\Exception $e) {
                            $orderInfo = session('order_info');
                            $user = User::where('id', $orderInfo['user_id'])->first();
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
                            } else if ($orderInfo['product_type'] == 'LicenceKey') {
                                $keyChannelIds = $orderInfo['key_channel_ids'];
                                $channels = KeyChannel::whereIn('id', $keyChannelIds)->get();
                                foreach ($channels as $ch) {
                                    $ch->status = 'available';
                                    $ch->save();
                                }
                                $product = LicenceKey::where('id', $orderInfo['product_id'])->first();
                                $product->product_status = 'available';
                                $product->save();
                            }

                            session()->forget('order_info');
                            $errorMessage = $e->getMessage();
                            return redirect()->back()->withErrors(['error' => $errorMessage]);
                        }
                    } else if ($request->payment_method == 'paybis_manual' || $request->payment_method == 'payeer_manual') {
                        session([
                            'order_info' => [
                                'order_id' => $manual->id,
                                'user_id' => $user->id,
                                'product_type' => $product_type,
                                'product_id' => $product_id,
                                'total_price' => $totalPrice,
                                'quantity' => $quantity,
                                'transaction_id' => $transaction->id,
                                'key_channel_ids' => $channels->pluck('id'),
                                'type' => 'product',
                            ],
                        ]);
                        $transaction->payment_method = $request->payment_method;
                        $transaction->save();
                        return redirect()->away(URL::to('/') . '/thanks');
                    }
                } else {
                    $orderInfo = session('order_info');
                    $user = User::where('id', $orderInfo['user_id'])->first();
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
                    } else if ($orderInfo['product_type'] == 'LicenceKey') {
                        $keyChannelIds = $orderInfo['key_channel_ids'];
                        $channels = KeyChannel::whereIn('id', $keyChannelIds)->get();
                        foreach ($channels as $ch) {
                            $ch->status = 'available';
                            $ch->save();
                        }
                        $product = LicenceKey::where('id', $orderInfo['product_id'])->first();
                        $product->product_status = 'available';
                        $product->save();
                    }

                    session()->forget('order_info');
                    return redirect()->back()->withErrors(['quantity' => __('Error occurred. Try with less quantity')])->withInput();
                }
            } else {
                return redirect()->back()->withErrors(['product' => __('Error occurred. Product error.')])->withInput();
            }
        } else {
            return redirect()->back()->withErrors(['product' => __('Error occured. Product error.')])->withInput();
        }
    }

    public function addBalance(Request $request)
    {
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

        if ($request->payment_method == 'stripe') {
            try {
                Stripe::setApiKey($data->stripe_secret);
                $domain = URL::to('/');
                $YOUR_DOMAIN = $domain;
                $session = \Stripe\Checkout\Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [
                        [
                            'price_data' => [
                                'currency' => 'usd',
                                'product_data' => [
                                    'name' => 'Account Balance',
                                ],
                                'unit_amount' => intval($totalPrice * 100),
                            ],
                            'quantity' => 1,
                        ],
                    ],
                    'mode' => 'payment',
                    'customer_email' => $user->email,
                    'success_url' => $YOUR_DOMAIN . '/thanks',
                    'cancel_url' => $YOUR_DOMAIN . '/cancel',
                ]);
                return redirect()->away($session->url);
            } catch (\Exception $e) {
                $orderInfo = session('order_info');
                $user = User::where('id', $orderInfo['user_id'])->first();
                $transaction = BalanceTransaction::where('id', $orderInfo['transaction_id'])->first();
                $user->balance = $user->balance - $orderInfo['total_price'];
                $user->save();
                $transaction->status = 'canceled';
                $transaction->save();

                session()->forget('order_info');
                $errorMessage = $e->getMessage();
                return redirect()->back()->withErrors(['error' => $errorMessage]);
            }
        }
    }

    public function stripeThanks()
    {
        $data = Store::find('1');
        $orderInfo = session('order_info');

        $user = User::where('id', $orderInfo['user_id'])->first();
        if ($orderInfo['payment_method'] == 'paybis_manual' || $orderInfo['payment_method'] == 'payeer_manual') {
            session()->forget('order_info');
            return view('frontend.thanksmanual', compact('data'));
        }

        if ($orderInfo['type'] == 'balance') {
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
            $orderMode=$order->easy_mode;
            if ($orderInfo['product_type'] == 'GamingAccount') {

                $emailChannelIds = $orderInfo['email_channel_ids'];
                $channels = EmailChannel::whereIn('id', $emailChannelIds)->get();
                Mail::to($user->email)->send(new OrderMail($channels, $user->name, $orderInfo['product_type'],$orderMode));
            } else if ($orderInfo['product_type'] == 'LicenceKey') {
                $keyChannelIds = $orderInfo['key_channel_ids'];
                $channels = KeyChannel::whereIn('id', $keyChannelIds)->get();
                Mail::to($user->email)->send(new OrderMail($channels, $user->name, $orderInfo['product_type']));
            }
        }
        session()->forget('order_info');
        return view('frontend.thanks', compact('data'));
    }


    public function stripeCancel()
    {
        $data = Store::find('1');
        $orderInfo = session('order_info');
        $user = User::where('id', $orderInfo['user_id'])->first();

        if ($orderInfo['type'] == 'balance') {
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
            } else if ($orderInfo['product_type'] == 'LicenceKey') {
                $keyChannelIds = $orderInfo['key_channel_ids'];
                $channels = KeyChannel::whereIn('id', $keyChannelIds)->get();
                foreach ($channels as $ch) {
                    $ch->status = 'available';
                    $ch->save();
                }
                $product = LicenceKey::where('id', $orderInfo['product_id'])->first();
                $product->product_status = 'available';
                $product->save();
            }
        }
        session()->forget('order_info');
        return view('frontend.cancel', compact('data'));
    }
}
