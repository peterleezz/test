<?php
namespace Common\Model;
use Think\Model;
class PeakTimeModel extends Model {

   protected $_validate = array(
   	  array('peak_name','require','请输入时段名称！',self::MUST_VALIDATE),  
	     // array('club_id','require','请选择会所！',self::MUST_VALIDATE),  
	     array('peak_time','require','请选择时间！',self::MUST_VALIDATE), 	     	   
  );

     protected $_auto = array (         
         array('update_time','getDbTime',self::MODEL_BOTH,'function'), 
          array('brand_id','get_brand_id',self::MODEL_BOTH,'function'),  
     );
}