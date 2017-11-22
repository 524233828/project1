<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/22
 * Time: 19:13
 */


namespace Logic;

use Model\ArticleModel;

class ArticleLogic extends BaseLogic
{
    public function getArticle($resource_id)
    {
        return ArticleModel::getArticle($resource_id);
    }
}