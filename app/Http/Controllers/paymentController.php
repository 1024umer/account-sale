<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Mail\OrderMail;
use App\Models\KeyChannel;
use App\Models\LicenceKey;
use App\Models\Transaction;
use App\Models\EmailChannel;
use App\Models\GamingAccount;
use App\Models\ManualPayment;
use App\Models\OrderProduct;
use App\Models\BalanceTransaction;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use DB;



class paymentController extends Controller
{
  public function check_vpn_proxy(Request $request)
  {
    $ipaddress = $request->ip();// Get IP
    $apikey = "MjIzMzQ6UjU1bVppV3ZKRnV4eFVLVFRYNFdXUmw4a1gzaDFZNnM="; // API Key

    // cURL request
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://v2.api.iphub.info/ip/" . $ipaddress,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "x-key: " . $apikey
        ),
    ));

    $response = json_decode(curl_exec($curl));
    $err = curl_error($curl);

    curl_close($curl);

    $block = 0;

    if ($err) {
        echo "cURL Error :" . $err;
    } else {
        $block = $response->block;
        // Check if 'country' field is present in the API response
        $country = $response->countryName;
    }

    $result = ($block == 1) ? "Using VPN or Proxy." : "Not using VPN or Proxy.";

    $using_proxy = ($block == 1) ? '1' : '0';

    return ['ip_address' => $ipaddress, 'country' => $country, 'result' => $result, 'using_proxy' => $using_proxy];
  }
    public function payment(Request $request){

    if($request->paymentMethod == 'stripe'){
        if (Auth::check()) {
        if(session('cart'))
        {
            $total = 0;
            $product_id = 0;
        foreach(session('cart') as $id => $details){
            $total += $details['price'] * $details['quantity'];
            $product_id = $id;
    }
    $check_proxy = $this->check_vpn_proxy();
    $emailChannelsss = '';

    $order = new Order();
    $order->status = 'pending';
    $order->user_id = Auth::user()->id;
    $order->amount = $total;
    $order->orderable_id = $product_id;
    $order->easy_mode = $request->easy_mode;
    $order->channel_id = $emailChannelsss;
    $order->orderable_type = 'App\Models\GamingAccount';
    $order->ip_address = $check_proxy['ip_address'];
    $order->country = $check_proxy['country'];
    $order->using_proxy = $check_proxy['using_proxy'];
    $order->save();
    $transaction = new Transaction();
    $transaction->user_id = Auth::user()->id;
    $transaction->order_id = $order->id;
    $transaction->status = 'pending';
    $transaction->payment_method = 'Stripe';
    $transaction->save();


    foreach(session('cart') as $id => $details){
        $total += $details['price'] * $details['quantity'];

      $orderproduct = new OrderProduct();
      $orderproduct->order_id = $order->id;
      $orderproduct->gaming_accounts_id = $id;
      $orderproduct->quantity = $details['quantity'];
      $orderproduct->price = $details['price'];
      $orderproduct->save();


}
$data = Store::where('id', '1')->first();

$user = Auth::user();
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
                      'name' => 'Gaming Account',
                  ],
                  'unit_amount' => intval($total * 100),
              ],
              'quantity' => $details['quantity'],
          ],
      ],
      'mode' => 'payment',
      'customer_email' => $user->email,
      'success_url' => $YOUR_DOMAIN . '/thanksPayment',
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


}
session()->flush();

        }else{
            return redirect()->route('login');
         }

    }elseif($request->paymentMethod == 'paypal'){


     if (Auth::check()) {
     if(session('cart'))
        {
                $total = 0;
                $product_id = 0;
            foreach(session('cart') as $id => $details){
                $total += $details['price'] * $details['quantity'];
                $product_id = $id;
             }
                   $check_proxy = $this->check_vpn_proxy();
                    $emailChannelsss = '';

                    $order = new Order();
                    $order->status = 'pending';
                    $order->user_id = Auth::user()->id;
                    $order->amount = $total;
                    $order->orderable_id = $product_id;
                    $order->channel_id = $emailChannelsss;
                    $order->orderable_type = 'App\Models\GamingAccount';
                    $order->ip_address = $check_proxy['ip_address'];
                    $order->country = $check_proxy['country'];
                    $order->using_proxy = $check_proxy['using_proxy'];
                    $order->save();
                    $transaction = new Transaction();
                    $transaction->user_id = Auth::user()->id;
                    $transaction->order_id = $order->id;
                    $transaction->status = 'pending';
                    $transaction->payment_method = 'paypal';
                    $transaction->save();


                foreach(session('cart') as $id => $details){
                    $total += $details['price'] * $details['quantity'];

                $orderproduct = new OrderProduct();
                $orderproduct->order_id = $order->id;
                $orderproduct->gaming_accounts_id = $id;
                $orderproduct->quantity = $details['quantity'];
                $orderproduct->price = $details['price'];
                $orderproduct->save();


                 }
                 session()->flush();
    return redirect()->route('home');

}
     }else{
        return redirect()->route('login');
     }
    }elseif($request->paymentMethod == 'coinbase'){

        if (Auth::check()) {
            if(session('cart'))
            {
                $total = 0;
                $product_id = 0;
            foreach(session('cart') as $id => $details){
                $total += $details['price'] * $details['quantity'];
                $product_id = $id;
        }
            $check_proxy = $this->check_vpn_proxy();
            $emailChannelsss = '';

        $order = new Order();
        $order->status = 'pending';
        $order->user_id = Auth::user()->id;
        $order->amount = $total;
        $order->orderable_id = $product_id;
        $order->channel_id = $emailChannelsss;
        $order->orderable_type = 'App\Models\GamingAccount';
        $order->ip_address = $check_proxy['ip_address'];
        $order->country = $check_proxy['country'];
        $order->using_proxy = $check_proxy['using_proxy'];
        $order->save();
        $transaction = new Transaction();
        $transaction->user_id = Auth::user()->id;
        $transaction->order_id = $order->id;
        $transaction->status = 'pending';
        $transaction->payment_method = 'coinbase';
        $transaction->save();


        foreach(session('cart') as $id => $details){
            $total += $details['price'] * $details['quantity'];

          $orderproduct = new OrderProduct();
          $orderproduct->order_id = $order->id;
          $orderproduct->gaming_accounts_id = $id;
          $orderproduct->quantity = $details['quantity'];
          $orderproduct->price = $details['price'];
          $orderproduct->save();


    }
    session()->flush();
    return redirect()->route('home');

}
}else{
    return redirect()->route('login');
 }
    }else{


        if (Auth::check()) {
            if(session('cart'))
            {
                $total = 0;
                $product_id = 0;
            foreach(session('cart') as $id => $details){
                $total += $details['price'] * $details['quantity'];
                $product_id = $id;
        }
        $check_proxy = $this->check_vpn_proxy();
        $emailChannelsss = '';

        $order = new Order();
        $order->status = 'pending';
        $order->user_id = Auth::user()->id;
        $order->amount = $total;
        $order->orderable_id = $product_id;
        $order->channel_id = $emailChannelsss;
        $order->orderable_type = 'App\Models\GamingAccount';
        $order->ip_address = $check_proxy['ip_address'];
        $order->country = $check_proxy['country'];
        $order->using_proxy = $check_proxy['using_proxy'];
        $order->save();
        $transaction = new Transaction();
        $transaction->user_id = Auth::user()->id;
        $transaction->order_id = $order->id;
        $transaction->status = 'pending';
        $transaction->payment_method = 'Manual';
        $transaction->save();


        foreach(session('cart') as $id => $details){
            $total += $details['price'] * $details['quantity'];

          $orderproduct = new OrderProduct();
          $orderproduct->order_id = $order->id;
          $orderproduct->gaming_accounts_id = $id;
          $orderproduct->quantity = $details['quantity'];
          $orderproduct->price = $details['price'];
          $orderproduct->save();


    }
    session()->flush();
    return redirect()->route('home');



}}else{
        return redirect()->route('login');
     }

    }
}

