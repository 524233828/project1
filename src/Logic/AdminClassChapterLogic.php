<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/24
 * Time: 23:39
 */

namespace Logic;


use Model\ClassModel;

class AdminClassChapterLogic extends BaseLogic
{
    /**
     * 后台获取课程试听列表
     * @param int $class_id
     * @param int $page
     * @param int $row
     * @return array
     */
    public function listChapter($class_id,$page = 1,$row = 20)
    {

        $result_list = ClassModel::listClassChapter($class_id);

        $result['list'] = $result_list;

        return $result;
    }

    public function addChapter($title,$chapter_no,$class_id,$desc)
    {
        $data = [
            "class_id" => $class_id,
            "chapter_no" => $chapter_no,
            "title" => $title,
            "desc" => $desc,
        ];
        $banner = ClassModel::addChapter($data);

        return $banner;
    }

    public function deleteChapter($id)
    {
        return ClassModel::deleteChapter($id);
    }

    public function updateChapter($id,$title,$chapter_no,$class_id,$desc)
    {
        $data = [
            "class_id" => $class_id,
            "chapter_no" => $chapter_no,
            "title" => $title,
            "desc" => $desc,
        ];
        $where = ["id"=>$id];
        return ClassModel::updateChapter($where,$data);
    }
}