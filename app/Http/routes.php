<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});
//lumen的路由
$app->get('foo', function () {
    return view('Index.index');
});
//展示首页
$app->get('index','Index\IndexController@index');
//check路由
$app->get('check','Index\IndexController@check');

//使用中间件
$app->group(['middleware' => 'auth'],function () use ($app){
    $app->get("middle",function (){
        echo 'this is the middleware test';
    });
});