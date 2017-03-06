<?php
namespace App\Http\Controllers\Video;

use App\Constant;
use App\Http\Controllers\Controller;
use App\Logic\Video\VideoLogic;
use App\Model\Video;
use core\User\UserService;
use Illuminate\Http\Request;
use core\Video\VideoService;

class VideoController extends Controller
{

    //视频界面
    public function video($id)
    {

        $videoInfo = VideoService::getInstance()->getVideoById($id);
        if (!empty($videoInfo['data'])) {
            $userInfo = UserService::getInstance()->getUserInformation($videoInfo['data']['user_id'], ['introduce', 'nickname', 'photo']);
            if (!empty($userInfo)) {
                $videoInfo['data'] = array_merge($videoInfo['data'], $userInfo['data']);
                $videoInfo['data']['uid'] = !empty($_SESSION['userId']) ? $_SESSION['userId'] : '';
            }
        }
        return view('Video.index', ['data' => $videoInfo['data']]);
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
        $info = VideoService::getInstance()->uploadVideo($data);
        if ($info['code'] == Constant::SUCCESS) {
            return redirect('home');
        }
    }


}