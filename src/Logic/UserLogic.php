<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/18
 * Time: 22:24
 */

namespace Logic;

use Model\BuyModel;
use Model\UserModel;

class UserLogic extends BaseLogic
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

    public function listUserClass($user_id)
    {
        return BuyModel::listUserClass($user_id);
    }
}