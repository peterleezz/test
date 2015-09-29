<?php
namespace Common\Model;
use Think\Model\RelationModel;
class GoodsClubModel extends RelationModel {    
   protected $_validate = array(
        array('goods_id','require','goods_id is require!!',1),
        array('club_id','require','club id is require!',1),        
    );

   public function getAllCanSaleGoods($club_id=null)
   {
   	   $club_id=empty($club_id)?get_club_id():$club_id;
       $timenow = date("Y-m-d"); 
       $sql="SELECT b.* FROM yoga_goods_club a,yoga_goods b where a.club_id=$club_id and a.goods_id = b.id and  b.status!=0";

       return $this->query($sql);
   }
}