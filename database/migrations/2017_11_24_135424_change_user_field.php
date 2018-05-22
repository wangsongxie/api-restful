<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("users",function (Blueprint $table){

            $table->string("email")->default('')->comment('邮箱')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("users",function(Blueprint $table){
            $table->dropColumn("first_keep_pets_time");
            $table->dropColumn("birthday");
            $table->dropColumn("sex");
            $table->dropColumn("email");
        });
    }
}
