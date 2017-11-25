<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/25
 * Time: 15:14
 */

namespace Controller;


use FastD\Http\ServerRequest;
use Logic\AdminOrderLogic;
use Model\OrderModel;

class AdminOrderController extends BaseController
{
    /**
     * @name 获取订单列表
     * @apiParam key|string|搜索的键|false
     * @apiParam value|string|值|false
     * @returnParam
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function listOrder(ServerRequest $request)
    {
        $key = $request->getParam("key",'');
        $value = $request->getParam("nickname",'');
        return $this->response(AdminOrderLogic::getInstance()->listOrder($key,$value));
    }
}