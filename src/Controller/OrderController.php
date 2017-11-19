<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/18
 * Time: 22:36
 */

namespace Controller;

use Exception\OrderException;
use FastD\Http\ServerRequest;
use Logic\OrderLogic;

class OrderController extends BaseController
{

    /**
     * @name 购买课程
     * @apiParam class_id|int|课程ID|true
     * @returnParam jsapiConfig|json|微信js支付参数
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function createOrder(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");

        if(!$result = OrderLogic::getInstance()->buyClass($class_id)){
            OrderException::OrderCreateFail();
        }else{
            return $this->response(["jsapiConfig"=>$result]);
        }
    }

    /**
     * @name 支付回调
     * @return \Service\ApiResponse
     */
    public function notifyOrder()
    {
        $payment = wechat()->payment;
        $response = $payment->handleNotify("\Logic\OrderLogic::orderNotify");
        return $response;
    }
}