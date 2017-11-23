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

    const IMAGE_TABLE = "db_image";

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

    public static function addImage($data)
    {
        $data['create_time'] = time();
        $result = database()->insert(self::IMAGE_TABLE,$data);

        if(!$result){
            BaseException::SystemError();
        }
        return database()->id();
    }

    public static function getImageByResourceId($resource_id)
    {
        $result = database()->get(self::IMAGE_TABLE,"*",[
            "resource_id" => $resource_id
        ]);

        return $result;
    }
}