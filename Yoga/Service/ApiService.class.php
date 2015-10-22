<?php
namespace Service;
class ApiService  extends CService
{
	protected static $instance;
	public static function getInstance($name = 'default'){
        if (empty(self::$instance[$name])){
            self::$instance[$name] = new ApiService($name);
        }
        return self::$instance[$name];

    }

	public function __construct()
	{
		
	}

public function out($cardid,$clubid)
  {
    $card=$this->getCard($cardid);
    if(!$card)return array(-1,null);
    $member=$this->getMember($card['member_id']);
    if(!$member)return array(-1,null);
        list($status,$contract)=$this->findOneContract($card['id'],$clubid);         
        $ct=$contract;
        if($status==0  || $status==5) 
        {  
            $card["check_status"]=0;
            $card["last_check_out_time"]=date('Y-m-d H:i:s');
            M("Card")->data($card)->save();
            //record list
            M("CheckHistory")->data(array("brand_id"=>$contract["brand_id"],"member_id"=>$card["member_id"],"status"=>0,"club_id"=>$clubid,"card_id"=>$card['id'],"contract_id"=>$contract["id"]))->add();
        }
        $rspMember=$this->responseMember($member,$ct,$card,$status); 
        return array($status,$rspMember);  
  }

public function ptout($cardid,$clubid)
{
    $card=$this->getCard($cardid);
    if(!$card)return array(-1,null);
    $member=$this->getMember($card['member_id']);
    if(!$member)return array(-1,null);
        list($status,$contract)=$this->findOnePtContract($member['id'],$clubid); 
        if(!empty($contract))
           if($contract['status']==1)
              {
                  $this->consumeend($contract['id']); 
              }
    
     $rspMember=$this->responseMember($member,$contract,$card,$status); 
        return array($status,$rspMember);  
}

  public function consumeend($id)
  { 
     M("PtContract")->where("id=$id")->setField("status",0);
     M("PtConsumeHistory")->where(array("contract_id"=>$id ,"status"=>0))->order("id asc")->limit(1)->setField(array("end_time"=>getDbTime(),"status"=>1)) ;
     M("PtContract")->where("id=$id")->setInc("used_num",1);
     $id= M("PtConsumeHistory")->field("id")->where(array("contract_id"=>$id))->order("id desc")->limit(1)->find();
     $id=$id['id'];
     $this->printpt($id);
  }


 public function findOnePtContract($memberid,$club_id)
  {
    $contracts=D("PtContract")->getAllContract($memberid,$club_id);
    if(empty($contracts))
    {
      $err="all relate contracts are transform to other cards!"; 
      $this->setError("all relate contracts are transform to other cards!"); 
      return array(7,null);
    } 
      foreach ($ret as $key => $value) { 
            
               //times
              if(  $value["total_num"]<=$value["used_num"])
              {
                $err="times out!";
                unset($ret[$key]);
                   $this->setError("times out!"); 
                $status=5;
                continue;
              }   
              if($value['invalid']!=1)
              {
                $this->setError("have transform");
                unset($ret[$key]);
                continue;
              }
 

              //expire
              // $timenow=date('Y-m-d');

              // if( $value['start_time']=='0000-00-00' && $value['end_time']=='0000-00-00' )
              // {
              //   continue;
              // }
              // if( $value['start_time']>$timenow || $value['end_time']<$timenow)  {
              //   $err="expire!";
              //   unset($ret[$key]);
              //   $status=4;
              //   continue;
              // }   

        }
        if(!empty($ret)) 
          {
            $ret=array_values($ret);
            return array(0,$ret[0]); 

          } 
        return array($status,$contracts[count($contracts)-1]); 
  }




public function ptin($cardid,$clubid)
{
    $card=$this->getCard($cardid);
    if(!$card)return array(-1,null);
    $member=$this->getMember($card['member_id']);
    if(!$member)return array(-1,null);
        list($status,$contract)=$this->findOnePtContract($member['id'],$clubid); 
        if(!empty($contract))
           if($contract['status']==1)
              {
                  $this->consumeend($contract['id']);
                  list($status,$contract)=$this->findOnePtContract($member['id'],$clubid); 
              }
        if(empty($contract))
          return array(-1,null);
       $id=$contract['id'];
     M("PtContract")->where("id=$id")->setField("status",1); 
    $id= M("PtConsumeHistory")->data(array("card_number"=>$cardid,"member_id"=>$contract['member_id'],"club_id"=>$contract['club_id'],"contract_id"=>$contract['id'],"brand_id"=>$contract['brand_id']))->add();
    $this->choosept($id);
     $rspMember=$this->responseMember($member,$ct,$card,$status); 
        return array($status,$rspMember);  
}
 

public function choosept($id)
{
   M("TaskChoosept")->data(array("history_id"=>$id))->add();
}
public function printpt($id)
{
    M("TaskPtprint")->data(array("history_id"=>$id))->add();
}

