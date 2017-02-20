<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Logic\Users\UsersLogic;
use Illuminate\Http\Request;
use App\Constant;
class HomeController extends Controller
{


    //展示个人中心界面(只做展示用)
    public function index()
    {
        //如果用户登录了,展示登录的信息
        $res = [];
        //获取用户的个人信息
        $info = UsersLogic::getInstance()->getUserInformation();
        //获取用户的头像
        if ($info['code'] == Constant::SUCCESS) {
            $res['nickname'] = $info['data']['nickname'];
            $res['introduce'] = $info['data']['introduce'];
            $res['photo'] = $info['data']['photo'];
        }
        return view('Home.index',['data' => $res]);
    }

}