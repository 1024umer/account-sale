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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('status')->default('success');
            $table->float('amount');
            $table->unsignedBigInteger('orderable_id')->nullable();
            $table->string('orderable_type')->nullable();
            $table->string('channel_id')->nullable();
            $table->foreignId('created_by')->default('1')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('easy_mode')->default('Normal Mode');
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
        Schema::dropIfExists('orders');
    }
};