	public function in($cardid,$clubid)
	{
		$card=$this->getCard($cardid);
		if(!$card)return array(-1,null);
		$member=$this->getMember($card['member_id']);
		if(!$member)return array(-1,null);
      	list($status,$contract)=$this->findOneContract($card['id'],$clubid); 
        $ct=$contract;
      	if($status==0) 
      	{
          	if($contract['active_type']==2) 
         		{
         			$contract['start_time']=date("Y-m-d");
         			$start_time=strtotime("now");
         			$card_type=$contract['card_type'];
         			$valid_time=$card_type['valid_time'];
         			$end_time=strtotime("+$valid_time months",$start_time);
         			$present_day=$contract["present_day"];
         			$end_time=strtotime("+$present_day days",$end_time);
 $contract['active_type']=3;
         			$contract['end_time']=date("Y-m-d",$end_time); 
         		}

         		$last_check_in_time=$card['last_check_in_time'];
         		if(date('Y-m-d',strtotime($last_check_in_time)) != date('Y-m-d'))
         		{
    				    $contract["used_num"]+=1;
         		} 
         		unset($contract['card_type']);
         		unset($contract['member']);
         		unset($contract['sale_club']);
         		M("Contract")->data($contract)->save(); 
         		$card["check_status"]=1;
         		$card["last_check_in_time"]=date('Y-m-d H:i:s');
         		M("Card")->data($card)->save();
         		//record list
         		M("CheckHistory")->data(array("brand_id"=>$contract["brand_id"],"member_id"=>$card["member_id"],"status"=>1,"club_id"=>$clubid,"card_id"=>$card['id'],"contract_id"=>$contract["id"]))->add();
      	}
      	$rspMember=$this->responseMember($member,$ct,$card,$status); 
      	return array($status,$rspMember);  
	}
 

	public function getCard($cardid)
	{
		$card=M("Card")->where(array("card_number"=>$cardid))->find(); 
     	if(empty($card))
     	{
     		$this->setError("this card does not exist!");
     		return false;
     	}  
     	//card status
     	switch ($card['status']) {
     		case '1':
     			$this->setError("this card is lost!"); 
     			return false;
     		case '3':
     			$this->setError("this card is resting!"); 
     			return false;
     		case '5':
     			$this->setError("this card is destroyed!"); 
     			return false;
     		default:
     			# code...
     			break;
     	} 
     	return $card;  
	}
	public function getMember($member_id)
	{
		$member=M("MemberBasic")->find($member_id); 
     	if(empty($member))
     	{
     		$this->setError("this member does not exist!");
     		return false;
     	} 
     	return $member;
	}


	public function get($cardid,$clubid)
	{
		$card=$this->getCard($cardid);
		if(!$card)return array(-1,null);
		$member=$this->getMember($card['member_id']);
		if(!$member)return array(-1,null);
      	list($status,$contract)=$this->findOneContract($card['id'],$clubid);
      	$rspMember=$this->responseMember($member,$contract,$card,$status);
      	return array($status,$rspMember); 
	}


