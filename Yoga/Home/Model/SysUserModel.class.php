<?php
namespace Admin\Model;
use Think\Model;
use Think\Model\RelationModel;
class SysUserModel extends Model {
    protected $_validate = array(
        /* 验证用户名 */
        array('username', '1,30', -1, self::EXISTS_VALIDATE, 'length'), //用户名长度不合法
        array('username', '', -3, self::EXISTS_VALIDATE, 'unique'), //用户名被占用
        /* 验证密码 */
        array('password', '6,30', -4, self::EXISTS_VALIDATE, 'length'), //密码长度不合法       
        array('last_login_ip', '\d+\.\d+\.\d+\.\d+', -10, self::EXISTS_VALIDATE, 'regex'), //手机禁止注册
        array('mobile', '', -11, self::EXISTS_VALIDATE, 'unique'), //手机号被占用
    );

    public function test()
    {
    	echo "test";
    }
}