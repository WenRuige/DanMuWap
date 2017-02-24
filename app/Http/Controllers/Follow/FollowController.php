<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Follow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Logic\Video\VideoLogic;
use App\Logic\Follow\FollowLogic;
use App\Constant;
use Log;

class FollowController extends Controller
{
    //检查该用户是否关注我
    public function ajaxCheckFollow(Request $request)
    {
        $this->validate($request, [
            'param' => 'required'
        ]);
        $userInfo = VideoLogic::getInstance()->getVideo($request->param);
        $followInfo = FollowLogic::getInstance()->checkFollow($userInfo['data']->user_id);
        if ($followInfo['code'] == Constant::SUCCESS) {
            return response()->json(array('code' => $followInfo['code'], 'message' => Constant::getMsg($followInfo['code']),'data' => $followInfo['data']));
        }else{
            return response()->json(array('code' => $followInfo['code'], 'message' => Constant::getMsg($followInfo['code'])));
        }
    }
    //关注我
    public function ajaxFollowme(){

    }
}