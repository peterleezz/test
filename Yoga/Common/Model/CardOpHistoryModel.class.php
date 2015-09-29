<?php
namespace Common\Model;
use Think\Model\RelationModel;
class CardOpHistoryModel extends RelationModel {
    protected $_validate = array(
        array('card_id','require','card_id is require!',self::MUST_VALIDATE), 
        array('card_status', 'require', "card_status is require!", self::MUST_VALIDATE),
  );
     protected $_auto = array(       
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


 public function updateStatus($card_id,$status,$status_before,$extension="",$record_id=null)
 {
    $record_id=empty($record_id)?is_user_login():$record_id;
    $this->data(array("card_id"=>$card_id,"card_status"=>$status,"record_id"=>$record_id,"status_before"=>$status_before,"extension"=>$extension))->add();
 }
}