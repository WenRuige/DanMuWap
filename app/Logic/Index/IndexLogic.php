<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/2/13
 * Time: 下午1:56
 */
//逻辑抽象层
namespace App\Logic\Index;

use App\Model\User;
use App\Model\Video;
use Log;
use App\Constant;

class IndexLogic
{
    //单例模式
    private static $_instance;

    public static function getInstance()
    {
        if (self::$_instance instanceof self) {
            return self::$_instance;
        } else {
            return new IndexLogic();
        }
    }

    //获取用户存储的信息
    public function show()
    {
        try {
            //获取用户的userId
            $info = Video::getInstance()->getVideo();
            foreach ($info as $key => $value) {
                $userInfo = User::getInstance()->getUserInformation($value->user_id);
                $info[$key]->photo = $userInfo->photo;
                $info[$key]->nickname = $userInfo->nickname;
            }
            $result = array('code' => Constant::SUCCESS, 'data' => $info, 'message' => Constant::getMsg(Constant::SUCCESS));
            return $result;
        } catch (\Exception $e) {
            $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
            return $result;
            Log::error($e->getMessage() . Constant::getMsg(Constant::UNKNOWN_ERROR));
        }
    }


}