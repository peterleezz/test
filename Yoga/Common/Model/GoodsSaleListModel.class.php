<?php
namespace Common\Model;
use Think\Model\RelationModel;
class GoodsSaleListModel extends RelationModel { 
    protected $_auto = array( 
       array('brand_id','get_brand_id',self::MODEL_BOTH,'function'),  
       array('sale_club_id','get_club_id',self::MODEL_BOTH,'function'), 
    );  
}