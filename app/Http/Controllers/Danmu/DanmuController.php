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
use Illuminate\Http\Request;
use App\Constant;

class DanmuController extends Controller
{

    //个人中心界面需要登录
    public function __construct()
    {
        parent::__construct(false);
    }
    //通过视频Id来获取弹幕信息
    public function getDanMu($id)
    {
        if (empty($id)) {
            echo 'error';die;
        }
        $info = DanmuLogic::getInstance()->getDanmu($id);
        if($info['code'] == Constant::SUCCESS){
            echo $info['data'];
        }

    }
}