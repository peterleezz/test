<?php
namespace Common\Model;
use Think\Model\RelationModel;
class ClubScheduleModel extends RelationModel {
    protected $_validate = array( 
        array('room_id','require','Room  Error!',self::MUST_VALIDATE),
          array('room_id','require','Room  Error!',self::MUST_VALIDATE),
            array('room_id','require','Room  Error!',self::MUST_VALIDATE),
        array('class_id','require','class_id Error',self::MUST_VALIDATE), 
  );
 
   protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'), 
       array('create_time','getDbTime',self::MODEL_INSERT,'function'), 
       array('club_id','get_club_id',self::MODEL_INSERT,'function'), 
    );  

   protected $_link = array( 
   'room'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"ClubClassroom",
          "mapping_name"=>"room",
          'foreign_key'=>"room_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_club_classroom',  
        ) , 
    'pt'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"UserExtension",
          "mapping_name"=>"pt",
          'foreign_key'=>"pt_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_user_extension',  
        ) , 
      'class'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"PtClassPublic",
          "mapping_name"=>"class",
          'foreign_key'=>"class_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_pt_class_public',
          
        ) 
     );  

}