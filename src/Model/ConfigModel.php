<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/29 0029
 * Time: 16:42
 */

namespace Model;


class ConfigModel extends BaseModel
{
    const CONFIG_TABLE = 'db_config';

    public static function getConfigByKey($key)
    {
        $info = database()->get(
            self::CONFIG_TABLE,
            ['value'],
            ['key' => $key]
        );

        return isset($info['value']) ? $info['value'] : null;
    }
}