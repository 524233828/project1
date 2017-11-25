<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/24
 * Time: 23:28
 */

namespace Controller;


use FastD\Http\ServerRequest;
use Logic\AdminClassTryLogic;
use Service\ApiResponse;

class AdminClassTryController extends BaseController
{
    /**
     * @name 后台获取课程试听列表
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
        return $this->response(AdminClassTryLogic::getInstance()->listTry($class_id));
    }

    /**
     * @name 新增课程试听
     * @apiParam class_id|int|课程ID|true
     * @apiParam img_url|string|试听图片|true
     * @apiParam resource_type|string|试听类型 0-视频 1-文章|true
     * @apiParam title|string|试听标题|true
     * @apiParam desc|string|试听内容|true
     * @apiParam sort|float|试听排序|true
     * @apiParam resource_data[].resource_id|int|视频资源ID|false
     * @apiParam resource_data[].title|int|文章标题|false
     * @apiParam resource_data[].img_url|int|文章图片|false
     * @apiParam resource_data[].content|int|文章内容|false
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function addIntroduce(ServerRequest $request)
    {

        $class_id = $request->getParam("class_id");
        $resource_type = $request->getParam("resource_type");
        $title = $request->getParam("title");
        $desc = $request->getParam("desc");
        $img_url = $request->getParam("img_url");
        $sort = $request->getParam("sort");

        $resource_data = $request->getParam("resource_data");

        $result = AdminClassTryLogic::getInstance()->addTry($class_id,$resource_type,$title,$desc,$img_url,$resource_data,$sort);
        if($result)
        {
            return $this->response([]);
        }

    }

    /**
     * @name 删除试听
     * @apiParam id|int|试听ID|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function deleteIntroduce(ServerRequest $request)
    {
        $id = $request->getParam("id");
        return $this->response([AdminClassTryLogic::getInstance()->deleteTry($id)]);
    }
}