<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
class Controller extends BaseController
{
    public function __construct($flag = true)
    {
        //如果flag为false的话,则不需要登录
        //获取session
        $userId = isset($_SESSION['userId']);
        if ($flag &&(!$userId)) {
            //跳转至登录界面
            header("Location:/login");
            exit;
        }
    }
}
