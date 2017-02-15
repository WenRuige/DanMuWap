<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/9
 * Time: 上午9:07
 */
namespace App\Model;

use DB;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    private static $_instance;

    public static function getInstance()
    {
        if (self::$_instance instanceof self) {
            return self::$_instance;
        } else {
            return new self();
        }
    }

    //检查用户名是否存在
    public function checkEmail($email)
    {
        return DB::table('users')->where('email', $email)->first();
    }

    //注册一个账户 @return true / false
    public function registerAccount($email, $password)
    {
        return DB::table('users')->insert([
            ['email' => $email, 'password' => $password]
        ]);
    }

    //检查改账户是否注册过
    public function checkIsRegister($email)
    {
        return DB::table('users')->where('email', $email)->value('email');
    }

    //更新用户信息
    public function updateUserInformation($userId, $data)
    {
        return DB::table('users')->where('id', $userId)->update($data);
    }

    //获取用户信息
    public function getUserInformation($userId)
    {
        return DB::table('users')->where('id', $userId)->first();
    }

    //更新用户的头像
    public function updateUserPhoto($filename,$userId)
    {
        return DB::table('users')->where('id', $userId)->update(['photo' => $filename]);
    }


}