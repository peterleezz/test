<?php
namespace Channel\Controller;
use  Common\Controller\BaseController;
class VisitController extends BaseController {

public  function indexAction()
    {   
        $this->display();
    }

	protected function getModel()
	{
		return D("ChannelVisit");
	} 

	public function queryAction()
	{	
		 
			list($page,$sidx,$limit,$sord,$start)=getRequestParams();
			$model = $this->getModel();
			$user_id = is_user_login();
			$condition = array("user_id"=>$user_id);	 
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

			$channels=M("Channel")->where(array("brand_id"=>get_brand_id()))->select();
			$response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
			$this->ajaxReturn($response); 
	}

public function addMemberAction()
{
		$channel = I("channel_id"); 
		$model =D("MemberBasic");	  
	   if (!$model->create()){      
      			$this->error($model->getError());
		}else{   

			//check if this customer is exsited
			
			$brand_id = get_brand_id();
			$club_id=get_club_id();
			$member = $model->where(array("club_id"=>$club_id,"name"=>I("name"),"phone"=>I("phone")))->find();
			
			if(!empty($member))
			{	
				$this->error("此访客信息已存在，不能再添加！");
			}
				$model->recommend_id=is_user_login();
				
		    	$id = $model->add();			 
				$avatar="default.jpg"; 
				if(!empty($_FILES["avatar"]["name"]))
				{
				 
					$upload = new \Think\Upload();// 实例化上传类
				    $upload->maxSize   =     3145728 ;// 设置附件上传大小
				    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
				    $upload->rootPath  =      '/Public/uploads/'; // 设置附件上传根目录
				    $upload->savePath="mmb_avatar/";
				    $upload->autoSub=false;
				    $upload->replace=true;
				    $upload->saveName="$id"; 
				    $info   =   $upload->upload();
				    if(!$info) {  
				    	$model->delete($id);
				        $this->error($upload->getError());
				    }else{   				    	
				    	$avatar=$info["avatar"]['savename'];
				    	$model->where("id=$id")->setField("avatar",$avatar);
				    }
				}   
		} 
	 $this->success('成功！', U("Channel/Visit/member/id/$id"),0);  
}

public function editMemberAction()
{
	$channel = I("channel_id");	 
		$model =D("MemberBasic");	  
		$id=I("id");
		$member = $model->find($id);			
			if(empty($member))
			{	
				$this->error("此访客不存在，不能修改！");
			}
			if($member["recommend_id"]!=is_user_login())
			{
				$this->error("无权修改此用户信息");
			}

			
	   if (!$model->create()){      
      			$this->error($model->getError());
		}else{   
 				 
		    	$model->save(); 
				if(!empty($_FILES["avatar"]["name"]))
				{
				 
					$upload = new \Think\Upload();// 实例化上传类
				    $upload->maxSize   =     3145728 ;// 设置附件上传大小
				    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
				    $upload->rootPath  =      '/Public/uploads/'; // 设置附件上传根目录
				    $upload->savePath="mmb_avatar/";
				    $upload->autoSub=false;
				    $upload->replace=true;
				    $upload->saveName="$id"; 
				    $info   =   $upload->upload();
				    if(!$info) {			     
				        $this->error($upload->getError());
				    } 
				    else
				  	{
				  		$avatar=$info["avatar"]['savename'];
				    	$model->where("id=$id")->setField("avatar",$avatar);
				  	}
				}   
		} 

		 $this->success('成功！', U("Channel/Visit/manage"),0);  
}
public function existAction()
	{
		$brand_id = get_brand_id();
		$model=M("MemberBasic");
		$member = $model->where(array("club_id"=>get_club_id(),"name"=>I("name"),"phone"=>I("phone")))->find();
		if(!empty($member))
		{
			$this->ajaxReturn(array("status"=>0,"id"=>$member["id"]));
		}
		else
		{
			$this->ajaxReturn(array("status"=>1));
		}
	}

	public function memberAction()
	{
		// $id=I("id");
		// if(!empty($id))
		// {
		// 	$model=D("MemberBasic");
		// 	$member = $model->find($id);
		// 	if($member["brand_id"]!=get_brand_id())
		// 	{
		// 		$this->error("无权查看此用户信息");
		// 	}
		// 	if($member['recommend_id']!= is_user_login())
		// 	{
		// 		$this->error("此用户由他人添加，您无权修改！");
		// 	}
		// 	$this->assign("member",$member);
		// }  
		// $model = M("Channel");
		// $channles = $model->where(array("brand_id"=>get_brand_id()))->select();
		// $this->assign("channels",$channles);

  //   	$model = M("Club");
  //   	$clubs = $model->where(array("brand_id"=>get_brand_id()))->field("id,club_name")->select();
  //   	$this->assign("clubs",$clubs);
		// $this->display();
		
	}


	//customer manage
	public function manageAction()
	{
		// $clubs = D("Club")->getAllClubsName();
		if(is_user_brand())
		{
			$channels=D("Channel")->getAllChannelName();
		}
		else
		{
			$channels=D("Channel")->getChannelNameByUser(is_user_login());
		}

		// $this->assign("clubs",$clubs);
		$this->assign("channels",$channels);
		$this->display();
	}

	public function getMembersAction()
	{
		list($page,$sidx,$limit,$sord,$start)=getRequestParams(); 
         $condition = array("record_id"=>is_user_login());  
 
         $channel_id = I("channel_id"); 
         if($channel_id!=0 && $channel_id!=='')
         {
            $condition["channel_id"] = $channel_id;  
         }

         $type = I("type"); 
         if($type!=0 && $type!=='')
         {
            $condition["type"] = $type;   
         } 

         $name = I("name"); 
         if($name!=='')
         {
            $condition["name"] = array("like","%$name%");    
         }

         $phone = I("phone"); 
         if($phone!=='')
         {
            $condition["phone"] = $phone;    
         }
 
         $model = M("MemberBasic");

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
}