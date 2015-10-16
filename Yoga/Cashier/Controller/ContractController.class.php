<?php
namespace Cashier\Controller;
use Common\Controller\BaseController;
class ContractController extends BaseController {
	public function indexAction()
	{  
		// $cardtypes=D("CardType")->getAllBrandCardTypes();
		// $this->assign("cardtypes",$cardtypes);
		$this->display();
	} 

public function applyPaybackAction($id)
{
	 $paybackmodel=M("PayBack");
	 $ret=$paybackmodel->where(array("contract_id"=>$id))->find();
	if(!empty($ret))
	{
		$this->error("已在申请列表中！");
	}
	 $data=array("contract_id"=>$id,"apply_id"=>is_user_login(),"club_id"=>get_club_id(),"brand_id"=>get_brand_id());
     M("PayBack")->data($data)->add();
      $this->success("申请退款成功,稽核后将有人联系此客户！");
}
	public function printrecordAction($id)
	{  
		$service=\Service\CService::factory("Financial"); 
		$history=$service->getPayRecord($id);
		$this->assign("history",$history);
		$project=M("BillProject")->find($history["bill_project_id"]);
		$this->assign("bill",$project);
		$contract = M("Contract")->find($project['object_id']);
		$this->assign("contract",$contract);
		$club = M("Club")->find(get_club_id());
		$cashier = M("UserExtension")->find($history['record_id']);
		if(empty($cashier))
		{
			$brand = M("Brand")->find($history['brand_id']);
			$this->assign("cashier",$brand['brand_name']);
		}
		else 
		$this->assign("cashier",$cashier['name_cn']);

		$member=M("MemberBasic")->find($contract['member_id']);
		$this->assign("member",$member);
		$mc_id=$member['mc_id'];
		if(!empty($contract['mc_id']))
		{
			$mc_id=$contract['mc_id'];
		} 
		if(!empty($mc_id))
		{
			$mc=M("UserExtension")->find($mc_id);
		}
		$this->assign("mc",$mc);

		$card_type_id=$contract['card_type_id'];
		$card_type=M("CardType")->find($card_type_id);
		$this->assign("card_type",$card_type);
		$this->assign("club",$club);
		$this->assign("print_time",date('Y-m-d H:i:s')); 
		$this->display();
   }







public function continueAction($id)
{  
	    $project=M("BillProject")->find($id); 
  		$this->assign("bill",$project);
		$contract = D('Contract')->relation('card_type')->find($project['object_id']); 
		$member_id = $contract['member_id'];
		$member = M('MemberBasic')->find($member_id);
		$this->assign("member",$member);
		$this->assign("contract",$contract); 
 
		$useClubs=D("CardUseclub")->getAllUseClub($contract['card_type']['id']);
		$clubs="";
		
		// 	$model =M("BrandConfig");
		// $config = $model->where(array("brand_id"=>get_brand_id()))->find();
		// $this->assign("extra",$config['member_fillcard_price']);
		
		$fee = D("Goods")->getXuhuiFee();
		$this->assign("extra",$fee['price']);

		foreach ($useClubs as $key => $value) {
			if($key!=0)$clubs.="、";
			$clubs.=$value['club_name'];
		}
		$this->assign("useClubs",$clubs);

		//all cardtypes that can upgrade to 
		$card_type = $card['card_type'];
		$cardtypes = D("CardSaleclub")->getCanSaleCards(); 
	
		$this->assign("typesarr",json_encode($cardtypes));
		$this->assign("cardtypes",$cardtypes); unset($contract['card_type_extension']);
		unset($contract['card_type_extension']);
		$this->assign("current_contract",json_encode($contract));
		 $mcs= D("User")->getMc();
	    $this->assign("mcs",$mcs);	
		$this->display();
}


	public function upgradeAction($id)
	{ 
		$project=M("BillProject")->find($id); 
  		$this->assign("bill",$project);
		$contract = D('Contract')->relation('card_type')->find($project['object_id']); 

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
			
		$fee = D("Goods")->getShengjiFee();
		$this->assign("extra",$fee['price']);

		$this->assign("useClubs",$clubs);

		//all cardtypes that can upgrade to 
		$card_type = $card['card_type'];
		$cardtypes = D("CardType")->getAllCanUpgrade($contract['start_time'],$contract['card_type']['id']);
		$cardtypes = array_values($cardtypes);
		$this->assign("typesarr",json_encode($cardtypes));
		$this->assign("cardtypes",$cardtypes);
		unset($contract['card_type_extension']);
		$this->assign("current_contract",json_encode($contract));
		 $mcs= D("User")->getMc();
	 $this->assign("mcs",$mcs);	
		$this->display();
	}

	public function payAction($id)
	{
		$service=\Service\CService::factory("Financial");  
  		$project=M("BillProject")->find($id);
  		$this->assign("bill",$project);
		$contract = D('Contract')->relation('card_type')->find($project['object_id']); 
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
		

		//all cardtypes that can upgrade to 
		$card_type = $card['card_type'];
		$cardtypes = D("CardType")->getAllCanUpgrade($contract['start_time'],$contract['card_type']['id']);
		$this->assign("typesarr",json_encode($cardtypes));
		$this->assign("cardtypes",$cardtypes);
		$this->assign("current_contract",json_encode($contract)); 

		$this->display();
	}



