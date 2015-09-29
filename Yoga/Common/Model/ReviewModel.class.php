<?php
namespace Common\Model;
use Think\Model\RelationModel;
class ReviewModel extends RelationModel { 
      protected $_link = array(
        'club'=>array(
            "mapping_type"=>self::BELONGS_TO,
            "class_name"=>"Club",
            "mapping_name"=>"club",
            'foreign_key'=>"club_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_club',        
        ) , 
        'recorder'=>array(
            "mapping_type"=>self::BELONGS_TO,
            "class_name"=>"UserExtension",
            "mapping_name"=>"recorder",
            'foreign_key'=>"record_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_user_extension',        
        ) , 
     );
 
}