<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPropsForeignKeys2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('lights', function (Blueprint $table){
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::table('bulbs', function (Blueprint $table){
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('lights', function (Blueprint $table){
            $table->dropForeign('lights_product_id_foreign');
            $table->dropColumn('product_id');
        });
        Schema::table('bulbs', function (Blueprint $table){
            $table->dropForeign('bulbs_product_id_foreign');
            $table->dropColumn('product_id');
        });
    }
}
