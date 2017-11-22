<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/16
 * Time: 23:47
 */

namespace Service;

use Exception\BaseException;
use Upload\File;

class Uploader
{
    public static function save($file_form_name)
    {
        $uploader = upload();

        $file = new File($file_form_name, $uploader);

        $resource_id = md5_file($file->getFileInfo());

        $file->setName($resource_id);

        try
        {
            if ($file->upload()) {
                return $file;
            }else{
                BaseException::UploadError();
            }
        }catch(\Exception $e)
        {
            if($e->getCode()==0)
            {
                return $file;
            }
        }
    }
}