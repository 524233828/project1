<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/24
 * Time: 17:33
 */

namespace Controller;


use FastD\Http\ServerRequest;
use Logic\AdminClassIntroduceLogic;
use Service\ApiResponse;

class AdminClassIntroduceController extends BaseController
{
    /**
     * @name 后台获取课程简介列表
     * @apiParam class_id|int|课程ID|true
     * @returnParam [].id|int|课程ID
     * @returnParam [].sold|int|卖出数量
     * @returnParam [].price|float|售价
     * @returnParam [].img_url|string|图片地址
     * @returnParam [].title|string|课程标题
     * @returnParam [].tag|string|课程标签
     * @returnParam [].desc|string|课程描述
     * @param ServerRequest $request
     * @return ApiResponse;
     */
    public function listIntroduce(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");
        return $this->response(AdminClassIntroduceLogic::getInstance()->listIntroduce($class_id));
    }

    /**
     * @name 新增课程简介
     * @apiParam class_id|int|课程ID|true
     * @apiParam list[].img_url|string|简介图片|true
     * @apiParam list[].url|string|简介跳转地址|true
     * @apiParam list[].title|string|简介标题|true
     * @apiParam list[].content|string|简介内容|true
     * @apiParam list[].sort|float|简介排序|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function addIntroduce(ServerRequest $request)
    {

        $list = $request->getParam("list");
        $class_id = $request->getParam("class_id");

        $class = AdminClassIntroduceLogic::getInstance()->addIntroduce($class_id,$list);
        if($class)
        {
            return $this->response([]);
        }

    }

    /**
     * @name 更新课程简介
     * @apiParam list[].id|int|简介ID|true
     * @apiParam list[].class_id|int|课程ID|true
     * @apiParam list[].img_url|string|简介图片|true
     * @apiParam list[].url|string|简介跳转地址|true
     * @apiParam list[].title|string|简介标题|true
     * @apiParam list[].content|string|简介内容|true
     * @apiParam list[].sort|float|简介排序|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse;
     */
    public function updateIntroduce(ServerRequest $request)
    {
        $list = $request->getParam("list");

        return $this->response(AdminClassIntroduceLogic::getInstance()->updateIntroduce($list));
    }

    /**
     * @name 删除简介
     * @apiParam id|int|简介ID|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function deleteIntroduce(ServerRequest $request)
    {
        $id = $request->getParam("id");
        return $this->response([AdminClassIntroduceLogic::getInstance()->deleteIntroduce($id)]);
    }
}