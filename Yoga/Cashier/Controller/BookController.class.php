<?php
namespace Cashier\Controller;
use  Common\Controller\BaseController;
class BookController extends BaseController {

	public function indexAction()
	{
		$this->display();
	}

	public function queryMemberAction($name)
	{
		if(empty($name)) $this->ajaxReturn(array("status"=>0,"info"=>"请输入查询信息！"));
		$club_id = get_club_id(); 
		$model=M("MemberBasic"); 
		$condition=array("club_id"=>$club_id,"_complex"=>array("name"=>array("like","%{$name}%"),"phone"=>$name,"_logic"=>"or"));
		$members=$model->where($condition)->select();
        $this->ajaxReturn(array("status"=>1,"data"=>$members));
		 
	}
  
  public function buyAction()
	{ 
		$member_id=I("member_id");
		$member=M("MemberBasic")->find(I("member_id"));
		if(empty($member))
		{
			$this->error("member does not exist");
		} 

		$use_recharge=I("use_recharge");
		
		$rules = array( 
		     array('pos','number','请输入正确的pos金额!',1),    
		     array('cash','number','请输入正确的现金金额!',1),    
		     array('check','number','请输入正确的支票金额!',1),    
		      array('network','number','请输入正确的支票金额!',1),    
		       array('netbank','number','请输入正确的支票金额!',1),    
		);
		 
		$recharge=0;
		if($use_recharge==1)
		{ 
			$recharge=$member['recharge']>I("should_pay")?I("should_pay"):$member['recharge']; 
		}	
		 
		if($use_recharge==1 && $recharge!=0)
		{ 
			M("MemberBasic")->where(array("id"=>$member_id))->setField("recharge",$member['recharge']-$recharge);
			
			$data=array("member_id"=>$member_id,"value"=>"-$recharge","record_id"=>is_user_login(),"description"=>"购定金消费￥{$recharge},余额￥".($member['recharge']-$recharge));			 
			$recharge_id=M("RechargeHistory")->data($data)->add();
		}

		
		$service=\Service\CService::factory("Financial");
		$mc_id = I("type")==8?$member['pt_id']:$member['mc_id'];
	 	$bill_id=$service->addBillProject(I("type"),0,0,$member_id,I("should_pay"),0,get_brand_id(),is_user_login(),get_club_id(),$mc_id,I("description"));
	 	if(!$bill_id)
	 	{  
	 		M("MemberBasic")->where(array("id"=>$member_id))->setField("recharge",$member['recharge']+$recharge);
	 		if(isset($recharge_id))M("RechargeHistory")->delete($recharge_id);
	 		$this->error($service->getError());
	 	}
	 	$ret = $service->pay($bill_id,0,is_user_login(),get_brand_id(),I('description'),I("cash"),I("pos"),I("check"),I("check_num"),get_club_id(),$recharge,I("network"),I("netbank"));
	 	if(!$ret)
	 	{ 
	 		M("MemberBasic")->where(array("id"=>$member_id))->setField("recharge",$member['recharge']+$recharge);
	 		if(isset($recharge_id))M("RechargeHistory")->delete($recharge_id);
	 		M("BillProject")->delete($bill_id);
	 		$this->error($service->getError());
	 	}
	 	if( I("type")==8)
 	    	M("MemberBasic")->where(array("id"=>$member_id))->setInc("pt_book_price", I("should_pay"));
 	    if( I("type")==9)
 			M("MemberBasic")->where(array("id"=>$member_id))->setInc("contract_book_price", I("should_pay"));
	   // if(!empty($reason))
	   // {
	   // 	  $contract = M("PtContract")->find($contract_id);
	   // 	  $data=array("extension"=>json_encode($contract),"reason"=>$reason,"record_id"=>is_user_login(),"club_id"=>get_club_id(),"brand_id"=>get_brand_id(),"type"=>1,"status"=>0);
	   // 	  M("Review")->data($data)->add();
	   // } 
		$this->success("购买成功！",U("Cashier/Book/printreceipts/id/$ret")); 
	} 

	

}