<?php
namespace App\Http\Controllers\Video;

use App\Constant;
use App\Http\Controllers\Controller;
use App\Logic\Users\UsersLogic;
use App\Logic\Video\VideoLogic;
use App\Model\Video;
use Illuminate\Http\Request;


class VideoController extends Controller
{

    //视频界面
    public function video($id)
    {
        $res = [];
        $info = VideoLogic::getInstance()->getVideo($id);
        //获取用户相关信息
        $userInfo = UsersLogic::getInstance()->getUserInformationByVideoId($info['data']->user_id);
        if ($info['code'] == Constant::SUCCESS) {
            $res['video'] = $info['data'];
        } else {
            echo 'error';
        }
        if ($userInfo['code'] == Constant::SUCCESS) {
            $res['user'] = $userInfo['data'];
        }
        return view('Video.index', ['data' => $res]);
    }

    //上传视频模板
    public function showUploadVideo()
    {
        return view('Video.uploadVideo');
    }
    //上传用户的视频
    //TODO:上传完删除该文件,二次上传的时候删除该信息
    public function uploadVideo(Request $request)
    {

        $this->validate($request, [
                'name' => 'required',
                'content' => 'required'
            ]
        );
        $file = $request->file('file');
        //如果上传文件为空的话,直接返回失败
        if (empty($file)) {
            return redirect('home');
        }
        $filename = md5(date('Y-m-d H:i:s'));
        //支持多文件上传
        $request->file('file')[0]->move('video/upload', $filename . '.mp4');
        $request->file('picture')->move('video/cover', $filename . '.jpg');

        $data['picture'] = $filename . '.jpg';
        $data['name'] = $request->name;
        $data['video'] = $filename . '.mp4';
        $data['content'] = $request->content;
        $data['create_time'] = date("Y-m-d H:i:s");
        $data['user_id'] = $_SESSION['userId'];
        $info = VideoLogic::getInstance()->uploadVideo($data);
        if ($info['code'] == Constant::SUCCESS) {
            return redirect('home');
        }
    }


}