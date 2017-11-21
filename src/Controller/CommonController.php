<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/21
 * Time: 23:55
 */

namespace Controller;

use FastD\Http\ServerRequest;
use Service\Uploader;

class CommonController extends BaseController
{

    /**
     * @name 上传文件
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function upload(ServerRequest $request)
    {
        $result = Uploader::save("file");

        if($result){
            return $this->response([]);
        }
    }
}