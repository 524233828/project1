<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/29
 * Time: 14:28
 */

namespace Logic;


use Model\AttendTestModel;

class AdminUserTestLogic extends BaseLogic
{
    public function listUserTest()
    {
        return AttendTestModel::listAttend();
    }
}