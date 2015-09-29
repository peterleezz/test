<?php
namespace Reception\Controller;
use Common\Controller\BaseController;
class PtController extends BaseController {
  public function indexAction()
  {
    $this->display();
  }

  public function consumeprintAction($id)
  {
     
      $contract = D("PtContract")->relation(true)->find($id); 
      $this->assign("contract",$contract);  

      $member_id=$contract['member_id'];
      $cards=D("Card")->getAllCards($member_id);
      if(!empty($cards))
      {
        $card=$cards[count($cards)-1];
        $this->assign("member_number",$card['card_number']);  
      }
      else
      {
         $this->assign("member_number",$member_id);  
      }
      $this->assign("print_time",date('Y-m-d H:i:s')); 

      $history=M("PtConsumeHistory")->where(array("contract_id"=>$contract['id']))->order("id desc")->find();
      $this->assign("history",$history); 

      $count=M("PtConsumeHistory")->where(array("contract_id"=>$contract['id'],"create_time"=>array("gt",date("Y-m-d 00:00:00"))))->count();
      $this->assign("count",$count);

      $pt_id=$history['pt_id'];

      if(!empty($pt_id))
      {
        $pt=M("UserExtension")->find($pt_id); 
        $this->assign("pt",$pt);
      } 
      else
      {
        $this->assign("pt",$contract['pt']);
      } 
     
      $this->display();
  } 

  public function consumestartAction($id)
  {
  	$contract = M("PtContract")->find($id);
  	if(empty($contract))
  	{
  		$this->error("Contract is not exist...");
  	}
  	if($contract['used_num'] >= $contract['total_num'])
  	{
  		$this->error("此课程已经消费完！");
  	}

  	if($contract['invalid'] !=1)
  	{
  		$this->error("合同非正常状态！");
  	}
    if($contract['status']==1)
    {
        $this->error("上课ing！");
        return;
    }

  	 M("PtContract")->where("id=$id")->setField("status",1);
    M("PtContract")->where("id=$id")->setInc("used_num",1);
  	M("PtConsumeHistory")->data(array("member_id"=>$contract['member_id'],"club_id"=>$contract['club_id'],"contract_id"=>$contract['id'],"brand_id"=>$contract['brand_id']))->add();
  	 $this->success("开始上课！");
  }

  public function consumeendAction($id)
  {
    $contract = M("PtContract")->find($id);
    if(empty($contract))
    {
      $this->error("Contract is not exist...");
    }
     
    if($contract['invalid'] !=1)
    {
      $this->error("合同非正常状态！");
    }

     if($contract['status'] !=1)
    {
      $this->error("请先开始上课！");
    } 
    M("PtContract")->where("id=$id")->setField("status",0);
     M("PtConsumeHistory")->where(array("contract_id"=>$id))->order("id desc")->limit(1)->setField("end_time",getDbTime());
     $this->success("消课成功！");
  }


  public function queryAction()
  { 
  	 R("Cashier/Ptcontract/query"); 
  }
}