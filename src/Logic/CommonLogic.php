<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/24
 * Time: 14:59
 */

namespace Logic;

use EasyWeChat\Payment\Order;
use Exception\OrderException;
use Model\UserModel;

class CommonLogic extends BaseLogic
{
    public function login()
    {
        $oauth = wechat()->oauth;

        // 获取 OAuth 授权结果用户信息
        $user = $oauth->user();
        $wechat_user = $user->toArray();
        $_SESSION['wechat_user'] = $wechat_user;
        $openid = $wechat_user['openid'];
        $my_user = UserModel::getUserByOpenId($openid);

        if(!$my_user)
        {
            $my_user['id'] = UserModel::addUser($wechat_user);
        }

        $_SESSION["uid"] = $my_user['id'];


        $targetUrl = empty($_SESSION['redirect_url']) ? '/' : $_SESSION['redirect_url'];
        header('location:'. $targetUrl); // 跳转到原来的页面
        exit;
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