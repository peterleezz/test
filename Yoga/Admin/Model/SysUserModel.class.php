<?php
namespace Admin\Model;
use Think\Model;
class SysUserModel extends Model {
    protected $_validate = array(
        /* 验证用户名 */
        array('username', '6,30', "用户名至少6-30位！", self::EXISTS_VALIDATE, 'length'), //用户名长度不合法
        array('username', '', "用户名已被注册！", self::EXISTS_VALIDATE, 'unique'), //用户名被占用
        /* 验证密码 */
        array('password', '6,30', "密码名至少6-30位！", self::EXISTS_VALIDATE, 'length'), //密码长度不合法       
        array('last_login_ip', '\d+\.\d+\.\d+\.\d+', "IP 地址不合法", self::EXISTS_VALIDATE, 'regex'),  
        array('confirm_password','password','确认密码不正确',0,'confirm'),
    );

    public function test()
    {
    	echo "test";
    }
}