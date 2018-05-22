<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserIdentifyData extends Migration
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function up()
    {
        //
        $img = 'http://img.mall.dog126.com/Public/mobile/images/image-6.jpg';
        $users = \App\User::all();
        foreach ($users as $key => $user) {

            $identify = [
                "shop_name" => "狗店名称{$key}",
                "real_name" => "真实姓名{$key}",
                "id_card" => "36012118825965121x",
                "id_card_image" => "{$img}",
                "mobile" => '13800168000',
                "address" => "建设路xxx号{$key}",
                "bank_name" => "建设银行{$key}",
                "license_image_url" => "{$img}",
                "sell_type"  => rand(0,2) ,
                "user_id" => $user->id,
                "is_valid" => true ,
                "region_id" => \App\Region::inRandomOrder()->first()->region_id,
                "shipping_price" => 500 ,
                "stars" => rand(0,5),
                "trade_num" => rand(0,100),
                "logo" => $img ,
            ];
            \App\UserIdentify::create($identify);

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
