<?php
namespace Common\Model;
use Think\Model\RelationModel;
class ContractModel extends RelationModel { 
  //status :1-new 2-continue 3-upgrade 4-transform' 5--be upgraded  6--be transformed
    protected $_validate = array( 
        array('member_id','require','请选择访客信息!',1),
        array('type','require','请选择普通卡或团卡!',1),
        array('card_type_id','require','请选择卡种类型!',1),
        array('active_type','require','请选择开卡方式!',1),
        array('start_time','/^\d{4}-\d{2}-\d{2}$/','请选择合同开始日期!',2),
        array('end_time','/^\d{4}-\d{2}-\d{2}$/','请选择合同结束日期!',2),
        array('price','number','请选择应付价格!',1),
        array('cash','number','请输入正确的现金金额!',1),
        array('pos','number','请输入正确的POS刷卡金额!',1),
        array('check','number','请输入正确的支票金额刷卡数!',1),
         array('network','number','请输入正确的网络支付金额!',1),
          array('netbank','number','请输入正确的网银分期金额!',1),
        array('present_num','number','请输入正确的赠送次数或天数!',1),
        array('present_day','number','请输入正确的赠送次数或天数!',1),

    );

      protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'),
       array('brand_id','get_brand_id',self::MODEL_BOTH,'function'),  
      array('record_id','is_user_login',self::MODEL_BOTH,'function'),  
      array('sale_club_id','get_club_id',self::MODEL_BOTH,'function'),  
    ); 

        protected $_link = array(
        'card_type'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"CardType",
          "mapping_name"=>"card_type",
          'foreign_key'=>"card_type_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_card_type'
        ) , 

        'member'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"MemberBasic",
          "mapping_name"=>"member",
          'foreign_key'=>"member_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_member_basic',
            'mapping_fields'=>"id,name,phone,sex"
        ) , 

      'sale_club'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"Club",
          "mapping_name"=>"sale_club",
          'foreign_key'=>"sale_club_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_club',
            'mapping_fields'=>"id,club_name"
        ) , 


     ); 



        public function getOneValidContract($card_id)
        {
            $ret = $this->where(array("card_id"=>$card_id,"invalid"=>array("neq",0)))->order("start_time asc")->select();
            foreach ($ret as $key => $value) {
              # choose one valid card!
              #time  ,active_type{star_time,end_time is null?} ,times,invalid
               $card_type=M("CardType")->find($value['card_type_id']);$ret[$key]['card_type']=$card_type;
              if($card_type['type']==2 && $value["total_num"]<$value["used_num"]) continue;
              if($value['active_type']==2 && $value['start_time']=='0000-00-00' && $value['end_time']=='0000-00-00' )
              {
                return $value;
              }

              $timenow=date('Y-m-d');
              if( $value['start_time']>$timenow || $value['end_time']<$timenow) continue;
             
              return $value;
            }
            return $ret[count($ret)-1];
        }

        public function getAllValidContract($card_id)
        {
          $ret = $this->where(array("card_id"=>$card_id,"invalid"=>array("neq",0)))->order("start_time asc")->select();
            foreach ($ret as $key => $value) { 
               $card_type=M("CardType")->find($value['card_type_id']);$ret[$key]['card_type']=$card_type;
              if($card_type['type']==2 && $value["total_num"]<$value["used_num"])
              {
                unset($ret[$key]);
                continue;
              }  
              if($value['active_type']==2 && $value['start_time']=='0000-00-00' && $value['end_time']=='0000-00-00' )
              {
                continue;
              }
              $timenow=date('Y-m-d');
              if( $value['start_time']>$timenow || $value['end_time']<$timenow)  {
                unset($ret[$key]);
                continue;
              }   
            }
            return $ret;
        }

        public function getAllValidContractByUid($member_id)
        {
          $ret = $this->where(array("member_id"=>$member_id,"invalid"=>array("neq",0)))->order("start_time asc")->select(); 
            foreach ($ret as $key => $value) { 
               $card_type=M("CardType")->find($value['card_type_id']);$ret[$key]['card_type']=$card_type;
              if($card_type['type']==2 && $value["total_num"]<$value["used_num"])
              {
                unset($ret[$key]);
                continue;
              }  
              if($value['active_type']==2 && $value['start_time']=='0000-00-00' && $value['end_time']=='0000-00-00' )
              {
                continue;
              }
              $timenow=date('Y-m-d');
              if( $value['start_time']>$timenow || $value['end_time']<$timenow)  {
                unset($ret[$key]);
                continue;
              }   
            }
            return $ret;
        }


        public function getAllContract($card_id)
        {
          $ret = $this->relation(true)->where(array("card_id"=>$card_id,"invalid"=>array("neq",0)))->order("start_time asc")->select(); 
          return $ret;
        } 


        public function getAllContractByUid($member_id)
        {
          $ret = $this->relation(true)->where(array("member_id"=>$member_id,"invalid"=>array("neq",0)))->order("start_time asc")->select(); 
          return $ret;
        } 



        public function getAllContractByUser($member_id)
        {
          $ret = $this->relation(true)->where(array("member_id"=>$member_id))->order("start_time asc")->select(); 
          return $ret;
        } 
}