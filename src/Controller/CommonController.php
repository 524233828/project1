<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/21
 * Time: 23:55
 */

namespace Controller;

use FastD\Http\ServerRequest;
use Logic\UploadLogic;
use Service\Uploader;

class CommonController extends BaseController
{

    /**
     * @name 上传文件
     * @apiParam upload|file|文件|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function uploadImage(ServerRequest $request)
    {
        return $this->response(["path"=>UploadLogic::getInstance()->uploadImage()]);
    }
}