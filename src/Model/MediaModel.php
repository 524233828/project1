<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/16
 * Time: 22:50
 */

namespace Model;

use Exception\BaseException;

class MediaModel extends BaseModel
{

    const MEDIA_TABLE = "db_media";

    public function getMedia()
    {

    }

    public function addMedia($data)
    {
        $data['create_time'] = time();
        $result = database()->insert(self::MEDIA_TABLE,$data);

        if(!$result){
            BaseException::SystemError();
        }
        return database()->id();
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