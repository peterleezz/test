<?php
namespace Channelmanager\Controller;
use  Common\Controller\BaseController;
class ChannelController extends BaseController {
	public  function indexAction()
	{   
		$this->display();
	}

	public function add()
	{
 
   	 	$model = D("Channel");
   	 	if(!$model->create())
   	 	{
   	 		$response=array("success"=>false,"message"=>$model->getError());
   	 	    $this->ajaxReturn($response);
   	 	} 
   	 	$id=$model->add(); 
   	 	$response=array("success"=>true,"message"=>"success!","new_id"=>$id);
   	 	$this->ajaxReturn($response);
	}
	public function edit()
	{
   	 	$model = D("Channel");
   	 	$id=I("id");
   	 	if(!$model->create())
   	 	{
   	 		$response=array("success"=>false,"message"=>$model->getError(),"new_id"=>$id);
   	 	    $this->ajaxReturn($response);
   	 	} 
   	 	$model->save(); 
   	 	$response=array("success"=>true,"message"=>"success!","new_id"=>$id);
   	 	$this->ajaxReturn($response);
	}
	public function del()
	{ 
		$id=I("id");
   	 	$model = M("Channel");  
   	 	$ret=$model->where(array("brand_id"=>get_brand_id()))->delete($id);
		if(!$ret)
   	 	{
   	 		$response=array("success"=>false,"message"=>"failed!","new_id"=>$id);
   	 		$this->ajaxReturn($response);
   	 	} 
   	 	$response=array("success"=>true,"message"=>"failed!","new_id"=>$id);
   	 	$this->ajaxReturn($response);
	}
 
	public function setAction()
	{
		$oper = I("oper");		 
		switch ($oper) {
			case 'add':
				$this->add();
				break;
			case 'edit':
				$this->edit();
				break;
			case 'del':
				$this->del();
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
			$model = D("Channel");
			$club_id = get_club_id();
				
			if($club_id!=0) 
			{
				$condition = array("club_id"=>$club_id);
			}
			else
			{
				$condition = array("brand_id"=>get_brand_id());
			}
			$search=I("_search");
			if(!empty($search))
			{
				$condition = array_merge($condition,getOneSearchParams()) ;
			} 
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