<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/2/13
 * Time: 下午10:37
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class Login extends Model
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
        $user = DB::table('users')->where('email', $email)->first();
        return $user;
//        $users = DB::table('users')
//            ->select('email','password')
//            ->where('email', '=', $email)
//            ->get();
//        return $users;
    }
}