<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("dogs",function (Blueprint $table){
            $table->increments("id");

            $table->unsignedInteger("cate_id")->comment('分类')->default(0);
            $table->unsignedInteger("user_id");
            $table->string("shop_id")->default(0)->comment("商店id");
            $table->string("title")->commnet("宝贝标题");
            $table->date("birthday")->comment('生日');
            $table->integer("vaccine")->default(0)->comment('疫苗');
            $table->tinyInteger("sex")->default(0)->comment("性别0公1母");
            $table->boolean("sterilization")->default(false)->comment("是否绝育0是1否");
            $table->unsignedInteger("grade")->default(0)->comment('宠物品级01宠物级、血统级');
            $table->tinyInteger("body_size")->default(0)->comment('宠物体型:012小中大');
            $table->tinyInteger("insect")->default(0)->comment("是否驱虫:次数"); //
            $table->boolean("is_presell")->default(false)->comment("是否预售:0否1是");
            $table->unsignedInteger("health_ensure_days")->default(0)->comment("健康保证天数");

            $table->string("keywords")->default('')->comment();
            $table->decimal("buyout_price",8,2)->default(0)->comment('一口价');
            $table->decimal("market_price",8,2)->default(0)->comment('市场价');
            $table->decimal("presell_price",8,2)->default(0)->comment("预售价格");
            $table->string("desc")->default('')->comment("简介");


            $table->softDeletes();
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
        throw new Exception("dogs table can`t be droped") ;
    }
}
