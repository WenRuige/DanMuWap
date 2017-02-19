<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/2/13
 * Time: 下午1:56
 */
//逻辑抽象层
namespace App\Logic\Comment;


use App\Model\Comment;
use Log;
use App\Constant;

class CommentLogic
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

}