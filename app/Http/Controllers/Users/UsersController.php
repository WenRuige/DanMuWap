<?php
namespace App\Http\Controllers\Users;

use App\Constant;
use App\Http\Controllers\Controller;
use App\Logic\Users\UsersLogic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            return response()->json(array('code' => Constant::SUCCESS, 'data' => $info['data'], 'message' => Constant::getMsg(Constant::SUCCESS)));
        } else {
            return response()->json(array('code' => $info['code'], 'message' => Constant::getMsg($info['code'])));
        }
    }

    //展示修改用户个人头像
    public function showAlterUserPhotoBlade()
    {
        return view('Users.uploadPhoto');
    }

    //上传用户头像
    public function uploadPhoto(Request $request)
    {
        $file = $request->file('file');
        //如果上传文件为空的话,直接返回失败
        if (empty($file)) {
            return redirect('home');
        }
        $filename = md5(date('Y-m-d H:i:s')) . '.jpg';
        $request->file('file')[0]->move('picture/upload', $filename);
        $info = UsersLogic::getInstance()->uploadPhoto($filename);
        if ($info['code'] == Constant::SUCCESS) {
            return redirect('home');
        }
    }


}