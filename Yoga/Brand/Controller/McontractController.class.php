<?php
namespace Brand\Controller;
use Common\Controller\BaseController;
class McontractController extends BaseController {
	public function indexAction()
	{
		$clubs = D("Club")->getAllClubsName();
		$this->assign("clubs",$clubs);
		$userModel=D("User");
		$mcs=$userModel->getMc();
		$this->assign("mcs",$mcs);
		$cardtypes=D("CardType")->getAllBrandCardTypes();
		$this->assign("cardtypes",$cardtypes);

		$this->display();
	}

	public function queryAction()
	{
		list($page,$sidx,$limit,$sord,$start)=getRequestParams();
	        $filters=I("filters",'',''); 
	        $brand_id=get_brand_id(); 
	    $club_id=get_club_id();
	    $valuesql="select b.*,a.name,a.sex,a.phone ,c.card_number ,d.name as card_name,d.type as card_type ,d.price as card_type_price from yoga_contract b left join yoga_member_basic a on b.member_id=a.id left join yoga_card c on b.card_id=c.id left join yoga_card_type d  on b.card_type_id=d.id where b.brand_id= $brand_id  ";
	    $countsql="select count(*) as count from yoga_contract b left join yoga_member_basic a on b.member_id=a.id left join yoga_card c on b.card_id=c.id left join yoga_card_type d  on b.card_type_id=d.id where  b.brand_id= $brand_id  ";
       $filters = json_decode($filters);  
       $sql="";
        if($filters->groupOp=='AND')
        {
            $rules = $filters->rules; 
            foreach ($rules as $key => $value) {  

            	 if($value->field=="mc_id"&& !empty($value->data))
                {
                    $sql.=" and b.mc_id ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }

            	 if($value->field=="sale_club_id" && !empty($value->data))
                {
                    $sql.=" and b.sale_club_id ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                 if($value->field=="start_time" && !empty($value->data))
                {
                    $sql.=" and b.create_time  ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                 if($value->field=="end_time" && !empty($value->data))
                {
                    $sql.=" and b.create_time  ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }


                 if($value->field=="card_type_id" && !empty($value->data))
                {
                    $sql.=" and b.card_type_id ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }

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
}