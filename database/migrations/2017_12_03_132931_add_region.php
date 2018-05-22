<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRegion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("region_third",function(Blueprint $table){
            $table->increments("id");
            $table->string("region_id",6)->nullable();
            $table->unsignedInteger('parent_region_id')->nullable();
            $table->string("name");
            $table->index("region_id");
            $table->index("parent_region_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("region_third");
    }
}
