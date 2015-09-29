<?php
namespace Common\Model;
use Think\Model\RelationModel;
class GoodsModel extends RelationModel {
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

}