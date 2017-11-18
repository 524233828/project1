<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/16
 * Time: 23:47
 */

namespace Service;

use Upload\File;

class Uploader
{
    public static function save($file_form_name)
    {
        $uploader = upload();

        $file = new File($file_form_name, $uploader);

        $new_file_name = md5($file->getFileInfo());

        $file->setName($new_file_name);

        try{
            $file->upload();
        }catch (\Exception $e){
            $file->getErrors();
        }
    }
}