<?php
namespace Common\Model;
use Think\Model\RelationModel;
class AppointHistoryModel extends RelationModel {
    protected $_validate = array( 
        array('member_id','number','Member Id Error!',self::MUST_VALIDATE),
        // array('open_id','require','Open_id Error',self::MUST_VALIDATE),
        array('schedule_id','number','Schedule Error',self::MUST_VALIDATE),  
          array('pos','number','Pos Error',self::MUST_VALIDATE),  
  );
 
   protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'), 
       array('create_time','getDbTime',self::MODEL_INSERT,'function'),  
    );  

    protected $_link = array( 
   'member'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"MemberBasic",
          "mapping_name"=>"member",
          'foreign_key'=>"member_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_member_basic',  
        ) , 
     
     'schedule'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"ClubSchedule",
          "mapping_name"=>"schedule",
          'foreign_key'=>"schedule_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_club_schedule',  
        ) , 

     );  

}