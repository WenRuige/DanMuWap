<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/2/13
 * Time: 下午1:56
 */
//逻辑抽象层
namespace App\Logic\UsersLogic;

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

    //存储用户信息
    public function storeUserInformation($data)
    {
        try {
            //获取用户的userId
            $userId = $_SESSION['userId'];
            if(empty($userId)){
                $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
                return $result;
            }
            $info = User::getInstance()->checkIsRegister($email);
        } catch (\Exception $e) {
            $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
            return $result;
            Log::error($e->getMessage() . Constant::getMsg(Constant::UNKNOWN_ERROR));
        }
    }

}