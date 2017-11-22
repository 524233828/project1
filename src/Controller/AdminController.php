<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/22
 * Time: 18:20
 */

namespace Controller;

use FastD\Http\ServerRequest;
use Logic\AdminLogic;

class AdminController extends BaseController
{
    /**
     * @name 管理系统登录
     * @apiParam name|string|账号|true
     * @apiParam pass|string|密码|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function login(ServerRequest $request)
    {
        $name = $request->getParam("name");
        $pass = $request->getParam("pass");

        return $this->response(AdminLogic::getInstance()->login($name,$pass));
    }
}