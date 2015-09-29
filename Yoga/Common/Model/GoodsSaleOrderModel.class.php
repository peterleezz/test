<?php
namespace Common\Model;
use Think\Model\RelationModel;
class GoodsSaleOrderModel extends RelationModel { 
  
     protected $_link = array(
      'sale_club'=>array(
            "mapping_type"=>self::BELONGS_TO,
            "class_name"=>"Club",
            "mapping_name"=>"sale_club",
            'foreign_key'=>"sale_club_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_club',
        
        ) , 

        'record_user'=>array(
            "mapping_type"=>self::BELONGS_TO,
            "class_name"=>"UserExtension",
            "mapping_name"=>"record_user",
            'foreign_key'=>"record_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_user_extension',
             'mapping_fields'=>"id,name_cn"
        ) , 
          'member'=>array(
            "mapping_type"=>self::BELONGS_TO,
            "class_name"=>"MemberBasic",
            "mapping_name"=>"member",
            'foreign_key'=>"member_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_member_basic',
           
        ) , 

          'goodslist'=>array(
            "mapping_type"=>self::HAS_MANY,
            "class_name"=>"GoodsSaleList",
            "mapping_name"=>"goodslist",
            'foreign_key'=>"order_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_goods_sale_list', 
        ) , 
          
     );

     
}