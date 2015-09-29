<?php
namespace Common\Model;
use Think\Model;
class LockModel extends Model {
    protected $_validate = array( 
        array('locknum','require','请输入柜子号!',self::MUST_VALIDATE),
        array('club_id','number','Club id Error',self::MUST_VALIDATE),
        array('key','require','柜子密钥错误！',self::MUST_VALIDATE),  
  );
 
   protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'), 
       array('create_time','getDbTime',self::MODEL_INSERT,'function'), 
    ); 

    
}