	//find one usefull contract,if all are useless,response the last one's error!
	public function findOneContract($card_id,$clubid)
	{
		$contracts=D("Contract")->getAllContract($card_id);
		if(empty($contracts))
		{
			$err="all relate contracts are transform to other cards!"; 
      $this->setError("all relate contracts are transform to other cards!"); 
			return array(7,null);
		}
     	$ret=$this->checkClubid($contracts,$clubid); 
     	$status;
     	if(!$ret)
     	{
     		$err=("this card can not be used this shop!"); 
        $this->setError("this card can not be used this shop!");  
     		return array(2,null);
     	} 
     	foreach ($ret as $key => $value) { 
               $card_type=$value['card_type'];
               //times
              if($card_type['type']==2 && $value["total_num"]<=$value["used_num"])
              {
              	$err="times out!";
                unset($ret[$key]);
                $status=5;
                continue;
              }   
              //expire
              $timenow=date('Y-m-d');

              if($value['active_type']==2 && $value['start_time']=='0000-00-00' && $value['end_time']=='0000-00-00' )
              {
                continue;
              }
              if( $value['start_time']>$timenow || $value['end_time']<$timenow)  {
              	$err="expire!";
                unset($ret[$key]);
                $status=4;
                continue;
              }  
              //busy
             if($this->checkPeakTime($value['card_type']))
             {
             	$err="busy time!";
                unset($ret[$key]);
                $status=6;
                continue;
             }

        }
        if(!empty($ret)) 
          {
            $ret=array_values($ret);
            return array(0,$ret[0]); 

          }
        if($status!=0)
      	{
      		switch ($status) {
      			case '2':
      				$this->setError("this card can not be used this shop!"); 
      				break;
      			case '4':
      				$this->setError("expire!"); 
      				break;
      			case '5':
      				$this->setError("times out!"); 
      				break;
      			case '6':
      				$this->setError("busy time!"); 
      				break; 
      			case '7':
      				$this->setError("all relate contracts are transform to other cards!"); 
      				break; 
      			default:
      				# code...
      				break;
      		} 
      	} 
        return array($status,$contracts[count($contracts)-1]); 
	}

	// public function contractStatus($value)
	// {
	// 		$s1,$s2,$s3;
	// 	 	$card_type=$value['card_type'];
 //               //times
 //              if($card_type['type']==2 && $value["total_num"]<$value["used_num"])
 //              { 
 //                $s1=1; 
 //              }   
 //              //expire
 //              $timenow=date('Y-m-d');
 //              if( $value['start_time']>$timenow || $value['end_time']<$timenow)  { 
 //                $s2=1; 
 //              }  
 //              //busy
 //             if($this->checkPeakTime($value['card_type']))
 //             { 
 //                $s3=6; 
 //             }
	// }

	public function checkPeakTime($card_type)
	{
		$peak_times=M("PeakTime")->where(array("id"=>array("in",$card_type['peak_time'])))->select();
        foreach ($peak_times as $key => $value) {
           $peak_time=$value['peak_time'];
           $peak_time=json_decode($peak_time);
           foreach ($peak_time as $pk) {
              		$week=$pk->week;
              		$start_time=$pk->start_time;
              		$end_time=$pk->end_time; 
              		$now_week=date("w");$now_week=$now_week==0?7:$now_week;
              		$now_time=date("H:i");
              		if($week==$now_week && $now_time>$start_time && $now_time<$end_time)
              		{
              			return true;
              		}

              	}   	 
        }
        return false;
	}


public function checkpeak($card_id,$clubid,$time)
  {
    $card=$this->getCard($card_id);
    $contracts=D("Contract")->getAllContract($card['id']); 
    if(empty($contracts))
    {
      return false;
    }
    $ret=$this->checkClubid($contracts,$clubid);
    if(!$ret)
    {
       return false;
    }
      foreach ($ret as $key => $value) { 
               $card_type=$value['card_type'];
               //times
              if($card_type['type']==2 && $value["total_num"]<=$value["used_num"])
              { 
                continue;
              }   
              //expire
              $timenow=date('Y-m-d'); 
              if($value['active_type']==2 && $value['start_time']=='0000-00-00' && $value['end_time']=='0000-00-00' )
              {
                continue;
              }
              if( $value['start_time']>$timenow || $value['end_time']<$timenow)  { 
                continue;
              }  
              $time=date('Y-m-d H:i:s',$time);
              $peak_times=M("PeakTime")->where(array("id"=>array("in",$value['card_type']['peak_time'])))->select();
              $ret=true;
              foreach ($peak_times as $v) {
                 $peak_time=$v['peak_time'];
                 $peak_time=json_decode($peak_time);
                 foreach ($peak_time as $pk) {
                        $week=$pk->week;
                        $start_time=$pk->start_time;
                        $end_time=$pk->end_time; 
                        $now_week=date("w",$time);$now_week=$now_week==0?7:$now_week;
                        $now_time=date("H:i",$time);
                        if($week==$now_week && $now_time>$start_time && $now_time<$end_time)
                        {
                          $ret=false;
                          break;
                        } 
                      }   
                if(!$ret)break;   
              }
              if($ret) return true;

        }
        return false; 
  }


