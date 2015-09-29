<?php
namespace Mc\Controller;
use Common\Controller\BaseController;
use Service\McService;
class ListController extends BaseController {
public  function indexAction()
	{  
		$mcs=D("User")->getMc(); 
		$club_id=get_club_id();
		 $start_time=date("Y-m"); 
		 $ret=array();
		 $followModel=M("McFollowUp");
		foreach ($mcs as $key => $value) {			
		     $st=McService::getInstance()->getUserOneMonthStatistics($value['id'],$start_time); 
		     $v = array("name"=>$value["name_cn"],"protential"=>0,"transform"=>0,"sale"=>0,"invit"=>0);
		     if(!empty($st))
		     {
		     	$v["protential"]=$st[0]['protential_value'];
		     	$v["transform"]=$st[0]['transform_value'];
		     }
		     $v["invit"]=$followModel->where(array("mc_id"=>$value['id'],"ret"=>array("neq",0)))->count();
		     $v["goodssale"]= McService::getInstance()->getThisMonthGoodsSale($value['id']); 
		     $v["cardsale"]=McService::getInstance()->getThisMonthCardsSale($value['id']); 
		     $sale[$key]=$v["goodssale"]+$v["cardsale"];
			 $ret[]=$v;			 
		}
		array_multisort($sale,SORT_DESC,$ret); 
		$this->assign("heroes",$ret);
		 $this->display();
	}  
}