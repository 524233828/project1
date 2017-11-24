<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/24
 * Time: 14:03
 */

namespace Controller;

use FastD\Http\ServerRequest;
use Logic\UserLogic;

class MeController extends BaseController
{
    /**
     * @name 获取个人信息
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function getUser(ServerRequest $request)
    {
        $uid = $_SESSION['uid'];
        return $this->response(UserLogic::getInstance()->getUser($uid));
    }
}