	public function checkClubid($contracts,$club_id)
	{
		$model = D("CardUseclub");
		foreach ($contracts as $key => $value) {
			if(!$model->canUse($value['card_type_id'],$club_id))
			{
				unset($contracts[$key]); 
			}
		}
		return $contracts;
	}

	public function responseMember($member,$contract,$card,$status)
	{ 
		$rsp = new ResponseMember();
		$rsp->birthday=date("Ymd",strtotime($member['birthday'])); 
		$rsp->name=$member['name'];
		$rsp->no=$card['card_number'];
		$rsp->tel=$member['phone'];
		$rsp->gender=$member['sex'];
    $avatar = $member['avatar'];
    $avatar = str_replace("8995", "9077", $avatar);  
    if(strpos($avatar, "http")===0)
    {
      $rsp->face=$avatar;
    }
    else
    {
      $rsp->face="http://". $_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/Public/uploads/mmb_avatar/". $avatar;
    }
		
		$rsp->err=$this->getError();
		$rsp->id_number=$member['certificate_number'];
		$rsp->card_id=$card['card_number'];
		$rsp->card_status=$card['status']==2 || $card['status']==0?1:0;
		$rsp->status=$status;
		if(!empty($contract))
		{
			$rsp->card_busy=$this->checkPeakTime($contract['card_type'])?1:0;
			$rsp->times=$rsp->card_has_num=$contract['total_num'];
			$rsp->cardtype=$contract['card_type']['type']==1?"时间卡":"次数卡";
			$rsp->club_id=$contract['sale_club']['id'];
			$allcanuseclubs= D("CardUseclub")->getAllUseClub($contract['card_type']['id']);
			foreach ($allcanuseclubs as $key => $value) {
				if($key!=0)
					{
						$rsp->club_ids.=",";
						$rsp->club_names.=",";
					}
				$rsp->club_ids.=$value["id"];
				$rsp->club_names.=$value['club_name'];
			}
			$rsp->club_name=$contract['sale_club']['club_name'];
			$rsp->cometimes=$contract['used_num'];
			$rsp->endtime=$contract['end_time'];
			 if($value['active_type']==2 && $value['start_time']=='0000-00-00' && $value['end_time']=='0000-00-00' )
              {
                $rsp->expired=0;
              }
              else
              {
              	  $timenow=date('Y-m-d');
	              if( $contract['start_time']>$timenow || $contract['end_time']<$timenow)  {
	              	 $rsp->expired=1;
	              }  
	              else
	              {
	              	$rsp->expired=0;
	              }
              }
			  
             $rsp->left=$contract['card_type']['type']==1?-1:$contract['total_num']-$contract['used_num'];
             $rsp->mstatus=$this->isCheckIn($card)?"in":"out";
		}
		return $rsp;
	}  

	public function isCheckIn($card)
	{
		$last_check_in_time=strtotime($card['last_check_out_time']);
		$now = time();
		if($card['check_status']==1 && ($now-$last_check_in_time)<18000) return true;
		return false;
	}

