<?php
namespace Cashier\Controller;
use Common\Controller\BaseController;
class RechargeController extends BaseController {
	public function indexAction()
	{ 
		
		$this->display();
	}

    public function querypayhistoryAction($id)
    {
        list($page,$sidx,$limit,$sord,$start)=getRequestParams(); 
        $model = D("RechargeHistory"); 
        $records=$model->relation(true)->where(array("member_id"=>$id))->order("$sidx $sord")->limit("$start,$limit")->select();    
        $count = $model->where(array("member_id"=>$id))->count();  
        list($ret,$count)=$result;
         if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                $total_pages = 0; 
         }           

          $service=\Service\CService::factory("Financial"); 
         foreach ($records as $key => $value) {
             if($value['value'] > 0) //recharge
             { 
               list($history,$count)=$service->getPayHistory("7",$value['id'],0,1);
               $records[$key]['history']=$history[0];
             } 
         }
         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$records);
         $this->ajaxReturn($response); 
    }


	public function printAction($id)
	{ 
		$member = M('MemberBasic')->find($id);
		$this->assign("member",$member); 
		$model = D("RechargeHistory"); 
		$records=$model->relation(true)->where(array("member_id"=>$id))->select();		
        $in=$out=0;
        foreach ($records as $key => $value) {
            if($value['value'] > 0)
            {
                $in+=$value['value'];
            }
            else 
                $out+=$value['value'];
        }
        $this->assign("in",$in);
        $this->assign("out",$out);
		$this->assign("records",$records);
        $this->assign("print_time",date('Y-m-d H:i:s'));
        $club=M("Club")->find($member['club_id']);
        $this->assign("club",$club);    
		$this->display();
	}

	public function rechargeAction($member_id,$cash,$pos,$check,$check_num,$network,$netbank,$discount,$rechargevalue)
	{
		$memberModel=M("MemberBasic");
		$member =$memberModel->find($member_id);
		if(empty($member))
		{
			$this->error("User is not exist！");
		}


        $model = D("RechargeHistory");
        if(!$model->create())
        {
            $this->error($model->getError());
        }
        $model->record_id=is_user_login();
        $model->member_id=$member_id;
        $value=I("cash")+I("check")+I("pos")+I("network")+I("netbank");

        if($value!=$rechargevalue * $discount / 100.0)
        {
            $this->error("充值金额不等于需付金额!");
        }

        $recharge = $member['recharge']+$rechargevalue;
        $model->value=$rechargevalue;

        $model->discount=$discount;
        $model->value_real=$value;

        $model->description="充值￥{$value},折扣{$discount},有效金额{$rechargevalue},余额￥{$recharge}(". I("description").")";
        $id=$model->add(); 


        $service=\Service\CService::factory("Financial"); 
        $bill_id=$service->addBillProject(7,0,$id,$member_id,I("cash")+I("pos")+I("check")+I("network")+I("netbank"),0,get_brand_id(),is_user_login(),get_club_id(),$member['mc_id'],I("description"),$discount);
        if(!$bill_id)
        {  
            $this->error($service->getError());
        }
        $ret = $service->pay($bill_id,0,is_user_login(),get_brand_id(),"充值￥{$value},折扣{$discount},有效金额{$rechargevalue}|". I("description"),I("cash"),I("pos"),I("check"),I('check_num'),get_club_id(),0,I("network"),I("netbank"));
        if(!$ret)
        {  
            M("BillProject")->delete($bill_id);
            $this->error($service->getError());
        } 

		$memberModel->where(array("id"=>$member_id))->setField("recharge",$recharge);

  //       $cashModel = M("CashHistory");
  //       $cashModel->data(array("type"=>3,"cash"=>I("cash"),"check"=>I("check"),"pos"=> I("pos"),"object_id"=>$member_id,"price"=>0,"record_id"=>is_user_login(),"brand_id"=>get_brand_id(),"description"=>I("description"),"check_num"=>I('check_num')))->add();
		$this->ajaxReturn(array("status"=>1,"info"=>"充值成功！","recharge"=>$recharge)) ;
	}
 


 public function rechargeNewAction($member_id,$cash,$pos,$check,$check_num,$network,$netbank,$discount)
    {
        $memberModel=M("MemberBasic");
        $member =$memberModel->find($member_id);
        if(empty($member))
        {
            $this->error("User is not exist！");
        }


        $model = D("RechargeHistory");
        if(!$model->create())
        {
            $this->error($model->getError());
        }
        $model->record_id=is_user_login();
        $model->member_id=$member_id;
        $value=I("cash")+I("check")+I("pos")+I("network")+I("netbank");
 

        $recharge = $member['recharge']+$value;
        $model->value=$value;

        $model->discount=$discount;
        $model->value_real=$value;

        $model->description="充值￥{$value},折扣{$discount},余额￥{$recharge}";
        $id=$model->add(); 


        $service=\Service\CService::factory("Financial"); 
        $bill_id=$service->addBillProject(7,0,$id,$member_id,I("cash")+I("pos")+I("check")+I("network")+I("netbank"),0,get_brand_id(),is_user_login(),get_club_id(),$member['mc_id'],I("description"),$discount);
        if(!$bill_id)
        {  
            $this->error($service->getError());
        }
        $ret = $service->pay($bill_id,0,is_user_login(),get_brand_id(),"充值￥{$value},折扣{$discount},余额￥{$recharge}". I("description"),I("cash"),I("pos"),I("check"),I('check_num'),get_club_id(),0,I("network"),I("netbank"));
        if(!$ret)
        {  
            M("BillProject")->delete($bill_id);
            $this->error($service->getError());
        } 

        $memberModel->where(array("id"=>$member_id))->setField(array("recharge"=>$recharge,"recharge_discount"=>$discount));

  //       $cashModel = M("CashHistory");
  //       $cashModel->data(array("type"=>3,"cash"=>I("cash"),"check"=>I("check"),"pos"=> I("pos"),"object_id"=>$member_id,"price"=>0,"record_id"=>is_user_login(),"brand_id"=>get_brand_id(),"description"=>I("description"),"check_num"=>I('check_num')))->add();
        $this->ajaxReturn(array("status"=>1,"info"=>"充值成功！","recharge"=>$recharge)) ;
    }


 	public function queryAction()
 	{
 		 list($page,$sidx,$limit,$sord,$start)=getRequestParams(); 
         $condition = array("club_id"=>get_club_id(),"is_member"=>1,"recharge"=>array("gt",0));  
         $filters=I("filters",'','');
 		$filters = json_decode($filters);  
 		$sql="";
        $setcreate_time=false;
 		if($filters->groupOp=='AND')
        {
            unset($condition['recharge']);
            $rules = $filters->rules; 
            foreach ($rules as $key => $value) {   
                if($value->field=="name" && !empty($value->data))
                {
                    $condition["name"] = array("like","%{$value->data}%") ;    
                }
                else if($value->field=="phone" && !empty($value->data))
                {
                    $condition["phone"] = $value->data;   
                }

                else  if($value->field=="card_number")
                {
                    $card_number=$value->data;
                     $tmodel=new \Think\Model();
                     $ids=$tmodel->query("select  group_concat( distinct member_id) as ids from yoga_card where card_number='$card_number'");
                      
                     $ids=$ids[0]['ids']; 
                     $condition["id"] =array("in",$ids);   
                }

                
            }
        }  
  
         $model = D("MemberBasic");

         $ret = $model->relation("mc")->relation(true)->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select();   
    
         $count = $model->where($condition)->count();  
         if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }  
         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
         $this->ajaxReturn($response); 


 	}
}
