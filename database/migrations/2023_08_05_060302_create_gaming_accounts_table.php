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
        Schema::create('gaming_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('sub_category_id')->constrained('sub_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('sub_subcategory_id')->constrained('sub_subcategories')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title');
            $table->longText('description');
            $table->float('price');
            $table->float('discount')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('product_status', ['sold', 'available'])->default('available');
            $table->string('options')->nullable();
            $table->string('manual')->default(0);
            $table->string('sku')->nullable();
            $table->string('main_image')->nullable();
            $table->string('long_image')->nullable();
            $table->integer('stock')->default(0);
            $table->string('custom_stock')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->integer('file_limit')->default(0);
            $table->integer('min_quantity')->default(0);
            $table->integer('max_quantity')->default(0);
            $table->foreignId('created_by')->default('1')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('gaming_accounts');
    }
};
