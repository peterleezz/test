<?php
namespace Common\Model;
use Think\Model\RelationModel;
class MemberBasicModel extends RelationModel {
    protected $_validate = array(
          array('name','require','访客姓名不能为空!',3),
          array('phone','require','访客手机号码不能为空!',3),
          array('sex','require','访客性别不能为空!',3),
          array('type','require','访客分类不能为空!',3),
    );

     protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'),
       array('record_id','is_user_login',self::MODEL_BOTH,'function'), 
       array('brand_id','get_brand_id',self::MODEL_BOTH,'function'),  
       array('club_id','get_club_id',self::MODEL_BOTH,'function'),  
    ); 

    protected $_link = array(
        'record_user'=>array(
        	"mapping_type"=>self::BELONGS_TO,
        	"class_name"=>"UserExtension",
        	"mapping_name"=>"record_user",
        	'foreign_key'=>"record_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_user_extension'
        ) ,
        // 'recommend_user'=>array(
        //   "mapping_type"=>self::BELONGS_TO,
        //   "class_name"=>"UserExtension",
        //   "mapping_name"=>"user",
        //   'foreign_key'=>"recommend_id",
        //     'relation_foreign_key'  =>  'id',
        //     'relation_table'    =>  'yoga_user_extension'
        // ) , 

         'mc'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"UserExtension",
          "mapping_name"=>"mc",
          'foreign_key'=>"mc_id",
            'relation_foreign_key'  =>  'id',
               'mapping_fields'=>"id,name_cn",
            'relation_table'    =>  'yoga_user_extension'
        ) , 

'pt'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"UserExtension",
          "mapping_name"=>"pt",
          'foreign_key'=>"pt_id",
            'relation_foreign_key'  =>  'id',
               'mapping_fields'=>"id,name_cn",
            'relation_table'    =>  'yoga_user_extension'
        ) , 

'contracts'=>array(
          "mapping_type"=>self::HAS_MANY,
          "class_name"=>"Contract",
          "mapping_name"=>"contracts",
          'foreign_key'=>"member_id",
            'relation_foreign_key'  =>  'id', 
            'relation_table'    =>  'yoga_contract'
        ) , 




'near_club_info'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"Club",
          "mapping_name"=>"near_club_info",
          'foreign_key'=>"near_club",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_club'
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