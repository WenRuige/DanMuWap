<?php
namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use core\User\UserService;
use Illuminate\Http\Request;
use core\Video\VideoService;
use core\Constant;

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

    //上传视频封面
    public function uploadPicture(Request $request)
    {
        $img = $request->img;
        list($type, $data) = explode(',', $img);
        // 判断类型
        if (strstr($type, 'image/jpeg') != '') {
            $ext = '.jpg';
        } elseif (strstr($type, 'image/gif') != '') {
            $ext = '.gif';
        } elseif (strstr($type, 'image/png') != '') {
            $ext = '.png';
        }
        $path = 'video/cover/' . md5(date('Y-m-d H:i:s')) . $ext;
        file_put_contents($path, base64_decode($data), true);
        echo json_encode(array('img' => md5(date('Y-m-d H:i:s')) . $ext));
    }

    //上传用户的视频
    //TODO:上传完删除该文件,二次上传的时候删除该信息
    public function uploadVideo(Request $request)
    {
        //获取文件名称md5加密
        $filename = md5(date('Y-m-d H:i:s'));
        //TODO:路径改为可配置
        $file = 'video/upload/' . $filename . '.mp4';
        $request->file('file')[0]->move('video/upload', $filename . '.mp4');
        $info = VideoService::getInstance()->uploadVideo($file, 'video/gif', $filename);
        //如果不为空的话返回文件名称
        if (!empty($info['data'])) {
            echo json_encode(array('filename' => $info['data']));
        }

        //如果上传文件为空的话,直接返回失败
//        if (empty($file)) {
//            return redirect('home');
//        }
//        //支持多文件上传
//        $request->file('file')[0]->move('video/upload', $filename . '.mp4');
//        $request->file('picture')->move('video/cover', $filename . '.jpg');
//        $data['picture'] = $filename . '.jpg';
//        $data['name'] = $request->name;
//        $data['video'] = $filename . '.mp4';
//        $data['content'] = $request->content;
//        $data['create_time'] = date("Y-m-d H:i:s");
//        $data['user_id'] = $_SESSION['userId'];
//        $info = VideoService::getInstance()->uploadVideo($data);
//        if ($info['code'] == Constant::SUCCESS) {
//            return redirect('home');
//        }
    }

    //上传视频相关信息
    public function uploadVideoInformation(Request $request)
    {
        $data['picture'] = $request->picture;
        $data['name'] = $request->name;
        $data['video'] = $request->video . '.mp4';
        $data['gif'] = $request->video . '.gif';
        $data['content'] = $request->content;
        $data['create_time'] = date("Y-m-d H:i:s");
        $data['user_id'] = $_SESSION['userId'];
        $info = VideoService::getInstance()->uploadVideoInformation($data);
        if ($info['code'] == Constant::SUCCESS) {
            return redirect('home');
        }
    }


}