  public function find($clubid,$mobile,$name,$offset,$num,$no="")
  {
      $cards = CService::factory("Member")->queryMemberOr($clubid,$mobile,$name,$offset,$num,$no);
      $this->clearError();
      if(empty($cards))
      {
         $this->setError("can not find related card!"); 
         return array(-1,null);
      }
      $arr=array(); 
      foreach ($cards as $key => $value) {
        list($status,$member)=$this->get($value['card_number'],$clubid); 
        $arr[]=$member;
      }
      $this->clearError();
      return array(0,$arr);

  }

  public function query($mobile,$clubid)
  {
      $cards = CService::factory("Member")->queryMemberOr($clubid,$mobile,null,0,999);
      $this->clearError();
      if(empty($cards))
      {
         $this->setError("can not find related card!"); 
         return array(-1,null);
      }
      $arr=array(); 
      foreach ($cards as $key => $value) {
        list($status,$member)=$this->get($value['card_number'],$clubid); 
        $arr[]=$member;
      }
      $this->clearError();
      return array(0,$arr);

  }

  public function bind($mobile,$no,$name)
  {
      $members = CService::factory("Member")->queryMemberAnd($mobile,$no,$name); 
      if(empty($members))
      {
        $this->setError("can not find this member!"); 
         return array(-1,null);
      }
      $arr=array();
      foreach ($members as $key => $value) {
         $cards = D("Card")->getAllCards($value['id']); 
         foreach ($cards as $card) {
            $info = array("card_id"=>$card['card_number']);
            $club_id="";
            $clubs=array();
            $contracts=D("Contract")->getAllContract($card['id']);
            foreach ($contracts as $contract) {  
                $clbs=D("CardUseclub")->getAllUseClub($contract['card_type_id']);
                foreach ($clbs as $clb) {
                  $clubs[]=$clb['id'];
                }
            }
            
            $clubs=array_unique($clubs);
            $club_id=implode(',', $clubs);
            $info['club_id']=$club_id;
            $arr[]=$info;
         }
         
      }
      return array(0,$arr);
  }


private function checkCardStatus($club_id,$card_number)
{
        $club = M("Club")->find($club_id);
        $brand_id =$club['brand_id'];
        $card = D("Card")->getCard($card_number,$brand_id);
        if(empty($card))
        {
          $card = M("CardDel")->where(array("card_number"=>$card_number,"brand_id"=>$brand_id))->find();
          if(empty($card))
           $this->setError("卡号不存在，请检查!"); 
         else
         {
            if($card['status']==4)
            {
               $this->setError("此卡已退会!"); 
            }
            else
            {
               $this->setError("此卡已销卡!"); 
            }
         }
           return false; 
        }
        switch ($card['status']) {
          case '0':
            return true;
          case '1':
          $this->setError("此卡已挂失!"); 
            return false;
            case '3':
            $this->setError("正在请假中!"); 
            return false;
            case '4':
            $this->setError("此卡已退会!"); 
            return false;
            $this->setError("此卡已销卡!"); 
            case '5':
            return false; 
          default:
            # code...
            break;
        }
}
  public function myinfo($club_id,$card_number)
  {
    if(!$this->checkCardStatus($club_id,$card_number))
    {
        return false;
    }
        $club = M("Club")->find($club_id);
        $brand_id =$club['brand_id'];
        $card = D("Card")->getCard($card_number,$brand_id); 
        $member_id=$card['member_id'];
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

        $ptclasses = D("PtContract")->getAllValidContract($member_id); 
        if(!empty($ptclasses)) $ptclass = $ptclasses[0];
        $contract=$this->findOneContractNew($card['id'],$club_id);  
        $today = date('Y-m-d');
        $appoint=M()->field("c.name as roomname,b.pos as pos ,d.name as schedulename,a.start as starttime")-> where("a.id=b.schedule_id and a.start like '{$today}%' and a.club_id={$club_id} and b.member_id={$member_id} and a.room_id=c.id and a.class_id=d.id")->table(array("yoga_pt_class_public"=>"d","yoga_club_classroom"=>"c","yoga_club_schedule"=>"a","yoga_appoint_history"=>"b"))->find();
        
        $lock = M("Lock")->where(array("last_use_card"=>$card_number,"club_id"=>$club_id,"is_use"=>1))->find();

        return array("ptcontracts"=>$ptclasses,  "member"=>$member,"ptcontract"=>$ptclass,"contract"=>$contract,"appoint"=>$appoint,"mylock"=>$lock);
  }

