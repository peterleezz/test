<?php
namespace Brand\Controller;
use Common\Controller\BaseController;
class PtclassController extends BaseController {
	public  function indexAction()
	{  
		$clubs = M("Club")->where(array("brand_id"=>get_brand_id()))->field('id,club_name')->select();	 
		$this->assign("clubarray",$clubs);  
		$this->display();
	}

	private function addPtclass()
	{
 
   	 	$model = D("PtClass");
   	 	if(!$model->create())
   	 	{
   	 		$response=array("success"=>false,"message"=>$model->getError());
   	 	    $this->ajaxReturn($response);
   	 	} 
   	 	$id=$model->add();
   	 	$clubs = I("clubs");
   	 	if(!empty($clubs))
   	 	{
   	 		$model = M("PtClub");
   	 		$clubs = explode(',', $clubs);
   	 		foreach ($clubs as $key => $value) {
   	 			$model->data(array("pt_class_id"=>$id,"club_id"=>$value))->add();
   	 		}
   	 	}
   	 	$response=array("success"=>true,"message"=>"success!","new_id"=>$id);
   	 	$this->ajaxReturn($response);
	}
	private function editPtclass()
	{
   	 	$model = D("PtClass");
   	 	$id=I("id");
   	 	if(!$model->create())
   	 	{
   	 		$response=array("success"=>false,"message"=>$model->getError(),"new_id"=>$id);
   	 	    $this->ajaxReturn($response);
   	 	} 
   	 	$model->save();
   	 	$model = M("PtClub");
   	 	$model->where(array("pt_class_id"=>$id))->delete();
   	 	$clubs = I("clubs");
   	 	if(!empty($clubs))
   	 	{   	 		
   	 		$clubs = explode(',', $clubs);
   	 		foreach ($clubs as $key => $value) {
   	 			$model->data(array("pt_class_id"=>$id,"club_id"=>$value))->add();
   	 		}
   	 	}
   	 	$response=array("success"=>true,"message"=>"success!","new_id"=>$id);
   	 	$this->ajaxReturn($response);
	}
	private function delPtclass()
	{ 
		$id=I("id");
   	 	$model = M("PtClass");  
   	 	$ret=$model->where(array("brand_id"=>get_brand_id()))->delete($id);
		if(!$ret)
   	 	{
   	 		$response=array("success"=>false,"message"=>"failed!","new_id"=>$id);
   	 		$this->ajaxReturn($response);
   	 	}
   	 	$model = M("PtClub");
   	 	$model->where(array("pt_class_id"=>array("in",$id)))->delete();
   	 	$response=array("success"=>true,"message"=>"failed!","new_id"=>$id);
   	 	$this->ajaxReturn($response);
	}
	public function setPtclassAction()
	{
		$oper = I("oper");
		switch ($oper) {
			case 'add':
				$this->addPtclass();
				break;
			case 'edit':
				$this->editPtclass();
				break;
			case 'del':
				$this->delPtclass();
				break;
			default:
				$response=array("success"=>false,"message"=>"unknow operation!","new_id"=>0);
				$this->ajaxReturn($response);
				break;
		}		 
	}


	public function getPtclassAction()
	{
			list($page,$sidx,$limit,$sord,$start)=getRequestParams();
			$model = D("PtClass");
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

 
	public function queryAction()
	{	
			 list($page,$sidx,$limit,$sord,$start)=getRequestParams();
			$model = D("PtClass");
			$brand_id = get_brand_id();
			$condition = array("brand_id"=>$brand_id);	 
			 
			$name = I("name"); 
			if($name!=-1 && $name!=='')
			{
				$condition["name"] = array("like","%$name%");	 
			}

			$ret = $model->relation(true)->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select();
			
			$count = $model->where($condition)->count();	
			$club = I("club"); 
			$pts=array();
			if($club!=-1 && $club!=='')
			{
				 foreach ($ret as $key => $value) {
				  
				   if(!empty($value['clubs']))
				   {
				   		foreach ($value['clubs'] as $clubobj) {
				   			if($clubobj['club_id']==$club)
				   			{
				   				$pts[]=$value;
				   				break;
				   			}
				   		}
				   }
				   

				 }
			}
			else
			{
				$pts=$ret;
			}

			$clubs = M("Club")->where(array("brand_id"=>get_brand_id()))->field('id,club_name')->select(); 
			
			if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
			} else { 
			              $total_pages = 0; 
			} 	
			$response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$pts,"userdata"=>$clubs);
			$this->ajaxReturn($response); 
	}
}