	public function doPayAction()
	{
		// $model=M("BillProject");
		// $bill=$model->find(I("bill_id"));
  		$service=\Service\CService::factory("Financial"); 
	 	$ret = $service->pay(I("bill_id"),1,is_user_login(),get_brand_id(),I("description"),I("cash"),I("pos"),I("check"),I('check_num'),get_club_id(),0,I("network"),I("netbank"));
	 	if(!$ret)
	 	{   
	 		$this->error($service->getError());
	 	}   
	   $this->success("收款成功！",U("Cashier/Contract/index"));
	}


	// public function doPayAction()
	// {
	// 	$model=D("Contract");
	// 	$payed=I("cash")+I("check")+I("pos");   
	//  	$cardTypeModel=M("CardType"); 
	//  	$original=$contract = $model->find(I("current_contract_id"));
	//  	if(empty($contract))
	//  	{
	//  		$this->error("contract is not exist!");
	//  	} 
	//  	$contract_id=$contract['id'];
	//  	$should_pay=$contract['should_pay']-$contract['payed'];
	//  	$payed+=$contract['payed'];
	//  	$contract['payed']=$payed; 
	//  	$contract['update_time']=getDbTime(); 
 //  		$contract['description']=I("description"); 
 //  		$model->data($contract)->save();

 //  		$service=\Service\CService::factory("Financial");  
 //  		$projects=$service->getBillProjects("0,4,5",$contract["id"]);
	//  	$ret = $service->payProjects($projects,1,is_user_login(),get_brand_id(),I("description"),I("cash"),I("pos"),I("check"),I('check_num'),get_club_id(),0);
	//  	if(!$ret)
	//  	{ 
	//  		$model->data($original)->save();  
	//  		$this->error($service->getError());
	//  	} 
	//  	//cash history
	//  	// $cashModel = M("CashHistory");
	//  	// $cashModel->data(array("type"=>0,"sub_type"=>1, "cash"=>I("cash"),"check"=>I("check"),"pos"=> I("pos"),"object_id"=>$contract_id,"price"=>$should_pay,"record_id"=>is_user_login(),"brand_id"=>get_brand_id()))->add();
	//    //contract history
	//    M("ContractHistory")->data(array("contract_id"=>$contract_id,"extension"=>json_encode(I("post."))))->add();
	//    $this->success("收款成功！");
	// }

	// public function payAction($id)
	// {

	// 	$contract = D('Contract')->relation('card_type')->find($id); 
	// 	$member_id = $contract['member_id'];
	// 	$member = M('MemberBasic')->find($member_id);
	// 	$this->assign("member",$member);
	// 	$this->assign("contract",$contract); 
 
	// 	$useClubs=D("CardUseclub")->getAllUseClub($contract['card_type']['id']);
	// 	$clubs="";
		
	// 	foreach ($useClubs as $key => $value) {
	// 		if($key!=0)$clubs.="、";
	// 		$clubs.=$value['club_name'];
	// 	}
	// 	$this->assign("useClubs",$clubs);

	// 	//all cardtypes that can upgrade to 
	// 	$card_type = $card['card_type'];
	// 	$cardtypes = D("CardType")->getAllCanUpgrade($contract['start_time'],$contract['card_type']['id']);
	// 	$this->assign("typesarr",json_encode($cardtypes));
	// 	$this->assign("cardtypes",$cardtypes);
	// 	$this->assign("current_contract",json_encode($contract)); 

	// 	$this->display();
	// }

