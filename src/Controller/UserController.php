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

class UserController
{
    /**
     * @name 登录回调
     */
    public function login(ServerRequest $request)
    {
        UserLogic::getInstance()->login();
    }
}