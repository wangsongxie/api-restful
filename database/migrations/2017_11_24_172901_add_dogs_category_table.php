<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDogsCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("dog_categories",function (Blueprint $table){
            $table->increments("id");
            $table->string("pid")->default('')->comment('父类');
            $table->string("name")->default('')->comment('类别名称');
            $table->string("thumb")->default('')->comment('缩略图地址');
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
        //
    }
}
