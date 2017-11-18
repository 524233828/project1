<?php
/**
 * @author xiaoyongbiao
 * @email 781028081@qq.com
 * Date: 2017/8/29
 */

namespace Model;

use FastD\Model\Model;

class UserModel extends Model
{
    const TABLE_NAME = "db_user";

    public static function getUser($uid)
    {
        $user = database()->get(self::TABLE_NAME,"*",[
            "id" => $uid
        ]);

        return $user;
    }

    public static function addUser($data)
    {
        
    }
}