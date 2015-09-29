<?php
namespace Common\Model;
use Think\Model\RelationModel;
class ClubScheduleModel extends RelationModel {
   

   protected $_link = array( 
   'recorder'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"UserExtension",
          "mapping_name"=>"recorder",
          'foreign_key'=>"member_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_user_extension',  
        ) ,  
     );  

}