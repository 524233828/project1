<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/29
 * Time: 14:48
 */

namespace Controller;


use FastD\Http\ServerRequest;
use Logic\AdminUserTestLogic;

class AdminUserTestController extends BaseController
{

    /**
     * @name 后台获取参加测试的用户列表
     * @apiParam page|int|页数|false
     * @returnParam [].id|int|记录ID
     * @returnParam [].user_id|int|用户ID
     * @returnParam [].nickname|string|用户名
     * @returnParam [].test_id|int|测试ID
     * @returnParam [].title|string|测试名
     * @returnParam [].channel_name|string|渠道号
     * @returnParam [].create_time|int|测试时间戳
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function listUserTest(ServerRequest $request)
    {
        $page = $request->getParam("page",1);
        return $this->response(AdminUserTestLogic::getInstance()->listUserTest($page));
    }
}