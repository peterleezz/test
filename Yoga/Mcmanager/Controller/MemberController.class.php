<?php
namespace Mcmanager\Controller;
use Mc\Controller\VisitController;  
class MemberController extends VisitController {
	public function notmemberAction()
	{  
        $mcs=D("User")->getMc();
        $this->assign("mcs",$mcs);
        $this->assign("mcsarr",json_encode($mcs));        
        $this->assign("is_member",0);
        $this->assign("active","#menu_54");
        $this->assign("active_open","#menu_7");
		$this->display();
	}
    public function ismemberAction()
    {  
        $mcs=D("User")->getMc();
        $this->assign("mcs",$mcs);
        $this->assign("mcsarr",json_encode($mcs));        
        $this->assign("is_member",1);
        $this->assign("active","#menu_55");
        $this->assign("active_open","#menu_7");
        // $this->display("notmember");
         $this->display();
    } 

    public function getMembersAction()
    {
         $service = \Service\CService::factory("Member");   
         $response = $service->getMembers(); 
         $this->ajaxReturn($response); 
    }

    public function assignAction($members,$mc_id)
    {
        if(empty($mc_id)) $this->error("Please choose one mc!"); 
        $model=M("MemberBasic");
        foreach ($members as $key => $value) {
           $model->where("id=$value")->setField(array("mc_id"=>$mc_id,"assign_time"=>getDbTime()));
        }
        $this->success("指派成功!");
        
    }

 
}