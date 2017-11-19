<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/18
 * Time: 23:09
 */

namespace Logic;

use EasyWeChat\Payment\Order;
use Exception\ClassException;
use Exception\OrderException;
use Model\BuyModel;
use Model\ClassModel;
use Model\OrderModel;

class OrderLogic extends BaseLogic
{

    public function buyClass($class_id)
    {
        $class = ClassModel::getClass($class_id);

        if(!$class)
        {
            ClassException::ClassNotFound();
        }

        //微信统一下单
        $attributes = [
            'trade_type'       => 'JSAPI',
            'body'             => '夜猫足球-'.$class['title'],
            'detail'           => '夜猫足球-'.$class['title'],
            'out_trade_no'     => OrderModel::getOrderId(),
            'total_fee'        => floor($class['price']*100), // 单位：分
            'openid'           => $_SESSION['wechat_user']['openid'], // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
        ];

        //生成支付参数
        $config = $this->createOrder($attributes);

        //数据库记录订单
        //开启事务
        database()->query("start transaction");

        $order_date = [
            "order_id" => $attributes['out_trade_no'],
            "total_fee" => $class['price'],
            "create_time" => time(),
            "point" => 1
        ];

        $user_class_data = [
            "class_id"=>$class_id,
            "user_id"=>$_SESSION['uid'],
            "order_id"=>$attributes['out_trade_no'],
            "create_time"=>time(),
            "status"=>0,
        ];
        $order_id = OrderModel::addOrder($order_date);
        $buy_id = BuyModel::addUserClass($user_class_data);
        if($order_id&&$buy_id)
        {
            database()->query("commit");
            return $config;
        }else{
            database()->query("rollback");
            return false;
        }
    }

    /**
     * 支付回调
     * @param $notify
     * @param $successful
     * @return bool
     */
    public static function orderNotify($notify,$successful)
    {
        return true;
    }

    /**
     * 微信统一下单
     * @param $data
     * @return array|string
     */
    private function createOrder($data)
    {
        $order = new Order($data);

        $payment = wechat()->payment;

        $result = $payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;

            $config = $payment->configForJSSDKPayment($prepayId);

            return $config;
        }else{
            OrderException::OrderCreateFail();
        }
    }
}