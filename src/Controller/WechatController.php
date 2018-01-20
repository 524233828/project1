<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2018/1/18
 * Time: 9:33
 */

namespace Controller;


use Component\Wxapp\Wxapp;
use EasyWeChat\Foundation\Application;
use FastD\Http\ServerRequest;

class WechatController
{
    public function wxapp(ServerRequest $request)
    {
        $log = myLog("wxappCustomer");
        $params = $request->getQueryParams();
        $open_id = $params['openid'];
        $body = $request->getBody()->getContents();
        $log->addDebug("params:".json_encode($params));
        $log->addDebug("body:".$body);
        $app_id = config()->get("wxapp_app_id");
        $app_secret = config()->get("wxapp_app_secret");
        $wxapp = new Wxapp($app_id,$app_secret);

        $data = [
            "touser" => $open_id,
            "msgtype" => "link",
            "link" => [
                "title" => "哈哈哈哈哈",
                "description" => "hhhhhhh",
                "url" => "https://zucaib.com",
                "thumb_url" => "http://120.78.193.207/upload/7e93d1947a1f8509f27ebd59f8c81b6c.jpg"
            ]
        ];

        $result = $wxapp->sendCustomerMsg($data);

        $log->addDebug("Result:".$result);


    }
}