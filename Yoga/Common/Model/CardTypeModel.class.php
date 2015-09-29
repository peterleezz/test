<?php
namespace Common\Model;
use Think\Model\RelationModel;
class CardTypeModel extends RelationModel {
    protected $_validate = array(
        array('name','require','卡种名不能为空!',1),
        array('price','require','价格不能为空!',1),
        array('price','/^\d+(\.\d+)?$/','价格格式不正确!',2),
         array('min_price','require','价格不能为空!',1),
        array('min_price','/^\d+(\.\d+)?$/','价格格式不正确!',2),
        array('valid_time','require','有效时间不能为空!',1),
        array('valid_time','/^\d+?$/','有效时间格式不正确!',2),
    );

     protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'),
       array('brand_id','get_brand_id',self::MODEL_BOTH,'function'),  
    ); 

    protected $_link = array(
        'saleclub'=>array(
        	"mapping_type"=>self::MANY_TO_MANY,
        	"class_name"=>"Club",
        	"mapping_name"=>"saleclub",
        	'foreign_key'=>"card_type_id",
            'relation_foreign_key'  =>  'club_id',
            'relation_table'    =>  'yoga_card_saleclub'
        ) ,
        'useclub'=>array(
            "mapping_type"=>self::MANY_TO_MANY,
            "class_name"=>"Club",
            "mapping_name"=>"useclub",
            'foreign_key'=>"card_type_id",
            'relation_foreign_key'  =>  'club_id',
            'relation_table'    =>  'yoga_card_useclub'
        ) ,
     );

    public function getAllCanSaleCardTypes($brand_id=null,$club_id=null)
    {
        $brand_id=empty($brand_id)?get_brand_id():$brand_id;
        $can_sale_id = D("CardSaleclub")->getCanSaleCards($club_id);
        $ids = "";
        foreach ($can_sale_id as $key => $value) { 
            if($key!=0) $ids.=",";
            $ids.=$value["id"];
        }
         $condition=array("brand_id"=>$brand_id,"id"=>array("in",$ids));
         return    $this->relation(true)->where($condition)->select();

    }


    public function getAllBrandCardTypes($brand_id=null)
    {
         $brand_id=empty($brand_id)?get_brand_id():$brand_id;
         return $this->where(array("brand_id"=>$brand_id))->select();
    }

    public function getAllCanUpgrade($old_card_start_time,$card_type_id,$brand_id=null)
    {
        $brand_id=empty($brand_id)?get_brand_id():$brand_id;
        $can_sale_id = D("CardSaleclub")->getCanSaleCards();
        $ids = "";
        foreach ($can_sale_id as $key => $value) {
            if($value['id']==$card_type_id) continue;
            if($key!=0) $ids.=",";
            $ids.=$value["id"];
        }
        $cardtype=$this->find($card_type_id);
        $price = $cardtype['price'];
        // $valid_time = $cardtype['valid_time'];
        // $valid_number=$cardtype['valid_number'];
        // $type=$cardtype['type'];
        $condition=array("price"=>array("EGT",$price), "brand_id"=>$brand_id,"id"=>array("in",$ids));
        // if($type==1) //time
        // {
        //     $condition["valid_time"]=array("EGT",$valid_time);
        // }
        // else
        // {

        // }
        $ret = $this->where($condition)->select();
      
        $old_start_time=strtotime($old_card_start_time);
        $now=time();
        foreach ($ret as $key => $value) {
            $month = $value["valid_time"]; 
            $end_time =strtotime("+$month month", $old_start_time);
            if($end_time <= $now)
            {
                unset($ret[$key]);
            }
        }
        return $ret;
    }
    

}