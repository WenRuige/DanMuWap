<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;

class RegisterController extends Controller
{


    //构造函数
    public function __construct()
    {

    }

    public function index()
    {
        return view('Register.index');
        //echo 'this is register page';
    }
}