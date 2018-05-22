<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("article_brands");
        Schema::dropIfExists("article_category_brands");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create("article_category_brands", function(Blueprint $table){
            $table->increments("id");
            $table->unsignedInteger("cate_id")->default(0)->comment("文章分类id");
            $table->unsignedInteger("dog_cate_id")->default(0)->comment("狗狗分类id");
            $table->timestamps();
        });
        Schema::create("article_brands", function(Blueprint $table){
            $table->increments("id");
            $table->unsignedInteger("cate_id")->default(0)->comment("文章分类id");
            $table->unsignedInteger("dog_cate_id")->default(0)->comment("狗狗分类id");
            $table->timestamps();
        });
    }
}
