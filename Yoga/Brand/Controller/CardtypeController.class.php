<?php
namespace Brand\Controller;
use Common\Controller\BaseController;
class CardtypeController extends BaseController {
	public  function indexAction()
	{  
		$clubs = M("Club")->where(array("brand_id"=>get_brand_id()))->field('id,club_name')->select();	 
		$this->assign("clubs",$clubs); 		 
		$this->display();
	}
  
	public function getCardtypeAction()
	{
			list($page,$sidx,$limit,$sord,$start)=getRequestParams(); 
         $condition = array("brand_id"=>get_brand_id());     
         $filters=I("filters",'','');
      $filters = json_decode($filters);  
      $sql="";
        $setcreate_time=false;
      if($filters->groupOp=='AND')
        {
         $_string="";

         $idfilter=false;
            $rules = $filters->rules; 
            foreach ($rules as $key => $value) {               
                 if($value->field=="category" && $value->data!=-1)
                {
                   $condition["category"] = $value->data;   
                } 
                else if($value->field=="type" && $value->data!=-1)
                {
                    $condition["type"] = $value->data;   
                } 
                else if($value->field=="name" && $value->data!=='')
                {
                    $condition["name"] = array("like","%{$value->data}%");    
                } 
                 else if($value->field=="saleclub" && $value->data!='-1')
                {  
                   if(!empty($_string))
                     $_string.=" and ";
                  $_string.="id in (select card_type_id from yoga_card_saleclub where club_id={$value->data})";
                } 
                 else if($value->field=="useclub" && $value->data!='-1')
                {  
                 if(!empty($_string))
                     $_string.=" and ";
                  $_string.="id in (select card_type_id from yoga_card_useclub where club_id={$value->data})";
                } 
            }
            if(!empty($_string))
            {
               $condition['_string'] = $_string;  
            }
        } 
  
         $model = D("CardType"); 
         $ret = $model->relation(true)->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select();    
         foreach ($ret as $key => $value) {
            if(!empty($value['peak_time']))
            {
               $ret[$key]['peaktime']=M("PeakTime")->where(array("id"=>array("in",$value['peak_time'])))->select();
            }
            else
            {
               $ret[$key]['peaktime']=null;
            }
         }
         $count = $model->where($condition)->count();  
         if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }  
 

         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
         $this->ajaxReturn($response); 
	}
	private function addCardType()
	{
 
   	 	$model = D("CardType");
         if(I("min_price") > I("price"))
         {
            $this->error("最低价格不能高于报价!");
         }
   	 	if(!$model->create())
   	 	{
   	 		$response=array("success"=>false,"message"=>$model->getError());
   	 	    $this->ajaxReturn($response);
   	 	} 
   	 	$id=$model->add();
   	 	 
   	 	$clubs = I("saleclub");

   	 	if(!empty($clubs))
   	 	{
   	 		$model = M("CardSaleclub");
   	 		$clubs = explode(',', $clubs);
   	 		foreach ($clubs as $key => $value) {
   	 			$model->data(array("card_type_id"=>$id,"club_id"=>$value))->add();
   	 		}
   	 	}
   	 	$clubs = I("useclub");
   	 	if(!empty($clubs))
   	 	{
   	 		$model = M("CardUseclub");
   	 		$clubs = explode(',', $clubs);
   	 		foreach ($clubs as $key => $value) {
   	 			$model->data(array("card_type_id"=>$id,"club_id"=>$value))->add();
   	 		}
   	 	}
   	 	$response=array("success"=>true,"message"=>"success!","new_id"=>$id);
   	 	$this->ajaxReturn($response);
	}
	private function editCardType()
	{
		 	 if(I("min_price") > I("price"))
         {
            $this->error("最低价格不能高于报价!");
         }
   	 	$model = D("CardType");
   	 	$id=I("id");
   	 	if(!$model->create())
   	 	{
   	 		$response=array("success"=>false,"message"=>$model->getError());
   	 	    $this->ajaxReturn($response);
   	 	}  
   	 	$model->save();
   	 	$model = M("CardSaleclub");
   	 	$model->where(array("card_type_id"=>$id))->delete();
   	 	$clubs = I("saleclub");
   	 	if(!empty($clubs))
   	 	{   	  
   	 		$clubs = explode(',', $clubs);
   	 		foreach ($clubs as $key => $value) {
   	 			$model->data(array("card_type_id"=>$id,"club_id"=>$value))->add();
   	 		}
   	 	}
   	 	$model = M("CardUseclub");
   	 	$model->where(array("card_type_id"=>$id))->delete();
   	 	$clubs = I("useclub");
   	 	if(!empty($clubs))
   	 	{   	  
   	 		$clubs = explode(',', $clubs);
   	 		foreach ($clubs as $key => $value) {
   	 			$model->data(array("card_type_id"=>$id,"club_id"=>$value))->add();
   	 		}
   	 	} 
   	 	$response=array("success"=>true,"message"=>"success!","new_id"=>$id);
   	 	$this->ajaxReturn($response);
	}
	private function delCardType()
	{ 
		$id=I("id");
   	 	$model = M("CardType");  
   	 	$ret = $model->where(array("brand_id"=>get_brand_id()))->delete($id);
   	 	if(!$ret)
   	 	{
   	 		$response=array("success"=>false,"message"=>"failed!","new_id"=>$id);
   	 		$this->ajaxReturn($response);
   	 	}
   	 	$model = M("CardSaleclub");
   	 	$model->where(array("card_type_id"=>array("in",$id)))->delete();
   	 	$model = M("CardUseclub");
   	 	$model->where(array("card_type_id"=>array("in",$id)))->delete();   	 	
   	 	$response=array("success"=>true,"message"=>"failed!","new_id"=>$id);
   	 	$this->ajaxReturn($response);
	}
	public function setCardTypeAction()
	{
		$oper = I("oper");
		switch ($oper) {
			case 'add':
				$this->addCardType();
				break;
			case 'edit':
				$this->editCardType();
				break;
			case 'del':
				$this->delCardType();
				break;
			default:
				$response=array("success"=>false,"message"=>"unknow operation!","new_id"=>0);
				$this->ajaxReturn($response);
				break;
		}		 
	}	 

   public function queryAction()
   {  
        list($page,$sidx,$limit,$sord,$start)=getRequestParams();
         $brand_id = get_brand_id();
         $condition = array("brand_id"=>$brand_id);    

         $category = I("category"); 
         if($category!=-1 && $category!=='')
         {
            $condition["category"] = $category;  
         }

         $type = I("type"); 
         if($type!=-1 && $type!=='')
         {
            $condition["type"] = $type;   
         } 

         $name = I("name"); 
         if($name!=-1 && $name!=='')
         {
            $condition["name"] = array("like","%$name%");    
         }
         $model = D("CardType");
         $ret = $model->relation(true)->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select();

         $count = $model->where($condition)->count(); 
         $saleclub = I("saleclub"); 
         $useclub = I("useclub"); 
         $result=array();
         if($saleclub!=-1 && $saleclub!=='')
         {
             foreach ($ret as $key => $value) {              
               if(!empty($value['saleclub']))
               {
                     foreach ($value['saleclub'] as $clubobj) {
                        if($clubobj['club_id']==$saleclub)
                        {
                           $result[]=$value;
                           break;
                        }
                     }
               }
               

             }
         }
         else
         {
            $result=$ret;
         }   
         $ret=$result;
          $result=array();
         if($useclub!=-1 && $useclub!=='')
         {
             foreach ($ret as $key => $value) {              
               if(!empty($value['useclub']))
               {
                     foreach ($value['useclub'] as $clubobj) {
                        if($clubobj['club_id']==$useclub)
                        {
                           $result[]=$value;
                           break;
                        }
                     }
               }
               

             }
         }
         else
         {
            $result=$ret;
         }

         $clubs = M("Club")->where(array("brand_id"=>get_brand_id()))->field('id,club_name')->select(); 
	if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }  
         $peaktimes = M("PeakTime")->where(array("brand_id"=>get_brand_id()))->field('id,peak_name')->select(); 
         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$result,"userdata"=>array("clubs"=>$clubs,"peaktimes"=>$peaktimes));
         $this->ajaxReturn($response); 
   }
}
