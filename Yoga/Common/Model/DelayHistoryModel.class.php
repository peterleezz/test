<?php
namespace Common\Model;
use Think\Model\RelationModel;
class DelayHistoryModel extends RelationModel {    
    protected $_validate = array(
        array('club_id','require','请选择延期会所！',self::MUST_VALIDATE),     
        array('delay_day', 'number', "请输入延期天数！", self::MUST_VALIDATE), 
        array('reason', 'require', "请输入延期原因", self::MUST_VALIDATE), 
  );
 
    protected $_auto = array(    
       array('brand_id','get_brand_id',self::MODEL_INSERT,'function'),  
    ); 

        protected $_link = array(
        'club'=>array(
            "mapping_type"=>self::BELONGS_TO,
            "class_name"=>"Club",
            "mapping_name"=>"club",
            'foreign_key'=>"club_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_club'
        ) ,
 
     );

}