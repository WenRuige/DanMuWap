<?php
namespace App\Http\Controllers\Video;

use App\Constant;
use App\Http\Controllers\Controller;
use App\Logic\Video\VideoLogic;
use Illuminate\Http\Request;


class VideoController extends Controller
{
    public function __construct()
    {
        parent::__construct(true);
    }

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