<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/21
 * Time: 23:55
 */

namespace Controller;

use FastD\Http\ServerRequest;
use Logic\CommonLogic;
use Logic\UploadLogic;
use Service\Uploader;

class CommonController extends BaseController
{

    /**
     * @name 登录回调
     */
    public function login(ServerRequest $request)
    {
        CommonLogic::getInstance()->login();
    }

    /**
     * @name 支付回调
     * @return \Service\ApiResponse
     */
    public function notifyOrder()
    {
        $payment = wechat()->payment;
        $response = $payment->handleNotify("\Logic\CommonLogic::orderNotify");
        $response->send();
    }
}