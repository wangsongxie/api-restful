<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArticleSeeder extends Migration
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function up()
    {
        //

        for($i = 0 ; $i < 100 ; $i ++)
        {
            $article = \App\Article::create([
                'cate_id' => \App\ArticleCategory::inRandomOrder()->first()->id ,
                'title' => "测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章测试文章{$i}",
                'thumb' => 'http://img.mall.dog126.com/Public/attached/201710/201710131119176925.jpg',
                'from' => '百度',
                'is_hot' => rand(0,1),
            ]);

            \App\ArticleInfo::create([
                'article_id' => $article->id,
                'desc' => "我是文章内容简介{$i}，我是文章内容简介{$i}，我是文章内容简介{$i}，我是文章内容简介{$i}，我是文章内容简介{$i}，",
                'content' => "<p>我是文章内容{$i},  我是文章内容{$i}  我是文章内容{$i}  我是文章内容{$i} <img src='http://img.mall.dog126.com/Public/attached/201710/201710131119176925.jpg' /> <span style='color: red'>文字颜色</span></p>
 <p>我是文章内容{$i},  我是文章内容{$i}  我是文章内容{$i}  我是文章内容{$i} <img src='http://img.mall.dog126.com/Public/attached/201710/201710131119176925.jpg' /> <span style='color: red'>文字颜色</span></p> 
 <p>我是文章内容{$i},  我是文章内容{$i}  我是文章内容{$i}  我是文章内容{$i} <img src='http://img.mall.dog126.com/Public/attached/201710/201710131119176925.jpg' /> <span style='color: red'>文字颜色</span></p> 
 <p>我是文章内容{$i},  我是文章内容{$i}  我是文章内容{$i}  我是文章内容{$i} <img src='http://img.mall.dog126.com/Public/attached/201710/201710131119176925.jpg' /> <span style='color: red'>文字颜色</span></p> "
            ]);
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
