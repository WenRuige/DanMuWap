<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Index;

use App\Events\ExampleEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use Cache;
use Event;

class IndexController extends Controller
{


    //构造函数
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    //方法
    public function check()
    {

        //加载Model类中的方法
        Event::fire(new ExampleEvent());
        //        $this->user->say();
        Cache::put('key','value',30);
            $data = Cache::get('key');

    }

    public function index(Request $request)
    {
        //启用验证系统
//        $this->validate($request, [
//            'name' => 'required'
//        ]);
        return view('Index.index');
    }
}