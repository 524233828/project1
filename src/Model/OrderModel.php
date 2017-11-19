<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/16
 * Time: 22:51
 */

namespace Model;

use Exception\BaseException;

class OrderModel extends BaseModel
{
    const ORDER_TABLE = "db_order";


    public static function addOrder($data)
    {
        $user = database()->insert(self::ORDER_TABLE,$data);

        if(!$user){
            BaseException::SystemError();
        }
        return database()->id();
    }

    public static function updateOrder()
    {

    }

    public static function listOrder()
    {

    }

    public static function getOrderId()
    {
        return microtime(true)*10000;
    }

}