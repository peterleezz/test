<?php
namespace Home\Controller;
use Common\Controller\BaseController;
use Service\McNewService;
class McController extends BaseController {  
	 public function queryAction()
	 { 
	 	if(is_user_brand())
	 	{
	 		$response = array("page"=>0,"total"=>0,"records"=>0,"rows"=>null);
		    $this->ajaxReturn($response);   
	 	}
	 	list($page,$sidx,$limit,$sord,$start)=getRequestParams();
	 	$sidx = preg_replace("/classify.*,/", "", $sidx); $sidx = trim($sidx);
	 	$mcs = D("User")->getMc();
	 	$arr = array();
	 	foreach ($mcs as $key => $value) {
	 		$ret = $this->getOne($value['id']); 
	 		if($value['group_id']==0)
	 		{
	 			$ret ['classify']="未分组";
	 		}
	 		else
	 		{
	 			$group = D("McGroup")->find($value['group_id']);
	 			$ret ['classify']=$group['name'];
	 		}
	 		$mcs[$key]=array_merge($value,$ret);
	 	} 
	 	if(empty($sidx) || $sidx=="id"){$sidx="cardsale_all";$sord="desc";}
	 	$function = $sidx."_".$sord;  
	 	$f2 = "f2_".$sidx."_".$sord;
	 	 $mcs=$this->sortarr($mcs,$function,$f2);
	 	 $response = array("page"=>0,"total"=>0,"records"=>0,"rows"=>$mcs);
		 $this->ajaxReturn($response);   
	 }

	 public function sortarr($list,$function,$f2)
	 {
	 	$arr = array();
	 	foreach ($list as $key => $value) {
	 		$arr[$value['classify']][]=$value;
	 	} 
	 	usort($arr,$function);
	 	foreach ($arr as $key => $value) {
	 		usort($value,$f2);
	 		 $arr[$key]=$value;
	 	} 
	 	
	 	$a = array();
	 	foreach ($arr as $key => $value) {
	 		foreach ($value as $v) {
	 			$a[]=$v;
	 		}
	 	}
	 	return $a;
	 }

 
	 public  function getOne($mc_id)
	 {
	 	$club_id = get_club_id();
	 	
	 	//当日潜客
	 	$potential_d=McNewService::getInstance()->getTodayPotentialNumber($mc_id);  
	 	$potential_all = McNewService::getInstance()->getAllPotentialNumber($mc_id);  
	 	//成交额
	 	$cardsale_d =McNewService::getInstance()-> getTodayCardsSale($mc_id); 
	 	$cardsale_all =McNewService::getInstance()-> getAllCardsSale($mc_id);  
	 	return array("potential_d"=>$potential_d,"potential_all"=>$potential_all,"cardsale_d"=>$cardsale_d,"cardsale_all"=>$cardsale_all);
	 }
}