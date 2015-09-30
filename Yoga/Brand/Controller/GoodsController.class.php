<?php
namespace Brand\Controller;
use Common\Controller\BaseController;
class GoodsController extends BaseController {
	public  function indexAction()
	{  
		$clubs = M("Club")->where(array("brand_id"=>get_brand_id()))->field('id,club_name')->select();
		$categories = M("GoodsCategory")->where(array("brand_id"=>get_brand_id()))->field('id,name')->select();
		$this->assign("clubarray",$clubs); 
		$this->assign("categories",$categories); 
		$this->display();
	}

	private function addGoodsCategory()
	{

		$rules = array(       
	        array('name', "require", "请输入分类名！",1),  
	        array('property', 'require', "请选择分类属性！", 1),  
	        array('type', 'require', "请选择商品类型！",1),         
   	 	);		
   	 	$model = M("GoodsCategory");
   	 	if(!$model->validate($rules)->create())
   	 	{
   	 		$response=array("success"=>false,"message"=>$model->getError(),"new_id"=>$id);
   	 	    $this->ajaxReturn($response);
   	 	}
   	 	$model->brand_id=get_brand_id();
   	 	unset($model->id);
   	 	$id=$model->add();
   	 
   	 	$response=array("success"=>true,"message"=>"success!","new_id"=>$id);
   	 	$this->ajaxReturn($response);
	}
	private function editGoodsCategory()
	{
		$rules = array(       
	        array('name', "/[\\S]+/", "请输入分类名！",0,"regex"),   
   	 	);		
   	 	$model = D("GoodsCategory");
   	 	$id=I("id");
   	 	$category = $model->find($id);
   	 	if($category['is_system']==1) 
   	 	{
   	 		$response=array("success"=>false,"message"=>"系统分类不能修改！","new_id"=>$id);
   	 	    $this->ajaxReturn($response);
   	 	}
   	 	if(!$model->validate($rules)->create())
   	 	{
   	 		$response=array("success"=>false,"message"=>$model->getError(),"new_id"=>$id);
   	 	    $this->ajaxReturn($response);
   	 	} 
   	 	$model->save();
   	 	$response=array("success"=>true,"message"=>"success!","new_id"=>$id);
   	 	$this->ajaxReturn($response);
	}
	private function delGoodsCategory()
	{ 
		$id=I("id");
   	 	$model = M("GoodsCategory"); 
   	 	$category = $model->find($id);
   	 	if($category['is_system']==1) 
   	 	{
   	 		$response=array("success"=>false,"message"=>"系统分类不能修改！","new_id"=>$id);
   	 	    $this->ajaxReturn($response);
   	 	}
   	 	   	 	
   	 	$model->where(array("brand_id"=>get_brand_id()))->delete($id);
   	 	$response=array("success"=>true,"message"=>"success!","new_id"=>$id);
   	 	$this->ajaxReturn($response);
	}
	public function setGoodsCategoryAction()
	{
		$oper = I("oper");
		switch ($oper) {
			case 'add':
				$this->addGoodsCategory();
				break;
			case 'edit':
				$this->editGoodsCategory();
				break;
			case 'del':
				$this->delGoodsCategory();
				break;
			default:
				$response=array("success"=>false,"message"=>"unknow operation!","new_id"=>0);
				$this->ajaxReturn($response);
				break;
		}		 
	}
	public function getGoodsCategoryAction()
	{
			$page = I("page");
 			$page = empty($page )?0:$page ;
 			$sidx = I("sidx");
 			$sidx = empty($sidx )?"id":$sidx ;
 			$limit = I("rows");
 			$limit = empty($limit )?0:$limit ;
 			$sord = I("sord");
 			$sord = empty($sord )?"desc":$sord ; 	
 			$totalrows = I("totalrows");  
			if(!empty($totalrows)) {
				$limit = $totalrows;
			}
 			$start = $limit*$page - $limit; 			

			$model = M("GoodsCategory");
			$brand_id = get_brand_id();
			$condition = array("brand_id"=>$brand_id);	 
			$goods = $model->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select();	
			$count = 	$model->where($condition)->count();	
			if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
			} else { 
			              $total_pages = 0; 
			} 	
			$response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$goods);
			$this->ajaxReturn($response); 
	}


	//goods
	public function getGoodsAction()
	{
			$page = I("page");
 			$page = empty($page )?0:$page ;
 			$sidx = I("sidx");
 			$sidx = empty($sidx )?"id":$sidx ;
 			$limit = I("rows");
 			$limit = empty($limit )?0:$limit ;
 			$sord = I("sord");
 			$sord = empty($sord )?"desc":$sord ; 	
 			$start = $limit*$page - $limit; 
			$model = D("Goods");
			$brand_id = get_brand_id();
			$condition = array("brand_id"=>$brand_id);	 
			$goods = $model->relation(true)->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select();
			$clubs = M("Club")->where(array("brand_id"=>get_brand_id()))->field('id,club_name')->select(); 

			$count = 	$model->where($condition)->count();	
			if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
			} else { 
			              $total_pages = 0; 
			} 	
			$response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$goods,"userdata"=>$clubs);
			$this->ajaxReturn($response); 
	}
	private function addGoods()
	{
 
   	 	$model = D("Goods");
   	 	if(!$model->create())
   	 	{
   	 		$response=array("success"=>false,"message"=>$model->getError(),"new_id"=>$id);
   	 	    $this->ajaxReturn($response);
   	 	} 
   	 	unset($model->id);
   	 	$id=$model->add();
   	 	//add sale club
   	 	
   	 	$clubs = I("clubs");
   	 	if(!empty($clubs))
   	 	{
   	 		$goodsClubModel = M("GoodsClub");
   	 		$clubs = explode(',', $clubs);
   	 		foreach ($clubs as $key => $value) {
   	 			$goodsClubModel->data(array("goods_id"=>$id,"club_id"=>$value))->add();
   	 		}
   	 	}
   	 	$response=array("success"=>true,"message"=>"success!","new_id"=>$id);
   	 	$this->ajaxReturn($response);
	}
	private function editGoods()
	{
		 	
   	 	$model = D("Goods");
   	 	$id=I("id");
   	 	$goods = $model->find($id);
   	 	if(!$model->create())
   	 	{
   	 		$response=array("success"=>false,"message"=>$model->getError(),"new_id"=>$id);
   	 	    $this->ajaxReturn($response);
   	 	} 
   	 	$model->save();
   	 	if($goods['is_system']!=1)
   	 	{
   	 		$goodsClubModel = M("GoodsClub");
	   	 	$goodsClubModel->where(array("goods_id"=>$id))->delete();
	   	 	$clubs = I("clubs");
	   	 	if(!empty($clubs))
	   	 	{   	 		
	   	 		$clubs = explode(',', $clubs);
	   	 		foreach ($clubs as $key => $value) {
	   	 			$goodsClubModel->data(array("goods_id"=>$id,"club_id"=>$value))->add();
	   	 		}
	   	 	}
	   	 } 
   	 	$response=array("success"=>true,"message"=>"success!","new_id"=>$id);
   	 	$this->ajaxReturn($response);
	}
	private function delGoods()
	{ 
		$id=I("id");
   	 	$model = M("Goods");  
   	 	$goods = $model->find($id);
   	 	if($goods['is_system']==1) 
   	 	{
   	 		$response=array("success"=>false,"message"=>"failed!","new_id"=>$id);
   	 		$this->ajaxReturn($response);
   	 	}
   	 	$ret=$model->where(array("brand_id"=>get_brand_id()))->delete($id);
		if(!$ret)
   	 	{
   	 		$response=array("success"=>false,"message"=>"failed!","new_id"=>$id);
   	 		$this->ajaxReturn($response);
   	 	}
   	 	$goodsClubModel = M("GoodsClub");
   	 	$goodsClubModel->where(array("goods_id"=>array("in",$id)))->delete();
   	 	$response=array("success"=>true,"message"=>"failed!","new_id"=>$id);
   	 	$this->ajaxReturn($response);
	}
	public function setGoodsAction()
	{
		$oper = I("oper");
		switch ($oper) {
			case 'add':
				$this->addGoods();
				break;
			case 'edit':
				$this->editGoods();
				break;
			case 'del':
				$this->delGoods();
				break;
			default:
				$response=array("success"=>false,"message"=>"unknow operation!","new_id"=>0);
				$this->ajaxReturn($response);
				break;
		}		 
	}

	public function queryAction()
	{	
			$page = I("page");
 			$page = empty($page )?0:$page ;
 			$sidx = I("sidx");
 			$sidx = empty($sidx )?"id":$sidx ;
 			$limit = I("rows");
 			$limit = empty($limit )?1000:$limit ;
 			$sord = I("sord");
 			$sord = empty($sord )?"desc":$sord ; 	
 			$start = $limit*$page - $limit; 
 			$start=$start>=0?$start:0;
			$model = D("Goods");
			$brand_id = get_brand_id();
			$condition = array("brand_id"=>$brand_id);	 
			$category_id = I("category_id"); 
			if($category_id!=-1 && $category_id!=='')
			{
				$condition["category_id"] = $category_id;	 
			}

			$sale_type = I("sale_type"); 
			if($sale_type!=-1 && $sale_type!=='')
			{
				$condition["sale_type"] = $sale_type;	 
			} 

			$name = I("name"); 
			if($name!=-1 && $name!=='')
			{
				$condition["name"] = array("like","%$name%");	 
			}

			$ret = $model->relation(true)->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select();
			
			$count = $model->where($condition)->count();	
			$club = I("club"); 
			$goods=array();
			if($club!=-1 && $club!=='')
			{
				 foreach ($ret as $key => $value) {
				  
				   if(!empty($value['clubs']))
				   {
				   		foreach ($value['clubs'] as $clubobj) {
				   			if($clubobj['club_id']==$club)
				   			{
				   				$goods[]=$value;
				   				break;
				   			}
				   		}
				   }
				   

				 }
			}
			else
			{
				$goods=$ret;
			}

			$clubs = M("Club")->where(array("brand_id"=>get_brand_id()))->field('id,club_name')->select(); 
			
			if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
			} else { 
			              $total_pages = 0; 
			} 	
			$response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$goods,"userdata"=>$clubs);
			$this->ajaxReturn($response); 
	}
}