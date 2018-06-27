<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/28 0028
 * Time: 0:25
 */

namespace Model;


class RecommendModel
{
    const USER_RECOMMEND_TABLE = "db_user_recommend";
    const RECOMMEND_TABLE = "db_recommend";

    public static function getUserRecommend($uid, $field = '*')
    {
        return database()->get(
            self::USER_RECOMMEND_TABLE,
            $field,
            ['uid' => $uid]
        );
    }

    public static function getRecommendById($id, $field = '*')
    {
        return database()->get(
            self::RECOMMEND_TABLE,
            $field,
            ['id' => $id]
        );
    }

}