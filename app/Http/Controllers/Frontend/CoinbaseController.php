<?php

namespace App\Http\Controllers\Frontend;

use App\Models\BalanceTransaction;
use Exception;
use Throwable;
use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Models\KeyChannel;
use App\Models\LicenceKey;
use App\Models\Transaction;
use App\Models\EmailChannel;
use Illuminate\Http\Request;
use App\Models\GamingAccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class CoinbaseController extends Controller
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
                        $referral_user->balance = $referral_user->balance + ($totalPrice * $data->referral_percentage / 100);
                        $referral_user->referral_balance = $referral_user->referral_balance + ($totalPrice * $data->referral_percentage / 100);
                        $referral_user->save();
                    }
                    $order = new Order();
                    $order->status = 'pending';
                    $order->user_id = $user->id;
                    $order->amount = $totalPrice;
                    $order->orderable_id = $product_id;
                    $order->orderable_type = 'App\Models\GamingAccount';
                    $order->save();

                    $transaction = new Transaction();
                    $transaction->user_id = $user->id;
                    $transaction->order_id = $order->id;
                    $transaction->status = 'pending';
                    $transaction->payment_method = 'Coinbase';
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
                        ],
                    ]);
                    if ($request->payment_method == 'coinbase') {
                        try {
                            $url = 'https://api.commerce.coinbase.com/charges';
                            $array = [
                                'name' => $account->title,
                                'description' => '',
                                'local_price' => [
                                    'amount' => $totalPrice,
                                    'currency' => 'usd'
                                ],
                                'pricing_type' => "fixed_price",
                                'redirect_url' => route('stripe.thanks'),
                                'cancel_url' => route('stripe.cancel')
                            ];

                            $yourjson = json_encode($array);
                            $ch = curl_init();
                            $apiKey = $data->coinbase_api_key;
                            $apiVersion = $data->coinbase_api_version;
                            $header = [
                                'Content-Type: application/json',
                                'X-CC-Api-Key: ' . $apiKey,
                                // 'X-CC-Version: 2018-03-22',
                                'X-CC-Version: ' . $apiVersion
                            ];

                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $yourjson);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                            $result = curl_exec($ch);

                            if ($result === false) {
                                $orderInfo = session('order_info');
                                $user = User::where('id', $orderInfo['user_id'])->first();
                                if ($user->referral != null) {
                                    $data = Store::where('id', '1')->first();
                                    $referral_user = User::where('username', $user->referral)->first();
                                    $referral_user->balance = $referral_user->balance - ($orderInfo['total_price'] * $data->referral_percentage / 100);
                                    $referral_user->referral_balance = $referral_user->referral_balance - ($orderInfo['total_price'] * $data->referral_percentage / 100);
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
                                return redirect()->back()->withErrors(['Error ocurecd' => curl_error($ch)]);
                            }

                            curl_close($ch);

                            $result = json_decode($result);

                            if (isset($result->error)) {
                                $orderInfo = session('order_info');
                                $user = User::where('id', $orderInfo['user_id'])->first();
                                if ($user->referral != null) {
                                    $data = Store::where('id', '1')->first();
                                    $referral_user = User::where('username', $user->referral)->first();
                                    $referral_user->balance = $referral_user->balance - ($orderInfo['total_price'] * $data->referral_percentage / 100);
                                    $referral_user->referral_balance = $referral_user->referral_balance - ($orderInfo['total_price'] * $data->referral_percentage / 100);
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
                                return redirect()->back()->withErrors(['Error ocurecd' => 'Something went wrong']);
                            } else {
                                return Redirect::away($result->data->hosted_url);
                            }
                        } catch (Throwable $e) {
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
                            return redirect()->back()->withErrors(['Error ocurecd' => $e->getMessage()]);
                        }
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
                    $transaction->payment_method = 'Coinbase';
                    $transaction->save();

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
                        ],
                    ]);

                    if ($request->payment_method == 'coinbase') {
                        try {
                            $url = 'https://api.commerce.coinbase.com/charges';
                            $array = [
                                'name' => $licenceKey->title,
                                'description' => '',
                                'local_price' => [
                                    'amount' => $totalPrice,
                                    'currency' => 'usd'
                                ],
                                'pricing_type' => "fixed_price",
                                'redirect_url' => route('stripe.thanks'),
                                'cancel_url' => route('stripe.cancel')
                            ];

                            $yourjson = json_encode($array);
                            $ch = curl_init();
                            $apiKey = $data->coinbase_api_key;
                            $apiVersion = $data->coinbase_api_version;
                            $header = [
                                'Content-Type: application/json',
                                'X-CC-Api-Key: ' . $apiKey,
                                // 'X-CC-Version: 2018-03-22',
                                'X-CC-Version: ' . $apiVersion
                            ];

                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $yourjson);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                            $result = curl_exec($ch);

                            if ($result === false) {
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
                                return redirect()->back()->withErrors(['Error ocurecd' => curl_error($ch)]);
                            }

                            curl_close($ch);

                            $result = json_decode($result);

                            if (isset($result->error)) {
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
                                return redirect()->back()->withErrors(['Error ocurecd' => 'Something went wrong']);
                            } else {
                                return Redirect::away($result->data->hosted_url);
                            }
                        } catch (Throwable $e) {
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
                            return redirect()->back()->withErrors(['Error ocurecd' => $e->getMessage()]);
                        }
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

        $data = Store::where('id', '1')->first();

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

        if ($request->payment_method == 'coinbase') {
            try {
                $url = 'https://api.commerce.coinbase.com/charges';
                $array = [
                    'name' => $user->name,
                    'description' => '',
                    'local_price' => [
                        'amount' => $totalPrice,
                        'currency' => 'usd'
                    ],
                    'pricing_type' => "fixed_price",
                    'redirect_url' => route('stripe.thanks'),
                    'cancel_url' => route('stripe.cancel')
                ];

                $yourjson = json_encode($array);
                $ch = curl_init();
                $apiKey = $data->coinbase_api_key;
                $apiVersion = $data->coinbase_api_version;
                $header = [
                    'Content-Type: application/json',
                    'X-CC-Api-Key: ' . $apiKey,
                    // 'X-CC-Version: 2018-03-22',
                    'X-CC-Version: ' . $apiVersion
                ];

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $yourjson);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $result = curl_exec($ch);

                if ($result === false) {
                    $orderInfo = session('order_info');
                    $user = User::where('id', $orderInfo['user_id'])->first();
                    $user = User::where('id', $orderInfo['user_id'])->first();
                    $transaction = BalanceTransaction::where('id', $orderInfo['transaction_id'])->first();
                    $user->balance = $user->balance - $orderInfo['total_price'];
                    $user->save();
                    $transaction->status = 'canceled';
                    $transaction->save();
                    
                    session()->forget('order_info');
                    return redirect()->back()->withErrors(['Error ocurecd' => curl_error($ch)]);
                }

                curl_close($ch);

                $result = json_decode($result);

                if (isset($result->error)) {
                    $orderInfo = session('order_info');
                    $user = User::where('id', $orderInfo['user_id'])->first();
                    $user = User::where('id', $orderInfo['user_id'])->first();
                    $transaction = BalanceTransaction::where('id', $orderInfo['transaction_id'])->first();
                    $user->balance = $user->balance - $orderInfo['total_price'];
                    $user->save();
                    $transaction->status = 'canceled';
                    $transaction->save();

                    session()->forget('order_info');
                    return redirect()->back()->withErrors(['Error ocurecd' => 'Something went wrong']);
                } else {
                    return Redirect::away($result->data->hosted_url);
                }
            } catch (Throwable $e) {
                $orderInfo = session('order_info');
                $user = User::where('id', $orderInfo['user_id'])->first();
                $user = User::where('id', $orderInfo['user_id'])->first();
                $transaction = BalanceTransaction::where('id', $orderInfo['transaction_id'])->first();
                $user->balance = $user->balance - $orderInfo['total_price'];
                $user->save();
                $transaction->status = 'canceled';
                $transaction->save();

                session()->forget('order_info');
                return redirect()->back()->withErrors(['Error ocurecd' => $e->getMessage()]);
            }
        }
    }
}
