<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group(['prefix' => '/v1', 'namespace' => '\App\Http\Controllers\V1'], function () {

    Route::group([], function () {
        Route::get('/aliyun/getOssSts', 'AliyunOssController@getSts');
        Route::post('/sms', 'GuestController@sendsms');
        Route::post('/register', 'GuestController@register');
        Route::post('/login', 'GuestController@login');
        Route::post('/wechat/login', 'WechatController@WechatLogin');
        Route::post('/bind/mobile', 'GuestController@bindMobile');

        Route::get('/regions/all_with_pinyin', 'RegionController@getSecondPinYinRegion');
        Route::get('/home', 'DogController@index');
        Route::get('/dog/list', 'DogController@getDogList');
        Route::get('/dog/detail', 'DogController@detail');
        Route::get('/region', 'GuestController@region');
        Route::get('/regions', 'GuestController@regions');


        Route::get('/shop', 'ShopController@shopList');
        Route::get('/shop/index', 'ShopController@shopIndex');
        Route::get('/shop/{shop_id}/detail', 'ShopController@shopDetail')->where('shop_id', '[0-9]+');
        Route::get('/shop/{shop_id}/dogs', 'ShopController@shopDogs')->where('shop_id', '[0-9]+');


        Route::get('/article/baike', 'ArticleController@baike');
        Route::get('/article/second_category', 'ArticleController@articleSecondCategory');
        Route::get('/article/list', 'ArticleController@articleList');
        Route::get('/article/{article_id}/recommends', 'ArticleController@recommendArticles')->where('article_id', '[0-9]+');
        Route::get('/article/detail', 'ArticleController@detail');

        Route::get('/article/{article_id}/comments', 'ArticleController@comments')->where('article_id', '[0-9]+');


        Route::get('/baike/detail', 'BaikeController@detail');
        Route::get('/dog/categories', 'DogController@getCategory');
        Route::get('/baike/videos', 'BaikeController@videos');
        Route::get('/baike/price', 'BaikeController@price');
    });


    Route::group(['middleware' => 'api.auth'], function () {



        Route::post('/user/verify', 'UserController@userVerify');
        Route::get('/user/check_identify', 'UserController@checkUserIdentify');
        Route::post('/dog/delete', 'DogController@delDog');
        Route::get('/shop/on_sell', 'ShopController@onSell');
        Route::get('/dog/{dog_id}/refresh', 'DogController@refresh')->where('dog_id', '[0-9]+');
        Route::group(['prefix' => '/article'], function () {
            Route::post("/like", 'ArticleController@like');
            Route::post("/collect", 'ArticleController@collect');
            Route::post('/comment/add', 'ArticleController@commentAdd');
        });

        Route::group(['prefix' => '/user'], function () {
            Route::get("/info", 'UserController@getUserInfo');
            Route::post("/info/update", 'UserController@updateUserinfo');
            Route::post("/update_mobile", 'UserController@updateMobile');
            Route::post("/add_address", 'UserController@addAddress');
            Route::post("/update_address", 'UserController@updateAddress');
            Route::get("/address", 'UserController@addressList');
            Route::post("/del_address", 'UserController@delAddress');
            Route::get("/collect", 'UserController@collect');
            Route::get("/order/list", 'OrderController@userOrderList');

        });

        Route::post("/order/pay", 'OrderController@pay');
        Route::post("/order/cancel", 'OrderController@cancelOrder');
        Route::get("/order/detail", 'OrderController@orderDetail');

        Route::group(['prefix' => '/dog'], function () {
            Route::post("/publish", 'DogController@publish');
            Route::post("/collect", 'DogController@collect');
            Route::get("/{dog_id}/show", 'DogController@show')->where('dog_id', '[0-9]+');
            Route::post("/update", 'DogController@update');
        });

        Route::group(['prefix' => '/order'], function () {
            Route::post("/submit", 'OrderController@submit');
        });

    });
    Route::get("/order/pay/test", 'OrderController@payTest');

});