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
use Service\ApiResponse;

class ClassController extends BaseController
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
        return $this->response(ClassLogic::getInstance()->listClass($page),true);

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
     * @returnParam introduce[].url|string|图片跳转地址
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function getClass(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");

        return $this->response(ClassLogic::getInstance()->getClass($class_id),true);
    }

    /**
     * @name 问题试听列表
     * @apiParam class_id|int|问题ID|true
     * @returnParam [].id|int|课程ID
     * @returnParam [].resource_type|int|资源类型，0-视频 1-文章
     * @returnParam [].sort|int|试听列表排序 大的在前
     * @returnParam [].title|int|试听列表排序 大的在前
     * @returnParam [].desc|int|试听列表排序 大的在前
     * @returnParam [].img_url|int|试听列表排序 大的在前
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
     * @name 课程章节
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
     * @returnParam [].lesson[].resource_type|int|资源类型，0-视频 1-文章
     * @returnParam [].lesson[].resource.media_time|int|视频长度，单位：秒， resource_type=0时存在
     * @returnParam [].lesson[].resource.title|string|文章标题，resource_type=1时存在
     * @returnParam [].lesson[].resource.img_url|string|文章图片地址，resource_type=1时存在
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function getClassChapter(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");

        return $this->response(ClassLogic::getInstance()->getClassChapter($class_id),true);
    }


    /**
     * @name 增加一个课程
     * @apiParam title|string|课程标题|true
     * @apiParam desc|string|课程描述|true
     * @apiParam tag|string|课程标签|true
     * @apiParam img_url|string|课程图片|true
     * @apiParam price|float|课程价格|true
     * @apiParam sold|int|课程卖出|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function addClass(ServerRequest $request)
    {

        $title = $request->getParam("title");
        $desc = $request->getParam("desc");
        $tag = $request->getParam("tag");
        $img_url = $request->getParam("img_url");
        $price = $request->getParam("price");
        $sold = $request->getParam("sold");

        $class = ClassLogic::getInstance()->addClass($title,$desc,$tag,$img_url,$price,$sold);
        if($class)
        {
            return $this->response([]);
        }

    }

    /**
     * @name 后台获取问题详情
     * @apiParam class_id|int|课程ID|true
     * @returnParam id|int|课程ID
     * @returnParam sold|int|卖出数量
     * @returnParam img_url|string|图片地址
     * @returnParam price|float|价格
     * @returnParam title|string|标题
     * @returnParam status|int|状态1-可用 0-不可用
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function adminGetClass(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");

        return $this->response(ClassLogic::getInstance()->adminGetClass($class_id),true);
    }

    /**
     * @name 更新一个课程
     * @apiParam class_id|int|课程ID|true
     * @apiParam title|string|课程标题|true
     * @apiParam desc|string|课程描述|true
     * @apiParam tag|string|课程标签|true
     * @apiParam img_url|string|课程图片|true
     * @apiParam price|float|课程价格|true
     * @apiParam sold|int|课程卖出|true
     * @param ServerRequest $request
     * @return ApiResponse;
     */
    public function updateClass(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");
        $title = $request->getParam("title");
        $desc = $request->getParam("desc");
        $tag = $request->getParam("tag");
        $img_url = $request->getParam("img_url");
        $price = $request->getParam("price");
        $sold = $request->getParam("sold");

        return $this->response(ClassLogic::getInstance()->updateClass(
            $class_id,
            $title,
            $desc,
            $tag,
            $img_url,
            $price,
            $sold
        ));
    }

    /**
     * @name 冻结课程
     * @apiParam class_id|int|课程ID|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function deleteClass(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");
        return $this->response([ClassLogic::getInstance()->deleteClass($class_id)]);
    }

    /*****************************章节**************************/
    /**
     * @name 增加一个课程
     * @apiParam title|string|课程标题|true
     * @apiParam desc|string|课程描述|true
     * @apiParam tag|string|课程标签|true
     * @apiParam img_url|string|课程图片|true
     * @apiParam price|float|课程价格|true
     * @apiParam sold|int|课程卖出|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function addChapter(ServerRequest $request)
    {

        $title = $request->getParam("title");
        $desc = $request->getParam("desc");
        $tag = $request->getParam("tag");
        $img_url = $request->getParam("img_url");
        $price = $request->getParam("price");
        $sold = $request->getParam("sold");

        $class = ClassLogic::getInstance()->addClass($title,$desc,$tag,$img_url,$price,$sold);
        if($class)
        {
            return $this->response([]);
        }

    }

    /**
     * @name 后台获取问题详情
     * @apiParam class_id|int|课程ID|true
     * @returnParam id|int|课程ID
     * @returnParam sold|int|卖出数量
     * @returnParam img_url|string|图片地址
     * @returnParam price|float|价格
     * @returnParam title|string|标题
     * @returnParam status|int|状态1-可用 0-不可用
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function adminGetChapter(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");

        return $this->response(ClassLogic::getInstance()->adminGetClass($class_id),true);
    }

    /**
     * @name 更新一个课程
     * @apiParam class_id|int|课程ID|true
     * @apiParam title|string|课程标题|true
     * @apiParam desc|string|课程描述|true
     * @apiParam tag|string|课程标签|true
     * @apiParam img_url|string|课程图片|true
     * @apiParam price|float|课程价格|true
     * @apiParam sold|int|课程卖出|true
     * @param ServerRequest $request
     * @return ApiResponse;
     */
    public function updateChapter(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");
        $title = $request->getParam("title");
        $desc = $request->getParam("desc");
        $tag = $request->getParam("tag");
        $img_url = $request->getParam("img_url");
        $price = $request->getParam("price");
        $sold = $request->getParam("sold");

        return $this->response(ClassLogic::getInstance()->updateClass(
            $class_id,
            $title,
            $desc,
            $tag,
            $img_url,
            $price,
            $sold
        ));
    }

    /**
     * @name 冻结课程
     * @apiParam class_id|int|课程ID|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function deleteChapter(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");
        return $this->response([ClassLogic::getInstance()->deleteClass($class_id)]);
    }

}