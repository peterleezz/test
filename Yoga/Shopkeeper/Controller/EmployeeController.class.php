<?php
namespace Shopkeeper\Controller;

class EmployeeController extends \Brand\Controller\EmployeeController {
	public  function indexAction()
	{
		if(is_user_brand())
		{
			parent::indexAction();		
			return;	 
		}
		$clubs = M("Club")->field('id,club_name')->select(get_club_id());
		// $this->assign("clubs",$clubs); 
		$this->assign("clubs",json_encode($clubs)); 
		$this->assign("clubarray",$clubs); 
		$roles=M("AuthGroup")->select();
		$this->assign("roles",$roles); 
		$this->selfid = is_user_login();
		$this->display();
	}
	public  function editAction()
	{
		$notEmptyField = getNotEmptyField(); 
		$this->checkPermission(I("id"));  
	   $userModel = M("User");
	   $extensionModel = M("UserExtension");
	   if (!$userModel->field($notEmptyField)->create()){      
      			$this->error($userModel->getError());
		}else{ 
			$password=I("password");
			if(!empty($password))
			{ 
				$userModel->password=ucenter_md5(I("password"), C("MD5_SECRET_KEY"));
			}  
			$userModel->club_id=get_club_id();
		     $userModel->save();
			 if (!$extensionModel->field($notEmptyField)->create()){      		 
	      			$this->error($extensionModel->getError());
			}else{
				  $extensionModel->work_status=I("work_status");
				  $extensionModel->can_grant=I("can_grant");
				if(!empty($_FILES["avatar"]["name"]))
				{
					$config["savePath"]="em_avatar";
					$upload = new \Think\Upload();// 实例化上传类
				    $upload->maxSize   =     31457280 ;// 设置附件上传大小
				    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
				    $upload->rootPath  =      './Public/uploads/'; // 设置附件上传根目录
				    $upload->savePath="em_avatar/";
				    $upload->autoSub=false;
				    $upload->replace=true;
				    $upload->saveName=I("id"); 
				    $info   =   $upload->upload();
				    if(!$info) {   
				        $this->error($upload->getError());
				    }else{   
				    	$avatar=$info["avatar"]['savename'];
				    }
				    $extensionModel->avatar=$avatar;
				}  
			
			    $extensionModel->save();		 
			    //add roles
			    $roles = I('roles');

			    M("AuthGroupAccess")->where("uid=".I("id"))->delete();
			    foreach ($roles as $key => $value) {
			    	M("AuthGroupAccess")->data(array("uid"=>I("id"),"group_id"=>$value))->add();	    
			    }

			    $roles = I('financeroles');
			     M("FinanceClub")->where(array("user_id"=>I("id")))->delete();
			    foreach ($roles as $key => $value) {
			    	M("FinanceClub")->data(array("user_id"=>I("id"),"club_id"=>$value))->add();	    
			    }
			   
			}
		}
		 $this->success('成功！', U('Shopkeeper/Employee/index'));
	}

	public function getEmployeesAction()
 	{
			list($page,$sidx,$limit,$sord,$start)=getRequestParams();

			$model = M("User");
			$brand_id = get_brand_id();
			$condition = array("brand_id"=>$brand_id,"is_brand"=>0);	
			$valuesql="select * from yoga_user a,yoga_user_extension b where a.brand_id=$brand_id and a.is_brand=0 and a.id=b.id and a.invalid=1 and a.club_id=".get_club_id()." ";
			$countsql="select count(*) as count from yoga_user a,yoga_user_extension b where a.brand_id=$brand_id and a.is_brand=0 and a.id=b.id and a.invalid=1 and a.club_id=".get_club_id()." ";
			$filters=I("filters",'','');
	 		$filters = json_decode($filters);  
	 		$sql="";
	 		if($filters->groupOp=='AND')
	        {
	            $rules = $filters->rules; 
	            foreach ($rules as $key => $value) {   
	               
	                //  if($value->field=="club"  && $value->data!=0 )
	                // {
	                // 	$sql.=" and a.club_id ".getOPerationMysql($value->op)."  '{$value->data}'"; 
	                // }
	                if($value->field=="work_status" && $value->data!=-1)
	                {
	                	$sql.=" and b.work_status ".getOPerationMysql($value->op)."  '{$value->data}'"; 
	                }
	                 if($value->field=="name_cn" )
	                {
	                	$sql.=" and b.name_cn  like '%{$value->data}%'"; 
	                }
	                 if($value->field=="name_en")
	                {
	                	$sql.=" and b.name_en  like '%{$value->data}%'"; 
	                }
	                 if($value->field=="role" && $value->data!=-1)
	                {
	                	$ids=M("AuthGroupAccess")->where("group_id=".$value->data)->select();
	                	
	                	$id=array();
	                	foreach ($ids as $key => $value) {
	                		$id[]=$value['uid'];
	                	}
	                	$ids=implode(",", $id); 
	                	$sql.=" and b.id in($ids)"; 
	                }
	                
	            }
	        } 

 		$model = new \Think\Model();
        $countsql=$countsql." ".$sql;
        $count=$model->query($countsql);
        $count=$count[0]["count"]; 
        $valuesql = $valuesql." ".$sql.$tail." order by a.$sidx $sord limit $start,$limit"; 

        $ret = $model->query($valuesql);
		foreach ($ret as $key => $value) {
			  $ret[$key]['role']=D("User")->getRole($value['id']);
		}
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
		$clubs = M("Club")->field('id,club_name')->select(get_club_id());
		$this->assign("clubs",$clubs);

		$brand_user = M("User")->where(array("is_brand"=>get_brand_id()))->find();

		//get roles
		$authGroupAccess =M("AuthGroupAccess");
		$group_ids=  $authGroupAccess->where("uid=".$brand_user['id'])->field("group_id")->select();
		$ids=array();
		foreach ($group_ids as $key => $value) {
			$ids[]=$value['group_id'];
		}
		// $map['id'] = array("in",$ids);
		$map['module'] = array("not in","Brand,Shopkeeper");

		$groups = M("AuthGroup")->where($map)->field("id,title")->select();
		$this->assign("groups",$groups);
		$this->display();
	}


