<?php
namespace Common\Model;
use Think\Model\RelationModel;
class FinanceClubModel extends RelationModel { 

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