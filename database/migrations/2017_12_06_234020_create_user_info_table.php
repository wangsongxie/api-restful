<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('user_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname')->default('')->comment('昵称') ; // 没有则自动生成 可以重复
            $table->string('real_name')->default('')->comment('真实姓名');
            $table->date("first_keep_pets_time")->nullable()->comment('首次养宠时间');
            $table->date("birthday")->nullable()->comment('生日');
            $table->enum("sex",["0","1"])->default(0)->comment('性别');
            $table->string('contact')->default('')->comment('联系人');
            $table->string('region_id')->default('')->comment('地区ID');
            $table->string('headimgurl')->default('')->comment('头像地址'); // 绝对地址
            $table->string('qq_name')->default('')->comment('qq昵称'); // 如果有用户昵称则显示用户昵称
            $table->string('qq_headimgurl')->default('')->comment('qq头像地址');
            $table->string('qq_openid')->default('')->comment('qq平台openid');
            $table->string('wx_name')->default('')->comment('wx昵称');
            $table->string('wx_headimgurl')->default('')->comment('微信头像地址');
            $table->string('wx_openid')->default('')->comment('wxopenid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_info');
    }
}
