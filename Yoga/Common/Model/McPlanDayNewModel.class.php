<?php
namespace Common\Model;
use Think\Model;
class McPlanNewModel extends Model {
    protected $_validate = array( 
        array('user_id','/^\d+$/','请输入正确的员工!',self::MUST_VALIDATE),
 	      array('protential','/^\d*(\.\d+)?$/','请输入正确的新增潜客量!',self::MUST_VALIDATE),
        array('invit','/^\d*(\.\d+)?$/','请输入正确的邀约次数!',self::MUST_VALIDATE),
        array('invit_success','/^\d*(\.\d+)?$/','请输入正确的邀约量',self::VALUE_VALIDATE),
        array('invit_come','/^\d*(\.\d+)?$/','请输入正确的到场量!',self::MUST_VALIDATE),
        array('a_member','/^\d*$/','请输入正确的A类客户量!',self::VALUE_VALIDATE), 
        array('b_member','/^\d*(\.\d+)?$/','请输入正确的B类客户量!',self::MUST_VALIDATE),
        array('pre_sale','/^\d*$/','请输入正确的预购金额!',self::VALUE_VALIDATE), 
        array('sale','/^\d*(\.\d+)?$/','请输入正确的售出金额!',self::MUST_VALIDATE),
        array('deal_num','/^\d*$/','请输入正确的成交单数!',self::VALUE_VALIDATE), 
        array('transform','/^\d*$/','请输入正确的转换量!',self::VALUE_VALIDATE),  
  );
 
   protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'),
       array('brand_id','get_brand_id',self::MODEL_BOTH,'function'),  
       array('club_id','get_club_id',self::MODEL_BOTH,'function'), 
    ); 


}
