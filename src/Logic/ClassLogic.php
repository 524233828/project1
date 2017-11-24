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
use Model\BuyModel;
use Model\ClassModel;
use Model\MediaModel;
use Model\OrderModel;

class ClassLogic extends BaseLogic
{
    /**
     * 获取课程特色
     * @param $class_id
     * @return bool|mixed
     */
    public function getClass($class_id)
    {
        $class = ClassModel::getClass($class_id);

        if(empty($class)){
            ClassException::ClassNotFound();
        }

        $class['introduce'] = ClassModel::getClassIntroduce($class_id);

        return $class;
    }

    /**
     * 获取课程试听
     * @param $class_id
     * @return array
     */
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

    public function buyClass($class_id)
    {
        $class = ClassModel::getClass($class_id);

        if(!$class)
        {
            ClassException::ClassNotFound();
        }

        //微信统一下单
        $attributes = [
            'trade_type'       => 'JSAPI',
            'body'             => '夜猫足球-'.$class['title'],
            'detail'           => '夜猫足球-'.$class['title'],
            'out_trade_no'     => OrderModel::getOrderId(),
            'total_fee'        => floor($class['price']*100), // 单位：分
            'openid'           => $_SESSION['wechat_user']['openid'], // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
        ];

        //生成支付参数
        $config = CommonLogic::getInstance()->createOrder($attributes);

        //数据库记录订单
        //开启事务
        database()->query("start transaction");

        $order_date = [
            "order_id" => $attributes['out_trade_no'],
            "total_fee" => $class['price'],
            "create_time" => time(),
            "point" => 1
        ];

        $user_class_data = [
            "class_id"=>$class_id,
            "user_id"=>$_SESSION['uid'],
            "order_id"=>$attributes['out_trade_no'],
            "create_time"=>time(),
            "status"=>0,
        ];
        $order_id = OrderModel::addOrder($order_date);
        $buy_id = BuyModel::addUserClass($user_class_data);
        if($order_id&&$buy_id)
        {
            database()->query("commit");
            return $config;
        }else{
            database()->query("rollback");
            return false;
        }
    }

    /**
     * 后台增加课程
     * @param $title
     * @param $desc
     * @param $tag
     * @param $img_url
     * @param $price
     * @param $sold
     * @return int|string
     */
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

    /**
     * 后台获取单个课程
     * @param $class_id
     * @return bool|mixed
     */
    public function adminGetClass($class_id)
    {
        $class = ClassModel::getClass($class_id);

        if(empty($class)){
            ClassException::ClassNotFound();
        }

        return $class;
    }

    public function updateClass($class_id,$title,$desc,$tag,$img_url,$price,$sold)
    {
        $data = [
            "title"     => $title,
            "desc"      => $desc,
            "tag"       => $tag,
            "img_url"   => $img_url,
            "price"     => $price,
            "sold"      => $sold
        ];
        $where = ["id"=>$class_id];
        return ClassModel::updateClass($where,$data);
    }

    public function deleteClass()
    {

    }

}