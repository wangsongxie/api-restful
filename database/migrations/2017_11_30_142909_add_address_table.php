<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("address",function(Blueprint $table){
            $table->increments("id");
            $table->unsignedInteger("user_id")->default(0)->comment("用户id");
            $table->string("region_id")->default('')->comment("地区ID");
            $table->boolean("is_default")->default(false)->comment("是否默认");
            $table->string("username")->default("")->comment("姓名");
            $table->string("mobile")->default("")->comment("手机号");
            $table->string("address")->default("")->comment("详细地址");
            $table->timestamps();
            $table->index("user_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("address");
    }
}