  public function findOneContractNew($card_id,$clubid)
  {
    $contracts=D("Contract")->getAllContract($card_id);
    if(empty($contracts))
    { 
      $this->setError("无相关会籍合同!"); 
      return false;
    }
      $ret=$this->checkClubid($contracts,$clubid); 
      $status;
      if(!$ret)
      { 
        $this->setError("非通卡，不能用于此会馆!");  
        return false;
      } 
      foreach ($ret as $key => $value) { 
               $card_type=$value['card_type'];

               //times
              if($card_type['type']==2 && $value["total_num"]<=$value["used_num"])
              {
                $err="次数已用完!";
                  unset($ret[$key]);  continue;
              }   
              //expire 
             $timenow = date('Y-m-d');
              if($value['active_type']==2 && $value['start_time']=='0000-00-00' && $value['end_time']=='0000-00-00' )
              {
                $err="未激活卡!";
                continue;
              }
              if( $value['start_time']>$timenow || $value['end_time']< $timenow )  
              {
                $err="已过有效期!"; 
                unset($ret[$key]);
                continue;
              }  
              //busy
             if($this->checkPeakTime($value['card_type']))
             {
              $err="现在为限制时段，此卡不能用于繁忙时段!";
              unset($ret[$key]);
                continue;
             }

        }
        if(!empty($ret)) 
          {
            $ret=array_values($ret);
            return $ret[0]; 

          }
        $this->setError($err);
        return $contracts[count($contracts)-1]; 
  }


  public function mymoretime($contract_id,$club_id,$num)
  {
      $contract = M("Contract")->find($contract_id);
	 $card = M("Card")->find($contract['card_id']);

     if(empty($contract))
     {
        $this->setError("无相关会籍合同");
         return false;
     }
  
     M("Contract")->where("id={$contract_id}")->setInc("used_num",$num);
	for($i=0;$i<$num;$i++)
	{
		 M("CheckHistory")->data(array("brand_id"=>$contract["brand_id"],"member_id"=>$card["member_id"],"status"=>1,"club_id"=>$club_id,"card_id"=>$card['id'],"contract_id"=>$contract["id"]))->add();
	}
     return true;
  }

  public function myin($contract_id,$club_id)
  { 
     
     $contract = M("Contract")->find($contract_id); 
     if(empty($contract))
     {
        $this->setError("无相关会籍合同");
         return false;
     }
    $card_type = M('CardType')->find($contract['card_type_id']);
 if($card_type['type']==2 && $contract["total_num"]<=$contract["used_num"])
              {
                 $this->setError(  "次数已用完!");
              	return false;
		}
 
     $card = M("Card")->find($contract['card_id']);
            if($contract['active_type']==2) 
            {
              $contract['start_time']=date("Y-m-d");
              $start_time=strtotime("now"); 
              $card_type=json_decode($contract['card_type_extension'],true);
              $valid_time=$card_type['valid_time'];
              $end_time=strtotime("+$valid_time months",$start_time);
              $present_day=$contract["present_day"];
              $end_time=strtotime("+$present_day days",$end_time);
              $contract['end_time']=date("Y-m-d",$end_time); 
              $contract['active_type']=3;
             
            } 
            $last_check_in_time=$card['last_check_in_time'];
            if(date('Y-m-d',strtotime($last_check_in_time)) != date('Y-m-d'))
            {
                $contract["used_num"]+=1;
            } 
            unset($contract['card_type']);
            unset($contract['member']);
            unset($contract['sale_club']);
            M("Contract")->data($contract)->save(); 
            $card["check_status"]=1;
	          $card['checktype']=0;
            $card["last_check_in_time"]=date('Y-m-d H:i:s');
            M("Card")->data($card)->save();
            //record list
            M("CheckHistory")->data(array("brand_id"=>$contract["brand_id"],"member_id"=>$card["member_id"],"status"=>1,"club_id"=>$club_id,"card_id"=>$card['id'],"contract_id"=>$contract["id"]))->add();
    
    //预约记录使用
            $ret =$this->useAppoint($club_id,$card['member_id']);
            if($ret)
            {
              $this->updateScore($card['member_id'],0,json_encode($ret));
            }
    //积分计算
     return true;   
  }