	public  function addAction()
	{ 

	   $rules = array(       
        array('username', '1,30', "用户名至少1-30位！",1, 'length'),  
        array('username', '', "用户名已被注册！", 1, 'unique'),  
        array('password', '6,30', "密码至少6-30位！",1, 'length'),  
        array('confirm_password','password','确认密码不正确!',1,'confirm'),
        array('name_cn', 'require', "请输入中文名！",1),        
        array('name_en', 'require', "请输入英文名！",1),  
        array('identity_card', '/^\d{15}$|^\d{17}(\d|[Xx])$/', "身份证号码不对！",2),  
   	 );		 
	   $userModel = M("User");
	   $extensionModel = M("UserExtension");
	   if (!$userModel->validate($rules)->create()){      
      			$this->error($userModel->getError());
		}else{
			$userModel->brand_id=get_brand_id();
			$userModel->club_id=get_club_id();
			$userModel->password=ucenter_md5(I("password"), C("MD5_SECRET_KEY"));
			$userModel->update_time=getDbTime();
		     $id = $userModel->add();
			 if (!$extensionModel->create()){      
			 		$userModel->delete($id);
	      			$this->error($extensionModel->getError());
			}else{

				$avatar="default.jpg"; 
				if(!empty($_FILES["avatar"]["name"]))
				{
					$config["savePath"]="em_avatar";
					$upload = new \Think\Upload();// 实例化上传类
				    $upload->maxSize   =     31457280 ;// 设置附件上传大小
				    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
				    $upload->rootPath  =      './Public/uploads/'; // 设置附件上传根目录
				    $upload->savePath="em_avatar/";
				    $upload->autoSub=false;
				    $upload->replace=true;
				    $upload->saveName="$id"; 
				    $info   =   $upload->upload();
				    if(!$info) {  
				    	$userModel->delete($id);
				        $this->error($upload->getError());
				    }else{   
				    	$avatar=$info["avatar"]['savename'];
				    }
				} 
				$extensionModel->id = $id;
				$extensionModel->avatar=$avatar;
				$extensionModel->update_time=getDbTime();
			    $extensionModel->add();		

			    //add roles
			    $roles = I('roles');
			    foreach ($roles as $key => $value) {
			    	M("AuthGroupAccess")->data(array("uid"=>$id,"group_id"=>$value))->add();	    
			    }
			    
			}
		}
		 $this->success('成功！', U('Shopkeeper/Employee/index'));
	}

	public function showEditAction($id)
	{
		$this->checkPermission($id);
	 
		//get roles
		$brand_user = M("User")->where(array("is_brand"=>get_brand_id()))->find();

		//get roles
		$authGroupAccess =M("AuthGroupAccess");
		$group_ids=  $authGroupAccess->where("uid=".$brand_user['id'])->field("group_id")->select();
		$ids=array();
		foreach ($group_ids as $key => $value) {
			$ids[]=$value['group_id'];
		}
		// $map['id'] = array("in",$ids);
		$map['module'] = array("not in","Brand,Shopkeeper");
		$groups = M("AuthGroup")->where($map)->field("id,title")->select();
		$this->assign("groups",$groups);
		$user = M("User")->find($id);
		$user_extension = M("UserExtension")->find($id);
		$employee = array_merge($user,$user_extension);
		$this->assign("employee",$employee);

		//当前的权限
		$group_ids=  $authGroupAccess->where("uid=".$id)->field("group_id")->select();
		$ids=array();
		foreach ($group_ids as $key => $value) {
			$ids[]=$value['group_id'];
		}
		$map['id'] = array("in",$ids);
		$map['module'] = array("neq","Brand");
		$groups = M("AuthGroup")->where($map)->field("id")->select();
		$roles=array();
		foreach ($groups as $key => $value) {
			$roles[]=$value['id'];
		}
		$this->assign("roles",$roles);
		$this->display("showAdd");
	}
    
}
