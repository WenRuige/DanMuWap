<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use core\Follow\FollowService;
use core\User\UserService;
use core\Video\VideoService;

class HomeController extends Controller
{


    //展示个人中心界面(只做展示用)
    public function index()
    {
        $uid = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
        $userInfo = UserService::getInstance()->getUserInformation($uid, ['nickname', 'introduce', 'photo']);
        //获取这个用户的粉丝数
        $followInfo = FollowService::getInstance()->getFollowNum();
        if (!isset($followInfo['data'])) {
            $followInfo['data'] = 0;
        }
        //发布视频的数量
        $videoInfo = VideoService::getInstance()->getVideoNum();
        if (empty($userInfo['data'])) {
            $userInfo['data']['nickname'] = '无名氏';
            $userInfo['data']['introduce'] = '这个用户很懒';
        }
        return view('Home.index', ['data' => $userInfo['data'], 'follow' => $followInfo['data']]);
    }

}