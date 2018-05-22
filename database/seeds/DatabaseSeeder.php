<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $img = 'http://img.mall.dog126.com/Public/mobile/images/image-6.jpg';
        \App\User::truncate();
        \App\UserIdentify::truncate();
        // 创建10个用户
        for($i = 0 ; $i < 100 ; $i ++)
        {
            $tmp = [ 'id' => $i + 1,'mobile' => "1517916891{$i}" , 'password' => bcrypt('000000') , 'qq_openid' => "qqopenid{$i}" , 'wx_openid' => "wx_openid{$i}"] ;
            $user = \App\User::create($tmp);
            // 认证
            $identify = [
                'sell_type' => '0',
                "shop_name" => "狗店名称{$i}",
                "username" => "真实姓名{$i}",
                "idcard" => "36012118825965121x",
                "idcard_imgurl" => "{$img}",
                "mobile" => '13800168000',
                "address" => "建设路xxx号{$i}",
                "bank_name" => "建设银行{$i}",
                "license_imgurl" => "{$img}",
                "sell_type"  => 2 ,
                "user_id" => $i + 1,
                "is_valid" => true ,
                "province_id" => '420000',
                "city_id" => '420100',
                "area_id" => '420103',
                "shipping_price" => 500 ,
                "stars" => rand(0,5),
                "trade_num" => rand(0,100),
                "logo" => $img ,
            ];
            $user->identify()->save(new \App\UserIdentify($identify));
        }


        \App\BaikeDetail::truncate();
        \App\BaikeDogDetail::truncate();
        \App\BaikePrice::truncate();
        \App\Videos::truncate();
        $baike = [
            'id' => '1',
            'banner_imgurl' => 'http://img.mall.dog126.com/Public/attached/201710/201710131119176925.jpg',
            'desc' => '身高大于48厘米的贵宾犬，称为巨型贵宾犬，属于贵宾犬的一种，除外形较大，其余与贵宾犬基本一致，具有卷曲或扎捆特有的卷毛。 性格活跃、机警而且行动优雅，拥有很好的身体比例和矫健的动作，显示出一种自信的姿态。 毛发经过传统方式修剪和仔细的梳理后，贵宾犬会显示出与生俱来的独特而又高贵的气质。',
            'market_price' => '500-4000',
            'history' => ' 贵宾犬确切起源不详，在全西欧地区有四百年历史。贵宾犬也可称“卷毛狗”，属于非常聪明的且喜欢狩猎的犬种，只以展示用的毛型引人注意。此犬是现在最受人喜爱的品种之一。此犬多才多艺，在任何环境都能表现出高贵的举止。在原野上，法国贵宾犬会把水中发现的猎鸟取回。在马戏团中，由其醒目的外形，忠诚的服务，积极的性格，使其拥有许多犬迷。贵宾犬分为标准型，迷你型，玩具犬三种。它们之间的区别只是在于体型的大小不同。  性质聪明，活泼，性情优良，极易近人，是一种忠实的犬种。',
            'feature' => '巨型贵宾犬有着长而直的吻部，鼻子长而大，略圆的头骨，前腿笔直平行，肌肉健壮的后腿，还有比例匀称强壮的颈部;轻快灵活，个性聪明、活泼。',
            'dogcate_id' => '1',
        ];
        \App\BaikeDetail::insert($baike);
        $baike = \App\BaikeDetail::find(1);
        $baike->dogDetail()->insert([
            'cn_name' => '贵宾犬',
            "en_name" => 'somedog',
            'alias'   => '狗别名',
            'world'   => '动物界',
            'area'    => '中东，迪拜',
            'dislike_food' => '香蕉',
            'easy_illness' => '哮喘',
            'height' => '80' ,
            'weight' => '80' ,
            'age' => '18-20',
            "baike_id" => 1,
        ]);
        $i = 0;
        for(; $i < 30 ; $i ++)
        {
            $baike->price()->insert([
                "low" => rand(600 , 1800) ,
                "medium" => rand(1800 , 2500 ) ,
                "high" => rand(2500 , 4000),
                "month" => \Carbon\Carbon::now()->subMonth($i)->toDateString(),
                'created_at' => \Carbon\Carbon::now()->subDay($i),
                "baike_id" => 1,
            ]);
        }
        $baike->videos()->insert([
            "url" => "www.xxx.com/xxx.mp4",
            'title' => '狗狗狗狗',
            "click_count" => 10,
            "baike_id" => 1,
        ]);
        //eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3YxL2xvZ2luIiwiaWF0IjoxNTExNDkyOTg2LCJleHAiOjE1MTE0OTY1ODYsIm5iZiI6MTUxMTQ5Mjk4NiwianRpIjoiYWp3RDFNYjhPNE5ZZGxOZSIsInN1YiI6MSwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSIsImlkIjoxLCJtb2JpbGUiOiIxNTE3OTE2ODkxMSIsInFxX25hbWUiOiIiLCJxcV9oZWFkaW1ndXJsIjoiIiwicXFfb3BlbmlkIjoicXFvcGVuaWQxIiwid3hfbmFtZSI6IiIsInd4X2hlYWRpbWd1cmwiOiIiLCJ3eF9vcGVuaWQiOiJ3eF9vcGVuaWQxIn0.zjBeTbyydIZ6VxytPkhmPUfLJd0chHP0Jo2Cm1w4wxc

        // 测试文章数据
        \App\Article::truncate();
        for($i = 0 ; $i < 100 ; $i ++)
        {
            \App\Article::insert([
                'cate_id' => '30' ,
                'title' => "测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章{$i}",
                'thumb' => 'http://img.mall.dog126.com/Public/attached/201710/201710131119176925.jpg',
                'from' => '百度',
                'content' => '测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章',
                'is_hot' => rand(0,1),
                'keywords' => "测试{$i}",
                "desc" => '测试描述测试描述测试描述测试描述测试描述测试描述',
                "created_at" => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
        }
        \App\Dog::truncate();
        \App\DogFile::truncate();
        for($i = 0 ; $i < 100 ; $i ++)
        {
            $j = 0;
            while($j < 20)
            {
                $uid = $i + 1 ;
                $u = \App\User::find($uid);
                $shop_id = $u->identify()->value("id");
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
          "user_id":"{$uid}",
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
                unset($data['files']);
                $dog = new \App\Dog();
                $dog->fill($data)->save();
                $c = [];
                foreach ($files as $file)
                {
                    $c [] = new \App\DogFile(['url' => $file ['url'] , 'type' => $file ['type']]) ;
                }
                $save = $dog->files()->saveMany($c);
                $j ++ ;
            }
        }
//        \App\Region::truncate();
        // 地址 .
//        DB::insert(file_get_contents(__DIR__ . '/region_third.sql'));
    }
}
