<?php
namespace Common\Model;
use Think\Model;
class ClubModel extends Model {
    protected $_validate = array(
        array('club_name','require','请输入会所名称！',self::MUST_VALIDATE),        
        array('email','email','请输入正确的邮箱地址！',self::VALUE_VALIDATE),
        array('code','checkcode','会所代码已存在！',self::VALUE_VALIDATE,"callback"),
  );

     protected $_auto = array (         
         array('update_time','getDbTime',self::MODEL_BOTH,'function'), 
         array('create_time','getDbTime',self::MODEL_INSERT,'function'), 
     );

     private function checkcode()
     {
     	return false;
     }

     public function getAllClubsName()
     {
        return  $this->where(array("brand_id"=>get_brand_id()))->field('id,club_name')->select(); 
     }
}