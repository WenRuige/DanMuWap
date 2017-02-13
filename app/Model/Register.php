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
    public function __construct()
    {

    }
    //注册一个账户
    public static function  registerAccount($email,$password)
    {
        //使用查询构造器的方式来进行查询
        DB::select();
        return response()->json(['name' => 'Abigail', 'state' => 'CA']);
    }


}