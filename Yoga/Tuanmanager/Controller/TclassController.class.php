<?php
namespace Tuanmanager\Controller;
use Common\Controller\BaseController;
class TclassController extends BaseController {
	public function indexAction()
	{
			$pt = D("User")->getPtAndTuan(get_club_id());
		$this->pt=$pt;
		$this->display();
	}

	public function queryAction()
	{ 
		$club_id=get_club_id();
		 list($page,$sidx,$limit,$sord,$start)=getRequestParams();
			$model = D("PtClassPublic"); 
			$condition = array("club_id"=>$club_id); 
			 $filters=I("filters",'','');
			 $filters = json_decode($filters);  
			 if($filters->groupOp=='AND')
	        {
	            $rules = $filters->rules; 
	            foreach ($rules as $key => $value) { 
	                if($value->field=="name")
	                {
	                    $condition = array_merge($condition,array("name"=>array("like","%{$value->data}%")) );
	                }else  if($value->field=="pt_id" && $value->data!=0)
	                {
	                    $condition = array_merge($condition,array("pt_id"=>$value->data) );
	                }
	                 
	            }
	        } 
	     
 
			$ret = $model->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select(); 
			foreach ($ret as $key => $value) {
				$ret[$key]['image']="/Public/uploads/ptclass/".$value['image'];
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

	public function showAddAction()
	{
		$pt = D("User")->getPtAndTuan(get_club_id());
		$this->pt=$pt;
		$this->display();
	}

	public function showEditAction($id)
	{
		$class=M("PtClassPublic")->find($id);
		$class['desc']=htmlspecialchars_decode($class['desc']);
		$pt = D("User")->getPtAndTuan(get_club_id());
		$this->pt=$pt;
		$this->assign("class",$class);
		$this->display("showAdd");
	}

	public function editAction()
	{ 
		$model =D("PtClassPublic");
		if(!$model->create())
		{
			$this->error($model->getError());
		} 
		$time = time();
		if(!empty($_FILES["image"]["name"]))
			$model->image="{$time}.jpg";
		$id=I("id"); 
			$pt=M("UserExtension")->find(I("pt_id"));
		
		$class = $model->where("id=$id")->find();
		if(empty($class)) $this->error("原课程已删除！请新增！");  

		if(!empty($_FILES["image"]["name"]))
				{
					$config["savePath"]="ptclass";
					$upload = new \Think\Upload();// 实例化上传类
				    $upload->maxSize   =     3145728 ;// 设置附件上传大小
				    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
				    $upload->rootPath  =      './Public/uploads/'; // 设置附件上传根目录
				    $upload->savePath="ptclass/";
				    $upload->autoSub=false;
				    $upload->replace=true;
				    $upload->saveName="$time"; 
				    $info   =   $upload->upload();
				    if(!$info) {   
				        $this->error($upload->getError());
				    } 
			}
			 $model->name=I("name"); 
			  $model->desc=I("desc"); 
			   $model->lang=I("lang"); 
			    $model->level=I("level"); 
			    $model->pt_id=I("pt_id");
			    $model->teacher_name = $pt['name_cn'];
			  $model->save();
			$this->success("Success!",U('index')); 
	}

	public function addAction()
	{
		$model =D("PtClassPublic");
		if(!$model->create())
		{
			$this->error($model->getError());
		}
		$pt=M("UserExtension")->find(I("pt_id"));
		$model->teacher_name = $pt['name_cn'];
		$time = time();
		if(!empty($_FILES["image"]["name"]))
			$model->image="{$time}.jpg";
		$model->club_id=get_club_id();
		$model->is_self_add=0;
		$id = $model->add(); 

		if(!empty($_FILES["image"]["name"]))
				{
					$config["savePath"]="ptclass";
					$upload = new \Think\Upload();// 实例化上传类
				    $upload->maxSize   =     3145728 ;// 设置附件上传大小
				    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
				    $upload->rootPath  =      './Public/uploads/'; // 设置附件上传根目录
				    $upload->savePath="ptclass/";
				    $upload->autoSub=false;
				    $upload->replace=true;
				    $upload->saveName="$time"; 
				    $info   =   $upload->upload();
				    if(!$info) {  
				    	$model->delete($id);
				        $this->error($upload->getError());
				    } 
			}
			$this->success("Success!",U('index')); 
	}

	public function setPtclassAction()
	{
		$oper = I("oper");
		switch ($oper) { 
			case 'del':
				$this->delPtclass();
				break;
			default:
				$response=array("success"=>false,"message"=>"unknow operation!","new_id"=>0);
				$this->ajaxReturn($response);
				break;
		}		 
	}
	 protected function delPtclass()
    { 
        $id=I("id"); 
        $ret=M("PtClassPublic")->delete($id);
        if(!$ret)
        {
            $response=array("success"=>false,"message"=>"failed!","new_id"=>$id);
            $this->ajaxReturn($response);
        } 
        $response=array("success"=>true,"message"=>"删除成功!","new_id"=>$id);
        $this->ajaxReturn($response);
    }
}