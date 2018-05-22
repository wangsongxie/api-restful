<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDogsData extends Migration
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function up()
    {
        //

        \App\Dog::truncate();
        \App\DogFile::truncate();
        $users = \App\User::all();
        foreach ($users as $i => $user)
        {
            $j = 0;
            while($j < 20)
            {
                $u = $users;
                $shop_id = \App\UserIdentify::where(['user_id' => $user->id])->first()->id;
                $cate = rand(1,12);
                $isOrNo = rand(0,1);
                $json = <<<JSON
        {
          "cate_id" : "{$cate}",
          "birthday" : "2015-11-11",
          "vaccine" : "{$isOrNo}",
          "sex" : "{$isOrNo}",
          "sterilization" : "1",
          "grade" : "1",
          "shop_id": "{$shop_id}",
          "user_id":"{$user->id}",
          "body_size" : "{$isOrNo}",
          "insect" : "{$isOrNo}",
          "is_presell" : "{$isOrNo}",
          "health_ensure_days" : "9",
          "title" : "狗标题标题狗标题标题狗标题标题狗标题标题狗标题标题狗标题标题狗标题标题狗标题标题狗标题标题狗标题标题{$j}",
          "buyout_price" : 1111.11,
          "market_price" : 12.22222,
          "presell_price" : "13.33",
          "desc" : "描述描述描述描述描述描述描述描述描述描述描述描述描述描述描述",
          "detail" : "介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍介绍",
          "files" : [
            {
                "type":"1",
                "url":"http://img.mall.dog126.com/Public/attached/201708/201708081213172089.jpg"
            },{
                "type":"1",
                "url":"http://img.mall.dog126.com/Public/attached/201708/201708081213172089.jpg"
            },{
                "type":"1",
                "url":"http://img.mall.dog126.com/Public/attached/201708/201708081213172089.jpg"
            }
          ]
        }
JSON;

                $data = json_decode($json,true);
                $files = $data ['files'];
                $detail = $data['detail'];
                unset($data['files']);
                unset($data['detail']);
                $dog = new \App\Dog();
                $dog->fill($data)->save();
                \App\DogInfo::create([
                    'dog_id' => $dog->id,
                    'detail' => $detail,
                ]);
                $c = [];
                foreach ($files as $file)
                {
                    $c [] = new \App\DogFile(['url' => $file ['url'] , 'type' => $file ['type']]) ;
                }
                $save = $dog->files()->saveMany($c);
                $j ++ ;
            }
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
