<?php
namespace Admin\Controller;
use Think\Controller;
use Service\SysUserService;
class UserController extends AdminController {

  public function logoutAction()
  {
    session('[destroy]');
    $this->success('退出成功！', U('Admin/Index/index'));
  }

  public function editpwAction()
  {
      $this->display();
  }

  public function changepwAction($original_password,$new_password,$confirm_password)
  { 
    $sysUserService = new SysUserService();
    $id=getLoginAdminUid();
    $ret = $sysUserService->changePassword($id,$original_password,$new_password,$confirm_password);
    if($ret === true)
      $this->success('密码修改成功！', U('Admin/Brand/index'));
    else
       $this->error($ret);
  }  

   public function editAction()
    {
      $brandModel = D("SysUser");
      if(!$brandModel->create())
        {
            $this->error($brandModel->getError());
        }
        $brandModel->password=ucenter_md5($brandModel->password, 'yoga_peter!@#');
        if($brandModel->id==0)        
           $brandModel->add();
        else
            $brandModel->save();
      $this->success("success!");
    }

    public function indexAction($page=0)
    {
        $Model = D("SysUser");
        $count = $Model->count();
        $this->assign('pages', ceil($count/10));
        $this->assign('current_page', $page);
        $page+=1;
        $users = $Model->page("$page,10")->select();
        $this->assign('users', $users);
        $this->display();
    }

    public function delAction($id)
    {
        $Model = D("SysUser");
        $ret = $Model->delete($id);
        if($ret==1)
        {
            $this->success("success!");
        }
        else
        {
            $this->error($Model->getError());
        }
    }

}