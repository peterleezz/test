<?php
namespace Home\Controller;
use Common\Controller\BaseController;
use Service\UserService;

class TaskController extends BaseController {
	 
	 public function checkTaskAction()
	 {
	 	$id=is_user_login();
	 	if(D("User")->isReception($id)) //from reception
	 	{
	 		//check choose pt
	 		$ret = M("TaskChoosept")->where("status=0")->order("id asc")->limit(1)->find();
	 		if(!empty($ret))
	 		{
	 			$class=M("PtConsumeHistory")->find($ret['history_id']);
	 			$member=M("MemberBasic")->find($class['member_id']);
	 			$cmd="choosept";
	 			// M("TaskChoosept")->where("id=".$ret['id'])-> setField(array("status"=>2));
	 			$this->ajaxReturn(array("cmd"=>$cmd,"class"=>$class,"member"=>$member));
	 		}


	 		//check print  
	 		$ret = M("TaskPtprint")->where("status=0")->order("id asc")->limit(1)->find();
	 		if(!empty($ret))
	 		{
	 			$class=M("PtConsumeHistory")->find($ret['history_id']);
	 			$member=M("MemberBasic")->find($class['member_id']);
	 			$cmd="printpt";
	 			// M("TaskChoosept")->where("id=".$ret['id'])-> setField(array("status"=>2));
	 			$this->ajaxReturn(array("cmd"=>$cmd,"class"=>$class,"member"=>$member,"task"=>$ret));
	 		}
	 	}
	 }


	 public function setptAction($id,$pt_id)
	 {
	 	M("PtConsumeHistory")->where("id=$id")->setField(array("pt_id"=>$pt_id));
	 	$task =  M("TaskChoosept")->where("history_id=$id")->order("id asc")->limit(1)->find();
	 	M("TaskChoosept")->delete($task['id']);
	 	$this->success(" PT设置成功！");
	 }

	  public function printptAction($id)
	 { 
	 	$task =  M("TaskPtprint")->delete($id); 
	 	$this->success(" success");
	 }
}


