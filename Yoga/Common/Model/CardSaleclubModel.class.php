<?php
namespace Common\Model;
use Think\Model\RelationModel;
class CardSaleclubModel extends RelationModel {
    protected $_validate = array( 
        array('card_type_id','require','card_type_id can not be empty!',1),
        array('club_id','require','club_id can not be empty!',1),
    );
 
    protected $_link = array(
        'card_type'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"CardType",
          "mapping_name"=>"card_type",
          'foreign_key'=>"card_type_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_card_type'
        ) , 
     );

    public function getCanSaleCards($club_id=null)
    {
       $club_id=empty($club_id)?get_club_id():$club_id;
       $timenow = date("Y-m-d"); 
       $sql="SELECT b.* FROM yoga_card_saleclub a,yoga_card_type b where a.club_id=$club_id and a.card_type_id = b.id and b.start_time <='{$timenow}' and b.end_time >= '{$timenow}' and b.status!=0";

       return $this->query($sql);

    }
}