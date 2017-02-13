<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Login;

use App\Constant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Logic\Login\LoginLogic;

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
        $password = password_hash($request->input('password'), PASSWORD_DEFAULT);
        LoginLogic::getInstance()->login($email,$password);
        echo $password;
    }

    public function ajaxRegisterAccount(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $email = $request->input('email');
        $password = password_hash($request->input('password'), PASSWORD_DEFAULT);
        $info = RegisterLogic::getInstance()->registerAccount($email, $password);
        if ($info['code'] == Constant::SUCCESS) {
            return response()->json(array('code' => Constant::SUCCESS, 'message' => Constant::getMsg(Constant::SUCCESS)));
        } else {
            return response()->json(array('code' => $info['code'], 'message' => Constant::getMsg($info['code'])));
        }
    }
}