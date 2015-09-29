<?php
namespace Service;
class UserService extends CService
{
	
	private $userModel;
	private $userExtensionModel;
	protected static $instance;
	public static function getInstance($name = 'default'){
        if (empty(self::$instance[$name])){
            self::$instance[$name] = new UserService($name);
        }
        return self::$instance[$name];

    }

	public function __construct()
	{
		$this->userModel = D("User");
		$this->userExtensionModel = D("UserExtension");
	}
    
	public function changePassword($id,$original_password,$password,$confirm_password)
	{
		
		$user=$this->userModel->find($id);		
		if(ucenter_md5($original_password, C("MD5_SECRET_KEY")) !== $user['password'])
		{
			$this->setError("password_error");
			return false;
		}
		if($password!=$confirm_password)
		{
			$this->setError("confirm_password_error");
			return false;
		}
		 
		if(!validPassword($password))
		{
			$this->setError("new_password_error");
			return false;
		}
		// $this->userModel->password=ucenter_md5($password, C("MD5_SECRET_KEY"));
		$this->userModel->where(array("id"=>$id))->setField("password",ucenter_md5($password, C("MD5_SECRET_KEY")));
		return true;
		 
	}
}