	public function querypayhistoryAction($id)
	{
		list($page,$sidx,$limit,$sord,$start)=getRequestParams(); 
        $service=\Service\CService::factory("Financial"); 
        $bill_project =M("BillProject")->find($id);
        if($bill_project['type']==0 || $bill_project['type']==1 )
        {
        	$book_type = $bill_project['type']==0?9:8;
        	$book_bill_project = M("BillProject")->where(array("object_id"=>$bill_project['object_id'],"type"=>$book_type))->select();
        	if($book_bill_project)
        	{
        		foreach ($book_bill_project as $key => $value) {
        			$id.=",".$value['id'];
        		}
        	}
        }
        $result = $service->getPayHistoryByBillId($id,$start,$limit);
        if($result===false)
        {
        	$this->error($service->getError());
        }
        list($ret,$count)=$result;
         if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                $total_pages = 0; 
         }           

         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
         $this->ajaxReturn($response); 
	}

	public function printAction($id)
	{

		$bill = M("BillProject")->find($id);
		$this->assign("bill",$bill); 
		$contract = D('Contract')->relation('card_type')->find($bill['object_id']);  
		$member_id = $contract['member_id'];
		$member = M('MemberBasic')->find($member_id);
		$card_id=$contract['card_id'];
		$card=M("Card")->find($card_id);
		$this->assign("member",$member);
		$this->assign("card",$card);
		$this->assign("contract",$contract);

		$mc_id=$contract['mc_id'];
		if($mc_id!=0)
		{
			$mc=M("UserExtension")->find($mc_id);
			$mc_name=$mc['name_cn'];
			$this->assign("mc_name",$mc_name);
		} 
 
		$useClubs=D("CardUseclub")->getAllUseClub($contract['card_type']['id']);
		$clubs="";
		
		foreach ($useClubs as $key => $value) {
			if($key!=0)$clubs.="、";
			$clubs.=$value['club_name'];
		}
		$this->assign("useClubs",$clubs);

		//pasy history
		$service=\Service\CService::factory("Financial");  
		list($history,$count)=$service->getPayHistoryByBillId($id,0,999);
		$via=array();
		$via_cash=$via_check=$via_pos=false;
		$cashier_id=$contract['record_id'];
		foreach ($history as $key => $value) {
			 if($value['cash'] > 0 && !$via_cash)
			 {
			 	 $via[]="现金/Cash";
			 	 $via_cash=true;
			 }
			 if($value['check'] > 0 && !$via_check)
			 {
			 	 $via[]="支票/Check";
			 	 $via_cash=true;
			 }
			 if($value['pos'] > 0 && !$via_pos)
			 {
			 	 $via[]="刷卡/Pos";
			 	 $via_cash=true;
			 }
			 $cashier_id=$value['record_id']; 
		}
		$cashier=M("UserExtension")->find($cashier_id);
		$cashier_name=$cashier['name_cn'];
		$this->assign("cashier_name",$cashier_name); 
		$via=implode(",", $via);

		$this->assign("via",$via); 
		$this->assign("history",$history); 
		$this->assign("historycount",count($history)); 
		//all cardtypes that can upgrade to 
		$card_type = $card['card_type'];
		$cardtypes = D("CardType")->getAllCanUpgrade($contract['start_time'],$contract['card_type']['id']);
		$this->assign("typesarr",json_encode($cardtypes));
		$this->assign("cardtypes",$cardtypes);
		$this->assign("current_contract",json_encode($contract));

		$shopkeeper=D("User")->getShopkeeper(); 
		if(!empty($shopkeeper))
		{
			$shopkeeper_name=$shopkeeper[0]['name_cn'];
			$this->assign("shopkeeper_name",$shopkeeper_name);
		}
		
		$club = M("Club")->find(get_club_id());

		$this->assign("club",$club);
		$this->assign("print_time",date('Y-m-d H:i:s')); 

		if($bill['price']==0)
		{
			$title="赠送会籍";
        	$this->assign("title",$title);
        	 $this->assign("cashier",$cashier_name);
        	 $this->assign("print_time",date('Y-m-d H:i:s')); 

       	    $this->display(('Common@Base:print'));
		}
		else
		{
			$new_printer_club = C("new_printer_club");
	        $club_id= get_club_id();
	        if(in_array($club_id, $new_printer_club))
	        {
	            $this->display(('printnew'));
	        }
	        else
	        {
	           $this->display();
	        }

		}
		
	}
 

	// public function printAction($id)
	// {

	// 	$contract = D('Contract')->relation('card_type')->find($id); 
	// 	$member_id = $contract['member_id'];
	// 	$member = M('MemberBasic')->find($member_id);
	// 	$this->assign("member",$member);
	// 	$this->assign("contract",$contract); 
 
	// 	$useClubs=D("CardUseclub")->getAllUseClub($contract['card_type']['id']);
	// 	$clubs="";
		
	// 	foreach ($useClubs as $key => $value) {
	// 		if($key!=0)$clubs.="、";
	// 		$clubs.=$value['club_name'];
	// 	}
	// 	$this->assign("useClubs",$clubs);

	// 	//pasy history
	// 	$service=\Service\CService::factory("Financial");  
	// 	list($history,$count)=$service->getPayHistory("0,4,5",$id,0,999);
	// 	$this->assign("history",$history); 
	// 	//all cardtypes that can upgrade to 
	// 	$card_type = $card['card_type'];
	// 	$cardtypes = D("CardType")->getAllCanUpgrade($contract['start_time'],$contract['card_type']['id']);
	// 	$this->assign("typesarr",json_encode($cardtypes));
	// 	$this->assign("cardtypes",$cardtypes);
	// 	$this->assign("current_contract",json_encode($contract));


	// 	$club = M("Club")->find(get_club_id());
	// 	$this->assign("club",$club);
	// 	$this->assign("print_time",date('Y-m-d H:i:s')); 
	// 	$this->display();
	// }


