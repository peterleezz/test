<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller {
	 protected function _initialize(){
        // 获取当前用户ID
        define('UID',is_admin_login());
        if( !UID ){// 还没登录 跳转到登录页面
            $this->redirect('/Admin/');
        } 
    }

    private function loadDefaultRoles()
    {
    	$Model = M("SysConfig");
	     $roles = json_encode(I('roles'));      
	    foreach (I('roles') as   $value) {
	       $this->assign($value,1);
	     }
    }
}