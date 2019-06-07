<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/18
 * Time: 13:31
 */

namespace Logic;

use Component\Wxapp\Wxapp;
use Exception\BaseException;
use Exception\ClassException;
use Exception\UserException;
use Model\ArticleModel;
use Model\BuyModel;
use Model\ClassModel;
use Model\MediaModel;
use Model\OrderModel;
use Model\UserModel;

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

        $class['introduce'] = ClassModel::listClassIntroduce($class_id);

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
            return [];
//            ClassException::ClassNotFound();
        }

        $try = ClassModel::listClassTry($class_id);

        if(count($try)<1){
            return [];
//            ClassException::NoTryInClass();
        }

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
//            ClassException::ClassNotFound();
            return [];
        }

        $chapter = ClassModel::listClassChapter($class_id);

        $chapter_ids = [];
        foreach ($chapter as $v)
        {
            $chapter_ids[] = $v['id'];
        }

        if(count($chapter_ids)<1)
        {
//            ClassException::NoChapterInClass();
            return [];
        }
        $lesson = ClassModel::listChapterLesson([
            "chapter_id"=>$chapter_ids,
            "ORDER" => ["lesson_no" => "ASC", "id" => "ASC"],
        ]);

        if(count($lesson)<1)
        {
//            ClassException::NoLessonInChapter();
            return [];
        }

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

    public function buyClass($class_id,$channel = 1 ,$paysource = 0, $phone = "")
    {
        $class = ClassModel::getClass($class_id);

        if(!$class)
        {
            ClassException::ClassNotFound();
        }

        $class_list = BuyModel::getUserClass($_SESSION['uid'],$class_id);
        if($class_list)
        {
            ClassException::ClassHasBought();
        }

        //微信统一下单
        $attributes = [
            'trade_type'       => 'JSAPI',
            'body'             => '夜猫足球-'.$class['title'],
            'detail'           => '夜猫足球-'.$class['title'],
            'out_trade_no'     => OrderModel::getOrderId(),
            'total_fee'        => floor($class['price']*100), // 单位：分
            'openid'           => $_SESSION['userInfo']['openid'], // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
        ];

        if($class['price'] > 0 && $paysource == 0){
            //生成支付参数
            $config = CommonLogic::getInstance()->createOrder($attributes);
        }

        //小程序特殊处理，只记录手机号无需付款
        if($paysource == 1){
            if(isset($config)){
                unset($config);
            }

            if(empty($phone)&& empty($_SESSION['phone'])){
                UserException::UserNoPhone();
            }

            if(empty($_SESSION['phone'])){
                UserModel::updateUserByUid($_SESSION['uid'], ["phone" => $phone]);
            }
        }


        //数据库记录订单
        //开启事务
        database()->pdo->beginTransaction();

        $order_date = [
            "order_id" => $attributes['out_trade_no'],
            "total_fee" => $class['price'],
            "create_time" => time(),
            "point" => 1,
            "user_id" => $_SESSION['uid'],
            "channel_id" => $channel,
            "paysource" => $paysource,
        ];

        $user_class_data = [
            "class_id"=>$class_id,
            "user_id"=>$_SESSION['uid'],
            "order_id"=>$attributes['out_trade_no'],
            "create_time"=>time(),
        ];
        $order_id = OrderModel::addOrder($order_date);
        $buy_id = BuyModel::addUserClass($user_class_data);
        if($order_id && $buy_id)
        {
            database()->pdo->commit();
            if(isset($config)){
                return $config;
            }else{
                OrderModel::updateOrder(["status" => 1],["order_id"=>$order_id]);
                $user_class = BuyModel::getUserClassByOrderId($order_id, ['class_id']);
                $class = ClassModel::getClass($user_class['class_id']);
                BuyModel::buySuccess($order_id, $class['expire_month']);
                database()->pdo->commit();
                return ["timestamp" => time()];
            }

        }else{
            database()->pdo->rollBack();
            return false;
        }
    }

    public function getData($data, $iv)
    {

        if(empty($data) || empty($iv)){
            BaseException::ParamsError();
        }


        $log = myLog("wxapp_get_data");
        $log->addDebug("data:".$data);
        $log->addDebug("iv:".$iv);
        $app_id = config()->get("wxapp_app_id");
        $app_secret = config()->get("wxapp_app_secret");
        $wxapp = new Wxapp($app_id, $app_secret);
        $session_key = $_SESSION['userInfo']['session_key'];
        return $wxapp->encryptedDataDecode($data, $session_key, $iv);
    }

}