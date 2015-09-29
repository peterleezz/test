<?php
namespace Common\Model;
use Think\Model\RelationModel;
class PayBackModel extends RelationModel { 
 protected $_link = array(  
      'contract'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"Contract",
          "mapping_name"=>"contract",
          'foreign_key'=>"contract_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_contract', 
        ) ,  
      'recorder'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"UserExtension",
          "mapping_name"=>"recorder",
          'foreign_key'=>"apply_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_user_extension',
            'mapping_fields'=>"id,name_cn"
        ) ,  

      'reviewer'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"UserExtension",
          "mapping_name"=>"reviewer",
          'foreign_key'=>"review_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_user_extension',
            'mapping_fields'=>"id,name_cn"
        ) ,  
       'club'=>array(
            "mapping_type"=>self::BELONGS_TO,
            "class_name"=>"Club",
            "mapping_name"=>"club",
            'foreign_key'=>"club_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_club',        
        ) , 
     );    
  
}