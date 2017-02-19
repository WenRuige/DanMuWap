<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
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
        $this->validate($request,[
            'param' => 'required'
        ]);

        //dd($request->all());
    }
}