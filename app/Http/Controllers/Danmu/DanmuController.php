<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Danmu;

use App\Http\Controllers\Controller;
use App\Logic\Danmu\DanmuLogic;
use core\DanMu\DanMuService;
use Illuminate\Http\Request;
use core\Constant;
use core\Container;

class DanmuController extends Controller
{


    //通过视频Id来获取弹幕信息
    public function getDanMu($id)
    {
        if (empty($id)) {
            echo 'error';
            die;
        }
        DanMuService::getInstance()->getDanMu($id);
        $info = DanmuLogic::getInstance()->getDanmu($id);
        if ($info['code'] == Constant::SUCCESS) {
            echo $info['data'];
        }

    }

    public function shootDanMu(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'danmu' => 'required'
        ]);
        //valide验证id&danmu不可为空
        $data['video_id'] = $request->id;
        $data['content'] = $request->danmu;
        $data['create_time'] = date('Y-m-d H:i:s');
        $danmuInfo = DanMuService::getInstance()->shootDanMu($data);
        if ($danmuInfo['code'] != Constant::SUCCESS) {
            Container::log('error', json_encode($data));
        }
    }
}