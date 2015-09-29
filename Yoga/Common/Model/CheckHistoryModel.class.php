<?php
namespace Common\Model;
use Think\Model\RelationModel;
class CheckHistoryModel extends RelationModel { 
 
   protected $_auto = array( 
       array('brand_id','get_brand_id',self::MODEL_BOTH,'function'),  
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

         'contract'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"Contract",
          "mapping_name"=>"contract",
          'foreign_key'=>"contract_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_contract', 
        ) ,  

          'club'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"Club",
          "mapping_name"=>"club",
          'foreign_key'=>"club_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_club', 
        ) , 

           'card'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"Card",
          "mapping_name"=>"card",
          'foreign_key'=>"card_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_card', 
        ) , 
     );  
}