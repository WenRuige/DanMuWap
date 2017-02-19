<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/1/9
 * Time: 上午9:07
 */
namespace App\Model;

use DB;
use Illuminate\Database\Eloquent\Model;

class DanMu extends Model
{

    private static $_instance;
    protected $tableName = 'danmu';

    public static function getInstance()
    {
        if (self::$_instance instanceof self) {
            return self::$_instance;
        } else {
            return new self();
        }
    }

    //上传视频，插入一条数据
    public function uploadVideo($data)
    {
        return DB::table($this->tableName)->insert($data);
    }

    //获取视频
    public function getVideo()
    {
        return DB::table($this->tableName)->get();
    }

    //获取视频相关信息
    public function getVideoById($id)
    {
        return DB::table($this->tableName)->where('id', $id)->first();
    }
}