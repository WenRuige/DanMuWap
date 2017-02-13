<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/2/13
 * Time: 下午1:56
 */
//逻辑抽象层
namespace App\Logic\Register;

use App\Model\Register;
use Log;
use App\Constant;

class RegisterLogic
{
    //单例模式
    private static $_instance;

    public static function getInstance()
    {
        if (self::$_instance instanceof self) {
            return self::$_instance;
        } else {
            return new RegisterLogic();
        }
    }

    //注册一个账户
    public function registerAccount($email, $password)
    {
        try {
            //首先check邮箱是否重复
            $info = Register::getInstance()->checkIsRegister($email);
            //用户名重复
            if (!empty($info)) {
                $result = array('code' => Constant::PARAM_REPEAT, 'message' => Constant::getMsg(Constant::PARAM_REPEAT));
                return $result;
            }
            //若用户名不重复则直接插入数据
            $flag = Register::getInstance()->registerAccount($email, $password);
            if (is_bool($info) && $flag) {
                $result = array('code' => Constant::SUCCESS, 'message' => Constant::getMsg(Constant::SUCCESS));
                return $result;
            }
        } catch (\Exception $e) {
            $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
            return $result;
            Log::error($e->getMessage().Constant::getMsg(Constant::UNKNOWN_ERROR));
        }

    }
}