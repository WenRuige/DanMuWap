<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/8
 * Time: 下午8:24
 */
namespace App\Http\Controllers\Dynamic;

use App\Http\Controllers\Controller;

//动弹地址
class DynamicController extends Controller
{
    public function index()
    {
        return view('Dynamic.index');
    }


    //发送一条弹幕
    public function sendDynamic()
    {

    }

    public function getDynamic()
    {
        $barrages =
            array(
                array(
                    'info' => '第一条弹幕',
                    'img' => '../123.jpg',
                    'href' => '',

                ),
                array(
                    'info' => '第二条弹幕',
                    'href' => '',
                    'color' => '#ff6600'

                ),);
        echo json_encode($barrages[array_rand($barrages)]);
    }
}