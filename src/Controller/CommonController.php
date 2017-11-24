<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/21
 * Time: 23:55
 */

namespace Controller;

use FastD\Http\ServerRequest;
use Logic\CommonLogic;
use Logic\UploadLogic;
use Service\Uploader;

class CommonController extends BaseController
{

    /**
     * @name 上传图片
     * @apiParam upload|file|文件|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function uploadImage(ServerRequest $request)
    {
        return $this->response(["path"=>UploadLogic::getInstance()->uploadImage()]);
    }

    /**
     * @name 上传视频
     * @apiParam upload|file|文件|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function uploadVideo(ServerRequest $request)
    {
        return $this->response(["path"=>UploadLogic::getInstance()->uploadVideo()]);
    }

    /**
     * @name 登录回调
     */
    public function login(ServerRequest $request)
    {
        CommonLogic::getInstance()->login();
    }

    /**
     * @name 支付回调
     * @return \Service\ApiResponse
     */
    public function notifyOrder()
    {
        $payment = wechat()->payment;
        $response = $payment->handleNotify("\Logic\CommonLogic::orderNotify");
        return $response;
    }
}