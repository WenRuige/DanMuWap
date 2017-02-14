<?php
namespace App\Http\Controllers\Users;

use App\Constant;
use App\Http\Controllers\Controller;
use App\Logic\Users\UsersLogic;
use Illuminate\Http\Request;

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
    public function ajaxAlterUserInformation(Request $request)
    {
        $this->validate($request, [
            'nickname' => 'required',
            'introduce' => 'required'
        ]);
        $data['nickname'] = $request->input('nickname');
        $data['introduce'] = $request->input('introduce');
        //获取用户的session id
        $info = UsersLogic::getInstance()->storeUserInformation($data);
        if ($info['code'] == Constant::SUCCESS) {
            return response()->json(array('code' => Constant::SUCCESS, 'message' => Constant::getMsg(Constant::SUCCESS)));
        } else {
            return response()->json(array('code' => $info['code'], 'message' => Constant::getMsg($info['code'])));
        }

    }

    //获取用户的填写的信息
    public function ajaxGetUserInformation()
    {
        $info = UsersLogic::getInstance()->getUserInformation();
        if ($info['code'] == Constant::SUCCESS) {
            return response()->json(array('code' => Constant::SUCCESS, 'data'=> $info['data'],'message' => Constant::getMsg(Constant::SUCCESS)));
        } else {
          //  return response()->json(array('code' => $info['code'], 'message' => Constant::getMsg($info['code'])));
        }
    }
}