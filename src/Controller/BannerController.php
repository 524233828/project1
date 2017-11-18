<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/18
 * Time: 16:44
 */

namespace Controller;

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
}