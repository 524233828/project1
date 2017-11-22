<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/14
 * Time: 23:32
 */

namespace Controller;

use FastD\Http\ServerRequest;
use Logic\ArticleLogic;
use Logic\ClassLogic;
use Logic\UserLogic;

class UserController extends BaseController
{
    /**
     * @name 登录回调
     */
    public function login(ServerRequest $request)
    {
        UserLogic::getInstance()->login();
    }

    /**
     * @name 获取用户购买的课程列表
     * @returnParam [].id|int|课程ID
     * @returnParam [].img_url|string|课程图片
     * @returnParam [].title|string|课程标题
     * @returnParam [].desc|string|课程描述
     * @returnParam [].tag|string|课程标签
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function listUserClass(ServerRequest $request)
    {
        $user_id = 1;

        return $this->response(UserLogic::getInstance()->listUserClass($user_id));
    }

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

        return $this->response(ClassLogic::getInstance()->getClassChapter($class_id));
    }

    /**
     * @name 获取课程文章（购买后）
     * @apiParam resource_id|int|课程ID|true
     * @returnParam id|int|文章ID
     * @returnParam title|string|文章标题
     * @returnParam img_url|string|文章图片
     * @returnParam content|string|文章内容
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function getArticle(ServerRequest $request)
    {
        $resource_id = $request->getParam("resource_id");

        return $this->response(ArticleLogic::getInstance()->getArticle($resource_id));
    }
}