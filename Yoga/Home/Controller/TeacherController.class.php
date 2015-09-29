<?php
namespace Home\Controller;
use Think\Controller;

class TeacherController extends Controller { 
	public function registAction($username , $password, $verifycode ,$email,$confirm_password)
    {
        session('[start]'); 
         // if(!check_verify($verifycode)){
         //    $this->error('验证码输入错误！');
         // }
        $model = D("User");
         $rules = array(       
        array('username', '1,30', "用户名至少1-30位！",1, 'length'),  
        array('username', '', "用户名已被注册！", 1, 'unique'),  
        array('password', '6,30', "密码至少6-30位！",1, 'length'),  
        array('confirm_password','password','确认密码不正确!',1,'confirm'), 
   	 );		 
        $arr=array("confirm_password"=>$confirm_password, "email"=>$email, "username"=>$username,"password"=>md5($password),"name_cn"=>time(),"name_en"=>time(),"last_login_time"=>getDbTime(),"last_login_ip"=>get_client_ip(0)); 
         if (!$model->data($arr)->validate($rules)->create()){      
      			$this->error($model->getError());
		}
        $id = $model->data(array("username"=>$username,"password"=>$password,"last_login_time"=>getDbTime(),"last_login_ip"=>get_client_ip(0)))->add();
        D("UserExtension")->data(array("id"=>$id,"name_cn"=>time(),"name_en"=>time()))->add();
        $user =$model->where("id=$id")->find();  
        userLoginSession($user);               
        session('[destroy]'); 
        $this->success('登录成功！', U('Main/teacher'));
    }

}