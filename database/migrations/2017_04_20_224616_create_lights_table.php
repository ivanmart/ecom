<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('lights', function (Blueprint $table){
            $table->increments('id');
            $table->string('materials');
            $table->string('bulbs');                    // ex lights
            $table->unsignedSmallInteger('square');
            $table->unsignedSmallInteger('width');
            $table->unsignedSmallInteger('length');
            $table->unsignedSmallInteger('height');
            $table->unsignedSmallInteger('height_up');
            $table->unsignedSmallInteger('diameter');
            $table->unsignedSmallInteger('power');
            $table->boolean('dimmer')->default(0);
            $table->unsignedTinyInteger('protect');
            $table->float('weight', 7, 3);
            $table->float('volumn', 6, 3);
            $table->string('agestyle');
            $table->string('style');
            $table->unsignedInteger('family_id');
            $table->unsignedInteger('collection_id');
            $table->unsignedInteger('attached_light');
            $table->unsignedInteger('lights_quantity');
            $table->unsignedInteger('install_price');
            $table->string('lamp_color');
            $table->string('plafon_color');             // ex pluf_color
            $table->string('plafon_mat');
            $table->string('armatura_mat');
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
        Schema::drop('lights');
    }
}
