<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/2/13
 * Time: 下午10:38
 */
namespace App\Logic\Login;
use App\Constant;
use App\Model\Login;

//登录逻辑层
class LoginLogic
{
    //单例模式
    private static $_instance;

    public static function getInstance()
    {
        if (self::$_instance instanceof self) {
            return self::$_instance;
        } else {
            return new LoginLogic();
        }
    }

    //用户登录
    public function login($email, $password)
    {
        try {
            $info = Login::getInstance()->checkEmail($email);
            dd($info);
            if(empty($info)){
                $result = array('code' => Constant::USER_ERROR, 'message' => Constant::getMsg(Constant::USER_ERROR));
                return $result;
            }

        } catch (\Exception $e) {
            $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
            return $result;
            Log::error($e->getMessage().Constant::getMsg(Constant::UNKNOWN_ERROR));
        }
    }

}