  private function updateScore($member_id,$via,$extension)
  {
    //一周两次

    $start = date('Y-m-d 00:00:00',strtotime('last monday'));
    $end = date('Y-m-d 23:59:59',strtotime('next sunday'));
    $count =  M("ScoreHistory")-> where(array("member_id"=>$member_id,"via"=>0,"create_time"=>array("between","$start,$end")))->count(); 
    if($count >=2) 
      { 
        return;
      }
     $yaa=M("YaaMember")->find($member_id);

     if(empty($yaa))
     {
        $level=0;
        $historyscore=0;
     }
     else
     {
         $level = $yaa['level'];
         $historyscore= $yaa['score'];
     }
       
        $classcore = $this->getScore( $level,$via);
        $score = $classcore +$historyscore;
        $newlevel = $this->calLevel($score); 
        
        $data=array("member_id"=>$member_id,"level"=>$newlevel,"score"=>$score);
        if(empty($yaa))
            M("YaaMember")->data($data)->add(); 
        else 
        M("YaaMember")->data($data)->save(); 

        if($newlevel!=$level)
        {
            //生成证书 
           $service=\Service\CService::factory("Image");
           $service->updateCer($member_id);
           M("YaaMember")->where(array("member_id"=>$member_id))->setField(array("gift_status"=>0)); 
        }

        $data = array("member_id"=>$member_id,"score"=>$classcore,"via"=>$via,"extension"=>$extension);
        M("ScoreHistory")->data($data)->add();


  }

  private function getScore($level,$via)
  {
    $score = 0;
    switch ($level) {
      case 0:
      case 1:
      case 2:
        $score= 10;
        break;
       case 3:
       case 4:
       case 5:
        $score= 15;
        break;
        case 6:
          $score= 20;
        break;
         case 7:
          $score= 25;
        break;
         case 8:
          $score= 30;
        break;
         case 9:
          $score= 40;
        break;
         case 10:
          $score= 60;
        break;
         case 11:
          $score= 80;
        break;
         case 12:
          $score= 120;
        break;
      default:
        $score=10;
        break;
    }
    return $score;
  }

  public function getNextLevelScore($level)
  {
      switch ($level) {
        case '0':
        return 10;
         case '1':
        return 50;
         case '2':
        return 150;
         case '3':
        return 300;
         case '4':
        return 600;
         case '5':
        return 1200;
         case '6':
        return 2400;
         case '7':
        return 4800;
         case '8':
        return 9600;
         case '9':
        return 19200;
         case '10':
        return 38400;
         case '11':
        return 76800; 
        default:
          # code...
          break;
      }
  }
  private function calLevel($score)
  {
      if($score > 76800)
      {
        return 12;
      }else if($score >= 38400)
      {
        return 11;
      }else if($score >=19200)
      {
        return 10;
      }else if($score >= 9600)
      {
        return 9;
      }else if($score >= 4800)
      {
        return 8;
      }else if($score >= 2400)
      {
        return 7;
      }else if($score >= 1200)
      {
        return 6;
      }else if($score >= 600)
      {
        return 5;
      }else if($score >= 300)
      {
        return 4;
      }else if($score >= 150)
      {
        return 3;
      }else if($score >= 50)
      {
        return 2;
      }else if($score >= 10)
      {
        return 1;
      }
      return 0;
  }

