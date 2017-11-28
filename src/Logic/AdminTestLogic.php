<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/28
 * Time: 14:36
 */

namespace Logic;


use Model\TestModel;

class AdminTestLogic
{
    public function listTest()
    {
        $result = TestModel::listTest();

        return $result;
    }

    public function addTest($title,$star,$img_url,$test_num,$desc)
    {
        $data = [
            "img_url" => $img_url,
            "title" => $title,
            "star" => $star,
            "test_num" => $test_num,
            "desc" => $desc,
        ];
        $result = TestModel::addTest($data);

        return $result;
    }

    public function deleteTest($id)
    {
        return TestModel::deleteTest($id);
    }

    public function updateTest($id,$title,$star,$img_url,$test_num,$desc)
    {
        $data = [
            "img_url" => $img_url,
            "title" => $title,
            "star" => $star,
            "test_num" => $test_num,
            "desc" => $desc,
        ];
        $where = ["id"=>$id];
        return TestModel::updateTest($where,$data);
    }

    public function listAsk($test_id)
    {

        $where = ["test_id" => $test_id];
        $result = TestModel::listAsk($where);

        return $result;
    }

    public function addAsk($test_id,$img_url,$desc,$ask_no = 0)
    {
        $data = [
            "img_url" => $img_url,
            "test_id" => $test_id,
            "desc" => $desc,
        ];
        if(!$ask_no)
        {
            $ask_no = TestModel::getMaxAskNo($test_id);
            $data['ask_no'] = (int)$ask_no + 1;
        }else{
            $data['ask_no'] = $ask_no;
        }

        $result = TestModel::addAsk($data);

        return $result;
    }

    public function deleteAsk($id)
    {
        return TestModel::deleteAsk($id);
    }

    public function updateAsk($id,$test_id,$img_url,$desc,$ask_no = 0)
    {
        $data = [
            "img_url" => $img_url,
            "test_id" => $test_id,
            "desc" => $desc,
        ];
        if(!$ask_no)
        {
            $data['ask_no'] = $ask_no;
        }
        $where = ["id"=>$id];
        return TestModel::updateAsk($where,$data);
    }

    public function listAnswer($test_id)
    {
        $where = ["test_id" => $test_id];
        $result = TestModel::listAnswer($where);

        return $result;
    }

    public function addAnswer($test_id,$img_url)
    {
        $data = [
            "img_url" => $img_url,
            "test_id" => $test_id
        ];
        $result = TestModel::addAnswer($data);

        return $result;
    }

    public function deleteAnswer($id)
    {
        return TestModel::deleteAnswer($id);
    }

    public function updateAnswer($id,$test_id,$img_url)
    {
        $data = [
            "img_url" => $img_url,
            "test_id" => $test_id
        ];
        $where = ["id"=>$id];
        return TestModel::updateAnswer($where,$data);
    }


}