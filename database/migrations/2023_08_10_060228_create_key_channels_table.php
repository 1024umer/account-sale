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
        Schema::create('key_channels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('licence_key_id')->constrained('licence_keys')->onUpdate('cascade')->onDelete('cascade');
            $table->string('key');
            $table->float('price');
            $table->enum('status', ['available', 'sold'])->default('available');
            $table->integer('days');
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
        Schema::dropIfExists('key_channels');
    }
};