public function stripeThanks()
{
    $data = Store::find('1');
    $orderInfo = session('cart');
    $user=Auth()->user();
    $product_id = 0;
    $user = User::where('id', $user->id)->first();
    $total = 0;



      $transaction = Transaction::where('user_id', $user->id)
      ->orderBy('created_at', 'desc') // 'desc' should be a string
      ->first();

      $transaction->status = 'success';
        $transaction->save();
        $order = Order::where('id', $transaction->order_id )->first();
        $order->status = 'success';
        $order->save();
        $orderMode=$order->easy_mode;
        // if ($orderInfo['product_type'] == 'GamingAccount') {

          $channels = [];

          $channels = [];

          foreach(session('cart') as $id => $details){
              $total += $details['price'] * $details['quantity'];
              $product_id = $id;

              $name=DB::table('gaming_accounts')->where('id',$product_id)->first();
              // Retrieve channels for the current product
              $channelss = EmailChannel::where('gaming_account_id', $product_id)
                  ->where('status', 'available')
                  ->limit($details['quantity'])
                  ->get();

                  DB::table('email_channels')->where('gaming_account_id', $product_id)->update(['status' => 'sold']);

              // Add the channels to the array
              $channels = array_merge($channels, $channelss->toArray());
          }

          // Send a single email with information about all channels
          Mail::to($user->email)->send(new OrderMail($channels, $user->name, 'GamingAccountcart', $orderMode));


        // } else if ($orderInfo['product_type'] == 'LicenceKey') {
        //     $keyChannelIds = $orderInfo['key_channel_ids'];
        //     $channels = KeyChannel::whereIn('id', $keyChannelIds)->get();
        //     Mail::to($user->email)->send(new OrderMail($channels, $user->name, $orderInfo['product_type']));
        // }

    session()->forget('cart');
    return view('frontend.thanks', compact('data'));
}
}
