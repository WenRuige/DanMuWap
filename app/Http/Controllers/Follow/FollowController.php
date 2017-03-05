<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Follow;

use App\Http\Controllers\Controller;
use core\Follow\FollowService;
use core\Video\VideoService;
use Illuminate\Http\Request;
use core\Constant;

class FollowController extends Controller
{
    //检查该用户是否关注我
    public function ajaxCheckFollow(Request $request)
    {
        $this->validate($request, [
            'param' => 'required'
        ]);
        $videoInfo = VideoService::getInstance()->getVideoById($request->param);
        if (!empty($videoInfo['data'])) {
            $followInfo = FollowService::getInstance()->checkFollow($videoInfo['data']['user_id']);
        }
        if (isset($followInfo['data'])) {
            return response()->json(array('code' => $followInfo['code'], 'message' => Constant::getMsg($followInfo['code']), 'data' => $followInfo['data']));
        } else {
            return response()->json(array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg($followInfo['code'])));
        }
    }

    //关注我or取关
    public function ajaxFollow(Request $request)
    {
        $this->validate($request, [
            'video_id' => 'required'
        ]);
        $videoInfo = VideoService::getInstance()->getVideoById($request->video_id);

        if (!empty($videoInfo['data'])) {
            $followInfo = FollowService::getInstance()->follow($videoInfo['data']['user_id']);
        }
        if (!empty($followInfo['data'])) {
            return response()->json(array('code' => Constant::SUCCESS, 'message' => Constant::getMsg(Constant::SUCCESS)));
        } else {
            return response()->json(array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR)));
        }
    }
}