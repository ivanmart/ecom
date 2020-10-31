<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVisible extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('families', function (Blueprint $table){
            $table->boolean('visible')->default(1);
        });

        Schema::table('collections', function (Blueprint $table){
            $table->boolean('visible')->default(1);
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
        Schema::table('families', function (Blueprint $table){
            $table->dropColumn('visible');
        });

        Schema::table('collections', function (Blueprint $table){
            $table->dropColumn('visible');
        });

    }
}
