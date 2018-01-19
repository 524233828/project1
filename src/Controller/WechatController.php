<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2018/1/18
 * Time: 9:33
 */

namespace Controller;


use FastD\Http\ServerRequest;

class WechatController
{
    public function wxapp(ServerRequest $request)
    {
        $log = myLog("wxappCustomer");
        $params = $request->getQueryParams();
        $log->addDebug("params:".json_encode($params));
    }
}