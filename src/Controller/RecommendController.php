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
     * @name -获取用户购买的课程列表-
     * @returnParam id|int|推荐ID
     * @returnParam title|string|标题
     * @returnParam theme|string|主题
     * @returnParam desc|string|描述
     * @returnParam price|string|价格
     * @returnParam is_login|int|是否已登陆
     * @returnParam is_paid|int|是否已支付
     * @returnParam logo|string|是否已支付
     * @returnParam wx_qrcode|string|微信二维码
     * @returnParam imgs|array|图片列表
     * @returnParam info|string|详情
     * @return \Service\ApiResponse
     */
    public function index(ServerRequest $request)
    {
        $uid = null;
        if (isset($_SESSION['uid'])) {
            $uid = $_SESSION['uid'];
        }
        $recommend_id = $request->getParam("id");
        return $this->response(RecommendLogic::getInstance()->index($uid, $recommend_id),true);
    }

    public function payment(ServerRequest $request)
    {
        $recommend_id = $request->getParam("id");
        $channel = $request->getParam("channel");
        $paysource = $request->getParam("paysource");
        return $this->response(RecommendLogic::getInstance()->payment($recommend_id, $channel, $paysource),true);
    }
}