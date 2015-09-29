<?php
namespace Pt\Controller;
use Common\Controller\BaseController;
class MemberController extends BaseController {
  public function indexAction()
  {
    $this->display();
  }
public function queryAction()
  {
      list($page,$sidx,$limit,$sord,$start)=getRequestParams();
          $filters=I("filters",'',''); 
          $brand_id=get_brand_id(); 
      $club_id=get_club_id(); 
     $condition=array("club_id"=>$club_id);
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