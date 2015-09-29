<?php
namespace Finance\Controller;
use Common\Controller\BaseController;
class ContractController extends BaseController {
	public function paybackAction()
	{   
		if(is_user_brand())
		{
			$clubs = M("Club")->where(array("brand_id"=>get_brand_id()))->field('id,club_name')->order("id desc")->select();
		}
		else
		{
			$permission=D("FinanceClub")->where(array("user_id"=>is_user_login()))->relation(true)->select();
			$clubs=array();
			foreach ($permission as $key => $value) {
				$clubs[]=$value['club'];
			}
		}
		
		$this->assign("clubs",$clubs);
		$this->display();
	} 

	public function queryPayBackAction()
	{
		$clubs=implode(",", I("club_ids")); 
		list($page,$sidx,$limit,$sord,$start)=getRequestParams();
		$service = \Service\CService::factory("Member"); 
		list($count,$objs)=$service->queryPayBack($clubs,I("start_time"),I("end_time"),$sidx,$limit,$sord,$start); 

		if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
			} else { 
			  $total_pages = 0; 
			} 	
			 
		$response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$objs);
		$this->ajaxReturn($response);
	}

	public function paybackdetailAction($id)
	{
			$service=\Service\CService::factory("Financial");  
		$bill =$service->getBillProject("0,3,4,5",$id); 
		$this->assign("bill",$bill); 
		$contract = D('Contract')->relation('card_type')->find($id); 
		$member_id = $contract['member_id'];
		$member = M('MemberBasic')->find($member_id);
		$this->assign("member",$member);
		$this->assign("contract",$contract); 
 
		$useClubs=D("CardUseclub")->getAllUseClub($contract['card_type']['id']);
		$clubs="";
		
		foreach ($useClubs as $key => $value) {
			if($key!=0)$clubs.="、";
			$clubs.=$value['club_name'];
		}
		$this->assign("useClubs",$clubs);

		//pasy history 
		list($history,$count)=$service->getPayHistoryByBillId($id,0,999);
		$this->assign("history",$history); 
		//all cardtypes that can upgrade to 
		$card_type = $card['card_type'];
		$cardtypes = D("CardType")->getAllCanUpgrade($contract['start_time'],$contract['card_type']['id']);
		$this->assign("typesarr",json_encode($cardtypes));
		$this->assign("cardtypes",$cardtypes);
		$this->assign("current_contract",json_encode($contract));


		$club = M("Club")->find(get_club_id());
		$this->assign("club",$club);
		$this->assign("print_time",date('Y-m-d H:i:s')); 
		$this->display();
	}

	public function dopaybackAction()
	{
		$rules = array(       
	        array('id', "number", "请输入ID！"),  
	         array('price', "require", "请输入正确的价格!"),  
	        array('price','/^\d*(\.\d+)?$/','请输入正确的价格!'),  
   	 	);		
   	 	$model = M("PayBack");
   	 	if(!$model->validate($rules)->create())
   	 	{ 
   	 	    $this->error($model->getError());
   	 	}  
		$service=\Service\CService::factory("Financial");   
		$ret=$service->dopayback(I("id"),I("price"),I("desc"),is_user_login());
		$this->success("退款成功");
	}

	public function disagreeAction() 
	{
		$service=\Service\CService::factory("Financial");   
		$ret=$service->disagree(I("id"));
		$this->success("success");
	}
}