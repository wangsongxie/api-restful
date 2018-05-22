<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShopField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("user_identify",function(Blueprint $table){
            $table->unsignedInteger("trade_num")->default(0)->comment("担保交易量");
            $table->unsignedInteger("stars")->default(0)->comment("星级");
            $table->string("logo")->default("")->comment("招牌");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("user_identify",function(Blueprint $table){
            $table->dropColumn("trade_num");
            $table->dropColumn("stars");
            $table->dropColumn("logo");
        });
    }
}
