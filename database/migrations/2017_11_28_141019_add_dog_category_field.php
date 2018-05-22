<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDogCategoryField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("dog_categories",function(Blueprint $table){
            $table->unsignedInteger("article_cate_id")->default(0)->comment("文章分类id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("dog_categories",function(Blueprint $table){
            $table->dropColumn("article_cate_id");
        });
    }
}
