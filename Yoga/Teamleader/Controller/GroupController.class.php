<?php
namespace Teamleader\Controller;
use Common\Controller\BaseController;
class GroupController extends BaseController {

 public function getModel()
 {
    return D("McGroup");
 }
 public function getgroupsAction()
 {
 	     $model = D("McGroup");
		$response = $model->getGroups();
		$this->ajaxReturn($response); 
 }

public function getMcAction()
{
	     $model = D("McGroup");
		$response = $model->getMcs();
		$this->ajaxReturn($response); 
}

public function setGroupAction()
{
	$id = I("id");  
	$group_id = I("group");
	if(!is_array($id))
	{
		$id=array($id);
	}
	M("UserExtension")->where(array("id"=>array("in",$id)))->setField(array("group_id"=>$group_id));
   	 	$response=array("success"=>true,"info"=>"设置成功","message"=>"success!","new_id"=>$id,"status"=>true);
   	 	$this->ajaxReturn($response);
}
	 
}