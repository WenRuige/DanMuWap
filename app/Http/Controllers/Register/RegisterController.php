<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Register;

use core\Constant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Logic\Register\RegisterLogic;
use core\User\UserService;

class RegisterController extends Controller
{

    public function index()
    {
        return view('Register.index');
    }

    public function ajaxRegisterAccount(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $email = $request->input('email');
        $password = password_hash($request->input('password'), PASSWORD_DEFAULT);
        $userInfo = UserService::getInstance()->register($email, $password);
        if (!empty($userInfo['data'])) {
            return response()->json(array('code' => Constant::SUCCESS, 'message' => Constant::getMsg(Constant::SUCCESS)));
        } else {
            return response()->json(array('code' => Constant::USER_ERROR, 'message' => Constant::getMsg(Constant::USER_ERROR)));
        }
    }
}