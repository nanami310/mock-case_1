<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // プライマリキー
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // 商品ID
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ユーザーID
            $table->text('content'); // コメント内容
            $table->timestamps(); // created_at と updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
