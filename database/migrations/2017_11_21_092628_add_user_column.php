<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 短信表 .
        Schema::create("sms",function (Blueprint $table){
            $table->increments("id") ;
            $table->string("type")->comment("短信类型")->default('');
            $table->integer("code")->default(0)->comment('验证码');
            $table->string("mobile")->default(0)->comment('手机号');
            $table->tinyInteger("status")->default(0)->comment('状态');
            $table->timestamps();
        });
        // 用户表 .
        Schema::table("users",function(Blueprint $table){


            $table->string("mobile")->after('id')->default('')->comment('手机号'); // 如果该字段存在，则不能修改
            // 收款信息

//            $table->string('alipay')->after('id')->default('')->comment('支付宝收款账号');
//            $table->string('wechat')->after('id')->default('')->comment('微信收款账号');
        });

        // 实名认证表 .
        Schema::create("user_identify", function(Blueprint $table){
            $table->increments("id");
            $table->integer("user_id")->notnull()->comment('用户id');
            $table->unsignedTinyInteger("sell_type")->default(0)->comment('0未定义，1个人，2商家') ;  // 商家类型  0 1 2
            $table->string("shop_desc")->default('')->comment('商家简介');
            $table->string('shop_name')->default('')->comment('店铺名称');
            $table->string('real_name')->default('')->comment('真实姓名');
            $table->string('id_card')->default('')->comment('身份证号');
            $table->string('id_card_image')->default('')->comment('身份证图片地址');
            $table->string('mobile')->defaut('')->comment('手机号');
            $table->string("address")->default('')->comment('地址');
            $table->string('bank_name')->default('')->comment('开户银行');
            $table->string('bank_no')->default('')->comment('银行卡号');
            $table->string('license_image_url')->default('')->comment('营业执照');
            $table->index("sell_type");
            $table->index("user_id");
        }) ;
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
