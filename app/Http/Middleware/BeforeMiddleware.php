<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午3:55
 */
namespace App\Http\Middleware;

use Closure;

class BeforeMiddleware
{

    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}