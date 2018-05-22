<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnSellFieldToDogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("dogs",function(Blueprint $table){
            $table->boolean("is_sell")->default(true)->comment("是否下架");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("dogs",function(Blueprint $table){
            $table->dropColumn("is_sell");
        });
    }
}
