<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/18
 * Time: 16:37
 */

namespace Logic;

use Model\BannerModel;

class BannerLogic extends BaseLogic
{

    public function addBanner($img_url,$url,$status = 1)
    {
        $data = [
            "img_url" => $img_url,
            "url" => $url,
            "status" => $status,
        ];
        $banner = BannerModel::addBanner($data);

        return $banner;
    }

    public function deleteBanner($banner_id)
    {
        return BannerModel::deleteBanner($banner_id);
    }

    public function updateBanner($banner_id,$img_url,$url,$status)
    {
        $data = [
            "img_url" => $img_url,
            "url" => $url,
            "status" => $status,
        ];
        $where = ["id"=>$banner_id];
        return BannerModel::updateBanner($where,$data);
    }
}