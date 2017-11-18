<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/16
 * Time: 22:05
 */
namespace Controller;

use FastD\Http\Response;
use FastD\Http\ServerRequest;
use Logic\ClassLogic;

class ClassController extends BaseController
{

    /**
     * @name 首页获取文章列表
     * @apiParam page|int|分页页数，默认为1|false
     * @returnParam [].id|int|课程ID
     * @returnParam [].sold|int|卖出数量
     * @returnParam [].price|float|售价
     * @returnParam [].img_url|string|图片地址
     * @returnParam [].title|string|课程标题
     * @returnParam current_page|int|当前页数
     * @returnParam total_page|string|总页数
     * @param ServerRequest $request
     * @return Response;
     */
    public function listClass(ServerRequest $request)
    {

        $page = $request->getParam("page",1);
        return $this->response(ClassLogic::getInstance()->listClass($page));

    }

    /**
     * @name 问题详情课程特色页
     * @apiParam class_id|int|问题ID|true
     * @returnParam id|int|课程ID
     * @returnParam sold|int|卖出数量
     * @returnParam img_url|string|图片地址
     * @returnParam price|float|价格
     * @returnParam title|string|标题
     * @returnParam status|int|状态1-可用 0-不可用
     * @returnParam introduce[].img_url|string|介绍图片地址
     * @returnParam introduce[].title|string|介绍标题
     * @returnParam introduce[].content|string|介绍内容
     * @returnParam introduce[].sort|int|排序，大的在前
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function getClass(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");

        return $this->response(ClassLogic::getInstance()->getClass($class_id));
    }

    /**
     * @name 问题试听列表
     * @apiParam class_id|int|问题ID|true
     * @returnParam [].id|int|课程ID
     * @returnParam [].resource_type|int|资源类型，0-视频 1-文章
     * @returnParam [].sort|int|试听列表排序 大的在前
     * @returnParam [].resource.id|int|资源ID
     * @returnParam [].resource.media_url|string|视频地址， resource_type=0时存在
     * @returnParam [].resource.media_time|int|视频长度， resource_type=0时存在
     * @returnParam [].resource.size|int|视频大小，单位：byte， resource_type=0时存在
     * @returnParam [].resource.title|string|文章标题，resource_type=1时存在
     * @returnParam [].resource.img_url|string|文章图片地址，resource_type=1时存在
     * @returnParam [].resource.content|string|文章内容，resource_type=1时存在
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function getClassTry(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");

        return $this->response(ClassLogic::getInstance()->getClassTry($class_id));
    }

    /**
     * @name 问题章节
     * @apiParam class_id|int|问题ID|true
     * @returnParam [].id|int|章节ID
     * @returnParam [].title|string|章节标题
     * @returnParam [].chapter_id|int|第几章
     * @returnParam lesson.[].id|int|课时ID
     * @returnParam lesson.[].lesson_no|int|第几课
     * @returnParam lesson.[].desc|string|课程描述
     * @returnParam lesson.[].resource_type|int|资源类型，0-视频 1-文章
     * @returnParam lesson.[].resource.id|int|资源ID
     * @returnParam lesson.[].resource.media_url|string|视频地址， resource_type=0时存在
     * @returnParam lesson.[].resource.media_time|int|视频长度，单位：秒， resource_type=0时存在
     * @returnParam lesson.[].resource.size|int|视频大小，单位：byte， resource_type=0时存在
     * @returnParam lesson.[].resource.title|string|文章标题，resource_type=1时存在
     * @returnParam lesson.[].resource.img_url|string|文章图片地址，resource_type=1时存在
     * @returnParam lesson.[].resource.content|string|文章内容，resource_type=1时存在
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function getClassChapter(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");

        return $this->response(ClassLogic::getInstance()->getClassChapter($class_id));
    }

}