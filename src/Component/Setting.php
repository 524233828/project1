<?php
/**
 * @author xiaoyongbiao
 * @email 781028081@qq.com
 * Date: 2017/8/30
 */

namespace Component;
use Constant\CacheKey;
//use Helper\ArrayHelper;
use Model\ConfigModel;

/**
 * 配置类
 * Class Setting
 * @package Component
 */
class Setting
{

    private static $setting = [];

    public static function get($key, $default = null)
    {
        if (!empty(self::$setting[$key])) {
            return self::$setting[$key];
        } else {
            $value = ConfigModel::getConfigByKey($key);
            $value && self::$setting[$key] = $value;
            return $value ? : $default;
        }

//        $redis = redis();
//        if (empty($redis->hkeys(CacheKey::ADMIN_CONFIG_LIST_DATA))) {
//            $setting = ArrayHelper::map(SettingModel::all(), 'name', 'data');
//            foreach ($setting as $k => $value) {
//                $redis->hsetnx(CacheKey::ADMIN_CONFIG_LIST_DATA, $k, $value);
//            }
//
//            return isset($setting[$key]) ? $setting[$key] : $default;
//        }
//
//        if ($redis->hexists(CacheKey::ADMIN_CONFIG_LIST_DATA, $key)) {
//            if (!isset(self::$setting[$key])) {
//                $result = $redis->hget(CacheKey::ADMIN_CONFIG_LIST_DATA, $key);
//                self::$setting[$key] = $result;
//                return $result;
//            }
//            return self::$setting[$key] ;
//        }else if($data = SettingModel::getConfig($key)){
//            $redis->hSetNx(CacheKey::ADMIN_CONFIG_LIST_DATA, $key, $data);
//            return $data;
//        }

        return $default;
    }
}