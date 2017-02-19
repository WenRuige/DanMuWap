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

    //通过id来获取弹幕
    public function getDanmu($id)
    {
        return DB::table($this->tableName)->where('video_id', '=', $id)->get();
    }

}