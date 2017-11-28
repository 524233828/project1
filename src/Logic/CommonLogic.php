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
        $scope = $user['token']['scope'];
        $openid = $wechat_user['id'];
        if($scope=="snsapi_userinfo")
        {
            $userInfo = $wechat_user['original'];
            $data = [
                "openid" => $userInfo['openid'],
                "subscribe" => 1,
                "nickname" => $userInfo['nickname'],
                "sex" => $userInfo['sex'],
                "language" => $userInfo['language'],
                "city" => $userInfo['city'],
                "country" => $userInfo['country'],
                "province" => $userInfo['province'],
                "headimgurl"=> $userInfo['headimgurl'],
                "subscribe_time" => time(),
                "unionid" => isset($userInfo['unionid'])?$userInfo['unionid']:"",
                "remark" => "",
                "groupid" => "",
                "channel_id" => isset($_SESSION['channel'])?$_SESSION['channel']:1,
            ];
        }else{
            $userService = wechat()->user;
            $userInfo = $userService->get($openid);
            $data = [
                "openid" => $userInfo->openid,
                "subscribe" => $userInfo->subscribe,
                "nickname" => $userInfo->nickname?:"微信用户".time(),
                "sex" => $userInfo->sex?:0,
                "language" => $userInfo->language?:"未知",
                "city" => $userInfo->city?:"未知",
                "country" => $userInfo->coutry?:"未知",
                "province" => $userInfo->province?:"未知",
                "headimgurl"=> $userInfo->headimgurl?:"http://www.ym8800.com/static/img/preson.f518f1a.png",
                "subscribe_time" => $userInfo->subscribe_time?:time(),
                "unionid" => $userInfo->unionid?:"",
                "remark" => $userInfo->remark?:"",
                "groupid" => $userInfo->groupid?:"",
                "channel_id" => isset($_SESSION['channel'])?$_SESSION['channel']:1,
            ];
        }
        $log->addDebug("用户信息：".json_encode($data));
        $_SESSION['userInfo'] = $data;
        $my_user = UserModel::getUserByOpenId($data['openid']);

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