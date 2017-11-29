<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/29
 * Time: 14:16
 */

namespace Model;

use Exception\BaseException;

class AttendTestModel extends BaseModel
{
    const ATTEND_TABLE = "db_user_test";

    public static function addAttend($user_id,$test_id,$channel_id = 1)
    {
        $db = database();

        $data = [
            "user_id" => $user_id,
            "test_id" => $test_id,
            "channel_id" => $channel_id,
            "create_time" => time()
        ];
        $result = $db->insert(self::ATTEND_TABLE,$data);

        if($result){
            return true;
        }else{
            BaseException::SystemError();
        }
    }

    public static function listAttend()
    {
        $db = database();

        $result = $db->select(
            self::ATTEND_TABLE."(ut)",
            [
                "[>]db_user(u)"=>["ut.user_id"=>"id"],
                "[>]db_test(t)"=>["ut.test_id"=>"id"],
                "[>]db_channel(c)"=>["ut.channel_id"=>"id"],
            ],
            [
                "ut.id",
                "u.id(user_id)",
                "u.nickname",
                "t.id(test_id)",
                "t.title",
                "c.channel_name",
                "ut.create_time"
            ]);

        return $result;
    }
}