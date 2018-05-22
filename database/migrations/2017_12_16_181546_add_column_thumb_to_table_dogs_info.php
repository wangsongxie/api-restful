<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnThumbToTableDogsInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dog_info', function (Blueprint $table) {
            //
            $table->string('thumb')->after('dog_id')->default('')->comment('缩略图');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dogs_info', function (Blueprint $table) {
            //
        });
    }
}
