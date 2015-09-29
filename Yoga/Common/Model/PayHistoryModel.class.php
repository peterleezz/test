<?php
namespace Common\Model;
use Think\Model\RelationModel;
class PayHistoryModel extends RelationModel {
    protected $_validate = array( 
        array('type','number','Type Error',self::MUST_VALIDATE),//0--first 1--after payment 
        array('bill_project_id','number','Bill Project Error',self::MUST_VALIDATE), 
        array('cash','/^\d+(\.\d+)?$/','请输入正确的现金金额!',self::MUST_VALIDATE),
        array('pos','/^\d+(\.\d+)?$/','请输入正确的POS金额!',self::MUST_VALIDATE),
        array('check','/^\d+(\.\d+)?$/','请输入正确的支票金额!',self::MUST_VALIDATE),
        array('recharge','/^\d+(\.\d+)?$/','请输入正确的储值卡金额!',self::MUST_VALIDATE), 
         array('network','/^\d+(\.\d+)?$/','请输入正确的网络支付金额!',self::MUST_VALIDATE), 
          array('netbank','/^\d+(\.\d+)?$/','请输入正确的网银分期金额!',self::MUST_VALIDATE), 
  );
 
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

      'bill'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"BillProject",
          "mapping_name"=>"bill",
          'foreign_key'=>"bill_project_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_bill_project', 
        ) ,  

     );  
}