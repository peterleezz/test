<?php
namespace Cashier\Controller;
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
			 $brand_id = get_brand_id();
	        $can_sale_id = D("CardSaleclub")->getCanSaleCards(); 
	        $model = D("CardType");
	        $ids = array();
	        foreach ($can_sale_id as $key => $value) {  
	            $ids[]=$value["id"];
	        } 
	        $useclub = I("useclub");  
	        if(!empty($useclub) && $useclub!=-1)
	        {
	        	$can_use_id = D("CardUseclub")->getCanUseCards($useclub); 
		        $model = D("CardType");
		        $uids =  array();
		        foreach ($can_use_id as $key => $value) {  
		            $uids[]=$value["id"];
		        }
		        $ids = array_intersect($ids,$uids);
	        }
	        $ids = implode(',', $ids);
	         $condition=array("brand_id"=>$brand_id,"id"=>array("in",$ids));

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
 

             $ret= $model->relation(true)->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select();

			$count = 	$model->where($condition)->count();	
 

			if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
			} else { 
			              $total_pages = 0; 
			} 	
			$clubs = M("Club")->where(array("brand_id"=>get_brand_id()))->field('id,club_name')->select(); 
		  $peaktimes = M("PeakTime")->where(array("brand_id"=>get_brand_id()))->field('id,peak_name')->select(); 
			$response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret,"userdata"=>array("clubs"=>$clubs,"peaktimes"=>$peaktimes));
			$this->ajaxReturn($response); 
	}
}