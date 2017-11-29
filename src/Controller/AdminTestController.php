<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/29
 * Time: 9:20
 */

namespace Controller;


use FastD\Console\SeedRun;
use FastD\Http\ServerRequest;
use Logic\AdminTestLogic;

class AdminTestController extends BaseController
{
    public function listTest(ServerRequest $request)
    {
        return $this->response(AdminTestLogic::getInstance()->listTest());
    }

    public function addTest(ServerRequest $request)
    {
        $img_url = $request->getParam("img_url");
        $title = $request->getParam("title");
        $star = $request->getParam("star");
        $test_num = $request->getParam("test_num");
        $desc = $request->getParam("desc");

        return $this->response(AdminTestLogic::getInstance()->addTest($title,$star,$img_url,$test_num,$desc));
    }

    public function deleteTest(ServerRequest $request)
    {
        $id = $request->getParam("id");
        return $this->response(AdminTestLogic::getInstance()->deleteTest($id));
    }

    public function updateTest(ServerRequest $request)
    {
        $id = $request->getParam("id");
        $img_url = $request->getParam("img_url");
        $title = $request->getParam("title");
        $star = $request->getParam("star");
        $test_num = $request->getParam("test_num");
        $desc = $request->getParam("desc");

        return $this->response(AdminTestLogic::getInstance()->updateTest($id,$title,$star,$img_url,$test_num,$desc));
    }

    public function listAsk(ServerRequest $request)
    {

        $test_id = $request->getParam("test_id");

        return $this->response(AdminTestLogic::getInstance()->listAsk($test_id));
    }

    public function addAsk(ServerRequest $request)
    {
        $test_id = $request->getParam("test_id");
        $img_url = $request->getParam("img_url");
        $desc = $request->getParam("desc");
        $options = $request->getParam("options");
        $ask_no = $request->getParam("ask_no",0);

        return $this->response(AdminTestLogic::getInstance()->addAsk($test_id,$img_url,$desc,$options,$ask_no));
    }

    public function deleteAsk(ServerRequest $request)
    {
        $id = $request->getParam("id");
        return $this->response(AdminTestLogic::getInstance()->deleteAsk($id));
    }

    public function updateAsk(ServerRequest $request,$id,$test_id,$img_url,$desc,$options,$ask_no = 0)
    {
        $id = $request->getParam("id");
        $test_id = $request->getParam("test_id");
        $img_url = $request->getParam("img_url");
        $desc = $request->getParam("desc");
        $options = $request->getParam("options");
        $ask_no = $request->getParam("ask_no",0);
        return $this->response(AdminTestLogic::getInstance()->updateAsk($id,$test_id,$img_url,$desc,$options,$ask_no));
    }

    public function listAnswer(ServerRequest $request)
    {
        $test_id = $request->getParam("test_id");

        return $this->response(AdminTestLogic::getInstance()->listAnswer($test_id));
    }

    public function addAnswer(ServerRequest $request,$test_id,$img_url)
    {
        $img_url = $request->getParam("img_url");
        $test_id = $request->getParam("test_id");

        return $this->response(AdminTestLogic::getInstance()->addAnswer($test_id,$img_url));
    }

    public function deleteAnswer(ServerRequest $request)
    {
        $id = $request->getParam("id");
        return $this->response(AdminTestLogic::getInstance()->deleteAnswer($id));
    }

    public function updateAnswer(ServerRequest $request)
    {
        $img_url = $request->getParam("img_url");
        $test_id = $request->getParam("test_id");
        $id = $request->getParam("id");
        return $this->response(AdminTestLogic::getInstance()->updateAnswer($id,$test_id,$img_url));
    }
}