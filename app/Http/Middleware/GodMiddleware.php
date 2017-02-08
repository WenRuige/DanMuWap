<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 上午10:12
 */
namespace App\Http\Middleware;

use Closure;

class GodMiddleware
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}