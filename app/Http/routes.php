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

//注册模板路由
$app->get('register','Register\RegisterController@index');
//注册路由
$app->get('ajaxRegisterAccount','Register\RegisterController@ajaxRegisterAccount');
//登录模板路由
$app->get('login', [
    'as' => 'login', 'uses' => 'Login\LoginController@index'
]);
//登录路由
$app->get('ajaxLogin','Login\LoginController@ajaxLogin');
//展示首页
$app->get('index','Index\IndexController@index');
//视频详情
$app->get('p','Index\IndexController@video');
//我的页面
$app->get('home','Index\IndexController@home');
//check路由
$app->get('check','Index\IndexController@check');

//使用中间件
$app->group(['middleware' => 'auth'],function () use ($app){
    $app->get("middle",function (){
        echo 'this is the middleware test';
    });
});