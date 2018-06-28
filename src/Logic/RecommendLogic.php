<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/27 0027
 * Time: 23:25
 */

namespace Logic;

use Exception\RecommendException;
use Exception\UserException;
use Model\OrderModel;
use Model\RecommendModel;
class RecommendLogic extends BaseLogic
{
    public function index($uid, $recommend_id)
    {
        $uid || UserException::UserNotFound();

        $buy = RecommendModel::getUserRecommend($uid, ['id']);
        $recommend = RecommendModel::getRecommendById($recommend_id);
        $recommend || RecommendException::RecommendNotExists();

        if (empty($buy)) {
            unset($recommend['imgs'], $recommend['info']);
            $recommend['is_paid'] = 1;
        } else {
            $recommend['is_paid'] = 0;
        }
        $recommend['logo'] = '';
        $recommend['wx_qrcode'] = ' ';

        return $recommend;
    }

    public function pay($recommend_id, $channel = 1 ,$paysource = 0)
    {
        $recommend = RecommendModel::getRecommendById($recommend_id);
        $recommend || RecommendException::RecommendNotExists();

        //微信统一下单
        $attributes = [
            'trade_type'       => 'JSAPI',
            'body'             => $recommend['title'],
            'detail'           => $recommend['title'],
            'out_trade_no'     => OrderModel::getOrderId(),
            'total_fee'        => floor($recommend['price'] * 100), // 单位：分
            'openid'           => $_SESSION['userInfo']['openid'], // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
        ];
        $config = [];
        if($recommend['price'] > 0){
            //生成支付参数
            $config = CommonLogic::getInstance()->createOrder($attributes, $paysource);
        }

        //数据库记录订单
        //开启事务
        database()->pdo->beginTransaction();

        $order_date = [
            "order_id" => $attributes['out_trade_no'],
            "total_fee" => $recommend['price'],
            "create_time" => time(),
            "point" => 1,
            "user_id" => $_SESSION['uid'],
            "channel_id" => $channel,
            "paysource" => $paysource,
            "product_type" => 2,
            "product_id" => $recommend['id']
        ];

        $order_id = OrderModel::addOrder($order_date);
        if($order_id)
        {
            database()->pdo->commit();
            if (isset($config)) {
                return $config;
            } else {
                OrderModel::updateOrder(["status" => 1], ["order_id"=>$order_id]);
                return ["timestamp" => time()];
            }

        } else {
            database()->pdo->rollBack();
            return false;
        }
    }
}