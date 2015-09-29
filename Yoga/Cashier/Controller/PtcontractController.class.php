<?php
namespace Cashier\Controller;
use Common\Controller\BaseController;
class PtcontractController extends BaseController {
	public function indexAction()
	{ 
		// $cardtypes=D("CardType")->getAllBrandCardTypes();
		// $this->assign("cardtypes",$cardtypes);
		$this->display();
	}

	public function doPayAction()
	{ 
		$model=D("PtContract");
		$conract_id=I("current_contract_id");
		$contract=$model->find($conract_id);
		$member_id=$contract['member_id'];
		$member=M("MemberBasic")->find($member_id); 
		$recharge=0;
		$price=$contract['should_pay']-$contract['paid'];
		if(I('use_recharge')==1)
		{
			 $recharge=$member['recharge'];
			 $recharge=$recharge>$price?$price:$recharge;
		} 

		$service=\Service\CService::factory("Financial");  
  		$project=$service->getBillProject("1",I("current_contract_id"));
	 	$ret = $service->pay($project['id'],1,is_user_login(),get_brand_id(),I("description"),I("cash"),I("pos"),I("check"),I('check_num'),get_club_id(),$recharge,I("network"),I("netbank"));
		if(!$ret)
	 	{  
	 		$this->error($service->getError());
	 	}  
	 	if(I('use_recharge')==1 && $recharge>0)
		{ 
			M("MemberBasic")->where(array("id"=>$member_id))->setField("recharge",$member['recharge']-$recharge); 
			$data=array("member_id"=>$member_id,"value"=>"-$recharge","record_id"=>is_user_login(),"description"=>"PT收款消费￥{$recharge},余额￥".($member['recharge']-$recharge));			 
			M("RechargeHistory")->data($data)->add(); 
		}   
		$project=$service->getBillProject("1",I("current_contract_id"));

	 	$contract['paid']=$project['paid']; 
	 	$contract['update_time']=getDbTime(); 
  		$contract['description']=I("description"); 
  		$model->data($contract)->save(); 
	 	//cash history
		// $cashHistoryModel=M("CashHistory");
		// $data=array("record_id"=>is_user_login(),"price"=>$paid,"brand_id"=>get_brand_id(),"description"=>I("description"),"object_id"=>$contract_id,"update_time"=>getDbTime(),"club_id"=>get_club_id());
		// $cashHistoryModel->data($data)->add(); 
	    $this->success("收款成功！","/Cashier/Ptcontract/index");
	}

	public function payAction($id)
	{

		$contract = D('PtContract')->relation(true)->find($id);  
		$this->assign("contract",$contract);   
		$this->display();
	}



public function printrecordAction($id)
	{  

		$service=\Service\CService::factory("Financial"); 
		$history=$service->getPayRecord($id);
		$this->assign("history",$history);
		$project=M("BillProject")->find($history["bill_project_id"]);
		$this->assign("bill",$project);
		$contract = M("PtContract")->find($project['object_id']);
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
		if(!empty($contract['pt_id']))
		{
			$mc_id=$contract['pt_id'];
		} 
		if(!empty($mc_id))
		{
			$mc=M("UserExtension")->find($mc_id);
		}
		$this->assign("mc",$mc);

		$class_id=$contract['class_id'];
		$class=M("PtClass")->find($class_id);
		$this->assign("class",$class);

		$this->assign("club",$club);
		$this->assign("print_time",date('Y-m-d H:i:s')); 
		$this->display();
	} 
  
	public function querypayhistoryAction($id)
	{
		list($page,$sidx,$limit,$sord,$start)=getRequestParams(); 
        $service=\Service\CService::factory("Financial"); 
        $result = $service->getPayHistory("1",$id,$start,$limit); 
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

		$contract = D('PtContract')->relation(true)->find($id);  
		$this->assign("contract",$contract);  

		//pasy history
		$service=\Service\CService::factory("Financial");  
		list($history,$count)=$service->getPayHistory("1",$id,0,999);
		$this->assign("history",$history); 

		$club = M("Club")->find(get_club_id());
		$this->assign("club",$club);
		$this->assign("print_time",date('Y-m-d H:i:s')); 
		$this->display();
	}


 

	public function doTransformAction($contract_id,$new_id)
	{
		$memberModel  =M("MemberBasic"); 
		$contractModel = M("PtContract");
		$original_contract=$contract=$contractModel->find($contract_id);  
		$new_member =$memberModel->find($new_id);
		if(empty($new_member))
		{
			$this->error("Can't find this member in your brand's database!");
		}
		if($contract['member_id']==$new_id)
		{
			$this->error("They are the same person,Please Choose another one!");
		} 

		//change the contract  
		$contract['member_id']=$new_id; 
		$contract['invalid']=2;	
		$contractModel->data($contract)->save();  
 		$reason ="PT合同转让";	   
	   if(!empty($reason))
	   { 
	   	  $data=array("original_extension"=>json_encode($original_contract), "extension"=>json_encode($contract),"reason"=>$reason,"record_id"=>is_user_login(),"club_id"=>get_club_id(),"brand_id"=>get_brand_id(),"type"=>1,"status"=>0);
	   	  M("Review")->data($data)->add();
	   }

		$this->success("转PT成功！",U("Cashier/Ptcontract/index"));
	}

	public function transformAction($id)
	{ 
		$contract = D('PtContract')->relation(true)->find($id);  
		$this->assign("contract",$contract);  
		$this->display();
	}
	public function queryAction()
	{
			list($page,$sidx,$limit,$sord,$start)=getRequestParams();
	        $filters=I("filters",'',''); 
	        $brand_id=get_brand_id(); 
	    $club_id=get_club_id(); 
	   $condition=array("club_id"=>$club_id,"pt_id"=>is_user_login());
       $filters = json_decode($filters);   
        if($filters->groupOp=='AND')
        {
            $rules = $filters->rules; 
            foreach ($rules as $key => $value) {  
                  if($value->field=="contract_number")
                {
                    $condition["contract_number"]=$value->data; 
                }

                if($value->field=="card_number")
                {
                	$member_ids=M("Card")->where(array("card_number"=>$value->data))->field("group_concat( distinct member_id) as ids")->find(); 
                	if(!empty($member_ids))
                	{
                		$condition["member_id"]=array("in",$member_ids['ids']);
                	} 
                	else
                	{
                		$response = array("page"=>0,"total"=>0,"records"=>0,"rows"=>"");
         				$this->ajaxReturn($response); 
                	}
                }
                 if($value->field=="name")
                {
                    $member_ids=M("MemberBasic")->where(array("name"=>$value->data))->field("group_concat( distinct id) as ids")->find(); 
                	if(!empty($member_ids))
                	{
                		$condition["member_id"]=array("in",$member_ids['ids']);
                	}
                	else
                	{
                		$response = array("page"=>0,"total"=>0,"records"=>0,"rows"=>"");
         				$this->ajaxReturn($response); 
                	}
                }
                if($value->field=="phone")
                {
                     $member_ids=M("MemberBasic")->where(array("phone"=>$value->data))->field("group_concat( distinct id) as ids")->find(); 
                	if(!empty($member_ids))
                	{
                		$condition["member_id"]=array("in",$member_ids['ids']);
                	}
                	else
                	{
                		$response = array("page"=>0,"total"=>0,"records"=>0,"rows"=>"");
         				$this->ajaxReturn($response); 
                	}
                }
                
            }
        } 
      	$model=D("PtContract"); 
      	$count=$model->where($condition)->count();
      	$ret=$model->relation(true)->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select();
         if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }           

         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
         $this->ajaxReturn($response); 
	} 
}