<?php
namespace Finance\Controller;
use Common\Controller\BaseController;
class PayhistoryController extends BaseController {
	public function indexAction()
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

	public function queryReportAction()
	{ 

		list($page,$sidx,$limit,$sord,$start)=getRequestParams();
		$filters=I("filters",'',''); 
		  $filters = json_decode($filters);   

 			$rules = $filters->rules; 
            foreach ($rules as $key => $value) {  
                  if($value->field=="club_ids")
                {
                    $clubs=$value->data; 
                }
                else   if($value->field=="pay_id")
                {
                    $pay_id=$value->data; 
                }
                else   if($value->field=="type")
                {
                    $type=$value->data; 
                }
                else   if($value->field=="start_time")
                {
                    $start_time=$value->data; 
                }
                  else   if($value->field=="end_time")
                {
                    $end_time=$value->data; 
                }

            }
	 
		switch ($type) {
			case '1': //day
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				$st=$start_time." 00:00:00";
				$et=$start_time." 23:59:59";
			 
				break;
			case '2': //month
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				$st=$start_time."-01 00:00:00";
				$et=$start_time."-31 23:59:59";
			 
				break;
			case '3': //year
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				$st=$start_time."-01-01 00:00:00";
				$et=$start_time."-12-31 23:59:59";
			 
				break;
			case '4': //other
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				if(empty($end_time))
				{
					$this->error("请输入结束时间！");
				} 
				$st=$start_time;
				$et=$end_time; 
				break;
			default:
				# code...
				break;
		}
		$condition=array("club_id"=>array("in",$clubs),"create_time"=>array("between","$st,$et"));

		if(!empty($pay_id))
		{
			$condition=array("id"=>$pay_id);
		}
		$model=D("PayHistory");
		$bill_project=$model->relation(true)->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select(); 
		foreach ($bill_project as $key => $value) {
			$bill_project[$key]['member']=M("MemberBasic")->find($value['bill']['member_id']);
		}
		$count = $model->where($condition)->count(); 
		if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
			} else { 
			  $total_pages = 0; 
			}  
		$response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$bill_project);
		 $this->ajaxReturn($response);   
	}


	 public function del()
    { 
        $id=I("id");
        $model =D("PayHistory");
        $pay_history=$model->relation(true)->find($id);
        $paid=$pay_history['cash']+$pay_history['pos']+$pay_history['check']+$pay_history['recharge']+$pay_history['network']+$pay_history['netbank'];
         
        if($pay_history['bill']['type']==7)
        {
        	$ret=M("MemberBasic")->where(array("id"=>$pay_history['bill']['member_id']))->setDec("recharge",$paid); 
        }
        else
        { 
        	$ret=M("BillProject")->where(array("id"=>$pay_history['bill_project_id']))->setDec("paid",$paid); 
        }

        if($ret==false)
        {
            $response=array("success"=>false,"message"=>"failed!","new_id"=>$id);
            $this->ajaxReturn($response);
        } 
        $ret=$model->delete($id);
        if($ret==false)
        {
            $response=array("success"=>false,"message"=>"failed!","new_id"=>$id);
            $this->ajaxReturn($response);
        } 
        $response=array("success"=>true,"message"=>"success!","new_id"=>$id);

        $reason="删除消费记录"; 
        $pay_history['member']=M("MemberBasic")->find($pay_history['bill']['member_id']);
	   	$data=array("original_extension"=>json_encode($pay_history),"extension"=>json_encode($pay_history),"reason"=>$reason,"record_id"=>is_user_login(),"club_id"=>get_club_id(),"brand_id"=>get_brand_id(),"type"=>3,"status"=>0);
	   	M("Review")->data($data)->add(); 

        $this->ajaxReturn($response);
    }

    protected function edit()
    {
    	$id=I("id");
    	$rules = array( 
    		array('total','/^\d+(\.\d+)?$/','请输入正确的项目总价!',1),
	        array('cash','/^\d+(\.\d+)?$/','请输入正确的现金金额!',1),
	        array('pos','/^\d+(\.\d+)?$/','请输入正确的POS金额!',1),
	        array('check','/^\d+(\.\d+)?$/','请输入正确的支票金额!',1),
	        array('recharge','/^\d+(\.\d+)?$/','请输入正确的储值卡金额!',1),  
		); 
  		$model =D("PayHistory"); 
		if (!$model->validate($rules)->create()){
		    $this->error($model->getError());
		}   

      $projectModel=M("BillProject"); 
      $pay_history=$model->relation(true)->find($id); 
        $pay_history['member']=M("MemberBasic")->find($pay_history['bill']['member_id']);
      $new_pay=$pay_history;
      $new_pay['cash']=I("cash");
      $new_pay['pos']=I("pos");
      $new_pay['check']=I("check");
      $new_pay['recharge']=I("recharge");

       $new_pay['network']=I("network");
        $new_pay['netbank']=I("netbank");
      $new_pay['create_time']=I("create_time");
      $ret=$model->data($new_pay)->save();
      if($ret===false)
      {  
      	 $this->error($model->getError()); 
      }   
      $paid=$pay_history['cash']+$pay_history['pos']+$pay_history['check']+$pay_history['recharge']+$pay_history['network']+$pay_history['netbank'];
 	  $projectModel->where(array("id"=>$pay_history['bill_project_id']))->setField("price",I("total"));
 	  $new_paid=I("cash")+I("pos")+I("check")+I("recharge"); 
 	  $interval=$new_paid-$paid; 

 	  if($pay_history['bill']['type']==7)
        {
        	$ret=M("MemberBasic")->where(array("id"=>$pay_history['bill']['member_id']))->setInc("recharge",$interval); 
        }
        else
        { 
        	$ret=M("BillProject")->where(array("id"=>$pay_history['bill_project_id']))->setInc("paid",$interval); 
        } 

        $reason="修改消费记录"; 
        $new_pay['member']=M("MemberBasic")->find($new_pay['bill']['member_id']); 
        $new_pay['bill']=M("BillProject")->find($pay_history['bill_project_id']);  
	   	$data=array("original_extension"=>json_encode($pay_history),'extension'=>json_encode($new_pay), "reason"=>$reason,"record_id"=>is_user_login(),"club_id"=>get_club_id(),"brand_id"=>get_brand_id(),"type"=>3,"status"=>0);
	   	M("Review")->data($data)->add();  
        $response=array("success"=>true,"message"=>"success!","new_id"=>$id); 
        $this->ajaxReturn($response);

    }
 
}