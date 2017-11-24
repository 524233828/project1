<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/24
 * Time: 11:34
 */

namespace Controller;

use FastD\Http\Response;
use FastD\Http\ServerRequest;
use Logic\IndexLogic;

class IndexController extends BaseController
{
    /**
     * @name 首页获取课程列表
     * @apiParam page|int|分页页数，默认为1|false
     * @returnParam [].id|int|课程ID
     * @returnParam [].sold|int|卖出数量
     * @returnParam [].price|float|售价
     * @returnParam [].img_url|string|图片地址
     * @returnParam [].title|string|课程标题
     * @returnParam [].tag|string|课程标签
     * @returnParam [].desc|string|课程描述
     * @returnParam current_page|int|当前页数
     * @returnParam total_page|string|总页数
     * @param ServerRequest $request
     * @return Response;
     */
    public function listClass(ServerRequest $request)
    {
        $page = $request->getParam("page",1);
        return $this->response(IndexLogic::getInstance()->listClass($page),true);
    }

    /**
     * @name 首页获取banner
     * @returnParam [].id|int|bannerID
     * @returnParam [].img_url|string|图片url
     * @returnParam [].url|string|跳转链接
     * @return \Service\ApiResponse
     */
    public function listBanner()
    {
        return $this->response(IndexLogic::getInstance()->listBanner());
    }
}