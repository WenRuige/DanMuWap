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
use Illuminate\Http\Request;

//动弹地址
class DynamicController extends Controller
{
    public function index()
    {
        return view('Dynamic.index');
    }


    //发送一条弹幕
    public function sendDynamic(Request $request)
    {
        $this->validate($request, [
            'info' => 'required'
        ]);
        $info = DynamicService::getInstance()->sendDynamic($request->info);
        if (!empty($info['data'])) {

        }
    }

    //获取一条弹幕
    public function getDynamic()
    {

        $dynamicInfo = DynamicService::getInstance()->getDynamic();
        if (!empty($dynamicInfo['data'])) {
            echo json_encode($dynamicInfo['data'][array_rand($dynamicInfo['data'])]);
        }
    }
}