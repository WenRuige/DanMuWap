<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Logic\Comment\CommentLogic;
use Illuminate\Http\Request;
use App\Constant;
use Log;

class CommentController extends Controller
{

    //个人中心界面需要登录
    public function __construct()
    {
        parent::__construct(false);
    }

    //ajax拉取评论列表
    public function ajaxGetCommentList(Request $request)
    {
        $this->validate($request, [
            'param' => 'required'
        ]);
        $info = CommentLogic::getInstance()->getCommentInformation($request->param);
        if ($info['code'] == Constant::SUCCESS) {
            return response()->json(array('code' => Constant::SUCCESS, 'data' => $info['data'], 'message' => Constant::getMsg(Constant::SUCCESS)));
        } else {
            return response()->json(array('code' => $info['code'], 'message' => Constant::getMsg($info['code'])));
        }
    }
    //添加一条评论
    public function ajaxAddCommentList(Request $request)
    {
        $this->validate($request,[
            'comment' => 'required',
            'video_id' => 'required'
        ]);
        $info = CommentLogic::getInstance()->insertComment($request->comment,$request->video_id);
        if ($info['code'] == Constant::SUCCESS) {
            return response()->json(array('code' => Constant::SUCCESS, 'data' => $info['data'], 'message' => Constant::getMsg(Constant::SUCCESS)));
        } else {
            return response()->json(array('code' => $info['code'], 'message' => Constant::getMsg($info['code'])));
        }

    }
}