<?php
namespace Common\Model;
use Think\Model\RelationModel;
class BillProjectModel extends RelationModel { 
    protected $_validate = array( 
        array('type','number','Type Error',self::MUST_VALIDATE), //0-contract 1-pt 2-goods 3-transform  4-continue 5-upgrade 7-recharge 8--pt book 9--contract book |(10--tuika 11--continue_extra 12--upgrade_extra 13--transform_extra 14--rest_extra)
        array('sub_type','number','Sub_type Error',self::MUST_VALIDATE), //no use anymore
        array('member_id','number','请输入正确的会员！!',self::MUST_VALIDATE),
        array('price','/^\d*(\.\d+)?$/','请输入正确的价格!',self::MUST_VALIDATE),
        array('paid','/^\d*$/','请输入正确的金额！!',self::MUST_VALIDATE),
        array('status','number','Status Error',self::MUST_VALIDATE), 
  );
 
   protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'),
       array('brand_id','get_brand_id',self::MODEL_BOTH,'function'),  
       array('sale_club_id','get_club_id',self::MODEL_BOTH,'function'),
       array('number','get_number',self::MODEL_BOTH,'callback'),
       array('record_id','is_user_login',self::MODEL_BOTH,'function'),
    ); 

 protected $_link = array( 
   'member'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"MemberBasic",
          "mapping_name"=>"member",
          'foreign_key'=>"member_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_member_basic',
            'mapping_fields'=>"id,name,phone,sex"
        ) , 
      'mc'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"UserExtension",
          "mapping_name"=>"mc",
          'foreign_key'=>"mc_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_user_extension',
            'mapping_fields'=>"id,name_cn"
        ) ,  
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


   public function get_number()
   {
      return date("YmdHis").rand(0,10000);
   }
}