<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/14
 * Time: 23:32
 */

namespace Controller;

use FastD\Http\ServerRequest;
use Logic\UserLogic;

class UserController extends BaseController
{
    /**
     * @name 登录回调
     */
    public function login(ServerRequest $request)
    {
        UserLogic::getInstance()->login();
    }

    /**
     * @name 获取用户购买的课程列表
     * @returnParam [].id|int|课程ID
     * @returnParam [].img_url|string|课程图片
     * @returnParam [].title|string|课程标题
     * @returnParam [].desc|string|课程描述
     * @returnParam [].tag|string|课程标签
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function listUserClass(ServerRequest $request)
    {
        $user_id = 1;

        return $this->response(UserLogic::getInstance()->listUserClass($user_id));
    }
}