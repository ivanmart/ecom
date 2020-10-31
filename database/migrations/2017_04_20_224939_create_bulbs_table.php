<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBulbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bulbs', function (Blueprint $table){
            $table->increments('id');
            $table->string('lamp_type');
            $table->string('base');
            $table->string('power');
            $table->string('temperature');
            $table->unsignedSmallInteger('flow');
            $table->string('analog');
            $table->unsignedTinyInteger('voltage');
            $table->string('warranty');                 // ex lamp_varanty
            $table->boolean('matte')->default(0);       // ex lamp_opacity
            $table->string('shape');
            $table->string('size');
            $table->unsignedInteger('lifetime');        // ex validity
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
        Schema::drop('bulbs');
    }
}
