<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/2/13
 * Time: 下午8:18
 */
//异常类
namespace App;
class Constant{

    const SUCCESS = 0; //成功
    const UNKNOWN_ERROR = 1; //位置错误
    const PARAM_REPEAT = 2;//变量重复
    const USER_ERROR = 3;//用户名或密码错误

    public static $ret = array(
      self::SUCCESS => '成功',
      self::PARAM_REPEAT => '重复',
      self::USER_ERROR => '用户名或密码错误'
    );

    public static function getMsg($exceptionCode) {

        if (isset(self::$ret[$exceptionCode])) {
            return self::$ret[$exceptionCode];
        } elseif (isset(static::$ret[$exceptionCode])) {
            return static::$ret[$exceptionCode];
        } else {
            return self::$ret[self::UNKNOWN_ERROR];
        }
    }

}