public function doContinueAction()
	{		

		if(I("end_time")=="0000-00-00")
			$this->error("结束时间为空，程序bug，联系下管理员！");
		$model=D("Contract");
		$current_contract = $model->find(I("current_contract_id"));
		
		$member = M("MemberBasic")->find($current_contract['member_id']);
		$payed=I("cash")+I("check")+I("pos")+I("network")+I("netbank");   
	 	$cardTypeModel=M("CardType");
	 	$cardType=$cardTypeModel->find(I('card_type_id'));
	 	if(empty($cardType))
	 	{
	 		$this->error("卡种不存在!");
	 	}  
	 	$mc_id=I("join_mc_id");
	 	 
	 	 $cn = I("contract_number");
	 	 if(!empty($cn))$contract['contract_number']= $cn; 
	 	 else $contract['contract_number']= date("YmdHis").rand(0,10000); 
	 	$contract['card_type_id']=I('card_type_id');
	 	$contract['card_id']=$current_contract['card_id'];
	 	$contract['member_id']=$current_contract['member_id'];
	 	$contract['mc_id']=$mc_id;
	 	$contract['price']= I("should_pay"); 
	 	$contract['payed']=$payed;
	 	$contract['status']=2;
		$contract['is_review']=1;
	 	$contract['brand_id']=get_brand_id();	 	
	 	$contract['type']=I('type');
	 	$contract['update_time']=getDbTime();
	 	$contract['start_time']=I("start_time");
	 	$contract['end_time']=I("end_time");
	 	$contract['total_num']= $cardType['valid_number']+I("present_num");
	 	$contract['record_id']=is_user_login();
	 	$contract['sale_club_id']=get_club_id();
	 	$contract['present_day']=I("present_day");
	 	$contract['present_num']=I("present_num");
  		$contract['description']=I("description"); 
  		$contract['free_rest']=I("free_rest"); 
  		$contract['free_trans']=I("free_trans")==1 ||I("free_trans")=="true" || I("free_trans")=="on"?1:0 ;
  		$contract['card_type_extension']=json_encode($cardType);
  		$contract_id = $model->data($contract)->add();

  		$service=\Service\CService::factory("Financial"); 
	 	$bill_id=$service->addBillProject(4,0,$contract_id,$current_contract['member_id'],I("should_pay"),0,get_brand_id(),is_user_login(),get_club_id(),$mc_id,I("description"));
	 	if(!$bill_id)
	 	{ 
	 		$model->delete($contract_id);
	 		$this->error($service->getError());
	 	}
	 	$ret = $service->pay($bill_id,0,is_user_login(),get_brand_id(),I("description"),I("cash"),I("pos"),I("check"),I('check_num'),get_club_id(),0,I("network"),I("netbank"));
	 	if(!$ret)
	 	{ 
	 		$model->delete($contract_id);
	 		M("BillProject")->delete($bill_id);
	 		$this->error($service->getError());
	 	}

	 	// $config = M("BrandConfig")->where(array("brand_id"=>get_brand_id()))->find();  
	 	// $extra_bill_id=$service->addBillProject(11,0,$contract_id,$current_contract['member_id'],$config['member_fillcard_price'],0,get_brand_id(),is_user_login(),get_club_id(),$mc_id,I("description"));
	
	 	// if(!$extra_bill_id)
	 	// { 
	 	// 	$model->delete($contract_id);
	 	// 	M("BillProject")->delete($bill_id);
	 	// 	M("PayHistory")->delete($ret);
	 	// 	$this->error($service->getError());
	 	// }

	 	//cash history
	 	// $cashModel = M("CashHistory");
	 	// $cashModel->data(array("type"=>4,"cash"=>I("cash"),"description"=>I("description"),"check_num"=>I('check_num'),"check"=>I("check"),"pos"=> I("pos"),"object_id"=>$contract_id,"price"=> I("should_pay"),"record_id"=>is_user_login(),"brand_id"=>get_brand_id()))->add();
	   //contract history
	   M("ContractHistory")->data(array("contract_id"=>$contract_id,"extension"=>json_encode(I("post."))))->add();
	 
	    //review
	   $reason ="新增续会合同";
	   if($cardType['max_present_num']<I("present_num"))
	   {
	   		$reason.=";续会赠送次数过多";
	   }
	    if($cardType['max_present_day']<I("present_day"))
	   {
	   	 $reason.=";续会赠送天数过多";
	   }
	    if($cardType['price']-$current_contract['payed']>I("price"))
	   {
	   	 $reason.=";续会收银过低";
	   }
	   if(!empty($reason))
	   {
	   	  $contract = M("Contract")->find($contract_id);
	   	  $data=array("extension"=>json_encode($contract),"reason"=>$reason,"record_id"=>is_user_login(),"club_id"=>get_club_id(),"brand_id"=>get_brand_id(),"type"=>0,"status"=>0);
	   	  M("Review")->data($data)->add();
	   }
	 
	   M("MemberBasic")->where(array("id"=>$member['id']))->setField(array("type"=>1,"maybuy"=>0,"hopeprice"=>0,"mc_id"=>$mc_id)); 
	  	$fee=D("Goods")->getXuhuiFee();
	   $this->success("续会成功，请缴纳续会手续费！",U("Bar/Goods/index",array("member_id"=>$member['id'],"id"=>$fee['id'])));
	}


	public function doUpgradeAction()
	{
		if(I("end_time")=="0000-00-00")
			$this->error("结束时间为空，程序bug，联系下管理员！");
		 $mc_id=I("join_mc_id");
		$model=D("Contract");
		$payed=I("cash")+I("check")+I("pos")+I("network")+I("netbank");   
	 	$cardTypeModel=M("CardType");
	 	$cardType=$cardTypeModel->find(I('card_type_id'));
	 	if(empty($cardType))
	 	{
	 		$this->error("卡种不存在!");
	 	}  
	 	$originalcontract=$contract = $model->find(I("current_contract_id"));
	 	if(empty($contract))
	 	{
	 		$this->error("original contract is not exist!");
	 	}
	 	unset($contract['id']);

	 	$cn = I("contract_number");
	 	if(!empty($cn))$contract['contract_number']= $cn; 
	 	else $contract['contract_number']= date("YmdHis").rand(0,10000);  
	 	$contract['card_type_id']=I('card_type_id');
	 	$contract['price']= $contract['price']+I("should_pay");
	 	$payed+=$contract['payed'];
	 	$contract['payed']=$payed;
	 	$contract['status']=3;
	 	$contract['update_time']=getDbTime();
	 	$contract['end_time']=I("end_time");
	 	$contract['total_num']= $cardType['valid_number']+I("present_num");
	 	$contract['record_id']=is_user_login();
	 	$contract['sale_club_id']=get_club_id();
	 	$contract['present_day']=I("present_day");
	 	$contract['present_num']=I("present_num");
  		$contract['description']=I("description"); 
  		$contract['mc_id']=$mc_id;
  		$contract['free_rest']=I("free_rest"); 
  		$contract['free_trans']=I("free_trans")==1 ||I("free_trans")=="true" || I("free_trans")=="on"?1:0 ;
  		$contract['card_type_extension']=json_encode($cardType);
  		$contract_id=$model->data($contract)->add();
	 	//cash history
	 	// $cashModel = M("CashHistory");
	 	// $cashModel->data(array("type"=>5,"cash"=>I("cash"),"description"=>I("description"),"check_num"=>I('check_num'),"check"=>I("check"),"pos"=> I("pos"),"object_id"=>$contract_id,"price"=> I("should_pay"),"record_id"=>is_user_login(),"brand_id"=>get_brand_id()))->add();
	   
	    $member=M("MemberBasic")->find($contract['member_id']);
	  	$service=\Service\CService::factory("Financial"); 
	 	$bill_id=$service->addBillProject(5,0,$contract_id,$contract['member_id'],I("should_pay"),0,get_brand_id(),is_user_login(),get_club_id(),$mc_id,I("description"));
	 	if(!$bill_id)
	 	{ 
	 		$model->delete($contract_id);
	 		$this->error($service->getError());
	 	}
	 	$ret = $service->pay($bill_id,0,is_user_login(),get_brand_id(),I("description"),I("cash"),I("pos"),I("check"),I('check_num'),get_club_id(),0,I("network"),I("netbank"));
	 	if(!$ret)
	 	{ 
	 		M("BillProject")->delete($bill_id);
	 		$model->delete($contract_id);
	 		$this->error($service->getError());
	 	} 

	  //   $config = M("BrandConfig")->where(array("brand_id"=>get_brand_id()))->find(); 
	 	// $extra_bill_id=$service->addBillProject(12,0,$contract_id,$current_contract['member_id'],$config['member_upgrade_price'],0,get_brand_id(),is_user_login(),get_club_id(),$mc_id,I("description"));
	 	// if(!$extra_bill_id)
	 	// { 
	 	// 	$model->delete($contract_id);
	 	// 	M("BillProject")->delete($bill_id);
	 	// 	M("PayHistory")->delete($ret);
	 	// 	$this->error($service->getError());
	 	// }

	 	$model->where(array("id"=>$originalcontract['id']))->setField(array("status"=>5,"is_review"=>2,"invalid"=>0));

	  //   $service=\Service\CService::factory("Financial"); 
	  //   $originalproject=$project=$service->getBillProject("0,4,5",$contract_id);
	  //   $project['type']=5;
	  //   $project['price']=I("should_pay");
	  //   $project['paid']=$payed;
	  //   $project['sale_club_id']=get_club_id();
	  //   M("BillProject")->data($project)->save();
	 	// $ret = $service->pay($project["id"],0,is_user_login(),get_brand_id(),I("description"),I("cash"),I("pos"),I("check"),I('check_num'),get_club_id(),0);
	 	// if(!$ret)
	 	// { 
	 	// 	$model->data($originalcontract)->save();
	 	// 	M("BillProject")->data($originalproject)->save(); 
	 	// 	$this->error($service->getError());
	 	// }  
	   //contract history
	   M("ContractHistory")->data(array("contract_id"=>$contract_id,"extension"=>json_encode(I("post."))))->add();

	    $reason ="新增升级合同";
	   if($cardType['max_present_num']<I("present_num"))
	   {
	   		$reason.=";升级赠送次数过多";
	   }
	    if($cardType['max_present_day']<I("present_day"))
	   {
	   	 $reason.=";升级赠送天数过多";
	   }
	    if($cardType['price']>I("should_pay"))
	   {
	   	 $reason.=";升级收银过低";
	   }
	   if(!empty($reason))
	   { 
	   	  $data=array("original_extension"=>json_encode($originalcontract),"extension"=>json_encode($contract),"reason"=>$reason,"record_id"=>is_user_login(),"club_id"=>get_club_id(),"brand_id"=>get_brand_id(),"type"=>0,"status"=>0);
	   	  M("Review")->data($data)->add();
	   }
	 	M("MemberBasic")->where(array("id"=>$$member['id']))->setField(array("type"=>1,"maybuy"=>0,"hopeprice"=>0,"mc_id"=>$mc_id)); 
	  	$fee=D("Goods")->getShengjiFee();
	   $this->success("升级成功，请缴纳续会手续费！",U("Bar/Goods/index",array("member_id"=>$member['id'],"id"=>$fee['id'])));
 
	}



	public function doTransformAction($owner_id,$contract_id,$new_id,$new_card_number)
	{
		$memberModel  =M("MemberBasic");
		$cardModel=M("Card");
		$contractModel = M("Contract");
		$originalcontract=$contract=$contractModel->find($contract_id);

		$is_active=1;
		if($contract['active_type']==2 && $contract['start_time']=='0000-00-00')
		{
			$is_active=0;
		}
		$new_member =$memberModel->find($new_id);
		if(empty($new_member))
		{
			$this->error("Can't find this member in your brand's database!");
		}
		if($contract['member_id']!=$owner_id)
		{
			$this->error("This contract  not belongs to the owner!");
		}
		if($contract['invalid']!=1)
		{
			$this->error("合同无效，不能转让！");
		}
		$member=M("MemberBasic")->find($owner_id);  
		$service=\Service\CService::factory("Financial");

		// $model =M("BrandConfig");
		// $config = $model->where(array("brand_id"=>get_brand_id()))->find(); 
		$fee = D("Goods")->getZhuanrangFee();


		$bill_project=$service->getBillProject("0,3,4,5",$contract_id); 
		$bill_project['member_id']=$new_id;  
		$bill_project['type']=3; 
		unset($bill_project['id']);
		M("BillProject")->data($bill_project)->add();

		$contract['member_id']=$new_id; 
		$contract_number = date("YmdHis").rand(0,10000);
		$contract['contract_number']=$contract_number;
		$contract['free_trans']=$contract['free_trans']>1?$contract['free_trans']-1:0;
		unset($contract['id']);
		M("Contract")->data($contract)->add(); 
		if($contract['free_trans']==0)
		{ 
			 $config = $model->where(array("brand_id"=>get_brand_id()))->find(); 
		 	$extra_bill_id=$service->addBillProject(13,0,$contract_id,$current_contract['member_id'],$config['member_upgrade_price'],0,get_brand_id(),is_user_login(),get_club_id(),$mc_id,I("description"));
		 	if(!$extra_bill_id)
		 	{ 
		 		$model->delete($contract_id);
		 		M("BillProject")->delete($bill_id);
		 		M("PayHistory")->delete($ret);
		 		$this->error($service->getError());
		 	}
		} 

		M("BillProject")->data($bill_project)->save();
		if(!empty($new_card_number))
		{
			$newCard=$cardModel->where(array("card_number"=>$new_card_number,"brand_id"=>get_brand_id()))->find();
			if(!empty($newCard))
			{
				if($newCard['member_id']!=$new_id)
				{
					$this->error("此卡号已存在，请重新输入");
				}
				else
				{
					$new_card_id=$newCard['id'];
				}
			}
			else
			{
				//create a card with card_number
				$card=array("sale_club"=>get_club_id(), "is_active"=>$is_active, "brand_id"=>get_brand_id(),"card_number"=>$new_card_number,"member_id"=>$new_id,"update_time"=>getDbTime());
				$new_card_id=$cardModel->data($card)->add(); 
			}
		}
		else
		{
			$card=array("is_active"=>$is_active, "brand_id"=>get_brand_id(),"card_number"=>'',"member_id"=>$new_id,"update_time"=>getDbTime());
			$new_card_id=$cardModel->data($card)->add(); 
			$cardModel->where(array("id"=>$new_card_id))->setField("card_number",$new_card_id);
		}

		//change the contract  
		$contract['member_id']=$new_id;
		$contract['card_id']=$new_card_id;
		$contract['status']=4;	
		$contractModel->data($contract)->save();
 		M("ContractHistory")->data(array("contract_id"=>$contract_id,"extension"=>json_encode(I("post."))))->add();

 		$reason ="合同转让";	   
	   if(!empty($reason))
	   { 
	   	  $data=array("original_extension"=>json_encode($originalcontract), "extension"=>json_encode($contract),"reason"=>$reason,"record_id"=>is_user_login(),"club_id"=>get_club_id(),"brand_id"=>get_brand_id(),"type"=>0,"status"=>0);
	   	  M("Review")->data($data)->add();
	   }

	   M("MemberBasic")->where("id=$new_id")->setField(array("is_member"=>1,"join_time"=>getDbTime()));
		$this->success("转卡成功！",U("Cashier/Contract/index"));
	}

	public function transformAction($id)
	{ 
		$contract = D('Contract')->relation('card_type')->find($id); 
		$member_id = $contract['member_id'];
		$member = M('MemberBasic')->find($member_id);
		$this->assign("member",$member);
		$this->assign("contract",$contract); 

		$fee=D("Goods")->getZhuanrangFee();
		$this->assign("extra",$fee['price']);
		// $model =M("BrandConfig");
		// $config = $model->where(array("brand_id"=>get_brand_id()))->find();
		// $this->assign("extra",$config['member_trans_price']);
		

		// $useClubs=D("CardUseclub")->getAllUseClub($card['card_type']['id']);
		// $clubs="";
		
		// foreach ($useClubs as $key => $value) {
		// 	if($key!=0)$clubs.="、";
		// 	$clubs.=$value['club_name'];
		// }
		// $this->assign("useClubs",$clubs);
		// $contracts = D("Contract")->getAllValidContract($id);
		// $this->assign("contracts",$contracts); 
		$this->display();
	}
 
