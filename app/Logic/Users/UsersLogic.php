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

    //存储用户信息
    public function storeUserInformation($data)
    {
        try {
            //获取用户的userId
            $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
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
            $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
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
    //TODO:添加用户的创建时间和更新时间
    public function uploadPhoto($filename)
    {
        try {
            $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
            if (empty($userId)) {
                $result = array('code' => Constant::SESSION_OVERTIME, 'message' => Constant::getMsg(Constant::SESSION_OVERTIME));
                return $result;
            }
            //通过Userid来获取相关信息
            $oldUserimg = User::getInstance()->getUserInformation($userId)->photo;
            //删除之前上传的图片记录
            $res = unlink('picture/upload/' . $oldUserimg);
            if (!$res) {
                $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
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

    //通过视频id来获取相关的用户信息
    public function getUserInformationByVideoId($userId)
    {
        try {
            $info = User::getInstance()->getUserInformation($userId);
            if (empty($info)) {
                $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
                return $result;
            }
            $result = array(
                'code' => Constant::SUCCESS,
                'message' => Constant::getMsg(Constant::SUCCESS),
                'data' => $info
            );
            return $result;
        } catch (\Exception $e) {
            $result = array('code' => Constant::UNKNOWN_ERROR, 'message' => Constant::getMsg(Constant::UNKNOWN_ERROR));
            return $result;
            Log::error($e->getMessage() . Constant::getMsg(Constant::UNKNOWN_ERROR));
        }

    }


}