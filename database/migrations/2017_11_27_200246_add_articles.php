<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("articles", function(Blueprint $table){
            $table->increments("id");
            $table->unsignedInteger("cate_id")->default(0)->comment("分类id");
            $table->string("title")->default("")->comment("文章标题");

            $table->string("thumb")->default('')->comment('文章缩略图');
            $table->string("from")->default("网络")->comment("文章来源");
            $table->boolean("is_hot")->default(false)->comment("热门推荐");
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
        Schema::drop("articles");
    }
}
