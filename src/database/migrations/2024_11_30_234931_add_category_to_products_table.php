<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('category')->after('image'); // 位置を指定
            $table->string('condition')->after('category');
            $table->text('description')->after('name');
            $table->decimal('price', 10, 2)->after('description');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->dropColumn('condition'); // 追加したカラムを削除
            $table->dropColumn('description');
            $table->dropColumn('price'); // 追加したカラムを削除
        });
    }
}
