<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBaikeDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("baike_detail", function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("dogcate_id");
            $table->string("banner_imgurl")->default("")->comment("banner图");
            $table->text("desc")->comment("介绍");
            $table->string("market_price")->default("0-0")->comment("市场参考价");
            $table->text("history")->commnet("发展历史");
            $table->text("feature")->comment("形态特征");
            $table->timestamps();
            $table->index("dogcate_id");
        });
        Schema::create("baike_dog_detail", function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("baike_id");
            $table->string("cn_name")->default("")->comment("中文学名");
            $table->string("en_name")->default("")->comment("英文学名");
            $table->string("alias")->default("")->comment("别名");
            $table->string("world")->default("")->comment("界");
            $table->string('area')->default('')->comment('地域');
            $table->string("dislike_food")->default('')->comment("禁忌食物");
            $table->string("easy_illness")->default("")->comment("易患病");
            $table->string("height")->default("")->comment("身高");
            $table->string("usage")->default("")->comment("用途");
            $table->string("weight")->default("")->comment("体重");
            $table->string("age")->default("")->comment("寿命");
            $table->timestamps();


            $table->index("baike_id");
        });
        Schema::create("baike_price", function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("baike_id");
            $table->decimal("low", 8, 2)->default(0)->comment("低端犬");
            $table->decimal("medium", 8, 2)->default(0)->comment("低端犬");
            $table->decimal("high", 8, 2)->default(0)->comment("低端犬");
            $table->timestamps();
            $table->index("baike_id");
        });

        Schema::create("videos", function (Blueprint $table) {
            $table->increments("id");
            $table->string("title");
            $table->string("url");
            $table->unsignedInteger("click_count");
            $table->timestamps();

            $table->unsignedInteger("baike_id");
            $table->index("baike_id");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("baike_detail");
        Schema::dropIfExists("baike_dog_detail");
        Schema::dropIfExists("baike_price");
        Schema::dropIfExists("videos");
    }
}
