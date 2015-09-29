<?php
namespace Common\Controller;
use Think\Controller;
class QueryController extends BaseController {
 
    //综合查询
	public function getMemberInfo($member_id)
	{
		$member = M("MemberBasic")->find($member_id); 
        $avatar=$member['avatar'];
        if(strpos($avatar, "http")===0)
        {
          $member['avatar']=$avatar;
        }
        else
        {
          $member['avatar']="http://". $_SERVER['SERVER_NAME'].":81"."/Public/uploads/mmb_avatar/". $avatar;
        } 
		$contracts = D("Contract")->getAllContractByUser($member_id);
		$ptcontracts = D("PtContract")->getAllContract($member_id); 
		$cards=D("Card")->getAllCardsByUid($member_id);
		return array("info"=>$member,"contracts"=>$contracts,"ptcontracts"=>$ptcontracts,"cards"=>$cards);
	}

}