<?php
namespace Common\Model;
use Think\Model;
class ClubClassroomModel extends Model {
    protected $_validate = array( 
        array('name','require','Class Name Error!',self::MUST_VALIDATE),
        array('rows','number','Rows Error',self::MUST_VALIDATE),
        array('num','number','Number Error',self::MUST_VALIDATE),  
  );
 
   protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'), 
       array('create_time','getDbTime',self::MODEL_INSERT,'function'), 
       array('club_id','get_club_id',self::MODEL_INSERT,'function'), 
    ); 

   public function getRooms($club_id)
   {
      $conditon=array("club_id"=>$club_id);
      return $this->where($conditon)->select();
   }
}