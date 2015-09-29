<?php
namespace Reception\Controller;
use Common\Controller\BaseController;
class ConsumeController extends BaseController {

	public function indexAction()
	{
		$this->display();
	}

	public function queryAction()
	{
		 $service = \Service\CService::factory("Member"); 
      list($page,$sidx,$limit,$sord,$start)=getRequestParams(); 
      $condition = array("brand_id"=>get_brand_id(),"club_id"=>get_club_id());   
      $filters=I("filters",'','');
    $filters = json_decode($filters);   
    if($filters->groupOp=='AND')
        {
            $rules = $filters->rules;
            $name="";
            $phone="";  
            foreach ($rules as $key => $value) {               
                 if($value->field=="time" && !empty($value->data))
                {
                    $condition["create_time"] =array("like",$value->data."%") ;   
                } else  if($value->field=="status" )
                {
                    $condition["status"] =$value->data;   
                } 
                else if($value->field=="name")
                {  
                   $name=$value->data;   
                }  
                 else if($value->field=="phone")
                {  
                   $phone=$value->data;   
                }  
                 else if($value->field=="contract_number")
                {  
                    $contract=M("Contract")->where(array("contract_number"=>$value->data))->find();
                    if(empty($contract))
                    {
                        $response = array("page"=>0,"total"=>0,"records"=>0,"rows"=>null);
                        $this->ajaxReturn($response); 
                    }
                    $condition["contract_id"]=$contract['id'];
                }  else if($value->field=="card_number")
                {
                    $card=M("Card")->where(array("card_number"=>$value->data))->find();
                     if(empty($card))
                    {
                        $response = array("page"=>0,"total"=>0,"records"=>0,"rows"=>null);
                        $this->ajaxReturn($response); 
                    }
                    $condition["card_id"]=$card['id'];
                }
            }
            if(!empty($name) || !empty($phone))
            {
                $members=$service->getMemberByBrand(get_brand_id(),$name,$phone);
                 if(empty($members))
                    {
                        $response = array("page"=>0,"total"=>0,"records"=>0,"rows"=>null);
                        $this->ajaxReturn($response); 
                    }
                 $ids="";
                 foreach ($members as $k => $v) {
                    if($k!=0)$ids.=",";
                        $ids.=$v['id'];
                  } 
                 $condition["member_id"]=array("in",$ids);
            }
        } 

         $model = D("CheckHistory"); 
         $ret = $model->relation(true)->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select();   
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