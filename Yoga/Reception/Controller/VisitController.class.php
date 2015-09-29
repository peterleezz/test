<?php
namespace Reception\Controller;
use Common\Controller\BaseController;
class VisitController  extends \Channel\Controller\VisitnController {

	 public function setIndexActiveClass()
    {
          $this->assign("active_open","#menu_4");
    	$this->assign("active","#menu_33");
    }
	public function getAddRedirectUrl()
	{
		return U('Reception/Visit/index');
	}

public function getchannels()
{
	$channels=D("Channel")->getAllChannelName();	  
	return $channels;
}
	public function existAction()
	{
		$brand_id = get_brand_id();
		$model=M("MemberBasic");
		$member = $model->where(array("brand_id"=>$brand_id,"name"=>I("name"),"phone"=>I("phone")))->find(); 
		if(!empty($member))
		{
			$this->ajaxReturn(array("status"=>0,"id"=>$member["id"]));
		}
		else
		{
			$this->ajaxReturn(array("status"=>1));
		}
	}
}