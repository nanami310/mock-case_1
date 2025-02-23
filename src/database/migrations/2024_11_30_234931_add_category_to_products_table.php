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
            $table->text('category')->after('image');
            $table->string('condition')->after('category');
            $table->text('description')->after('name');
            $table->decimal('price', 10, 2)->after('description');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->dropColumn('condition');
            $table->dropColumn('description');
            $table->dropColumn('price'); 
        });
    }
}
