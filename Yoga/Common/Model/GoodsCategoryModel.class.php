<?php
namespace Common\Model;
use Think\Model\RelationModel;
class GoodsCategoryModel extends RelationModel { 

    protected $_link = array( 
         'goods'=>array(
            "mapping_type"=>self::HAS_MANY,
            "class_name"=>"Goods",
            "mapping_name"=>"goods",
            'foreign_key'=>"category_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_goods'
        ) ,
     );

}