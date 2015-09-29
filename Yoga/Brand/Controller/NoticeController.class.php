<?php
namespace Brand\Controller;
use Common\Controller\BaseController;
class NoticeController extends BaseController {
	public  function indexAction()
	{ 
		$this->display();
	}

	public function queryAction()
	{
		$model = D("Notice");
		$response = $model->getNotice();
		$this->ajaxReturn($response); 
	}
 public function getModel()
 {
    return D("Notice");
 }
    

}