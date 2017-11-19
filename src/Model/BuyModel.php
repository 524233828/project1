<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/19
 * Time: 10:34
 */

namespace Model;

use Exception\BaseException;

class BuyModel extends BaseModel
{
    const BUY_CLASS_TABLE = "db_order";

    public static function addUserClass($data)
    {
        $buy = database()->insert(self::BUY_CLASS_TABLE,$data);

        if(!$buy){
            BaseException::SystemError();
        }
        return database()->id();
    }
}