<?php
namespace Common\Model;
use Think\Model;
class ChannelSingleStatisticsModel extends Model {
    protected $_validate = array( 
        array('user_id','/^\d*(\.\d+)?$/','请输入正确的员工!',self::MUST_VALIDATE),
        array('protential_plan','/^\d*(\.\d+)?$/','请输入正确的潜在客户数量!',self::MUST_VALIDATE),
        array('protential_value','/^\d*(\.\d+)?$/','请输入正确的潜在客户数量',self::VALUE_VALIDATE),
        array('channel_plan','/^\d*(\.\d+)?$/','请输入正确的渠道客户数量!',self::MUST_VALIDATE),
        array('channel_value','/^\d*$/','请输入正确的渠道客户数量!',self::VALUE_VALIDATE), 
  );
 
   protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'),
       array('brand_id','get_brand_id',self::MODEL_BOTH,'function'),  
       array('club_id','get_club_id',self::MODEL_BOTH,'function'), 
    ); 

}