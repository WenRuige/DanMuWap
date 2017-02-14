<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    //个人中心界面需要登录
    public function __construct()
    {
        parent::__construct(false);
    }

    //展示个人中心界面(只做展示用)
    public function index()
    {
        return view('Home.index');
    }

}