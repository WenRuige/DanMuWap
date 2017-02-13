<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/9
 * Time: 上午9:07
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Register extends Model
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


}