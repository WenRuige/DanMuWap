<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/2/13
 * Time: 下午1:56
 */
//逻辑抽象层
namespace App\Logic\Follow;


use App\Model\DanMu;
use Log;
use App\Constant;

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

    //通过id来获取弹幕
    public function getDanmu($id)
    {
        try {
            //获取用户的userId
            $info = DanMu::getInstance()->getDanmu($id);
            $json = '[';
            foreach ($info as $key => $value) {
                $json .= $info[$key]->content . ',';
            }
            $json = substr($json, 0, -1);
            $json .= ']';
            $result = array('code' => Constant::SUCCESS, 'data' => $json, 'message' => Constant::getMsg(Constant::SUCCESS));
            return $result;
        } catch (\Exception $e) {
            $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
            return $result;
            Log::error($e->getMessage() . Constant::getMsg(Constant::UNKNOWN_ERROR));
        }
    }

    //保存弹幕信息
    public function saveDanmu($data)
    {
        try {
            //获取用户的userId
            $info = DanMu::getInstance()->saveDanmu($data);
            $result = array('code' => Constant::SUCCESS, 'message' => Constant::getMsg(Constant::SUCCESS));
            return $result;
        } catch (\Exception $e) {
            $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
            return $result;
            Log::error($e->getMessage() . Constant::getMsg(Constant::UNKNOWN_ERROR));
        }
    }

}