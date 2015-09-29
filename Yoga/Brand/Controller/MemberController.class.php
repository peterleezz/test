<?php
namespace Brand\Controller;
use Common\Controller\BaseController;
class MemberController extends BaseController {
	public  function indexAction()
	{  
		$clubs = M("Club")->where(array("brand_id"=>get_brand_id()))->field('id,club_name')->select();	 
		$this->assign("clubs",$clubs); 		 
		$this->display();
	}
  }