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

    public static function listOrder($where = [])
    {
        $db = database();

        $result = $db->select(
            self::ORDER_TABLE."(o)",
            [
                "[>]db_user(u)" => ["o.user_id" => "u.id"],
                "[>]db_class(c)" => ["o.order_id" => "c.id"]
            ],
            "*",
            $where
        );

        return $result;
    }

    public static function getOrderId()
    {
        return microtime(true)*10000;
    }

    public static function countOrder($where = [])
    {
        return database()->count(self::ORDER_TABLE."(o)",[],$where);
    }

}