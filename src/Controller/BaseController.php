<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/16
 * Time: 22:09
 */

namespace Controller;

use Service\ApiResponse;
use Constant\ErrorCode;

/**
 * 控制层，后续在此扩展对入参、出参的过滤与控制
 * Class BaseController
 * @package Controller
 */
class BaseController
{
    /**
     * @param $data
     * @param string $msg
     * @param int $code
     * @param int $status
     * @return ApiResponse
     */
    public function response($data, $msg = '', $code = ErrorCode::OK, $status = 200)
    {
        $msg = ErrorCode::msg($code) ? ErrorCode::msg($code) : $msg;
        $status = ErrorCode::status($code) ? ErrorCode::status($code) : $status;
        return new ApiResponse($msg, $code, $data, $status);
    }
}