<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/24
 * Time: 22:31
 */

namespace Logic;


use Exception\BaseException;
use Model\ArticleModel;
use Model\ClassModel;
use Model\MediaModel;

class AdminClassTryLogic extends BaseLogic
{
    /**
     * 后台获取课程试听列表
     * @param int $class_id
     * @param int $page
     * @param int $row
     * @return array
     */
    public function listTry($class_id,$page = 1,$row = 20)
    {

        $result_list = ClassModel::listClassTry($class_id);

        $resource_id = [];
        foreach ($result_list as $v)
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

        foreach ($result_list as $k=>$v)
        {
            if($v['resource_type']==0)
            {
                $result_list[$k]['resource'] = $media_index[$v['resource_id']];
            }else{
                $result_list[$k]['resource'] = $article_index[$v['resource_id']];
            }
        }

        $result['list'] = $result_list;

        return $result;
    }

    /**
     * @param $class_id
     * @param $resource_type
     * @param $title
     * @param $desc
     * @param $img_url
     * @param array $resource_data
     * @param int $sort
     * @return int|string
     */
    public function addTry($class_id,$resource_type,$title,$desc,$img_url,$resource_data = [],$sort = 0)
    {
        $data = [
            "class_id"  => $class_id,
            "resource_type" => $resource_type,
            "title"     => $title,
            "desc"      => $desc,
            "sort"       => $sort,
            "img_url"   => $img_url,
        ];

        //开启事务
        database()->query("start transaction");
        if($resource_type ==0)
        {
            $data['resource_id'] = MediaModel::getVideoByResourceId($resource_data['resource_id']);
        }else{
            $data['resource_id'] = ArticleModel::addArticle($resource_data);
        }

        if($result = ClassModel::addClass($data))
        {
            database()->query("commit");
            return $result;
        }else{
            database()->query("rollback");
            BaseException::SystemError();
        }
    }

    public function deleteTry($id)
    {
        return ClassModel::deleteTry($id);
    }
}