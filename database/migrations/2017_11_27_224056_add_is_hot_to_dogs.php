<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsHotToDogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("dog_categories",function(Blueprint $table){
            $table->boolean("is_hot")->after('thumb')->default(false)->comment("是否热门");
            $table->string("pinyin")->after('thumb')->default("")->comment("拼音");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("dog_categories",function(Blueprint $table){
            $table->dropColumn("is_hot");
            $table->dropColumn("pinyin");
        });
    }
}
