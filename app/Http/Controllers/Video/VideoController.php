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
        $filename = md5(date('Y-m-d H:i:s')) . '.mp4';
        $request->file('file')[0]->move('video/upload', $filename);
        $data['name'] = $request->name;
        $data['video'] = $filename;
        $data['content'] = $request->content;
        $data['create_time'] = date("Y-m-d H:i:s");
        $data['user_id'] = $_SESSION['userId'];
        $info = VideoLogic::getInstance()->uploadVideo($data);
        if ($info['code'] == Constant::SUCCESS) {
            return redirect('home');
        }
    }
}