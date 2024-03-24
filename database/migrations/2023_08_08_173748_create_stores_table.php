<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->longText('meta_keywords')->nullable();
            $table->string('favicon')->nullable();
            $table->string('main_logo')->nullable();
            $table->string('stripe_key')->nullable();
            $table->string('coinbase_api_key')->nullable();
            $table->string('coinbase_api_version')->nullable();
            $table->string('stripe_secret')->nullable();
            $table->string('paypal_secret')->nullable();
            $table->string('paypal_mode')->nullable();
            $table->string('paypal_client_id')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('discord_link')->nullable();
            $table->string('telegram_link')->nullable();
            $table->string('company_email')->nullable();
            $table->longText('privacy_policy')->nullable();
            $table->longText('terms_of_use')->nullable();
            $table->longText('payment_and_delivery')->nullable();

            $table->string('perfect_money_accountid')->nullable();
            $table->string('payeer_shop')->nullable();
            $table->string('payeer_merchant_key')->nullable();
            $table->string('paybis_account')->nullable();
            $table->string('payeer_account')->nullable();
            $table->string('referral_percentage')->nullable();

            $table->string('adminProfit')->nullable();
            $table->string('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
};
