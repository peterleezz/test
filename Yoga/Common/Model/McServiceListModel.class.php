<?php
namespace Common\Model;
use Think\Model\RelationModel;
class McServiceListModel extends RelationModel {
      protected $_auto = array( 
       array('mc_id','is_user_login',self::MODEL_BOTH,'function'),   
       array('club_id','get_club_id',self::MODEL_BOTH,'function'),  
    ); 
 

    protected $_link = array(
        'goods'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"Goods",
          "mapping_name"=>"goods",
          'foreign_key'=>"recommend_goods_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_goods'
        ) , 
         'mc'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"UserExtension",
          "mapping_name"=>"mc",
          'foreign_key'=>"mc_id",
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
         
     );


}