public function  doshoufeiAction()
{ 
		$paid=I("cash")+I("check")+I("pos")+I("network")+I("netbank");   
		$id=I("id");
	 	$bill_project=M("BillProject")->find($id);
	 	if($paid!=$bill_project['price']) 
	 	{
	 		$this->error("所付金额不够，请重新支付！!");
	 	}  
	 	$service=\Service\CService::factory("Financial"); 
	 	$ret = $service->pay($id,0,is_user_login(),get_brand_id(),I("description"),I("cash"),I("pos"),I("check"),I('check_num'),get_club_id(),0,I("network"),I("netbank"));
	 	if(!$ret)
	 	{   
	 		$this->error($service->getError());
	 	}   
	   $this->success("收款成功！",U("Cashier/Contract/index"));  
}
 public function shoufeiAction($id)
	{ 
		$bill_project =M("BillProject")->find($id); 
		if($bill_project['type']==14)
			$ids=$bill_project['extension'];
		else
			$ids=$bill_project['object_id'];
		$contracts=M("Contract")->where(array("id"=>array("in",$ids)))->select();
		foreach ($contracts as $key => $value) {
			$contracts[$key]['c']=json_decode($contracts[$key]['card_type_extension'],true);
		}
		$card=M("Card")->find($contracts[0]['card_id']);
		$this->assign("card",$card);
		$member_id = $bill_project['member_id'];
		$member = M('MemberBasic')->find($member_id);
		$this->assign("member",$member);
		$this->assign("contracts",$contracts);  
		$this->assign("id",$id);  
		$this->assign("project",$bill_project); 
		switch ($bill_project['type']) {
			case '11':
				$title="续会手续费";
				break;
				case '12':
				$title="升级手续费";
				break;
				case '13':
				$title="转让手续费";
				break;
				case '14':
				$title="停卡手续费";
				break; 
			default: 
				$title="手续费";
				break;
		}
		$this->assign("title",$title); 
		$this->display();
	}

	public function queryNewAction()
	{
			list($page,$sidx,$limit,$sord,$start)=getRequestParams();
	        $filters=I("filters",'',''); 
	        $brand_id=get_brand_id(); 
	    $club_id=get_club_id();
	    if(!is_user_brand())
	    {
	    	  $valuesql="select  b.status as bstatus, b.card_type_extension, b.free_rest,b.free_trans,b.rest_count,b.trans_count, b.is_review,b.description as `desc`, b.id as contract_id,b.contract_number, a.*,e.name,e.sex,e.phone ,c.card_number ,d.name as card_name,d.type as card_type ,d.price as card_type_price,b.invalid,b.type as btype,b.present_day,b.present_num,b.start_time,b.end_time,b.active_type,b.used_num,b.total_num   from yoga_bill_project a inner join yoga_contract b on a.object_id=b.id and a.type in(0,3,4,5) inner join yoga_member_basic e on a.member_id=e.id left join yoga_card c on b.card_id=c.id left join yoga_card_type d on b.card_type_id=d.id where  a.sale_club_id=$club_id  ";
	    	$countsql="select count(*) as count from yoga_bill_project a inner join yoga_contract b on a.object_id=b.id and a.type in(0,4,5) inner join yoga_member_basic e on a.member_id=e.id left join yoga_card c on b.card_id=c.id left join yoga_card_type d on b.card_type_id=d.id where  a.sale_club_id=$club_id ";
        }
        else
        {
        	 $valuesql="select  b.status as bstatus,b.card_type_extension,b.free_rest,b.free_trans,b.rest_count,b.trans_count,b.is_review,b.description as `desc`, b.id as contract_id,b.contract_number, a.*,e.name,e.sex,e.phone ,c.card_number ,d.name as card_name,d.type as card_type ,d.price as card_type_price,b.invalid,b.type as btype,b.present_day,b.present_num,b.start_time,b.end_time,b.active_type,b.used_num,b.total_num   from yoga_bill_project a inner join yoga_contract b on a.object_id=b.id and a.type in(0,3,4,5) inner join yoga_member_basic e on a.member_id=e.id left join yoga_card c on b.card_id=c.id left join yoga_card_type d on b.card_type_id=d.id where  a.brand_id=$brand_id  ";
	    	$countsql="select count(*) as count from yoga_bill_project a inner join yoga_contract b on a.object_id=b.id and a.type in(0,4,5) inner join yoga_member_basic e on a.member_id=e.id left join yoga_card c on b.card_id=c.id left join yoga_card_type d on b.card_type_id=d.id where  a.brand_id=$brand_id ";

        }
	   $filters = json_decode($filters);  
       $sql="";
        if($filters->groupOp=='AND')
        {
            $rules = $filters->rules; 
            foreach ($rules as $key => $value) {  
                  if($value->field=="contract_number")
                {
                    $sql.=" and b.contract_number ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }

                 if($value->field=="card_number")
                {
                    $sql.=" and c.card_number ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                 if($value->field=="name")
                {
                    $sql.=" and e.name ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                if($value->field=="phone")
                {
                    $sql.=" and e.phone ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                
            }
        }  
        // $tail="  and a.id=b.member_id and b.brand_id=$brand_id  and b.contract_type=0 and b.card_id=c.id and b.card_type_id=d.id";
  		$tail ="";
  		$model = new \Think\Model();
        $countsql=$countsql." ".$sql.$tail;
        $count=$model->query($countsql);
        $count=$count[0]["count"];
        $valuesql = $valuesql." ".$sql.$tail." order by $sidx $sord limit $start,$limit"; 
         $ret =$model->query($valuesql); 
         foreach ($ret as $key => $value) {
         	 $mc = M("UserExtension")->find($value['mc_id']);
         	 $recorder = M("UserExtension")->find($value['record_id']);
         	 $ret[$key]['mc_name']=!empty($mc)?$mc['name_cn']:"NO MC!";
         	 $ret[$key]['recorder_name']=!empty($recorder)?$recorder['name_cn']:"品牌帐号"; 
         }
         if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }       
         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
         $this->ajaxReturn($response); 
	}


	public function queryAction()
	{
			list($page,$sidx,$limit,$sord,$start)=getRequestParams();
	        $filters=I("filters",'',''); 
	        $brand_id=get_brand_id(); 
	    $club_id=get_club_id();
	    $valuesql="select b.*,a.name,a.sex,a.phone ,c.card_number ,d.name as card_name,d.type as card_type ,d.price as card_type_price from yoga_contract b left join yoga_member_basic a on b.member_id=a.id left join yoga_card c on b.card_id=c.id left join yoga_card_type d  on b.card_type_id=d.id where  b.sale_club_id=$club_id  ";
	    $countsql="select count(*) as count from yoga_contract b left join yoga_member_basic a on b.member_id=a.id left join yoga_card c on b.card_id=c.id left join yoga_card_type d  on b.card_type_id=d.id where  b.sale_club_id=$club_id  ";
       $filters = json_decode($filters);  
       $sql="";
        if($filters->groupOp=='AND')
        {
            $rules = $filters->rules; 
            foreach ($rules as $key => $value) {  
                  if($value->field=="contract_number")
                {
                    $sql.=" and b.contract_number ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }

                 if($value->field=="card_number")
                {
                    $sql.=" and c.card_number ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                 if($value->field=="name")
                {
                    $sql.=" and a.name ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                if($value->field=="phone")
                {
                    $sql.=" and a.phone ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                
            }
        } 
        // $tail="  and a.id=b.member_id and b.brand_id=$brand_id  and b.contract_type=0 and b.card_id=c.id and b.card_type_id=d.id";
  		$tail ="";
  		$model = new \Think\Model();
        $countsql=$countsql." ".$sql.$tail;
        $count=$model->query($countsql);
        $count=$count[0]["count"];
        $valuesql = $valuesql." ".$sql.$tail." order by $sidx $sord limit $start,$limit";

         $ret =$model->query($valuesql); 
         foreach ($ret as $key => $value) {
         	 $mc = M("UserExtension")->find($value['mc_id']);
         	 $recorder = M("UserExtension")->find($value['record_id']);
         	 $ret[$key]['mc_name']=!empty($mc)?$mc['name_cn']:"NO MC!";
         	 $ret[$key]['recorder_name']=!empty($recorder)?$recorder['name_cn']:"品牌帐号"; 
         }
         if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }           

         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
         $this->ajaxReturn($response); 
	}


	//query all the contract for this member card
	public function querycontractAction($id)
	{
		list($page,$sidx,$limit,$sord,$start)=getRequestParams();
		$model = M("Contract");
		$ret = $model->where(array("card_id"=>$id))->order("$sidx $sord")->limit("$start,$limit")->select();
		foreach ($ret as $key => $value) { 
               $card_type=M("CardType")->find($value['card_type_id']);$ret[$key]['card_type']=$card_type; 
            }

		$count=$model->where(array("card_id"=>$id))->count(); 
		 
			$count = 	$model->where($condition)->count();	
			if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
			} else { 
			              $total_pages = 0; 
			} 	
		 
		  $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
         $this->ajaxReturn($response); 
 
	}

	public function checkinAction($id)
	{	
			$bill = M("BillProject")->find($id); 
			$contract=M("Contract")->find($bill['object_id']);
			$card=M("Card")->find($contract['card_id']);
			$service=\Service\CService::factory("Api");  
			list($status,$member)= $service->in($card['card_number'],get_club_id());
			if($status!=0)
			{
				$this->error($service->getError());
			}
			$this->success("ok");
	}
	public function checkoutAction($id)
	{
			$bill = M("BillProject")->find($id); 
			$contract=M("Contract")->find($bill['object_id']);
			$card=M("Card")->find($contract['card_id']);
			$service=\Service\CService::factory("Api");  
			list($status,$member)= $service->out($card['card_number'],get_club_id());
			if($status!=0)
			{
				$this->error($service->getError());
			}
			$this->success("ok");
	}
}
