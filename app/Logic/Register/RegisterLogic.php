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
            $info = Register::getInstance()->checkIsRegister($email);
            if(!empty($info)){
                return response()->json(['code' => Constant::SUCCESS, 'message' => '']);
            }
            //首先check邮箱是否重复
            Register::getInstance()->registerAccount($email,$password);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

    }
}