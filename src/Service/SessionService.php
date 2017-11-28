<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/28
 * Time: 23:26
 */

class SessionService
{
    public function __construct()
    {
        ini_set('session.gc_maxlifetime',   config()->get("session_expire"));
        ini_set('session.cookie_lifetime',  config()->get("session_expire"));
        session_start();
    }
}