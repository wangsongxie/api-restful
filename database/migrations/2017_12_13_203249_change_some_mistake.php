<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSomeMistake extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table("user_info",function(Blueprint $table){
            $table->dropColumn('sex');

        });
        Schema::table("user_info",function(Blueprint $table){
            $table->unsignedInteger('user_id')->after('id')->default(0)->comment("用户id");
            $table->enum("sex", [0, 1, 2])->after('birthday')->default(0)->comment("性别：1-男 2-女");
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
    }
}
