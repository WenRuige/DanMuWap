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
$app->get('register', 'Register\RegisterController@index');
//注册路由
$app->get('ajaxRegisterAccount', 'Register\RegisterController@ajaxRegisterAccount');
//登录模板路由
$app->get('login', [
    'as' => 'login', 'uses' => 'Login\LoginController@index'
]);
//退出路由
$app->get('logout', [
    'as' => 'logout', 'uses' => 'Login\LoginController@Logout'
]);
//登录路由
$app->get('ajaxLogin', 'Login\LoginController@ajaxLogin');
//展示首页
$app->get('index', 'Index\IndexController@index');
//视频详情界面
$app->get('videos/{id}', [
    'as' => 'videos', 'uses' => 'Video\VideoController@video'
]);
//我的页面
$app->get('home', [
    'as' => 'home', 'uses' => 'Home\HomeController@index'
]);
//修改个人信息blade界面
$app->get('showAlterUserBlade', [
    'as' => 'showAlterUserBlade', 'uses' => 'Users\UsersController@showAlterUserBlade'
]);
//修改个人信息ajax路由
$app->get('ajaxAlterUserInformation', [
    'as' => 'ajaxAlterUserInformation', 'uses' => 'Users\UsersController@ajaxAlterUserInformation'
]);
//获取用户个人信息[接口]
$app->get('ajaxGetUserInformation', [
    'as' => 'ajaxGetUserInformation', 'uses' => 'Users\UsersController@ajaxGetUserInformation'
]);
//展示用户头像的模板界面
$app->get('showAlterUserPhotoBlade', [
    'as' => 'showAlterUserPhotoBlade', 'uses' => 'Users\UsersController@showAlterUserPhotoBlade'
]);
//上传头像路由
$app->post('uploadPhoto', [
    'as' => 'uploadPhoto', 'uses' => 'Users\UsersController@uploadPhoto'
]);
//上传视频模板界面
$app->get('showUploadVideo', [
    'as' => 'showUploadVideo', 'uses' => 'Video\VideoController@showUploadVideo'
]);
//上传视频
$app->post('uploadVideo', [
    'as' => 'uploadVideo', 'uses' => 'Video\VideoController@uploadVideo'
]);
//获取弹幕
$app->get('getDanMu/{id}', 'Danmu\DanmuController@getDanMu');
//发送弹幕
$app->post('shootDanMu', [
    'as' => 'shootDanMu', 'uses' => 'Danmu\DanmuController@shootDanMu'
]);
//拉取评论列表
$app->get('ajaxGetCommentList', [
    'as' => 'ajaxGetCommentList', 'uses' => 'Comment\CommentController@ajaxGetCommentList'
]);
//添加评论信息
$app->get('ajaxAddCommentList', [
    'as' => 'ajaxAddCommentList', 'uses' => 'Comment\CommentController@ajaxAddCommentList'
]);
//使用中间件
$app->group(['middleware' => 'auth'], function () use ($app) {
    $app->get("middle", function () {
        echo 'this is the middleware test';
    });
});