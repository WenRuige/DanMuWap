<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use core\User\UserService;
class HomeController extends Controller
{


    //展示个人中心界面(只做展示用)
    public function index()
    {
        $uid = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
        $userInfo = UserService::getInstance()->getUserInformation($uid,['nickname','introduce','photo']);
        if(empty($userInfo['data'])){
            $userInfo['data']['nickname'] = '无名氏';
            $userInfo['data']['introduce'] = '这个用户很懒';
        }
        return view('Home.index', ['data' => $userInfo['data']]);
    }

}