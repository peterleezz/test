<?php
namespace Common\Model;
use Think\Model\RelationModel;
class PtFollowUpModel extends RelationModel {
      protected $_auto = array(
      array('club_id','get_club_id',self::MODEL_BOTH,'function'),  
       array('pt_id','is_user_login',self::MODEL_BOTH,'function'),   
    ); 
 
    protected $_link = array(
        'pt'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"UserExtension",
          "mapping_name"=>"pt",
          'foreign_key'=>"pt_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_user_extension'
        ) , 

         'member'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"MemberBasic",
          "mapping_name"=>"member",
          'foreign_key'=>"member_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_member_basic'
        ) , 
        'ptclass'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"PtClass",
          "mapping_name"=>"ptclass",
          'foreign_key'=>"pt_class_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_pt_class'
        ) , 
     );

}