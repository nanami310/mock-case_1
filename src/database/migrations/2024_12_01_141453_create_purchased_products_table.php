<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasedProductsTable extends Migration
{
    public function up()
    {
        Schema::create('purchased_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // 他のカラムを追加
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchased_products');
    }
}