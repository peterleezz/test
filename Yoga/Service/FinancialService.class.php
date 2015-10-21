<?php
namespace Service;
class FinancialService extends CService
{
	
	private $billProjectModel; 
	private $payModel; 
	protected static $instance;
	public static function getInstance($name = 'default'){
        if (empty(self::$instance[$name])){
            self::$instance[$name] = new FinancialService($name);
        }
        return self::$instance[$name];

    }

	public function __construct()
	{
		$this->billProjectModel=D("BillProject");
		$this->payModel=D("PayHistory");
	}

	public function addBillProject($type,$sub_type,$object_id,$member_id,$price,$paid,$brand_id,$record_id,$sale_club_id,$mc_id,$description,$discount=100,$extension="")
	{
		$serial_number="{$type}_{$sub_type}_".date("YmdHis").rand(0,10000); 
		$data=array("extension"=>$extension,"discount"=>$discount,"description"=>$description,"serial_number"=>$serial_number,"status"=>0,"type"=>$type,"sub_type"=>$sub_type,"object_id"=>$object_id,"member_id"=>$member_id,"price"=>$price,"paid"=>$paid,"brand_id"=>$brand_id,"record_id"=>$record_id,"sale_club_id"=>$sale_club_id,"mc_id"=>$mc_id);
      if(!$this->billProjectModel->create($data))
		{ 
			$this->setError($this->billProjectModel->getError());
			return false;
		}
		 
		$id = $this->billProjectModel->data($data)->add();		 
		return $id;
	}

	public function pay($bill_id,$type,$record_id,$brand_id,$description,$cash,$pos,$check,$check_num,$club_id,$recharge=0,$network=0,$netbank=0)
	{
		$project=$this->billProjectModel->find($bill_id);
		if(empty($project))
		{
			$this->setError("bill_project_valid");
			return false;
		}
		// if($project['status']==1)
		// {
		// 	$this->setError("bill_project_paid_all");
		// 	return false;
		// }
		if($project['status']==3)
		{
			$this->setError("bill_project_paid_back");
			return false;
		}
		$paid = $project['paid']+$pos+$cash+$check+$recharge+$network+$netbank;
		if($paid>$project['price'])
		{
			$this->setError("pay_too_much");
			return false;
		}

		$data=array("type"=>$type,"bill_project_id"=>$bill_id,"record_id"=>$record_id,"brand_id"=>$brand_id,"description"=>$description,"network"=>$network,"netbank"=>$netbank,"cash"=>$cash,"pos"=>$pos,"check"=>$check,"check_num"=>$check_num,"club_id"=>$club_id,"recharge"=>$recharge);
		if(!$this->payModel->create($data))
		{
			$this->setError($this->payModel->getError());
			return false;
		}
		if($cash+$pos+$check+$recharge+$network+$netbank == 0) return true;
		$id=$this->payModel->data($data)->add(); 
		if(empty($id) || $id===false)
		{
			$this->setError($this->payModel->getError());
			return false;
		}
		if($paid==$project['price'])
		{
			$project['status']=1;
		}
		else 
		{
			$project['status']=$paid==0?0:2;
		}
		$project['paid']=$paid; 
		$project['update_time']=getDbTime(); 
		$this->billProjectModel->save($project);
		return $id;
	}
   
	public function getPayHistory($type,$object_id,$offset,$num)
	{
		$model = M("BillProject");
        $project = $model->where(array("object_id"=>$object_id,"type"=>array("in",$type)))->find(); 
        if(empty($project))
        {
        	$this->setError("bill_project_valid");
			return false;
        }
        $ret=D("PayHistory")->relation(true)->where(array("bill_project_id"=>$project['id']))->order("id desc")->limit("$offset,$num")->select();
 		$count=M("PayHistory")->where(array("bill_project_id"=>$project['id']))->count();
 		return array($ret,$count);
	}

	public function getPayHistoryByBillId($bill_id,$offset,$num)
	{  
        $ret=D("PayHistory")->relation(true)->where(array("bill_project_id"=>array("in",$bill_id)))->order("id desc")->limit("$offset,$num")->select();
 		$count=M("PayHistory")->where(array("bill_project_id"=>array("in",$bill_id)))->count();
 		return array($ret,$count);
	}



	public function getBillProject($type,$object_id)
	{
		$model = M("BillProject");
        $project = $model->where(array("object_id"=>$object_id,"type"=>array("in","$type")))->find(); 
        return $project;
	}

	public function getBillProjects($type,$object_id)
	{
		$model = M("BillProject");
        $project = $model->where(array("object_id"=>$object_id,"type"=>array("in","$type")))->select(); 
        return $project;
	}
	public function getPayRecord($id)
	{
		return D("PayHistory")->find($id);
	}

	public function dopayback($contract_id,$price,$desc,$user_id)
	{
		$paybackmodel=M("PayBack");
		 $ret=$paybackmodel->where(array("contract_id"=>$contract_id))->find(); 
		 if(empty($ret))
		 {
		 	$data=array("update_time"=>getDbTime(),"contract_id"=>$contract_id,"brand_id"=>get_brand_id(),"club_id"=>get_club_id(),"review_id"=>$user_id,"ret"=>1,"pay_back_price"=>$price,"description"=>$desc,"apply_id"=>$user_id);
		 	$paybackmodel->data($data)->add();
		 }
		 else
		 {
		 	$ret['ret']=1;
		 	$ret['pay_back_price']=$price;
		 	$ret['description']=$desc;
		 	$ret['review_id']=$user_id;
		 	$ret['update_time']=getDbTime();
		 	$paybackmodel->data($ret)->save();
		 }

		 M("Contract")->where(array("id"=>$contract_id))->setField(array("invalid"=>0,"status"=>7));

		 $contract =M("Contract")->find($contract_id);
		 $card_id = $contract['card_id'];
		 if(M("Contract")->where(array("card_id"=>$card_id,"invalid"=>1))->count()==0)
		 {
		 	$card = M("Card")->find($card_id);
		 	$card['status']=4;
		 	M("CardDel")->data($card)->add();
		 	M("Card")->delete($card_id);

		 }
		 return true;
	}
	public function disagree($contract_id)
	{
		$paybackmodel=M("PayBack");
		$paybackmodel->where(array("contract_id"=>$contract_id))->setField("ret",2); 
		return true;
	}
}
