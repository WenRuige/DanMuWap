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
            $param['flag'] = 1;
            $info = Follow::getInstance()->checkFollow($param);
            if (!empty($info)) {
                $flag = 1;
            }
            $result = array(
                'code' => Constant::SUCCESS,
                'message' => Constant::getMsg(Constant::SUCCESS),
                'data' => isset($flag) ? 1 : 0
            );
            return $result;
        } catch (\Exception $e) {
            $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
            return $result;
            Log::error($e->getMessage() . Constant::getMsg(Constant::UNKNOWN_ERROR));
        }
    }

    //follow or unfollow
    public function follow($uid)
    {
        try {
            //是否关注我
            $flag = $this->checkFollow($uid)['data'];
           // dd($flag);
            //如果没关注我的话
            $param['follow_id'] = $_SESSION['userId'];
            $param['be_followed_id'] = $uid;
            if (intval($flag) === 0) {
                $info = Follow::getInstance()->checkFollow($param);
                //check之前是否关注过我
                if (empty($info)) {
                    $param['flag'] = 1;
                    $param['create_time'] = date('Y-m-d H:i:s');
                    $followInfo = Follow::getInstance()->insertFollowInformation($param);
                } else {
                    $followInfo = Follow::getInstance()->updateFollowInformation($param, ['flag' => 1,'update_time' => date("Y-m-d H:i:s")]);
                }
            } else {
                //如果关注过我,直接取关
                $followInfo = Follow::getInstance()->updateFollowInformation($param, ['flag' => 0,'update_time' => date("Y-m-d H:i:s")]);
            }
            if (empty($followInfo)) {
                $result = array(
                    'code' => Constant::UNKNOWN_ERROR,
                    'message' => Constant::getMsg(Constant::UNKNOWN_ERROR),
                    'data' => ''
                );
            } else {
                $result = array(
                    'code' => Constant::SUCCESS,
                    'message' => Constant::getMsg(Constant::SUCCESS),
                    'data' => ''
                );
            }
            return $result;
        } catch (\Exception $e) {
            $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
            return $result;
            Log::error($e->getMessage() . Constant::getMsg(Constant::UNKNOWN_ERROR));
        }
    }


}