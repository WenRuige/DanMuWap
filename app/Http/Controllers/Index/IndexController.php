<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use core\User\UserService;
use core\Index\IndexService;

class IndexController extends Controller
{
    //首页展示
    public function index()
    {
        $videoInfo = IndexService::getInstance()->index();
        //如果视频内容不为空的话
        if (!empty($videoInfo['data'])) {
            foreach ($videoInfo['data'] as $key => $value) {

                $userInfo = UserService::getInstance()->getUserInformation($value['user_id'], ['photo', 'nickname']);
                if (!empty($userInfo['data'])) {
                    $videoInfo['data'][$key] = array_merge($videoInfo['data'][$key], $userInfo['data']);
                }
                //如果图片为空的话,将gif代替他
                if(empty($value['picture'])){
                    $videoInfo['data'][$key]['picture'] = 'video/gif/'.$value['gif'];
                }else{
                    $videoInfo['data'][$key]['picture'] = 'video/cover/'.$value['picture'];
                }

            }
        }
        return view('Index.index', ['data' => $videoInfo['data']]);
    }
}