<?php
namespace Cashier\Controller;
use  Common\Controller\BaseController;
class PtController extends BaseController {

	public function saleAction()
	{
		$ptclasses=D("PtClass")->getAllCanSaleClasses();
		$this->assign("classes",$ptclasses);
		$this->assign("classesarr",json_encode($ptclasses));
		$pts = D("User")->getPt();  
		$this->pts = $pts;
		$this->display();
	}

	public function queryMemberAction($name)
	{
		if(empty($name)) $this->ajaxReturn(array("status"=>0,"info"=>"请输入查询信息！"));
		$club_id = get_club_id(); 
		$model=M("MemberBasic"); 
		// $condition=array("club_id"=>$club_id,"_string"=> "is_member=1 or pt_book_price>0","_complex"=>array("name"=>array("like","%{$name}%"),"phone"=>$name,"_logic"=>"or"));
		$condition=array("club_id"=>$club_id,"_complex"=>array("name"=>array("like","%{$name}%"),"phone"=>$name,"_logic"=>"or"));
		$members=$model->where($condition)->select(); 
		foreach ($members as $key => $value) {
			$cards=D("Card")->getAllCards($value['id'],get_brand_id());
			$arr=array();
			foreach ($cards as $k => $v) {
				$arr[]=$v['card_number'];
			}
			$members[$key]['card_number']=implode(",", $arr);
		}
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
		$class_id=I("class_id");
		$class=M("PtClass")->find($class_id);
		if(empty($class))
		{
			$this->error("class is not exist!");
		}

		$use_recharge=I("use_recharge");
		
		$model = D("PtContract");
		if(!$model->create())
		{
			$this->error($model->getError());
		} 
		$rules = array( 
		     array('pos','number','请输入正确的pos金额!',1),    
		     array('cash','number','请输入正确的现金金额!',1),    
		     array('check','number','请输入正确的支票金额!',1),    
		     array('network','number','请输入正确的网络支付金额!',1),    
		     array('netbank','number','请输入正确的网银分期金额!',1),    
		);
		// $cashHistoryModel=M("CashHistory");
		// if (!$cashHistoryModel->validate($rules)->create()){
		//     $this->error($cashHistoryModel->getError());
		// } 
		
		$paid=I("cash")+I("pos")+I("check")+I("network")+I("netbank");  
		$book_price=0;
		$price=I("should_pay");
		if($member['pt_book_price']!=0)
		{
			$book_price = $price-$paid > $member['pt_book_price']?$member['pt_book_price']:$price-$paid;
			$paid+=$book_price;
		}

		$recharge=0;
		$should_pay=$price-$paid;
		if($use_recharge==1)
		{ 
			$recharge=$member['recharge']>$should_pay?$should_pay:$member['recharge']; 
		}	
		$paid+=$recharge;

		$model->paid=$paid;
		$contract_number = date("YmdHis").rand(0,10000);
		$model->contract_number=$contract_number;
		$model->pt_id=$member['pt_id'];
		$pt_id = I("pt_id");
		if(!empty($pt_id))
		{
			$model->pt_id = $pt_id;
		}

		$start_time=I("start_time");
		$end_time=I("end_time");
		if(empty($start_time))
		{
			$start_time=date('Y-m-d');
		}
		if(empty($end_time))
		{
			$end_time=date('Y-m-d',strtotime("+2 years"));
		}
		 $model->start_time=$start_time;
		  $model->end_time=$end_time;
		$contract_id=$model->add(); 
		if(empty($contract_id))
		{
			$this->error("Error!请检查参数的正确性");
		}
		if($use_recharge==1 && $recharge!=0)
		{ 
			M("MemberBasic")->where(array("id"=>$member_id))->setField("recharge",$member['recharge']-$recharge);
			
			$data=array("member_id"=>$member_id,"value"=>"-$recharge","record_id"=>is_user_login(),"description"=>"购PT消费￥{$recharge},余额￥".($member['recharge']-$recharge));			 
			$recharge_id=M("RechargeHistory")->data($data)->add();
		}

		
		$service=\Service\CService::factory("Financial");

	 	$bill_id=$service->addBillProject(1,0,$contract_id,$member_id,I("should_pay"),0,get_brand_id(),is_user_login(),get_club_id(),$member['pt_id'],I("description"));
	 	if(!$bill_id)
	 	{ 
	 		$model->delete($contract_id);
	 		M("MemberBasic")->where(array("id"=>$member_id))->setField("recharge",$member['recharge']+$recharge);
	 		if(isset($recharge_id))M("RechargeHistory")->delete($recharge_id);
	 		$this->error($service->getError());
	 	}
	 	$ret = $service->pay($bill_id,0,is_user_login(),get_brand_id(),I('description'),I("cash"),I("pos"),I("check"),I("check_num"),get_club_id(),$recharge,I("network"),I("netbank"));
	 	if(!$ret)
	 	{
	 		$model->delete($contract_id);
	 		M("MemberBasic")->where(array("id"=>$member_id))->setField("recharge",$member['recharge']+$recharge);
	 		if(isset($recharge_id))M("RechargeHistory")->delete($recharge_id);
	 		M("BillProject")->delete($bill_id);
	 		$this->error($service->getError());
	 	}

	 	if($book_price!=0)
	 	{
	 		M("MemberBasic")->where(array("id"=>$member_id))->setDec("pt_book_price", $book_price);
	 		$bill_project = M("BillProject")->where(array("member_id"=>$member_id,"type"=>8,"object_id"=>0))->select();
	 		$i=$book_price;
	 		foreach ($bill_project as $key => $value) {
	 			 $i-=$value['paid'];
	 			 M("BillProject")->where("id=".$value['id'])->setField(array("object_id"=>$contract_id));
	 			 if($i <=0)break;
	 		}
	 		 M("BillProject")->where("id=$bill_id")->setInc("paid", $book_price);

	 	}


		// $cashHistoryModel->data(array("type"=>1,"sub_type"=>0,"recharge"=>$recharge,"cash"=>I("cash"),"check"=>I("check"),"pos"=> I("pos"),"object_id"=>$contract_id,"price"=>I("should_pay"),"record_id"=>is_user_login(),"brand_id"=>get_brand_id()))->add();

		$reason ="新增PT合同"; 

	    if($class['price'] * I("total_num")>I("should_pay"))
	   {
	   	 $reason.=";收银过低";
	   }
	   if(!empty($reason))
	   {
	   	  $contract = M("PtContract")->find($contract_id);
	   	  $data=array("extension"=>json_encode($contract),"reason"=>$reason,"record_id"=>is_user_login(),"club_id"=>get_club_id(),"brand_id"=>get_brand_id(),"type"=>1,"status"=>0);
	   	  M("Review")->data($data)->add();
	   } 

	   $cards=D("Card")->getAllCards($member_id,get_brand_id());
	   if(empty($cards))
	   {
	   	$cardModel=D("Card");
	   		$card_number=date("YmdHis").rand(0,10000);
	   		$card=array("free_rest"=>I("free_rest"),"sale_club"=>get_club_id(),"is_active"=>1, "brand_id"=>get_brand_id(),"card_number"=>$card_number,"member_id"=>$member_id);
	 	    $card['update_time']=getDbTime(); 
		 	$card_id=$cardModel->data($card)->add();  
		 	$card_number=get_club_id(). $card_id;
		 	while(true)
		 	{
		 		if($cardModel->isExist($card_number,get_brand_id()))
		 		{
		 			$card_number.=rand(0,100);
		 		}
		 		else
		 		{
		 			break;
		 		}
		 	}
		 	$cardModel->where("id=$card_id")->setField("card_number",$card_number);
		 	$this->success("购买成功！相关卡号为：{$card_number} 请前台烧卡！",U("Cashier/Ptcontract/index"));
	   }
		$this->success("购买成功！您的任意会员卡均可进行私教消费！",U("Cashier/Ptcontract/index"));

	} 
}