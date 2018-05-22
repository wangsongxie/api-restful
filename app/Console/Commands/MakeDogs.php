<?php

namespace App\Console\Commands;

use App\Dog;
use App\DogFile;
use Illuminate\Console\Command;

class MakeDogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:dogs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建gou';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $i =0 ;
        while ($i < 200)
        {
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
          "user_id":"1",
          "body_size" : "{$isOrNo}",
          "insect" : "{$isOrNo}",
          "is_presell" : "0",
          "health_ensure_days" : "9",
          "title" : "狗标题标题狗标题标题狗标题标题狗标题标题狗标题标题狗标题标题狗标题标题狗标题标题狗标题标题狗标题标题",
          "buyout_price" : 111.11,
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
            unset($data['files']);
            $dog = new Dog();
            $dog->fill($data)->save();
            $c = [];
            foreach ($files as $file)
            {
                $c [] = new DogFile(['url' => $file ['url'] , 'type' => $file ['type']]) ;
            }
            $save = $dog->files()->saveMany($c);
            $i ++ ;
        }


    }
}
