<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/16
 * Time: 22:50
 */

namespace Model;

class BannerModel extends BaseModel
{

    const BANNER_TABLE = "db_banner";

    public static function listBanner($where = [])
    {
        $db = database();

        $result = $db->select(self::BANNER_TABLE,"*",
            $where
        );

        return $result;
    }

    public static function addBanner()
    {

    }
}