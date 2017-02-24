<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/2/13
 * Time: 下午1:56
 */
//逻辑抽象层
namespace App\Logic\Follow;

use Log;
use App\Constant;
use App\Model\Follow;

class FollowLogic
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

    //检查是否关注我
    public function checkFollow($uid)
    {
        try {
            $param['follow_id'] = $_SESSION['userId'];
            $param['be_followed_id'] = $uid;
            $info = Follow::getInstance()->checkFollow($param);
            if(empty($info)){
                $flag = 1;
            }
            $result = array(
                'code' => Constant::SUCCESS,
                'message' => Constant::getMsg(Constant::SUCCESS),
                'data' => isset($flag)?1:0
            );
            return $result;
        } catch (\Exception $e) {
            $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
            return $result;
            Log::error($e->getMessage() . Constant::getMsg(Constant::UNKNOWN_ERROR));
        }
    }
}