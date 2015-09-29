<?php
namespace Common\Model;
use Think\Model\RelationModel;
class CashHistoryModel extends RelationModel { 
     protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'),
       array('brand_id','get_brand_id',self::MODEL_BOTH,'function'),  
       array('club_id','get_club_id',self::MODEL_BOTH,'function'),  
       array('record_id','is_user_login',self::MODEL_BOTH,'function'),  
    ); 
  protected $_link = array( 
      'recorder'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"UserExtension",
          "mapping_name"=>"recorder",
          'foreign_key'=>"record_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_user_extension',
            'mapping_fields'=>"id,name_cn"
        ) , 


     );  
}