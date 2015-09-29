<?php
namespace Common\Model;
use Think\Model\RelationModel;
class RechargeHistoryModel extends RelationModel {
    protected $_validate = array(
        array('member_id','require','请选择需要充值的会员!',self::MUST_VALIDATE), 
        array('cash', 'number', "请输入正确的充值金额!", self::MUST_VALIDATE),  
         array('pos', 'number', "请输入正确的POS金额!", self::MUST_VALIDATE),
          array('check', 'number', "请输入正确的check金额!", self::MUST_VALIDATE),
             array('network', 'number', "请输入正确的network金额!", self::MUST_VALIDATE),
                array('netbank', 'number', "请输入正确的netbank金额!", self::MUST_VALIDATE),
  );
  protected $_auto = array(       
       array('record_id','is_user_login',self::MODEL_BOTH,'function'),  
    ); 
  
     protected $_link = array(
        'record_user'=>array(
            "mapping_type"=>self::BELONGS_TO,
            "class_name"=>"UserExtension",
            "mapping_name"=>"record_user",
            'foreign_key'=>"record_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_user_extension',
             'mapping_fields'=>"id,name_cn"
        ) , 
     );
}