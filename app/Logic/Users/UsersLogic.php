<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/2/13
 * Time: 下午1:56
 */
//逻辑抽象层
namespace App\Logic\Users;

use App\Model\Register;
use App\Model\User;
use Log;
use App\Constant;

class UsersLogic
{
    //单例模式
    private static $_instance;

    public static function getInstance()
    {
        if (self::$_instance instanceof self) {
            return self::$_instance;
        } else {
            return new UsersLogic();
        }
    }
    //TODO:将判断是否登录单独抽出到一个方法
    //存储用户信息
    public function storeUserInformation($data)
    {
        try {
            //获取用户的userId
            $userId = $_SESSION['userId'];
            if (empty($userId)) {
                $result = array('code' => Constant::SESSION_OVERTIME, 'message' => Constant::getMsg(Constant::SESSION_OVERTIME));
                return $result;
            }
            $info = User::getInstance()->updateUserInformation($userId, $data);
            if (empty($info)) {
                $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
                return $result;
            }
            $result = array('code' => Constant::SUCCESS, 'message' => Constant::getMsg(Constant::SUCCESS));
            return $result;
        } catch (\Exception $e) {
            $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
            return $result;
            Log::error($e->getMessage() . Constant::getMsg(Constant::UNKNOWN_ERROR));
        }
    }

    //获取用户详情
    public function getUserInformation()
    {
        try {
            $userId = $_SESSION['userId'];
            if (empty($userId)) {
                $result = array('code' => Constant::SESSION_OVERTIME, 'message' => Constant::getMsg(Constant::SESSION_OVERTIME));
                return $result;
            }
            $info = User::getInstance()->getUserInformation($userId);
            if (empty($info)) {
                $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
                return $result;
            }
            $res = ['nickname' => $info->nickname, 'introduce' => $info->introduce, 'photo' => $info->photo];

            $result = array(
                'code' => Constant::SUCCESS,
                'data' => $res,
                'message' => Constant::getMsg(Constant::SUCCESS)
            );
            return $result;

        } catch (\Exception $e) {
            $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
            return $result;
            Log::error($e->getMessage() . Constant::getMsg(Constant::UNKNOWN_ERROR));
        }
    }

    //上传图片
    public function uploadPhoto($filename)
    {
        try {
            $userId = $_SESSION['userId'];
            if (empty($userId)) {
                $result = array('code' => Constant::SESSION_OVERTIME, 'message' => Constant::getMsg(Constant::SESSION_OVERTIME));
                return $result;
            }
            $info = User::getInstance()->updateUserPhoto($filename, $userId);
            if (empty($info)) {
                $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
                return $result;
            }
            $result = array(
                'code' => Constant::SUCCESS,
                'message' => Constant::getMsg(Constant::SUCCESS)
            );
            return $result;
        } catch (\Exception $e) {
            $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
            return $result;
            Log::error($e->getMessage() . Constant::getMsg(Constant::UNKNOWN_ERROR));
        }
    }


}