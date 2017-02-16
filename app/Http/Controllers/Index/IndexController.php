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
use Illuminate\Http\Request;
use App\Logic\Index\IndexLogic;
use Cache;
use Event;

class IndexController extends Controller
{


    //构造函数
    public function __construct()
    {
        parent::__construct(false);
    }

    //方法
    public function check()
    {
        //加载Model类中的方法
        Event::fire(new ExampleEvent());
        //        $this->user->say();
        Cache::put('key', 'value', 30);
        $data = Cache::get('key');

    }

    //首页展示
    public function index(Request $request)
    {
        //启用验证系统
        $res = [];
        $info = IndexLogic::getInstance()->show();
        if ($info['code'] == Constant::SUCCESS) {
            $res = $info['data'];
        } else {
            //如果返回不是成功的话,跳转到错误界面
            echo 'error';
        }
        return view('Index.index',['data' => $res]);
    }

    //视频页面测试
    public function video()
    {
        return view('Video.index');
    }

}