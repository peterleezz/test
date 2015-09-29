<?php
namespace Service;
class SysUserService 
{
	
	private $sysUserModel;
	public function __construct()
	{
		$this->sysUserModel = D("SysUser");
	}
    public function login($username, $password){
		/* 获取用户数据 */
		$map['username']=$username;
		$user =$this->sysUserModel->where($map)->find();
		if(is_array($user)){
			/* 验证用户密码 */
			if(ucenter_md5($password, 'yoga_peter!@#') === $user['password']){
				$this->updateLogin($user['id']); //更新用户登录信息
				return $user; //登录成功，返回用户ID
			} else {
				return array("id"=>"-2"); //密码错误
			}
		} else {
			return array("id"=>"-1"); //用户不存在
		}
	}

	public function create($username, $password)
	{
		$map['username']=$username;
		$map['password']=ucenter_md5($password, 'yoga_peter!@#');
		$this->sysUserModel->add($map);
	}

	protected function updateLogin($uid){
		$data = array(
			'id'              => $uid,
			'last_login_time' => getDbTime(),
			'last_login_ip'   => get_client_ip(0),
		);
		$this->sysUserModel->save($data);
	}

	public function changePassword($id,$original_password,$password,$confirm_password)
	{
		
		$user=$this->sysUserModel->find($id);		
		if(ucenter_md5($original_password, 'yoga_peter!@#') !== $user['password'])
		{
			return "原始密码错误！";
		}
		$data = array("password"=>$password,"confirm_password"=>$confirm_password,"id"=>$id);
		if(!$this->sysUserModel->create($data))
		{
			 return ($this->sysUserModel->getError());
		}
		else
		{
			$this->sysUserModel->password=ucenter_md5($password, 'yoga_peter!@#');
			$this->sysUserModel->save();
			return true;
		}
	}
}
