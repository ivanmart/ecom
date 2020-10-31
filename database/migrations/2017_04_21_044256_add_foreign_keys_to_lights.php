<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToLights extends Migration
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
            $table->foreign('family_id')->references('id')->on('families');
            $table->foreign('collection_id')->references('id')->on('collections');
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
            $table->dropForeign('lights_family_id_foreign');
            $table->dropForeign('lights_collection_id_foreign');
        });
    }
}
