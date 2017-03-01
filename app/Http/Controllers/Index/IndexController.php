<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Index;

use App\Constant;
use App\Events\ExampleEvent;
use App\Http\Controllers\Controller;
use core\User\UserService;
use Illuminate\Http\Request;
use App\Logic\Index\IndexLogic;
use Cache;
use Event;
use core\Container;
use core\Index\IndexService;

class IndexController extends Controller
{
    //首页展示
    public function index()
    {
        $videoInfo = IndexService::getInstance()->index();

                UserService::getInstance()->getUserInformation();

//        $pd = Container::getMysql();
//        $data = $pd->from('users')->fetch();
//        //启用验证系统
//        $res = [];
//        $info = IndexLogic::getInstance()->show();
//        if ($info['code'] == Constant::SUCCESS) {
//            $res = $info['data'];
//        } else {
//            //如果返回不是成功的话,跳转到错误界面
//            echo 'error';
//        }
//        return view('Index.index', ['data' => $res]);
    }
}