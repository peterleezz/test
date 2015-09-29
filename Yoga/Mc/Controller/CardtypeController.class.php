<?php
namespace Mc\Controller;
use Common\Controller\BaseController;

class CardtypeController extends \Cashier\Controller\CardtypeController {
public  function indexAction()
	{  
		$clubs = M("Club")->where(array("brand_id"=>get_brand_id()))->field('id,club_name')->select();	 
		$this->assign("clubs",$clubs); 	
		$this->assign("action",U('Mc/Cardtype/getCardtype'))	; 
		// $this->display("Cashier@Cardtype:index");
		$this->display();
	}  
}