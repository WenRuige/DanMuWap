<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/2/13
 * Time: 下午1:56
 */
//逻辑抽象层
namespace App\Logic\Video;

use App\Model\Video;
use Log;
use App\Constant;

class VideoLogic
{
    //单例模式
    private static $_instance;

    public static function getInstance()
    {
        if (self::$_instance instanceof self) {
            return self::$_instance;
        } else {
            return new VideoLogic();
        }
    }

    //TODO:将判断是否登录单独抽出到一个方法
    public function uploadVideo($data)
    {
        try {
            $info = Video::getInstance()->uploadVideo($data);
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

    //通过视频Id来获取视频
    public function getVideo($id)
    {
        try {
            $info = Video::getInstance()->getVideoById($id);
            if (empty($info)) {
                $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
                return $result;
            }
            $result = array(
                'code' => Constant::SUCCESS,
                'data' => $info,
                'message' => Constant::getMsg(Constant::SUCCESS)
            );
            return $result;
        } catch (\Exception $e) {
            $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
            return $result;
            Log::error($e->getMessage() . Constant::getMsg(Constant::UNKNOWN_ERROR));
        }
    }

    //通过视频id来获取弹幕
    public function getDanmu($id)
    {
        try {
            $info = Video::getInstance()->getDanMuById($id);
            if (empty($info)) {
                $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
                return $result;
            }
            $result = array(
                'code' => Constant::SUCCESS,
                'data' => $info,
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