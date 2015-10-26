<?php
namespace Common\Model;
use Think\Model\RelationModel;
class BrandModel extends RelationModel {
    protected $_validate = array(
        array('brand_name','require','请输入品牌名称！',self::MUST_VALIDATE),
        /* 验证用户名 */
        array('username', '6,30', "用户名至少6-30位！", self::EXISTS_VALIDATE, 'length'), //用户名长度不合法
        array('username', '', "用户名已被注册！", self::EXISTS_VALIDATE, 'unique'), //用户名被占用
        /* 验证密码 */
        array('password', '6,30', "密码名至少6-30位！", self::EXISTS_VALIDATE, 'length'), //密码长度不合法       
        array('last_login_ip', '\d+\.\d+\.\d+\.\d+', "IP 地址不合法", self::EXISTS_VALIDATE, 'regex'),  
        array('contact_name','require','请输入联系人！',self::MUST_VALIDATE),
        array('email','email','请输入正确的邮箱地址！',self::MUST_VALIDATE),
  );

    protected $_link=array(
        'Club'=>array(
            'mapping_type'=>self::HAS_MANY,
            'mapping_name'=>'clubs',
            'class_name'=>'Club',
            'foreign_key'=>'brand_id', 
            'mapping_fields'=>'id,club_name', 
            )
        );

}