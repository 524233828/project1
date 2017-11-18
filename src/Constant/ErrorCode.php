<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/18
 * Time: 13:31
 */

namespace Constant;

use FastD\Http\Response;

/**
 * 错误码，除1处理成功，负数的基本错误外，其余错误码均为4位数字，区别于3位的HTTP状态码
 * Class ErrorCode
 * @package Constant
 */

class ErrorCode
{
    const OK = 1;  //处理成功

    const ERR_SYSTEM = -1; //系统错误
    const ERR_INVALID_PARAMETER = -4; //请求参数错误
    const ERR_CHECK_SIGN = -5; //签名验证错误
    const ERR_NO_PARAMETERS = -6; //参数缺失
    const ERR_UNKNOWN = -7; // 未知错误

    /**
     * 10xx用户系统错误
     */
    const USER_NOT_LOGIN = 1000; // 未登录

    /**
     * 11xx课程系统错误
     */
    const CLASS_NOT_FOUND = 1100; //课程不存在
    const CLASS_NO_CHAPTER = 1101;



    /**
     * 错误代码与消息的对应数组
     *
     * @var array
     */
    static public $msg = [
        self::OK                    => ['处理成功', Response::HTTP_OK],
        self::ERR_SYSTEM            => ['系统错误', Response::HTTP_INTERNAL_SERVER_ERROR],
        self::ERR_INVALID_PARAMETER => ['请求参数错误', Response::HTTP_BAD_REQUEST],
        self::ERR_CHECK_SIGN        => ['签名错误', Response::HTTP_FORBIDDEN],
        self::ERR_NO_PARAMETERS     => ['参数缺失', Response::HTTP_BAD_REQUEST],
        self::USER_NOT_LOGIN        => ['未登录', Response::HTTP_FORBIDDEN],
        self::CLASS_NOT_FOUND       => ['课程不存在', Response::HTTP_NOT_FOUND],
        self::CLASS_NO_CHAPTER      => ['该课程没有章节', Response::HTTP_NOT_FOUND],

    ];

    /**
     * 返回错误代码的描述信息
     *
     * @param int    $code        错误代码
     * @param string $otherErrMsg 其他错误时的错误描述
     * @return string 错误代码的描述信息
     */
    public static function msg($code, $otherErrMsg = '')
    {
        if ($code == self::ERR_UNKNOWN) {
            return $otherErrMsg;
        }

        if (isset(self::$msg[$code][0])) {
            return self::$msg[$code][0];
        }

        return $otherErrMsg;
    }

    /**
     * 返回错误代码的Http状态码
     * @param int $code
     * @param int $default
     * @return int
     */
    public static function status($code, $default = 200)
    {
        if ($code == self::ERR_UNKNOWN) {
            return $default;
        }

        if (isset(self::$msg[$code][1])) {
            return self::$msg[$code][1];
        }

        return $default;
    }

}

