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
}