<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/18
 * Time: 16:44
 */

namespace Controller;

use Exception\BaseException;
use FastD\Http\ServerRequest;
use Logic\BannerLogic;

class BannerController extends BaseController
{

    /**
     * @name 获取banner
     * @returnParam [].id|int|bannerID
     * @returnParam [].img_url|string|图片url
     * @returnParam [].url|string|跳转链接
     * @return \Service\ApiResponse
     */
    public function listBanner()
    {
        return $this->response(BannerLogic::getInstance()->listBanner());
    }


    /**
     * @name 新增banner
     * @apiParam img_url|string|图片地址|true
     * @apiParam url|string|跳转地址|true
     * @apiParam status|int|状态0-冻结 1-可用，默认为1|false
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function addBanner(ServerRequest $request)
    {
        $img_url = $request->getParam("img_url");
        $url = $request->getParam("url");
        $status = $request->getParam("status",1);
        $banner = BannerLogic::getInstance()->addBanner($img_url,$url,$status);
        if($banner)
        {
            return $this->response([]);
        }else{
            BaseException::SystemError();
        }

    }
}