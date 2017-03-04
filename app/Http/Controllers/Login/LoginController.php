<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Login;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use core\User\UserService;
use core\Constant;

class LoginController extends Controller
{

    public function index()
    {
        return view('Login.index');
    }

    //登录
    public function ajaxLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $email = $request->input('email');
        $password = $request->input('password');
        $userInfo = UserService::getInstance()->login($email, $password);
        if (!empty($userInfo['data'])) {
            return response()->json(array('code' => Constant::SUCCESS, 'message' => Constant::getMsg(Constant::SUCCESS)));
        } else {
            return response()->json(array('code' => Constant::USER_ERROR, 'message' => Constant::getMsg(Constant::USER_ERROR)));
        }
    }

    //退出登录
    public function Logout()
    {
        //注销session
        unset($_SESSION['userId']);
        header("Location:/login");
    }

}