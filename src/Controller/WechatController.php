<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2018/1/18
 * Time: 9:33
 */

namespace Controller;


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
        //小程序支付
        $staff = (new Application([
            'app_id'  => 'wx85ba94e795ed698e',
            'secret'  => '57a6d4c30b655ff90708478fec40f929'
        ]))->staff;
        $result = $staff->send([
            "touser"=> $open_id,
            "msgtype"=> "link",
            "link"=> [
                "title"=> "Happy Day",
                "description"=> "Is Really A Happy Day",
                "url"=> "https://zucaib.com",
                "thumb_url"=> "http://120.78.193.207/upload/7e93d1947a1f8509f27ebd59f8c81b6c.jpg"
            ]
        ]);

    }
}