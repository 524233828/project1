<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/24
 * Time: 14:20
 */

namespace Controller;


use FastD\Http\ServerRequest;
use Logic\MyClassLogic;

class MyClassController extends BaseController
{
    /**
     * @name 获取课程章节（购买后）
     * @apiParam class_id|int|课程ID|true
     * @returnParam [].id|int|章节ID
     * @returnParam [].title|string|章节标题
     * @returnParam [].chapter_no|int|第几章
     * @returnParam [].desc|int|第几章
     * @returnParam [].lesson[].id|int|课时ID
     * @returnParam [].lesson[].lesson_no|int|第几课
     * @returnParam [].lesson[].title|int|课程标题
     * @returnParam [].lesson[].desc|string|课程描述
     * @returnParam [].lesson[].img_url|string|课程图片
     * @returnParam [].lesson[].resource_id|string|资源ID
     * @returnParam [].lesson[].resource_type|int|资源类型，0-视频 1-文章
     * @returnParam [].lesson[].resource.media_time|int|视频长度，单位：秒， resource_type=0时存在
     * @returnParam [].lesson[].resource.media_url|int|视频地址， resource_type=0时存在
     * @returnParam [].lesson[].resource.title|string|文章标题，resource_type=1时存在
     * @returnParam [].lesson[].resource.img_url|string|文章图片地址，resource_type=1时存在
     * @returnParam [].lesson[].resource.content|string|文章内容，resource_type=1时存在
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function getClassChapter(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");

        return $this->response(MyClassLogic::getInstance()->getClassChapter($class_id));
    }

    /**
     * @apiParam class_id|int|课程ID|true
     * @apiParam percent|int|学习百分比|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function updateLearnPercent(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");
        $percent = $request->getParam("percent");
        $user_id = $_SESSION['uid'];

        return $this->response(MyClassLogic::getInstance()->updateLearnPercent($user_id,$class_id,$percent));
    }
}