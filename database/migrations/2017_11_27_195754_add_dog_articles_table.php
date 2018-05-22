<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDogArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("article_categories",function(Blueprint $table){
            $table->increments("id");
            $table->string("name")->default('')->comment('分类名称');
            $table->string("thumb")->default('')->comment('缩略图');
            $table->unsignedInteger("pid")->default(0)->comment("上级id");
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
        Schema::drop("article_categories");
    }
}
