<?php
namespace Common\Model;
use Think\Model;
class SpiderCodeProjectModel extends Model { 
    protected $_validate = array( 
        array('code','require','Code Error',self::MUST_VALIDATE),  
          array('name','require','Name Error',self::MUST_VALIDATE),  
            array('phone','require','Phone Error',self::MUST_VALIDATE),  
  );
 }