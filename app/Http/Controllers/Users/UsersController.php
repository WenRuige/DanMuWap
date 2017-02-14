<?php
namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Logic\UsersLogic\UsersLogic;

class UsersController extends Controller
{
    public function __construct()
    {
        parent::__construct(true);
    }

    //展示用户个人中心界面
    public function index()
    {

    }

    //展示修改用户信息的blade
    public function showAlterUserBlade()
    {
        return view('Users.alter');
    }
    //修改用户的个人信息
    public function ajaxAlterUserInformation(Request $request){
        $this->validate($request, [
            'nickname' => 'required',
            'introduce' => 'required'
        ]);
        $data['nickname'] = $request->input('nickname');
        $data['introduce'] = $request->input('introduce');
        //获取用户的session id

        UsersLogic::getInstance()->storeUserInformation($data);

    }
}