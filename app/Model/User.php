<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/9
 * Time: 上午9:07
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    public function __construct()
    {
       // echo '123';
    }

    public function say()
    {
        echo 'this is model singing';
    }


}