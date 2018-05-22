<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("orders",function(Blueprint $table){
            $table->increments("id");
            $table->string("order_no")->default("")->comment("订单号")->unique();
            $table->unsignedInteger("address_id")->default(0)->comment('关联收货地址ID');

            $table->string("consignee_name")->default("")->comment('收件人姓名');
            $table->string("consignee_mobile")->default("")->comment('收件人联系方式');
            $table->string("consignee_address")->default("")->comment('收件人地址');
            $table->decimal("origin_price", 8, 2)->defalt(0)->comment('原价');
            $table->boolean("is_pre")->defalt(false)->comment('是否预付费');
            $table->decimal("pre_price", 8, 2)->default(0)->comment('预付费多少钱');
            $table->enum("shipping_type", [0, 1, 2])->default(0)->comment('配送方式0外地，1同城，2自提');
            $table->decimal("shipping_price", 8, 2)->default(0)->comment('运费');
            $table->integer("number")->default(0)->comment('数量');
            $table->enum("payment", ['weixin', 'alipay'])->default('alipay')->comment('支付方式');
            $table->tinyInteger("order_status")->comment("0已提交，1已支付,2已发货，3已收货，4已评价，5订单取消，6发起退货，7已退货");
            $table->tinyInteger("pay_status")->comment("0未支付,1正在支付，2支付成功，3支付失败");
            $table->unsignedInteger("user_id");
            $table->softDeletes();
            $table->timestamps();

            $table->index("user_id");
        });

        Schema::create("order_dogs",function(Blueprint $table){
            $table->increments("id");
            $table->unsignedInteger("dog_id")->default(0)->comment('狗id');
            $table->unsignedInteger("order_id")->default(0)->comment("订单id");
            $table->string("thumb")->default("")->comment("缩略图");
            $table->date("birthday")->comment('生日');
            $table->unsignedInteger("cate_id")->comment('分类')->default(0);
            $table->integer("vaccine")->default(0)->comment('疫苗');
            $table->tinyInteger("sex")->default(0)->comment("性别0公1母");
            $table->boolean("sterilization")->default(false)->comment("是否绝育0是1否");
            $table->unsignedInteger("grade")->default(0)->comment('宠物品级01宠物级、血统级');
            $table->tinyInteger("body_size")->default(0)->comment('宠物体型:012小中大');
            $table->tinyInteger("insect")->default(0)->comment("是否驱虫:次数"); //
            $table->boolean("is_presell")->default(false)->comment("是否预售:0否1是");
            $table->unsignedInteger("health_ensure_days")->default(0)->comment("健康保证天数");
            $table->string("title")->commnet("宝贝标题");
            $table->decimal("buyout_price",8,2)->default(0)->comment('一口价');
            $table->decimal("market_price",8,2)->default(0)->comment('市场价');
            $table->decimal("presell_price",8,2)->default(0)->comment("预售价格");
            $table->unsignedInteger("shop_id");
            $table->timestamps();

            $table->index("order_id");
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
