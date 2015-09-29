<?php
namespace Common\Model;
use Think\Model\RelationModel;
class CardModel extends RelationModel { 
    protected $_validate = array(  
        array('card_type_id','require','请选择卡种类型!',1), 
        array('member_id','require','请选择会员!',1),
        array('start_time','/^\d{4}-\d{2}-\d{2}$/','请选择开始日期!',1),
        array('end_time','/^\d{4}-\d{2}-\d{2}$/','请选择结束日期!',1), 
    );

      protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'),  
        array('brand_id','get_brand_id',self::MODEL_BOTH,'function'),  
    ); 

      public function isExist($card_number,$brand_id)
      {
         $ret = $this->where(array("card_number"=>$card_number,"brand_id"=>$brand_id))->find();
         return !empty($ret);
      } 

      public function getCard($card_number,$brand_id)
      {
        $ret = $this->where(array("card_number"=>$card_number,"brand_id"=>$brand_id))->find();
       return $ret;
      }
  
       public function getCardByNumber($card_number)
      {
        $ret = $this->where(array("card_number"=>$card_number))->select();
       return $ret;
      }


      public function getAllCards($member_id,$brand_id=null)
      {
        if(empty($brand_id))
        {
          $brand_id=get_brand_id();
        }
        if(!empty($brand_id))
           return $this->where(array("member_id"=>$member_id,"brand_id"=>$brand_id,"status"=>array("neq",5)))->select();
        else
          return $this->where(array("member_id"=>$member_id,"status"=>array("neq",5)))->select();
      }

       public function getAllCardsByUid($member_id )
      { 
          return $this->where(array("member_id"=>$member_id))->select();
      }

}