<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/19
 * Time: 10:34
 */

namespace Model;

use Exception\BaseException;

class BuyModel extends BaseModel
{
    const BUY_CLASS_TABLE = "db_user_class";

    const CLASS_TABLE = "db_class";

    public static function addUserClass($data)
    {
        $data['create_time'] = time();
        $buy = database()->insert(self::BUY_CLASS_TABLE,$data);

        if(!$buy){
            BaseException::SystemError();
        }
        return database()->id();
    }

    public static function listUserClass($user_id)
    {
        $class = database()->select(
            self::BUY_CLASS_TABLE."(b)",
            ["[>]db_class(c)"=>["b.class_id"=>"id"]],
            ["c.img_url","c.title","c.desc","c.tag","c.id","b.learn_percent"],
            ["b.user_id"=>$user_id,"b.status"=>1]
            );

        return $class;
    }

    public static function updateLearnPercent($user_id,$class_id,$percent)
    {
        $where = [
            "user_id" => $user_id,
            "class_id" => $class_id,

        ];

        $data = [
            "learn_percent" => $percent,
            "update_time" => time()
        ];

        return database()->update(self::BUY_CLASS_TABLE,$data,$where);
    }


    public static function getUserClass($user_id,$class_id)
    {
        $where = [
            "user_id" => $user_id,
            "class_id" => $class_id,
        ];

        return database()->get(self::BUY_CLASS_TABLE,"*s",$where);
    }
}