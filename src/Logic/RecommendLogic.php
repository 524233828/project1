<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/27 0027
 * Time: 23:25
 */

namespace Logic;

use Exception\UserException;
use Model\RecommendModel;
class RecommendLogic extends BaseLogic
{
    public function index($uid, $id)
    {
        $uid || UserException::UserNotFound();

        $buy = RecommendModel::getUserRecommend($uid, ['id']);
        $recommend = RecommendModel::getRecommendById($id);

        if (empty($buy)) {
            unset($recommend['imgs'], $recommend['info']);
            $recommend['is_paid'] = 1;
        } else {
            $recommend['is_paid'] = 0;
        }

        return $recommend;
    }
}