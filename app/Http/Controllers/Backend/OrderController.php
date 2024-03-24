<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use App\Mail\OrderMail;
use App\Models\KeyChannel;
use App\Models\LicenceKey;
use App\Models\Transaction;
use App\Models\EmailChannel;
use Illuminate\Http\Request;
use App\Models\GamingAccount;
use App\Models\ManualPayment;
use App\Models\UsingProxyUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
  public function index(Request $request)
  {
    $totalOrders = Order::count();
    return view('backend.orders.index', compact('totalOrders'));
  }

  public function manualIndex()
  {
    $totalOrders = ManualPayment::count();
    return view('backend.orders.manualindex', compact('totalOrders'));
  }

  public function list(Request $request)
  {
    try {
      $totalData = Order::count();
      $totalFiltered = $totalData;

      $limit = $request->input('length');
      $start = $request->input('start');
      $order = 'id';
      $dir = $request->input('order.0.dir');
      if (empty($request->input('search.value'))) {
        $results = Order::offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();
      } else {
        $search = $request->input('search.value');

        $results = Order::search($search)
          ->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();

        $totalFiltered = count($results);
      }

      $data = array();
      if (!empty($results)) {
        foreach ($results as $row) {
          $nestedData['id'] = $row->id;
          $nestedData['user'] = $row->user->name;
          $nestedData['product_title'] = $row->orderable->title;
          $nestedData['product_type'] = $row->orderable_type;
          $nestedData['amount'] = $row->amount;
          $nestedData['status'] = $row->status;
          $nestedData['easy_mode'] = $row->easy_mode;
          $nestedData['ip_address'] = $row->ip_address;
          $nestedData['country'] = $row->country;
          if ($row->using_proxy == 1) {
            // Add a button for blocking proxy
            $blockButton = '<button class="btn btn-sm btn-primary details-btn block-proxy-button"
                                      data-id="' . $row->id . '"  data-user="' . $row->user->id . '" data-ip="' . $row->ip_address . '"
                                      data-url="' . route('block.proxy') . '">Block</button>';
          } else {
            // Show 'No' if not using proxy
            $blockButton = 'No';
          }

          $nestedData['using_proxy'] = $blockButton;
          $nestedData['date'] = $row->created_at->format('M, d, Y');
          $nestedData['action'] = ($row->status == 'success')
            ? '<div class="btn-group">
                            <button class="btn btn-sm btn-primary details-btn"
                            data-user-id="' . $row->user_id . '" onclick="openRestockModal(' . $row->user_id . ')">Restock</button>
                            </div>'
            : '-';
          $data[] = $nestedData;
        }
      }

      $json_data = array(
        "draw"            => intval($request->input('draw')),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $data
      );

      echo json_encode($json_data);
    } catch (\Throwable $th) {
      throw $th;
    } catch (\Exception $e) {
      throw $e;
    }
  }

  public function manuallist(Request $request)
  {
    try {
      $totalData = ManualPayment::count();
      $totalFiltered = $totalData;

      $limit = $request->input('length');
      $start = $request->input('start');
      $order = 'id';
      $dir = $request->input('order.0.dir');
      if (empty($request->input('search.value'))) {
        $results = ManualPayment::offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();
      } else {
        $search = $request->input('search.value');

        $results = ManualPayment::search($search)
          ->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();

        $totalFiltered = count($results);
      }

      $data = array();
      if (!empty($results)) {
        foreach ($results as $row) {
          if ($row->status == 'pending') {
            $st = 'btn-warning';
            $status = 'inactive';
          } elseif ($row->status == 'success') {
            $st = 'btn-success';
            $status = 'active';
          }
          $nestedData['id'] = $row->id;
          $nestedData['user'] = $row->user->name;
          // $nestedData['product_title'] = $row->orderable->title;
          $nestedData['product_type'] = $row->orderable_type;
          $nestedData['amount'] = $row->amount;
          $nestedData['status'] = $row->status;
          $nestedData['easy_mode'] = $row->easy_mode;

          $nestedData['date'] = $row->created_at->format('M, d, Y');
          $nestedData['action'] = view('backend.orders._actions', [
            'row' => $row,
            'st' => $st,
            'status' => $status
          ])->render();
          $data[] = $nestedData;
        }
      }

      $json_data = array(
        "draw"            => intval($request->input('draw')),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $data
      );

      echo json_encode($json_data);
    } catch (\Throwable $th) {
      throw $th;
    } catch (\Exception $e) {
      throw $e;
    }
  }

  public function details($id)
  {
    $user = ManualPayment::with('user')->where('id', $id)->first();
    if ($user) {
      return view('backend.orders.details', compact('user'));
    } else {
      return redirect()->back();
    }
  }

  public function update(Request $request)
  {
    if ($request->status == 'success') {
      $tId = $request->id;
      $transaction = Transaction::where('manual_id', $tId)->first();
      $transaction->status = 'success';
      $transaction->save();
      $order = ManualPayment::where('id', $request->id)->first();
      $order->status = 'success';
      $order->save();
      //return $order->orderable_id;
      if ($order->orderable_type == 'App\Models\GamingAccount') {
        $account = GamingAccount::where('id', $order->orderable_id)
          ->where('status', 'active')
          ->with(['emailChannels' => function ($query) {
            $query;
          }])
          ->first();
        if ($account) {
          $availableEmailChannels = $account->emailChannels;
          $emailChannelIds = $availableEmailChannels->pluck('id');
          $channels = EmailChannel::whereIn('id', $emailChannelIds)->get();
          //Mail::to($order->user->email)->send(new OrderMail($channels, $order->user->email, 'GamingAccount'));
          return redirect()->back()->with('success', 'Status updated successfully!');
        }
      } else {
        // $licenceKey = LicenceKey::where('id', $order->orderable_id)
        //     ->where('status', 'active')
        //     ->where('product_status', 'available')
        //     ->with(['keyChannels' => function ($query) use ($unitPrice) {
        //         $query->where('price', $unitPrice)->where('status', 'available');
        //     }])
        //     ->first();
        // $channels = KeyChannel::whereIn('id', $keyChannelIds)->get();
        // Mail::to($user->email)->send(new OrderMail($channels, $user->name, $orderInfo['product_type']));
        return redirect()->back()->with('success', 'Status updated successfully!');
      }
    } elseif ($request->status == 'canceled') {
      $tId = $request->id;
      $transaction = Transaction::where('manual_id', $tId)->first();
      $transaction->status = 'canceled';
      $transaction->save();
      $order = ManualPayment::where('id', $request->id)->first();
      $order->status = 'canceled';
      $order->save();
      if ($order->orderable_type == 'App\Models\GamingAccount') {
        $account = GamingAccount::where('id', $order->orderable_id)
          ->where('status', 'active')
          ->with(['emailChannels' => function ($query) {
            $query;
          }])
          ->first();
        $data = json_decode($account, true);
        //return $data['email_channels'][0]->id;
        //print_r($account->email_channels);
        foreach ($data['email_channels'] as $channel) {
          $emails = EmailChannel::where('id', $channel['id'])->first();
          $emails->status = 'available';
          $emails->save();
        }
        $account->product_status = 'available';
        $account->save();
        return redirect()->back()->with('success', 'Status updated successfully!');
      } else {
        // $licenceKey = LicenceKey::where('id', $order->orderable_id)
        //     ->where('status', 'active')
        //     ->where('product_status', 'available')
        //     ->with(['keyChannels' => function ($query) use ($unitPrice) {
        //         $query->where('price', $unitPrice)->where('status', 'available');
        //     }])
        //     ->first();
        // $channels = KeyChannel::whereIn('id', $keyChannelIds)->get();
        // Mail::to($user->email)->send(new OrderMail($channels, $user->name, $orderInfo['product_type']));
        return redirect()->back()->with('success', 'Status updated successfully!');
      }
    }
  }

  public function blockProxy(Request $request)
  {
    $proxy_user = new UsingProxyUser();
    $proxy_user->user_id = $request->input('userId');
    $proxy_user->ip_address = $request->input('ipAddress');
    $proxy_user->save();
    return response()->json(['success' => true]);
  }

  public function accountdetails($user_id)
  {
    $order = Order::where('user_id', $user_id)->first();
    $totalGamingAccounts = 0;
    if ($order) {
      $emailChannels = EmailChannel::where('gaming_account_id', $order->orderable_id)->where('status', 'available')->get();
      $totalGamingAccounts = $emailChannels->count();


      if ($totalGamingAccounts > 0) {
        $accounts = [];

        foreach ($emailChannels as $emailChannel) {
          $gamingAccount = Gamingaccount::find($emailChannel->gaming_account_id);

          $accounts[] = [
            'title' => $gamingAccount->title,
          ];
        }

        return response()->json([
          'totalGamingAccounts' => $totalGamingAccounts,
          'accounts' => $accounts,
        ]);
      } else {
        return response()->json([
          'totalGamingAccounts' => $totalGamingAccounts,
          'error' => 'No email channels found for the user.',
        ]);
      }
    } else {
      return response()->json([
        'totalGamingAccounts' => $totalGamingAccounts,
        'error' => 'No order found for the user.',
      ]);
    }
  }

  public function updateAccountStatus(Request $request)
  {
      $userId = $request->input('userId');
      $order = Order::where('user_id', $userId)->first();

      if (!$order) {
          return response()->json(['error' => 'No order found for the user.']);
      }

      $emailChannels = EmailChannel::where('gaming_account_id', $order->orderable_id)->get();

      if ($emailChannels->isEmpty()) {
          return response()->json(['error' => 'No EmailChannels found for the user.']);
      }

      $product = $emailChannels->first();
      $line1 = $product->format;
      $line2 = $product->value1;
      $delimiter = $product->delimiter;

      $headers = explode($delimiter, $line1);
      $lineValues = explode($delimiter, $line2);

      if (count($headers) !== count($lineValues)) {
          return response()->json(['error' => 'Error: Count of headers and lines should be equal.']);
      }

      $result = array_combine(array_map('strtolower', $headers), $lineValues);

      $emailData = [
          'Username' => $result['username'] ?? null,
          'Password' => $result['password'] ?? null,
          'Email' => $result['email'] ?? null,
          'EmailPassword' => $result['emailpassword'] ?? null,
          '2Fa' => $result['2fa'] ?? null,
          'Followers' => $result['followers'] ?? null,
      ];

      $numberOfRecordsToUpdate = $request->input('number', 1);
      $emailDataArray = array_fill(0, $numberOfRecordsToUpdate, $emailData);

      Mail::send('emails.accountinformation', ['emailData' => $emailDataArray], function ($message) use ($emailDataArray, $order) {
          $message->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
          $message->to($order->user->email)
              ->subject('Account Information');
      });

      EmailChannel::where('gaming_account_id', $order->orderable_id)
          ->limit($numberOfRecordsToUpdate)
          ->update(['status' => 'completed']);

      $request->session()->flash('status', 'Status updated successfully');

      return response()->json(['success' => true, 'emailData' => $emailDataArray]);
  }


}
