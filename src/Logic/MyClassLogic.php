<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/24
 * Time: 14:14
 */

namespace Logic;


use Exception\ClassException;
use Model\ArticleModel;
use Model\BuyModel;
use Model\ClassModel;
use Model\MediaModel;

class MyClassLogic extends BaseLogic
{
    /**
     * 获取课程章节
     * @param $class_id
     * @return array
     */
    public function getClassChapter($class_id)
    {
        $class = ClassModel::getClass($class_id);

        if(empty($class)){
            ClassException::ClassNotFound();
        }

        $user_class = BuyModel::getUserClass($_SESSION['uid'],$class_id);

        $buy_time = $user_class['update_time'];

        if($class['expire_month']!==0)
        {
            $expire_time = strtotime(date("Y-m-d H:i:s",$buy_time)." +{$class['expire_month']} month");
            if($expire_time<time())
            {
                ClassException::ClassExpire();
            }
        }

        $class['learn_percent'] = $user_class["learn_percent"];

        $chapter = ClassModel::listClassChapter($class_id);

        $chapter_ids = [];
        foreach ($chapter as $v)
        {
            $chapter_ids[] = $v['id'];
        }

        if(count($chapter_ids)<1)
        {
            ClassException::NoChapterInClass();
        }
        $lesson = ClassModel::listChapterLesson([
            "chapter_id"=>$chapter_ids,
            "ORDER" => ["lesson_no" => "ASC", "id" => "ASC"],
        ]);

        $lesson_index = [];
        $resource_id = [];
        foreach ($lesson as $k => $v)
        {

            $resource_id[] = $v['resource_id'];
        }

        $article = ArticleModel::listArticle(["id"=>$resource_id]);
        $article_index = [];
        foreach ($article as $k=>$v)
        {
            $article_index[$v['id']] = $v;
        }

        $media = MediaModel::listMedia(["id"=>$resource_id]);
        $media_index = [];
        foreach ($media as $k=>$v)
        {
            $media_index[$v['id']] = $v;
        }

        foreach ($lesson as $k=>$v)
        {
            if($v['resource_type']==0)
            {
                $v['resource'] = $media_index[$v['resource_id']];
            }else{
                $v['resource'] = $article_index[$v['resource_id']];
            }
            $lesson_index[$v['chapter_id']][] = $v;

        }

        foreach ($chapter as $k => $v)
        {
            $chapter[$k]["lesson"]=isset($lesson_index[$v['id']])?$lesson_index[$v['id']]:[];
        }

        $response = $class;
        $response['chapter'] = $chapter;
        return $response;
    }

    public function updateLearnPercent($user_id,$class_id,$percent)
    {
        return BuyModel::updateLearnPercent($user_id,$class_id,$percent);
    }
}