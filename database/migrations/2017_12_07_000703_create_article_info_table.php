<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_info', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("article_id")->default(0)->comment("文章ID");
            $table->text("desc")->nullable()->comment("文章简介");
            $table->text("content")->nullable()->comment("内容");
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
        Schema::dropIfExists('article_info');
    }
}
