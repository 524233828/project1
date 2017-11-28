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
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class CommonLogic extends BaseLogic
{
    public function login()
    {
        $log = new Logger('login');
        $log_path = app()->getPath()."/runtime";
        $log->pushHandler(new StreamHandler($log_path.'/login.log',Logger::DEBUG));
        $log->addDebug("开始授权获取用户信息");
        $oauth = wechat()->oauth;

        // 获取 OAuth 授权结果用户信息
        $user = $oauth->user();
        $log->addDebug("用户对象：".serialize($user));
        $wechat_user = $user->toArray();
        $log->addDebug("授权对象：".json_encode($wechat_user));
        $scope = $wechat_user['original']['scope'];
        $openid = $wechat_user['id'];
        if($scope=="snsapi_userinfo")
        {
            $userInfo = $wechat_user;
        }else{
            $userService = wechat()->user;
            $userInfo = $userService->get($openid);
        }
        $log->addDebug("用户信息：".json_encode($userInfo));
        $_SESSION['wechat_user'] = $wechat_user;
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
        $log = new Logger('orderNotify');
        $log_path = app()->getPath()."/runtime";
        $log->pushHandler(new StreamHandler($log_path.'/orderNotify.log',Logger::DEBUG));
        $log->addDebug("开始支付回调");
        $log->addDebug("支付回调对象：".serialize($notify));
        $log->addDebug("回调结果：".$successful);
        return true;
    }

    /**
     * 微信统一下单
     * @param $data
     * @return array|string
     */
    public function createOrder($data)
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