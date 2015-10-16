<?php
namespace Common\Model;
use Think\Model\RelationModel;
class GoodsModel extends RelationModel {

     const   BUKA     =   0;
     const   TINGKA     =   1;
     const   XUHUI     =  2;
     const   SHENGJI     = 3;
     const   ZHUANRANG     =4; 

     public function getBukaFee()
     {
        $ret= $this->getSystemGoods(self::BUKA,get_club_id());
        return $ret ;
     }
       public function getTingkaFee()
     {
        $ret= $this->getSystemGoods(self::TINGKA,get_club_id());
         return $ret ;
     }
       public function getXuhuiFee()
     {
        $ret= $this->getSystemGoods(self::XUHUI,get_club_id());
         return $ret ;
     }
       public function getShengjiFee()
     {
        $ret= $this->getSystemGoods(self::SHENGJI,get_club_id());
         return $ret ;
     }
       public function getZhuanrangFee()
     {
        $ret= $this->getSystemGoods(self::ZHUANRANG,get_club_id());
        return $ret ;
     }
      


    protected $_validate = array(
        array('name','require','商品名不能为空!',1),
        array('price','require','价格不能为空!',1),
        array('price','/^[-\+]?\d+(\.\d+)?$/','价格格式不正确!',2),
        array('category_id','/^\d+$/','请选择商品分类!',1),
        array('total_num','/^\d+$/','商品数量需为整数!',2),
    );

     protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'),
       array('brand_id','get_brand_id',self::MODEL_BOTH,'function'),  
    ); 

    protected $_link = array(
        'clubs'=>array(
        	"mapping_type"=>self::MANY_TO_MANY,
        	"class_name"=>"GoodsClub",
        	"mapping_name"=>"clubs",
        	'foreign_key'=>"goods_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_goods_club'
        ) ,

         'category'=>array(
            "mapping_type"=>self::BELONGS_TO,
            "class_name"=>"GoodsCategory",
            "mapping_name"=>"category",
            'foreign_key'=>"category_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_goods_category'
        ) ,
     );

    public function getSystemGoods($sys_type=0,$club_id=0)
    {
            $goods = $this->table(array("yoga_goods"=>"a","yoga_goods_club"=>"b"))->where("b.club_id={$club_id} and a.status=1 and a.id=b.goods_id and a.sys_type={$sys_type} and a.is_system=1")->field("a.*")->find();
            return $goods;
    }
}