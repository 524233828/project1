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

    public static function UploadError()
    {
        throw new self(
            ErrorCode::msg(ErrorCode::UPLOAD_FAIL),
            ErrorCode::UPLOAD_FAIL
        );
    }
}