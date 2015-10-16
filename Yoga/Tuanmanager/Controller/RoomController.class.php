<?php
namespace Tuanmanager\Controller;
use Common\Controller\BaseController;
 
class RoomController extends BaseController {
	public function indexAction()
	{
		$this->display();
	}

	public function delAction($id)
	{
		$room = M("ClubClassroom")->find($id);
		if(empty($room))
		{
			$this->error("can't find this class!");
		}
		if($room['club_id']!=get_club_id())
		{
			$this->error("can't delete this class!");
		}
		M("ClubClassroom")->delete($id);
		$response=array("success"=>true,"message"=>"success!","new_id"=>$id);
        $this->ajaxReturn($response);
	}
 
 	public function queryAction()
	{ 
		$uid=is_user_login();
		 list($page,$sidx,$limit,$sord,$start)=getRequestParams();
			$model = D("ClubClassroom"); 
			$condition = array("club_id"=>get_club_id()); 
			 $filters=I("filters",'','');
			 $filters = json_decode($filters);  
			 if($filters->groupOp=='AND')
	        {
	            $rules = $filters->rules; 
	            foreach ($rules as $key => $value) { 
	                if($value->field=="name")
	                {
	                    $condition = array_merge($condition,array("name"=>array("like","%{$value->data}%")) );
	                }
	                 
	            }
	        } 
	     
 
			$ret = $model->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select();  
			$count = $model->where($condition)->count();	 
			if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
			} else { 
			              $total_pages = 0; 
			} 	
			$response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
			$this->ajaxReturn($response); 
	}

	public function showEditAction($id)
	{
		$room = M("ClubClassroom")->find($id);
		if(empty($room))
		{
			$this->error("can't find this class!");
		}
		$this->room=$room;
		$this->display("showAdd");
	}
	public function editAction()
	{
		$model=D("ClubClassroom");
		if(!$model->create())
		{
			$this->error($model->getError());
		}
		$id=I("id");
		if(!empty($id))
		{
			$model->save();
		}
		else
		{
			$model->add();
		}
		$this->success("success",U("index"));
	} 

}