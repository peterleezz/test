<?php
namespace Common\Model;
use Think\Model\RelationModel;
class CardUseclubModel extends RelationModel {
    protected $_validate = array( 
        array('card_type_id','require','card_type_id can not be empty!',1),
        array('club_id','require','club_id can not be empty!',1),
    );
 
	public function getAllUseClub($card_type_id)
    {
    	$sql="select a.id,a.club_name from yoga_club a,yoga_card_useclub b where b.card_type_id=$card_type_id and a.id=b.club_id ";
   		return $this->query($sql);
    }
 
  public function getAllUseClubs($card_type_ids)
    {
      $sql="select  a.* from yoga_club a,yoga_card_useclub b where b.card_type_id in ('{$card_type_ids}') and a.id=b.club_id ";
      return $this->query($sql);
    }


     public function getCanUseCards($club_id=null)
    {
       $club_id=empty($club_id)?get_club_id():$club_id;
       $timenow = date("Y-m-d"); 
       $sql="SELECT b.* FROM yoga_card_useclub a,yoga_card_type b where a.club_id=$club_id and a.card_type_id = b.id";
       return $this->query($sql);

    }

    public function canUse($card_type_id,$club_id)
    {
        $ret = $this->where(array("card_type_id"=>$card_type_id,"club_id"=>$club_id))->find();
        return !empty($ret);
    }

    public function getCanUseClubs($member_id)
    {
        //获取所有的合同
        $contracts = D("Contract")->getAllContractByUid($member_id);
        $arr=array();
        foreach ($contracts as $key => $value) {
           $card_type_id=$value['card_type_id']; 
           $arr[]=$card_type_id;
        }if(empty($arr)) return null;
        $arr = array_unique($arr); 
        $card_type_ids = implode($arr, ",");
        $clubs = $this->getAllUseClubs($card_type_ids);
        return $clubs; 
    }
}
