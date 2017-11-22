<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/18
 * Time: 13:31
 */

namespace Logic;

use Exception\ClassException;
use Model\ArticleModel;
use Model\ClassModel;
use Model\MediaModel;

class ClassLogic extends BaseLogic
{
    /**
     * 获取课程列表
     * @param int $page
     * @param int $row
     * @return array
     */
    public function listClass($page = 1,$row = 10)
    {

        $page = $page<1?1:$page;

        $row = $row<1?1:$row;

        $first_row = ($page-1)*$row;

        $where = ["status"=>1];

        $count = ClassModel::countClass($where);

        $total_page = floor($count/$row)+1;

        $where["ORDER"] = ["id"=>"DESC"];
        $where["LIMIT"] = [$first_row,$row];

        $class = ClassModel::listClass($where);
        $class['total_page'] = $total_page;
        $class['current_page'] = $page;

        return $class;
    }


    public function getClass($class_id)
    {
        $class = ClassModel::getClass($class_id);

        if(empty($class)){
            ClassException::ClassNotFound();
        }

        $class['introduce'] = ClassModel::getClassIntroduce($class_id);

        return $class;
    }

    public function getClassTry($class_id)
    {
        $class = ClassModel::getClass($class_id);

        if(empty($class)){
            ClassException::ClassNotFound();
        }

        $try = ClassModel::getClassTry($class_id);

        $resource_id = [];
        foreach ($try as $v)
        {
            $resource_id[] = $v['resource_id'];
        }

        $resource_id = array_unique($resource_id);

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

        foreach ($try as $k=>$v)
        {
            if($v['resource_type']==0)
            {
                $try[$k]['resource'] = $media_index[$v['resource_id']];
            }else{
                $try[$k]['resource'] = $article_index[$v['resource_id']];
            }
        }
        return $try;
    }

    public function getClassChapter($class_id)
    {
        $class = ClassModel::getClass($class_id);

        if(empty($class)){
            ClassException::ClassNotFound();
        }

        $chapter = ClassModel::getClassChapter($class_id);

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

        return $chapter;
    }

    public function addClass($title,$desc,$tag,$img_url,$price,$sold)
    {
        $data = [
            "title"     => $title,
            "desc"      => $desc,
            "tag"       => $tag,
            "img_url"   => $img_url,
            "price"     => $price,
            "sold"      => $sold
        ];

        return ClassModel::addClass($data);
    }
}