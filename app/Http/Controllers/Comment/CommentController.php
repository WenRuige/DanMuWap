<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use core\Comment\CommentService;
use Illuminate\Http\Request;
use core\User\UserService;
use core\Constant;

class CommentController extends Controller
{


    //ajax拉取评论列表
    public function ajaxGetCommentList(Request $request)
    {
        $this->validate($request, [
            'param' => 'required'
        ]);
        $commentInfo = CommentService::getInstance()->getCommentList($request->param);
        if (!empty($commentInfo['data'])) {
            foreach ($commentInfo['data'] as $key => $value) {
                $userInfo = UserService::getInstance()->getUserInformation($value['user_id'], ['photo', 'nickname']);
                if (!empty($userInfo['data'])) {
                    $commentInfo['data'][$key] = array_merge($commentInfo['data'][$key], $userInfo['data']);
                }
            }
        }
        return response()->json(array('code' => Constant::SUCCESS, 'data' => $commentInfo['data'], 'message' => Constant::getMsg(Constant::SUCCESS)));
    }

    //添加一条评论
    public function ajaxAddCommentList(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required',
            'video_id' => 'required'
        ]);
        $info = CommentService::getInstance()->insertComment($request->comment, $request->video_id);
        if ($info['code'] == Constant::SUCCESS) {
            return response()->json(array('code' => Constant::SUCCESS, 'data' => $info['data'], 'message' => Constant::getMsg(Constant::SUCCESS)));
        } else {
            return response()->json(array('code' => $info['code'], 'message' => Constant::getMsg($info['code'])));
        }

    }
}