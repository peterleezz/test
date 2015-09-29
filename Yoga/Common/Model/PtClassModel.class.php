<?php
namespace Common\Model;
use Think\Model\RelationModel;
class PtClassModel extends RelationModel {
    protected $_validate = array(
        array('name','require','PT名不能为空!',1),
        array('price','require','价格不能为空!',1),
        array('price','/^[-\+]?\d+(\.\d+)?$/','价格格式不正确!',2), 
    );

     protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'),
       array('brand_id','get_brand_id',self::MODEL_BOTH,'function'),  
    ); 

    protected $_link = array(
        'clubs'=>array(
        	"mapping_type"=>self::MANY_TO_MANY,
        	"class_name"=>"PtClub",
        	"mapping_name"=>"clubs",
        	'foreign_key'=>"pt_class_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_pt_club'
        ) 
     );

      public function getAllCanSaleClasses($club_id=null)
   {
       $club_id=empty($club_id)?get_club_id():$club_id;
       $timenow = date("Y-m-d"); 
       $sql="SELECT b.* FROM yoga_pt_club a,yoga_pt_class b where `a`.`club_id`=$club_id and `a`.`pt_class_id` = `b`.`id` and  `b`.`status`!=0";

       return $this->query($sql);
   }


}