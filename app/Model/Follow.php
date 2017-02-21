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

class Follow extends Model
{

    private static $_instance;
    protected $tableName = 'follow';

    public static function getInstance()
    {
        if (self::$_instance instanceof self) {
            return self::$_instance;
        } else {
            return new self();
        }
    }

    //通过id来获取弹幕
    public function getDanmu($id)
    {
        return DB::table($this->tableName)->where('video_id', '=', $id)->get();
    }
    //保存弹幕信息
    public function saveDanmu($data)
    {
        return DB::table($this->tableName)->insert($data);
    }

}