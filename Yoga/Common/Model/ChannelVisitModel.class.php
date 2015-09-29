<?php
namespace Common\Model;
use Think\Model\RelationModel;
class ChannelVisitModel extends RelationModel {
    protected $_validate = array(
         array('visit_name','require','跟进对象姓名不能为空!',1),
          array('channel_id','require','请选择跟进的渠道!',1),
          array('visit_phone','require','跟进对象电话不能为空!',1),
          array('description','require','跟进内容不能为空!',1), 
    );

     protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'),
       array('user_id','is_user_login',self::MODEL_BOTH,'function'),  
    ); 

    protected $_link = array(
        'user'=>array(
        	"mapping_type"=>self::BELONGS_TO,
        	"class_name"=>"UserExtension",
        	"mapping_name"=>"user",
        	'foreign_key'=>"user_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_user_extension'
        ) ,
         'channel'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"Channel",
          "mapping_name"=>"channel",
          'foreign_key'=>"channel_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_channel'
        ) 
     );

}