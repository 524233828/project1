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

    public static function UploadError(\Exception $e)
    {
        switch($e->getMessage()){
            case "File validation failed":
                throw new self(
                    ErrorCode::msg(ErrorCode::UNABLE_MIME_TYPE),
                    ErrorCode::UNABLE_MIME_TYPE
                );
                break;
            default:
                throw new self(
                    ErrorCode::msg(ErrorCode::UPLOAD_FAIL),
                    ErrorCode::UPLOAD_FAIL
                );
        }

    }

    public static function VideoNotFound()
    {
        throw new self(
            ErrorCode::msg(ErrorCode::VIDEO_NOT_FOUND),
            ErrorCode::VIDEO_NOT_FOUND
        );
    }
}