  public function useAppoint($club_id,$member_id)
  {
     $today = date('Y-m-d');
       $appoints=M()->field("b.id,c.name as roomname,b.pos as pos ,d.name as schedulename,a.start as starttime")-> where("a.id=b.schedule_id and a.start like '{$today}%' and a.club_id={$club_id} and b.member_id={$member_id} and a.room_id=c.id and a.class_id=d.id and b.come=0")->table(array("yoga_pt_class_public"=>"d","yoga_club_classroom"=>"c","yoga_club_schedule"=>"a","yoga_appoint_history"=>"b"))->select();
     if(!empty($appoints))
       {
        foreach ($appoints as $key => $appoint) {
           M("AppointHistory")->where("id=".$appoint['id'])->setField(array("come"=>1));
        } 
          return $appoint;
       } 
       return false;
  }
  public function myout($contract_id,$club_id)
  {
    
     $contract = M("Contract")->find($contract_id);
     $card = M("Card")->find($contract['card_id']);
     $card["check_status"]=0;
       $card["last_check_out_time"]=date('Y-m-d H:i:s');
      M("Card")->data($card)->save();
            //record list
  M("CheckHistory")->data(array("brand_id"=>$contract["brand_id"],"member_id"=>$card["member_id"],"status"=>0,"club_id"=>$club_id,"card_id"=>$card['id'],"contract_id"=>$contract["id"]))->add();
        //清理柜子
        M("Lock")->where(array("club_id"=>$club_id,"last_use_card"=>$card['card_number']))->setField(array("is_use"=>0));
   M("LockUseHistory")->data(array("card_id"=>"0","lock_id"=>$value,"status"=>0,"via"=>1,"create_time"=>getDbTime()))->add;
     $lock =  M("Lock")->where(array("club_id"=>$club_id,"last_use_card"=>$card['card_number']))->find();
     if(!empty($lock))
        \Think\Log::write("free lock by checkout ".$lock['locknum'],'DEBUG');    
       return true;
  }

  public function myptout($id,$clubid)
{
    $contract = M("PtContract")->where(array("id"=>$id,"club_id"=>$clubid))->find();    
    if(!empty($contract))
	{
	$this->consumeend($contract['id']);	
	return true;
	}
	return false;
    
}

public function myptin($contract_id,$club_id,$pt_id,$card_number)
{
    $contract=M("PtContract")->find($contract_id); if($club_id!=$contract['club_id']){$this->setError('bad contract_id!');return false;}
    if(empty($contract))
     {
        $this->setError("无相关会籍合同");
         return false;
     } 
        if(!empty($contract))
           if($contract['status']==1)
              {
                  $this->consumeend($contract['id']);
                 $contract=M("PtContract")->find($contract_id);
              }
    
   if($contract['total_num'] <=$contract['used_num']) {$this->setError('次数用尽！');return false;}
   $id=$contract['id'];
    M("PtContract")->where("id=$id")->setField("status",1); 
    $id= M("PtConsumeHistory")->data(array("pt_id"=>$pt_id, "card_number"=>$card_number,"member_id"=>$contract['member_id'],"club_id"=>$contract['club_id'],"contract_id"=>$contract['id'],"brand_id"=>$contract['brand_id']))->add();
   M("Card")->where(array("card_number"=>$card_number))->setField(array("checktype"=>$contract_id));


	 return true;
}

private function ptappoint($member_id,$contract_id,$pt_id)
{
    $date = date('Y-m-d');
    $appoint = M("PtAppoint")->where(array("member_id"=>$member_id,"pt_id"=>$pt_id,"appoint_date"=>$date))->find();
    if(empty($appoint))
    {
        $appoint_id = M("PtAppoint")->date(array("member_id"=>$member_id,"pt_id"=>$pt_id,"appoint_date"=>$date,"create_time"=>getDbTime(),"is_appoint"=>0))->add();
    }
    else
    {
       $appoint_id = $appoint['id'];
    }
    // M("PtAppoint")->where("id=$appoint_id")->setField("is_come"=>1);
}


}

class ResponseMember
	{
		public $birthday;
		public $card_busy;
		public $card_has_num;
		public $card_id;
		public $card_status;
		public $club_id;
		public $club_ids;
		public $club_name;
		public $club_names;
		public $cometimes;
		public $endtime;
		public $err;
		public $expired;
		public $face;
		public $gender;
		public $id_number;
		public $left;
		public $mstatus;
		public $name;
		public $no;
		public $status;
		public $tel;
		public $times; 
	}
