<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/16
 * Time: 22:50
 */

namespace Model;

class MediaModel extends BaseModel
{

    const MEDIA_TABLE = "db_media";

    public function getMedia()
    {

    }

    public function addMedia()
    {

    }

    public static function listMedia($where = [])
    {
        $db = database();

        $result = $db->select(self::MEDIA_TABLE,"*",
            $where
        );

        return $result;
    }
}