<?php
namespace Brand\Controller;
use Common\Controller\BaseController;
class SystemconfigController extends BaseController {
	public function indexAction()
	{
		$model =M("BrandConfig");
		$config = $model->where(array("brand_id"=>get_brand_id()))->find();
		$this->assign("config",$config);
		$this->display();
	}

	public function addAction()
	{
		$model =D("BrandConfig");
		if(!$model->create())
		{
			$this->error($model->getError());
		}
		$id=I("id");
		if(!empty($id))
		{
			$model->save();
		}
		else
		{
			$model->add();
		}
		$this->success("设置成功","index");
	}

}