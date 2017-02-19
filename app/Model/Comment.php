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

class Comment extends Model
{

    private static $_instance;
    protected $tableName = 'comment';

    public static function getInstance()
    {
        if (self::$_instance instanceof self) {
            return self::$_instance;
        } else {
            return new self();
        }
    }

    //拉取评论列表
    public function getCommentByVideoId($id)
    {
        return DB::table($this->tableName)->where('video_id', '=', $id)->get();
    }

    //插入一条评论信息
    public function insertComment($data)
    {
        return DB::table($this->tableName)->insert($data);
    }


}