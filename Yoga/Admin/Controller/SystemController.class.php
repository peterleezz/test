<?php
namespace Admin\Controller;
use Think\Controller;
class SystemController extends AdminController {

  public function indexAction()
  {
     $Model = M("SysConfig");
     $config = $Model->find();
     foreach (json_decode($config['default_role']) as $key => $value) {
       $this->assign($value,1);
     }
      
     $this->display();
  }
  public function setAction()
  {
     $Model = M("SysConfig");
     $roles = json_encode(I('roles'));
     $config = $Model->find();
     if(empty($config))
     {
       $Model->add(array("default_role"=>$roles));
     }
     else
     {
       $config['default_role']=$roles;
       $Model->save($config);         
     }
    foreach (I('roles') as   $value) {
       $this->assign($value,1);
     }
       $this->success('设置成功',"index");
    
  }
}