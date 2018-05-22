<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
// factory(App\User::class, 100)->create();
$factory->define(App\User::class, function (Faker $faker) {
    static $password;
    return [
        'mobile' => 140 . rand(1111111,99999999),
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
//        'avatar' => 'https://randomuser.me/api/portraits/' . $faker->randomElement(['men', 'women']) . 'men/' . rand(1,99) . '.jpg',
        'password' => $password ?: $password = bcrypt('123456'),
    ];
});
//factory(App\UserInfo::class, 100)->create();
$factory->define(App\UserInfo::class, function(Faker $faker) {
    return [
        'nickname' => $faker->company,
        'real_name' => '张三',
        'first_keep_pets_time' =>date('Y-m-d', time()),
        'birthday' => date('Y-m-d', time()),
        'sex' => rand(1,2),
        'contact' => '李四',
        'region_id' =>  function () {
            return \App\Region::inRandomOrder()->first()->region_id;
        },
        'headimgurl' => 'http://img.mall.dog126.com/Public/mobile/images/image-6.jpg',
        'qq_name' => 'xxx',
        'qq_headimgurl' => 'http://img.mall.dog126.com/Public/mobile/images/image-6.jpg',
        'qq_openid' => 'xxxx',
        'wx_name' => 'xxxx',
        'wx_headimgurl' => 'http://img.mall.dog126.com/Public/mobile/images/image-6.jpg',
        'wx_openid' => 'xxx',
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        }
    ];
});


// factory(App\ArticleComment::class, 1000)->create();
$factory->define(App\ArticleComment::class, function(Faker $faker) {
    return [
        'article_id' => function () {
            // Get random video id
            return App\Article::inRandomOrder()->first()->id;
        },
        'user_id' => function () {
            // Get random user id
            return App\User::inRandomOrder()->first()->id;
        },
        'content' => '评论内容' . $faker->company,
    ];
});