<?php
namespace Common\Model;
use Think\Model;
class PtClassPublicModel extends Model {
    protected $_validate = array( 
        array('name','require','Class Name Error!',self::MUST_VALIDATE),
        array('time','number','Time Error',self::MUST_VALIDATE),
        array('lang','require','Language Error!',self::MUST_VALIDATE),
        array('level','/^[1-5]$/','Level Error!',self::MUST_VALIDATE), 
  );
 
   protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'), 
       array('create_time','getDbTime',self::MODEL_BOTH,'function'), 
    ); 

}