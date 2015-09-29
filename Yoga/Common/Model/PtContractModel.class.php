<?php
namespace Common\Model;
use Think\Model\RelationModel;
class PtContractModel extends RelationModel { 
    protected $_validate = array( 
        array('member_id','require','请选择会员信息!',1),
        array('class_id','require','请选择PT课程!',1),
        array('total_num','number','请输入正确的购买数量!',1), 
        array('start_time','/^\d{4}-\d{2}-\d{2}$/','请选择合同开始日期!',2),
        array('end_time','/^\d{4}-\d{2}-\d{2}$/','请选择合同结束日期!',2),
        array('standard_price','/^\d+(\.\d+)?$/','请输入正确的标准金额!!',1),
        array('should_pay','/^\d+(\.\d+)?$/','请输入正确的应收金额!!',1),
    );

      protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'),
       array('brand_id','get_brand_id',self::MODEL_BOTH,'function'),  
       array('club_id','get_club_id',self::MODEL_BOTH,'function'),  
       array('record_id','is_user_login',self::MODEL_BOTH,'function'),   
    ); 

        protected $_link = array(
        'ptclass'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"PtClass",
          "mapping_name"=>"ptclass",
          'foreign_key'=>"class_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_pt_class'
        ) , 

        'member'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"MemberBasic",
          "mapping_name"=>"member",
          'foreign_key'=>"member_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_member_basic', 
        ) , 

        'pt'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"UserExtension",
          "mapping_name"=>"pt",
          'foreign_key'=>"pt_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_user_extension',
            'mapping_fields'=>"id,name_cn"
        ) , 

      'club'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"Club",
          "mapping_name"=>"club",
          'foreign_key'=>"club_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_club',
            'mapping_fields'=>"id,club_name"
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



        public function getOneValidContract($card_id)
        {
            $ret = $this->where(array("total_num"=>array("gt","used_num"), "member_id"=>$member_id,"start_time"=>array("elt",$now),"end_time"=>array("egt",$now)))->order("start_time asc")->limit(1)->find();
            return $ret;
        }

        public function getAllValidContract($member_id)
        {
          $now=date("Y-m-d");
          $ret = $this->relation(true)-> where(array("total_num"=>array("gt","used_num"), "member_id"=>$member_id,"start_time"=>array("elt",$now),"end_time"=>array("egt",$now)))->order("start_time asc")->select();             
 
          return $ret;
        }


        public function getAllContract($member_id,$club_id=null)
        {
          if(empty($club_id))
              $club_id=get_club_id();
          $ret =$this->relation(true)->where(array("member_id"=>$member_id,"club_id"=>$club_id))->order("start_time asc")->select(); 
            return $ret;
        }


 
}
