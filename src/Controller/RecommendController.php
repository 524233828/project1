<?php
/**
 * Created by PhpStorm.
 * User: liwenye
 * Date: 2018/6/27 0027
 * Time: 23:20
 */

namespace Controller;
use FastD\Http\ServerRequest;
use Logic\RecommendLogic;


class RecommendController extends BaseController
{
    /**
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function index(ServerRequest $request)
    {
        $uid = 1;//$_SESSION['uid'];
        $recommend_id = $request->getParam("id");
        return $this->response(RecommendLogic::getInstance()->index($uid, $recommend_id),true);
    }

    public function pay(ServerRequest $request)
    {
        $recommend_id = $request->getParam("id");
        $channel = $request->getParam("channel");
        $paysource = $request->getParam("paysource");
        return $this->response(RecommendLogic::getInstance()->pay($recommend_id, $channel, $paysource),true);
    }
}