<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/16
 * Time: 22:50
 */

namespace Model;

use Exception\BaseException;

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

    public static function addBanner($data)
    {
        $banner = database()->insert(self::BANNER_TABLE,$data);

        if(!$banner){
            BaseException::SystemError();
        }
        return database()->id();
    }
}