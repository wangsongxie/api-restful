<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'doc'], function () {
    Route::get('json', 'SwaggerController@getJSON');
    Route::get('my-data', 'SwaggerController@getMyData');
});


Route::group(['prefix' => 'asd'], function()
{
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
});


Route::get("/logs_debug/{id?}",function($id = null){
    if(is_null($id))
    {
        return response()->json(DB::table("debug_log")->get());
    }
    else{
        return response()->json(DB::table("debug_log")->where(['log_id' => $id])->first());
    }
});
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');