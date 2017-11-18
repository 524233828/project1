<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/4
 * Time: 20:41
 */

/**
 * @return Service\RedisService;
 */
function redis()
{
    return app()->get("redis");
}

/**
 * @return \EasyWeChat\Foundation\Application;
 */
function wechat()
{
    return app()->get("wechat");
}

/**
 * @return \Upload\Storage\FileSystem;
 */
function upload()
{
    return app()->get("uploader");
}
