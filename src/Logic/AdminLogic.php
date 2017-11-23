<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/22
 * Time: 15:54
 */

namespace Logic;

use Exception\UserException;
use Model\AdminModel;

class AdminLogic extends BaseLogic
{
    public function login($name,$pass)
    {
        $pass = md5($pass);
        $admin = AdminModel::getAdmin(["name"=>$name,"password"=>$pass]);

        if(!$admin)
        {
            UserException::UserNotFound();
        }

        $_SESSION['admin_id'] = $admin[0]['id'];

        AdminModel::updateAdmin(["id"=>$admin[0]['id']],["last_login_time"=>time()]);

        return true;
    }
}