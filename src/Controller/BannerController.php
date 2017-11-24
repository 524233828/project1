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

    /**
     * @name 更新banner
     * @apiParam banner_id|int|banner的ID|true
     * @apiParam img_url|string|图片地址|true
     * @apiParam url|string|跳转地址|true
     * @apiParam status|int|状态0-冻结 1-可用，默认为1|false
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function updateBanner(ServerRequest $request)
    {
        $banner_id = $request->getParam("banner_id");
        $img_url = $request->getParam("img_url");
        $url = $request->getParam("url");
        $status = $request->getParam("status",1);
        $result = BannerLogic::getInstance()->updateBanner($banner_id,$img_url,$url,$status);
        if($result)
        {
            return $this->response([]);
        }else{
            BaseException::SystemError();
        }
    }

    /**
     * @name 冻结banner
     * @apiParam banner_id|int|banner的ID|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function deleteBanner(ServerRequest $request)
    {
        $banner_id = $request->getParam("banner_id");
        return $this->response([BannerLogic::getInstance()->deleteBanner($banner_id)]);
    }
}