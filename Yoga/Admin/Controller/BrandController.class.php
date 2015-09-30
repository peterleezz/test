<?php
namespace Admin\Controller;
use Think\Controller;
class BrandController extends AdminController {
    public function indexAction($page=0){
    	$brandModel = D("Brand");
        $count = $brandModel->count();
        $this->assign('pages', ceil($count/10));
        $this->assign('current_page', $page);
        $page+=1;
        $brands = $brandModel->where('status=1')->page("$page,10")->select();
        $this->assign('brands', $brands);
        $this->display();
    }

    public function editAction()
    {
    	$brandModel = D("Brand");
        $userModel = M("User");
        $roles=I('roles');
        $roles[]='Brand';
        $rolestring = json_encode($roles);
    	if(I("id")==0 && !$brandModel->create())
        {
            $this->error($brandModel->getError());
        }
        $brandModel->id=I("id");

        $password = ucenter_md5(I('password'), C("MD5_SECRET_KEY")); 
         $brandModel->password=$password;
         $extensionModel = M("UserExtension");
        if($brandModel->id==0)
        {
            $brandModel->roles=$rolestring;
            $id= $brandModel->add();      $this->createSystemInfo($id);
            $id = $userModel->add(array("username"=>I("username"),"password"=>$password,"is_brand"=>$id,"brand_id"=>$id));
             
             $extensionModel->data(array("id"=>$id,"desc"=>"", "name_cn"=>I("brand_name"),"name_en"=>I("brand_name")))->add(); 
        }         	
        else
        {
            $data = array("id"=> I("id"), "brand_name"=>I("brand_name"),"contact_name"=>I("contact_name"),"email"=>I("email"),"phone"=>I("phone"),"desc"=>I("desc"),"roles"=>$rolestring);
            $brandModel->data($data)->save();            
            $id = $userModel->where("is_brand=".I("id"))->getField("id");
            if(!empty($password))
                $userModel->save(array("password"=>$password,"id"=>$id));
            $extensionModel->where("id=$id")->setField("name_cn",I("brand_name"));
        }
        //set roles
       
        $chooserole = I('chooserole');
        $authGroupModel = M("AuthGroup");
        $authGroupAccessModel = M("AuthGroupAccess");
        $authGroupAccessModel->where("uid=$id")->delete();
        if($chooserole!='default')
        {
            foreach ($roles as $key => $value) {
                $group = ucfirst($value);
                $groupid = $authGroupModel->where(array("module"=>$group))->getField("id");              
                $authGroupAccessModel->data(array("uid"=>$id,"group_id"=>$groupid))->add();
            }            
        }  
    	$this->success("success!");
    }

    //创建系统信息
    public function createSystemInfo($brand_id)
    {
        //系统类的商品，停转卡收费
        M("GoodsCategory")->data(array("name"=>"系统停补卡收费","property"=>3,"type"=>1,"brand_id"=>$brand_id,"is_system"=>1))->add(); 
    }
    public function delbrandAction($id)
    {
        $brandModel = M("Brand");
        $userModel = M("User");
        $ret = $brandModel->where("id=$id")->delete() &&  $userModel->where("is_brand=$id")->delete();
        if($ret==1)
        {
            $this->success("success!");
        }
        else
        {
            $this->error($brandModel->getError());
        }
    }

    public function queryAction($brand_name,$login_name,$start_time,$end_time)
    {
        $brandModel = D("Brand");
        if(!empty($brand_name))
        {
            $map['brand_name']=array('like',"%$brand_name%");
        }    
        if(!empty($login_name))
        {
            $map['username']=$login_name;
        }   
        if(!empty($start_time))
        {
            $map['create_time']=array('gt',$start_time);
        }  
        if(!empty($end_time))
        {
            $map['create_time']=array('lt',$end_time);
        }       
        $this->assign('pages', 0);
        $this->assign('current_page', 0);
        $brands = $brandModel->where('status=1')->where($map)->select();
        $this->assign('brands', $brands);
        $this->display("index");

    }
}