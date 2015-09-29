<?php
namespace Mc\Controller;
 use Common\Controller\BaseController;
class GroupController  extends BaseController {

 	public function indexAction()
	{  
		$id=is_user_login();
        $mcs=D("McGroup")->getMyGroupMc($id); 
        $this->assign("mcs",$mcs);
        $this->assign("mcsarr",json_encode($mcs));        
        $this->assign("is_member",0);
        $this->assign("active","#menu_54");
        $this->assign("active_open","#menu_7");
		$this->display();
	}
	
	 public function getMembersAction()
    {
         $service = \Service\CService::factory("Member");   
         $response = $service->getMembers(); 
         $this->ajaxReturn($response); 
    }
	 
}