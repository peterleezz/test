<?php
namespace Home\Controller;
use Common\Controller\BaseController;
use Service\UserService;
class MainController extends BaseController {
	public  function mainAction()
	{
		// $test=getQiubai();
		// $this->assign("test",$test["content"]); 
		$this->display();
	}

	public function logoutAction()
	{ 
		 cookie("sid",null);
         $this->redirect('Home/Index/index');
	}

	public function errorAction()
	{
		$this->display();
	}

	public function changePasswordAction($original_password,$new_password,$confirm_password)
	{
		$id=is_user_login();
		$userService=\Service\CService::factory("User");
		$ret=$userService->changePassword($id,$original_password,$new_password,$confirm_password);
		if($ret)
		{
			 cookie("sid",null); 
			$this->success("密码修改成功,请重新登陆!",'Home/Index/index');
		}
		else
		{
			$this->error($userService->getError());
		}
	}


    public function teacherAction()
    {
    	echo "login success";
    }
}