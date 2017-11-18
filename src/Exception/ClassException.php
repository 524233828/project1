<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/18
 * Time: 14:36
 */

namespace Exception;

use Constant\ErrorCode;

class ClassException extends BaseException
{
    public static function ClassNotFound()
    {
        throw new self(
            ErrorCode::msg(ErrorCode::CLASS_NOT_FOUND),
            ErrorCode::CLASS_NOT_FOUND
        );
    }

    public static function NoChapterInClass()
    {
        throw new self(
            ErrorCode::msg(ErrorCode::CLASS_NO_CHAPTER),
            ErrorCode::CLASS_NO_CHAPTER
        );
    }
}