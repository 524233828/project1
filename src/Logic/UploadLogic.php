<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/22
 * Time: 19:28
 */

namespace Logic;

use Service\Uploader;

class UploadLogic extends BaseLogic
{
    public function uploadImage($name = "file")
    {
        $file = Uploader::save($name);

        $path = app()->get("config")->get("upload_dir").$file->getName().$file->getExtension();

        return $path;
    }
}