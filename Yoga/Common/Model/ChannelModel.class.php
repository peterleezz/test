<?php
namespace Common\Model;
use Think\Model\RelationModel;
class ChannelModel extends RelationModel {
    protected $_validate = array(
        array('name','require','渠道名不能为空!',1),
    );

     protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'),
       array('brand_id','get_brand_id',self::MODEL_BOTH,'function'),  
       array('club_id','get_club_id',self::MODEL_BOTH,'function'),  
    ); 

     public function getAllChannelName()
     {
     	 return  $this->where(array("club_id"=>get_club_id()))->field('id,name')->select(); 
     }

       public function getChannelNameByUser($user_id)
     {
         return  $this->where(array("user_id"=>$user_id))->field('id,name')->select(); 
     }


     protected $_link = array(
        'user'=>array(
            "mapping_type"=>self::BELONGS_TO,
            "class_name"=>"UserExtension",
            "mapping_name"=>"user",
            'foreign_key'=>"user_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_user_extension',
             'mapping_fields'=>"id,name_cn"
        ) , 
     );

 
}