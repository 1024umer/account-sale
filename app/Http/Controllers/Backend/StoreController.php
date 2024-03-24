<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $store = Store::where('id', '1')->first();
        return view('backend.store', compact('store'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            'stripe_key' => 'nullable|string',
            'stripe_secret' => 'nullable|string',
            'paypal_client_id' => 'nullable|string',
            'perfect_money_accountid' => 'nullable|string',
            'paypal_secret' => 'nullable|string',
            'paybis_account'=> 'nullable|string',
            'payeer_account'=> 'nullable',
            'favicon' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'main_logo' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $store = Store::where('id', '1')->first();
        if(!$store) {
            $store = new Store();
        }
        $store->meta_title = $request->meta_title;
        $store->meta_description = $request->meta_description;
        $store->meta_keywords = $request->meta_keywords;
        $store->paypal_mode = $request->paypal_mode;
        $store->stripe_key = $request->stripe_key;
        $store->paypal_client_id = $request->paypal_client_id;
        $store->paypal_secret = $request->paypal_secret;
        $store->company_email = $request->company_email;
        $store->stripe_secret = $request->stripe_secret;
        $store->coinbase_api_key = $request->coinbase_api_key;
        $store->perfect_money_accountid = $request->perfect_money_accountid;
        $store->payeer_shop = $request->payeer_shop;
        $store->payeer_merchant_key = $request->payeer_merchant_key;
        $store->paybis_account = $request->paybis_account;
        $store->payeer_account = $request->payeer_account;
        $store->referral_percentage = $request->referral_percentage;
        $store->facebook_link = $request->facebook_link;
        $store->instagram_link = $request->instagram_link;
        $store->coinbase_api_version = $request->coinbase_api_version;
        $store->telegram_link = $request->telegram_link;
        $store->youtube_link = $request->youtube_link;
        $store->discord_link = $request->discord_link;
        $store->privacy_policy = $request->privacy_policy;
        $store->terms_of_use = $request->terms_of_use;
        $store->payment_and_delivery = $request->payment_and_delivery;
        if ($request->hasFile('favicon')) {
            $store->favicon = $request->file('favicon');
        }
        if ($request->hasFile('main_logo')) {
            $store->main_logo = $request->file('main_logo');
        }
        $store->user_id=Auth()->user()->id;
        $store->save();

        return redirect()->route('admin.store.')->with('success', 'Store data updated successfull!');
    }

    public function allStores(Request $request)
    {
      $store = Store::all();
      return view('backend/allStores', compact('store'));
    }
    public function storeUpdateProfit(Request $request)

    {
      $store = Store::find($request->id);
        $store->update([
          'adminProfit'=>$request->adminProfit,
        ]);
        return redirect()->back()->with('success', 'Store Profit updated successfull!');

    }
 }
