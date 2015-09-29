<?php
namespace Reception\Controller;
use Common\Controller\BaseController;
class SpiderController extends BaseController {
	public function indexAction()
	{
		$this->display();
	}
	public function queryAction($code)
	{
		$code = M("SpiderCode")->where(array("code"=>$code))->find(); 
		if(empty($code))
		{
			$this->ajaxReturn(array("status"=>2));
		}
		$this->ajaxReturn(array("status"=>$code['valid']));
	}
	public function consumeAction($code,$name,$phone)
	{
		$rules = array(
		     array('code','require','蜘蛛码必须！',1),  
		      array('name','require','姓名必须！',1),  
		       array('phone','require','电话必须！',1),  
		      
		);

		$model=D("SpiderCode");
		if (!$model->validate($rules)->create()){
		    $this->error($model->getError());
		}  
		$c = M("SpiderCode")->where(array("code"=>$code))->find(); 
		if(empty($c))
		{
			$this->error("号码不存在");
		}
		if($c['valid']!=0)
		{
			$this->error("蜘蛛码被其他人消费！请重新提供！");
		}
		$model->where(array("code"=>$code))->setField(array("use_time"=>getDbTime(),"record_id"=>is_user_login(),"valid"=>1, "name"=>$name,"phone"=>$phone));
	
		$this->ajaxReturn(array("status"=>1));
	}
}