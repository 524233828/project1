<?php

namespace Exception;

use Constant\ErrorCode;

class BaseException extends \Exception
{
    public static function SystemError()
    {
        throw new self(
            ErrorCode::msg(ErrorCode::ERR_SYSTEM),
            ErrorCode::ERR_SYSTEM
        );
    }
}