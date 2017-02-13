<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Register;
class RegisterController extends Controller
{


    //构造函数
    public function __construct()
    {

    }

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
        Register::registerAccount($email,$password);
        //echo $password;
    }
}