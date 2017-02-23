<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/2/8
 * Time: 上午8:52
 */

//登录判断模块,主要进行判断是否登录,若未登录跳转至登录模块
namespace App\Http\Middleware;

use Closure;

class Authority
{
    //进行处理
    public function handle($request, Closure $next)
    {
        $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
        if (!empty($userId)) {
            return $next($request);
        } else {
            //如果未登录的话,跳转至登录的路由
            header("Location:/login");
        }


    }
}