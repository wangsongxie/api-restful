<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateThumbForDogsInfo extends Migration
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function up()
    {
        //
        $allDogInfos = \App\DogInfo::all();
        $img = 'http://img.mall.dog126.com/Public/attached/201708/201708081213172089.jpg';
        foreach ($allDogInfos as $allDogInfo) {
            $allDogInfo->thumb = $img;
            $allDogInfo->save();
        }
    }

    /**
     * Reverse the seeder.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
