<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/16
 * Time: 22:17
 */

/**
 * @namespace Model;
 * @class ClassModel;
 * 课程模块类
 * 由于课程的章节、课、简介及试听信息脱离课程后都没有意义
 * 因此统一归类到课程模块
 */
namespace Model;

use Exception\BaseException;

class ClassModel extends BaseModel
{
    const CLASS_TABLE = "db_class";
    const CHAPTER_TABLE = "db_class_chapter";
    const LESSON_TABLE = "db_class_chapter_lesson";
    const INTRODUCE_TABLE = "db_class_introduce";
    const TRY_TABLE = "db_class_try";

    /**
     * 获取课程列表
     * @param array $where
     * @return array
     */
    public static function listClass($where = [])
    {
        $db = database();

        $result = $db->select(self::CLASS_TABLE,"*",
            $where
        );

        return $result;
    }

    /**
     * 获取课程数量
     * @param array $where
     * @return bool|int
     */
    public static function countClass($where = [])
    {
        $db = database();

        return $db->count(self::CLASS_TABLE,"*",$where);
    }

    /**
     * 根据课程ID获取课程
     * @param $class_id
     * @return bool|mixed
     */
    public static function getClass($class_id)
    {
        $db = database();

        $result = $db->get(self::CLASS_TABLE,"*",["id"=>$class_id]);

        return $result;
    }

    /**
     * 根据课程ID获取简介列表
     * @param $class_id
     * @return array
     */
    public static function getClassIntroduce($class_id)
    {
        $db = database();

        $where = [
            "class_id" => $class_id,
            "ORDER" => ["sort" => "DESC", "id" =>"ASC"]
        ];

        $result = $db->select(self::INTRODUCE_TABLE,"*",
            $where
        );

        return $result;
    }

    /**
     * 获取课程试听列表
     * @param $class_id
     * @return array
     */
    public static function getClassTry($class_id)
    {
        $db = database();

        $where = [
            "class_id" => $class_id,
            "ORDER" => ["sort" => "DESC", "id" =>"ASC"]
        ];

        $result = $db->select(self::TRY_TABLE,"*",
            $where
        );

        return $result;
    }

    public static function getClassChapter($class_id)
    {
        $db = database();

        $where = [
            "class_id" => $class_id,
            "ORDER" => ["chapter_no" => "ASC", "id" => "ASC"]
        ];

        $result = $db->select(self::CHAPTER_TABLE,"*",
            $where
        );

        return $result;
    }

    public static function listChapterLesson($where = [])
    {
        $db = database();

        $result = $db->select(self::LESSON_TABLE,"*",
            $where
        );

        return $result;
    }

    public static function addClass($data)
    {
        $data['create_time'] = time();
        $result = database()->insert(self::CLASS_TABLE,$data);

        if(!$result){
            BaseException::SystemError();
        }
        return database()->id();
    }

    public static function addChapter($data)
    {
        $data['create_time'] = time();
        $result = database()->insert(self::CHAPTER_TABLE,$data);

        if(!$result){
            BaseException::SystemError();
        }
        return database()->id();
    }

    public static function addLesson($data)
    {
        $data['create_time'] = time();
        $result = database()->insert(self::LESSON_TABLE,$data);

        if(!$result){
            BaseException::SystemError();
        }
        return database()->id();
    }

    public static function addTry($data)
    {
        $data['create_time'] = time();
        $result = database()->insert(self::TRY_TABLE,$data);

        if(!$result){
            BaseException::SystemError();
        }
        return database()->id();

    }
}