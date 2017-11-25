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
                "[>]db_user(u)" => ["o.user_id" => "id"],
                "[>]db_user_class(uc)" => ["o.order_id" => "order_id"],
                "[>]db_class(c)" => ["uc.class_id" => "id"],
                "[>]db_channel(cc)" =>["o.channel_id"=>"id"]
            ],
            [
                "o.order_id",
                "u.id(user_id)",
                "u.nickname",
                "c.id(class_id)",
                "c.title",
                "cc.channel_name",
                "o.pay_time"
            ],
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