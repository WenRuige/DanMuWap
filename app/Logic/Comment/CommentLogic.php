<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/2/13
 * Time: 下午1:56
 */
//逻辑抽象层
namespace App\Logic\Comment;


use App\Model\Comment;
use App\Model\User;
use Log;
use App\Constant;

class CommentLogic
{
    //单例模式
    private static $_instance;

    public static function getInstance()
    {
        if (self::$_instance instanceof self) {
            return self::$_instance;
        } else {
            return new self();
        }
    }

    //获取评论信息
    public function getCommentInformation($id)
    {
        try {
            $info = Comment::getInstance()->getCommentByVideoId($id);
            foreach ($info as $key => $value) {
                $userInfo = User::getInstance()->getUserInformation($info[$key]->user_id);
                $info[$key]->nickname = $userInfo->nickname;
                $info[$key]->photo = $userInfo->photo;
            }
            $result = array('code' => Constant::SUCCESS, 'data' => $info, 'message' => Constant::getMsg(Constant::SUCCESS));
            return $result;
        } catch (\Exception $e) {
            $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
            return $result;
            Log::error($e->getMessage() . Constant::getMsg(Constant::UNKNOWN_ERROR));
        }
    }

    //添加一条
    public function insertComment($comment, $video_id)
    {
        try {
            $userId = $_SESSION['userId'];
            if (empty($userId)) {
                $result = array('code' => Constant::SESSION_OVERTIME, 'message' => Constant::getMsg(Constant::SESSION_OVERTIME));
                return $result;
            }
            $data['user_id'] = $userId;
            $data['content'] = $comment;
            $data['create_time'] = date("Y-m-d H:i:s");
            $data['video_id'] = $video_id;
            $info = Comment::getInstance()->insertComment($data);
            $result = array('code' => Constant::SUCCESS, 'data' => $info, 'message' => Constant::getMsg(Constant::SUCCESS));
            return $result;
        } catch (\Exception $e) {
            $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
            return $result;
            Log::error($e->getMessage() . Constant::getMsg(Constant::UNKNOWN_ERROR));
        }
    }

}