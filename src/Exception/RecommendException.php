<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/22
 * Time: 18:17
 */

namespace Exception;

use Constant\ErrorCode;

class RecommendException extends BaseException
{
    public static function RecommendNotExists()
    {
        throw new self(ErrorCode::msg(ErrorCode::RECOMMEND_NOT_EXISTS),ErrorCode::RECOMMEND_NOT_EXISTS);
    }

    public static function LoginFail()
    {
        throw new self(ErrorCode::msg(ErrorCode::LOGIN_FAIL),ErrorCode::LOGIN_FAIL);
    }
}