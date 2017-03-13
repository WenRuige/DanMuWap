<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Dynamic;

use App\Http\Controllers\Controller;
use core\Dynamic\DynamicService;
use core\User\UserService;
use Illuminate\Http\Request;

//动弹地址
class DynamicController extends Controller
{
    public function index()
    {
        $dynamicInfo = DynamicService::getInstance()->getDynamic();
        foreach ($dynamicInfo['data'] as $key => $value) {
            if (isset($value['user_id'])) {
                $userInfo = UserService::getInstance()->getUserInformation($value['user_id'], ['photo', 'nickname']);
                if (!empty($userInfo['data'])) {
                    $dynamicInfo['data'][$key]['img'] = 'picture/upload/' . $userInfo['data']['photo'];
                    $dynamicInfo['data'][$key]['nickname'] = $userInfo['data']['nickname'];
                }
            } else {
                $dynamicInfo['data'][$key]['img'] = 'dist/img/timg.jpeg';
                $dynamicInfo['data'][$key]['nickname'] = '匿名账户';
            }
        }
        return view('Dynamic.index', ['dynamic' => $dynamicInfo['data']]);
    }


    //发送一条弹幕
    public function sendDynamic(Request $request)
    {
        $this->validate($request, [
            'info' => 'required'
        ]);
        $info = DynamicService::getInstance()->sendDynamic($request->info);
        if (!empty($info['data'])) {
            return redirect('dynamic');
        }
    }

    //获取一条弹幕
    public function getDynamic()
    {

        $dynamicInfo = DynamicService::getInstance()->getDynamic();
        foreach ($dynamicInfo['data'] as $key => $value) {
            if (isset($value['user_id'])) {
                $userInfo = UserService::getInstance()->getUserInformation($value['user_id'], ['photo']);
                if (!empty($userInfo['data'])) {
                    $dynamicInfo['data'][$key]['img'] = 'picture/upload/' . $userInfo['data']['photo'];
                }
            }
        }

        if (!empty($dynamicInfo['data'])) {
            echo json_encode($dynamicInfo['data'][array_rand($dynamicInfo['data'])]);
        }
    }
}