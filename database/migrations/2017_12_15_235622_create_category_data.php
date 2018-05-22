<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $img = 'http://img.mall.dog126.com/Public/mobile/images/image-6.jpg';
        // 狗分类
        \App\DogsCategory::truncate();
        $cates = [
            ['pinyin' => 'g' ,'is_hot' => 1 , 'name' => '贵宾犬' , 'pid' => 0 , 'thumb' => 'http://img.mall.dog126.com/Public/mobile/images/image-6.jpg' ],
            ['pinyin' => 'b' ,'is_hot' => 1 , 'name' => '博美犬' , 'pid' => 0 , 'thumb' => 'http://img.mall.dog126.com/Public/mobile/images/image-6.jpg' ],
            ['pinyin' => 'x' ,'is_hot' => 1 , 'name' => '雪纳瑞' , 'pid' => 0 , 'thumb' => 'http://img.mall.dog126.com/Public/mobile/images/image-6.jpg' ],
            ['pinyin' => 't' ,'is_hot' => 1 , 'name' => '泰迪犬' , 'pid' => 0 , 'thumb' => 'http://img.mall.dog126.com/Public/mobile/images/image-6.jpg' ],
            ['pinyin' => 'k' ,'is_hot' => 1 , 'name' => '柯基犬' , 'pid' => 0 , 'thumb' => 'http://img.mall.dog126.com/Public/mobile/images/image-6.jpg' ],
            ['pinyin' => 'c' ,'is_hot' => 1 , 'name' => '茶杯犬' , 'pid' => 0 , 'thumb' => 'http://img.mall.dog126.com/Public/mobile/images/image-6.jpg' ],
            ['pinyin' => 'f' ,'is_hot' => 1 , 'name' => '法国斗牛犬' , 'pid' => 0 , 'thumb' => 'http://img.mall.dog126.com/Public/mobile/images/image-6.jpg' ],
            ['pinyin' => 'm' ,'is_hot' => 1 , 'name' => '迷你杜宾犬' , 'pid' => 0 , 'thumb' => 'http://img.mall.dog126.com/Public/mobile/images/image-6.jpg' ],
            ['pinyin' => 'l' ,'is_hot' => 1 , 'name' => '拉布拉多' , 'pid' => 0 , 'thumb' => 'http://img.mall.dog126.com/Public/mobile/images/image-6.jpg' ],
            ['pinyin' => 'h' ,'is_hot' => 1 , 'name' => '哈士奇' , 'pid' => 0 , 'thumb' => 'http://img.mall.dog126.com/Public/mobile/images/image-6.jpg' ],
            ['pinyin' => 'b' ,'is_hot' => 1 , 'name' => '巴吉度' , 'pid' => 0 , 'thumb' => 'http://img.mall.dog126.com/Public/mobile/images/image-6.jpg' ],
            ['pinyin' => 'a' ,'is_hot' => 1 , 'name' => '阿拉斯加犬' , 'pid' => 0 , 'thumb' => 'http://img.mall.dog126.com/Public/mobile/images/image-6.jpg' ],
        ];
        foreach ($cates as $val)
        {
            \App\DogsCategory::create($val);
        }

        // 狗狗的分类
        \App\ArticleCategory::truncate();
        \App\ArticleCategory::insert([
            [
                "id" => 1 ,
                "name" => "犬种",
                "thumb" => $img ,
                "pid" => 0,
            ],[
                "id" => 2 ,
                "name" => "喂养",
                "thumb" => $img ,
                "pid" => 0,
            ],[
                "id" => 3 ,
                "name" => "美容",
                "thumb" => $img ,
                "pid" => 0,
            ],[
                "id" => 4 ,
                "name" => "训练",
                "thumb" => $img ,
                "pid" => 0,
            ],[
                "id" => 5 ,
                "name" => "医疗",
                "thumb" => $img ,
                "pid" => 0,
            ],[
                "id" => 6 ,
                "name" => "繁育",
                "thumb" => $img ,
                "pid" => 0,
            ],[
                "id" => 7 ,
                "name" => "宠物小工具",
                "thumb" => $img ,
                "pid" => 0,
            ],[
                "id" => 8 ,
                "name" => "喂养道德篇",
                "thumb" => $img ,
                "pid" => 0,
            ],
            [
                "id" => 9 ,
                "name" => "热门分类",
                "thumb" => $img ,
                "pid" => 3,
            ],
            [
                "id" => 10 ,
                "name" => "洗澡",
                "thumb" => $img ,
                "pid" => 9,
            ],[
                "id" => 11 ,
                "name" => "护毛",
                "thumb" => $img ,
                "pid" => 9,
            ],[
                "id" => 12 ,
                "name" => "修毛",
                "thumb" => $img ,
                "pid" => 9,
            ],[
                "id" => 13 ,
                "name" => "泪痕",
                "thumb" => $img ,
                "pid" => 9,
            ],[
                "id" => 14 ,
                "name" => "肛门腺",
                "thumb" => $img ,
                "pid" => 9,
            ],[
                "id" => 15 ,
                "name" => "狗虱",
                "thumb" => $img ,
                "pid" => 9,
            ],[
                "id" => 16 ,
                "name" => "护理工具",
                "thumb" => $img ,
                "pid" => 9,
            ],[
                "id" => 17 ,
                "name" => "美容谨慎",
                "thumb" => $img ,
                "pid" => 9,
            ],[
                "id" => 18 ,
                "name" => "洗澡",
                "thumb" => $img ,
                "pid" => 9,
            ],[
                "id" => 19 ,
                "name" => "身体部分",
                "thumb" => $img ,
                "pid" => 3,
            ],[
                "id" => 20 ,
                "name" => "眼睛",
                "thumb" => $img ,
                "pid" => 19,
            ],[
                "id" => 21 ,
                "name" => "耳朵",
                "thumb" => $img ,
                "pid" =>19,
            ],[
                "id" => 22 ,
                "name" => "嘴",
                "thumb" => $img ,
                "pid" => 19,
            ],[
                "id" => 23 ,
                "name" => "鼻子",
                "thumb" => $img ,
                "pid" => 19,
            ],[
                "id" => 24 ,
                "name" => "脚掌",
                "thumb" => $img ,
                "pid" => 19,
            ],[
                "id" => 25 ,
                "name" => "腿",
                "thumb" => $img ,
                "pid" => 19,
            ],[
                "id" => 26 ,
                "name" => "尾巴",
                "thumb" => $img ,
                "pid" => 19,
            ],[
                "id" => 27 ,
                "name" => "背部",
                "thumb" => $img ,
                "pid" => 19,
            ],[
                "id" => 28 ,
                "name" => "胸部",
                "thumb" => $img ,
                "pid" => 19,
            ],
            // end 身体部位
            [
                "id" => 29 ,
                "name" => "幼犬",
                "thumb" => $img ,
                "pid" => 2,
            ],[
                "id" => 30 ,
                "name" => "成犬",
                "thumb" => $img ,
                "pid" => 2,
            ],[
                "id" => 31 ,
                "name" => "家庭训练",
                "thumb" => $img ,
                "pid" => 4,
            ],[
                "id" => 32 ,
                "name" => "观赏性训练",
                "thumb" => $img ,
                "pid" => 4,
            ],[
                "id" => 33 ,
                "name" => "工作犬训练",
                "thumb" => $img ,
                "pid" => 4,
            ],[
                "id" => 34 ,
                "name" => "卧",
                "thumb" => $img ,
                "pid" => 31,
            ],[
                "id" => 35 ,
                "name" => "直立行走",
                "thumb" => $img ,
                "pid" => 32,
            ],[
                "id" => 36 ,
                "name" => "搜救",
                "thumb" => $img ,
                "pid" => 33,
            ],[
                "id" => 37 ,
                "name" => "常见",
                "thumb" => $img ,
                "pid" => 5,
            ],[
                "id" => 38 ,
                "name" => "眼睛",
                "thumb" => $img ,
                "pid" => 4,
            ],[
                "id" => 39 ,
                "name" => "狗狗生病的征兆",
                "thumb" => $img ,
                "pid" => 37,
            ],[
                "id" => 40 ,
                "name" => "泪痕",
                "thumb" => $img ,
                "pid" => 38,
            ],
        ]);
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
