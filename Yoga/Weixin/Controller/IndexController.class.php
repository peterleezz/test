<?php
namespace Weixin\Controller;
use Think\Controller;
class IndexController extends Controller {


    public function infdetailAction()
    {
        $id=I("id");
        $member=M('member')->find($id);
        $yaa=M("Yaa")->find($id);

        //create pic 
    }

    //绑定
    public function bindAction(){
   		$card_number=I("card_number");
   		$id_card=I("id_card");
   		$openid=I("openid");
   		$cards = D("Card")->getCardByNumber($card_number);
   		if(empty($cards))
   		{
   			$this->ajaxReturn(array("status"=>0,"info"=>"卡号不存在，请检查卡号是否正确！"));   
   		}	
   			$member=M("MemberBasic")->where(array("certificate_number"=>"$id_card") )->find(); 	
	if(empty($member))
   		{
   			$this->ajaxReturn(array("status"=>0,"info"=>"身份证号不存在！"));  
   		}

   		foreach ($cards as $key => $value) {
   			$member_id=$value['member_id'];
   			$member=M("MemberBasic")->find($member_id);
   			if($member['certificate_number']==$id_card)
   			{
   				 // M("MemberBasic")->where("id=$member_id")->setField(array("weixin_openid"=>$openid)); 
          $data = array("member_id"=>$member_id,"weixin_code"=>$openid); 
          $ret =  M("WeixinBind")->where($data)->find();
          if(!$ret) 
          // M("WeixinBind")->where(array("weixin_code"=>$openid,"member_id"=>array("neq",$member_id)))->delete();
              M("WeixinBind")->data($data)->add();
   				$this->ajaxReturn(array("status"=>1,"info"=>"绑定成功!")); 
   			}
   		} 
   		 $this->ajaxReturn(array("status"=>0,"info"=>"卡号与身份证号不匹配，请检查！")); 
    }

    //获取绑定的卡
    public function bindcardsAction(){ 
         $openid=I("openid");
         if(empty($openid))$this->ajaxReturn(array("status"=>0,"info"=>"openid is empty")); 
         $arr=M("WeixinBind")->where(array("weixin_code"=>$openid))->field("group_concat(member_id) as uids")->find(); 
         if(!empty($arr))
         {
             $uids = $arr['uids'];
             $arr=array();
            $members=M("MemberBasic")->where(array("id"=>array("in",$uids)))->order("id desc")->limit(20)->select(); 
             foreach ($members as $key => $value) {
               $club = M("Club")->find($value['club_id']);
               $cards = D("Card")->getAllCards($value['id']);
               $members[$key]['club']=$club;
               $members[$key]['cards']=$cards;
               $clubs = D("CardUseclub")->getCanUseClubs($value['id']); 
                $members[$key]['useclubs']=$clubs;
               $arr[$value['club_id']][]=$members[$key];
             }
             $this->ajaxReturn(array("status"=>1,"data"=>$arr)); 
         }
         $this->ajaxReturn(array("status"=>1,"data"=>array())); 
         
    }



     public function myinfoAction(){  
         $openid=I("openid");
         if(empty($openid))$this->ajaxReturn(array("status"=>0,"info"=>"openid is empty")); 
          $arr=M("WeixinBind")->where(array("weixin_code"=>$openid))->field("group_concat(member_id) as uids")->find(); 
          $rsp=array(); 
         if(!empty($arr) && !empty($arr['uids']))
         {
             $uids = $arr['uids']; 
             $uids=explode(",", $uids);
             
             $members=M("MemberBasic")->where(array("id"=>array("in",$uids)))->order("id desc")->limit(20)->select(); 

             if(!empty($members))
             {
                foreach ($members as $key => $member) { 
                    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://'; 
                    if(!empty($member['avatar']))
                    $members[$key]['avatar'] = $sys_protocal.$_SERVER['HTTP_HOST']. "/Public/uploads/mmb_avatar/".$member['avatar'];
                      $yaa =   M("YaaMember")->find($member['id']);  
                    
                      $level = 0;
                      if(!empty($yaa))
                      {
                        $level = $yaa['level']; 
                      }
                      else
                      {
                         $yaa=array('level'=>0,"score"=>0);
                      }
                       $apiService = \Service\CService::factory("Api");
                       $nextScore = $apiService->getNextLevelScore($level);
                       $yaa['nextScore']=$nextScore;
                        $members[$key]['yaa']=$yaa;  
                        $paiming = $this->paiming($member['id']);
                        $up = $this->up($member['id']);
                       $members[$key]['paiming']=$paiming;  
                        $members[$key]['up']=$up;  
                }
                
             }
             else
             {
              $member=array();
             }   
              $this->ajaxReturn(array("status"=>1,"data"=>$members)); 
           }
           else
           { 
                $this->ajaxReturn(array("status"=>1,"data"=>null)); 
           }  
    }


    public function paiming($member_id)
    {
         $bodyInfo = M("BodyInfoLatest")->where("member_id={$member_id}")->find();
         if(empty($bodyInfo))
         {
             return 0;
         }
         else
         {
            $FZHPF = $bodyInfo['FZHPF'];
            $count = M("BodyInfoLatest")->where("FZHPF>$FZHPF")->count();
            return $count+972;

         }
    }

    public function up($member_id)
    {
        $bodyInfo = M("BodyInfo")->where("member_id={$member_id}")->order("id desc")->limit(2)->select();
        if(count($bodyInfo) ==2)
        {
             return ($bodyInfo[1]['FZHPF'] - $bodyInfo[0]['FZHPF'])/ $bodyInfo[0]['FZHPF']*1.0;
        }return 0;
    }

    public function getClubsAction($club_id)
    {
      
    }
     
     public function infoAction(){  
         $openid=I("openid");
         if(empty($openid))$this->ajaxReturn(array("status"=>0,"info"=>"openid is empty")); 
          $arr=M("WeixinBind")->where(array("weixin_code"=>$openid))->field("group_concat(member_id) as uids")->find();
          $rsp=array(); 
         if(!empty($arr) && !empty($arr['uids']))
         {
             $uids = $arr['uids']; 
             $uids=explode(",", $uids);
             foreach ($uids as $key => $value) {
                   $clubs = D("CardUseclub")->getCanUseClubs($value); 
                   $rsp=array_merge($rsp,$clubs);
             }
            
            $rsp=array_unique_2d($rsp);
             // $members=M("MemberBasic")->where(array("id"=>array("in",$uids)))->order("id desc")->limit(20)->select(); 

             // if(!empty($members))
             // {
             //    $member=$members[0];
             //    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://'; 
             //    $member['avatar'] = $sys_protocal.$_SERVER['HTTP_HOST']. "/Public/uploads/mmb_avatar/".$member['avatar'];
             // }
             // else
             // {
             //  $member=array();
             // }  

             // $clubs = array();
             // foreach ($members as $key => $value) {
             //    $club_id=$value['club_id'];
             //    $club=M("Club")->find($club_id);
             //    $club['uid']=$value['id'];
             //    $clubs[]=$club;
             // }
             // $member['clubs']=$clubs;
          } 

         $this->ajaxReturn(array("status"=>1,"data"=>$rsp)); 
    }

    //搜索附近的会所
    public function searchNearClubAction()
    {
        $lat=I("lat");
        $lon=I("lon");
        $distance=I("distance");
        $offset = I("offset");
        $num=I("num");
        $service = \Service\CService::factory("Search");
        $ids = $service->searchNearClub("*:*",$lat,$lon,$distance,$offset,$num);
        $clubs = M("Club")->where(array("id"=>array("in",$ids)))->select();
        $this->ajaxReturn(array("status"=>1,"data"=>$clubs)); 
    }
     
     //搜索某名字的会所
      public function searchClubAction()
    { 
        $offset = I("offset");
        $num=I("num");
        $key=I("key");
        $service = \Service\CService::factory("Search");
        $ids = $service->searchClub("club_name:$key",$offset,$num);
        $clubs = M("Club")->where(array("id"=>array("in",$ids)))->select();
        $this->ajaxReturn(array("status"=>1,"data"=>$clubs)); 
    }

//搜索附近的会员
      public function searchUserAction()
    { 
        $offset = I("offset");
        $num=I("num");
        $key=I("key");
        $service = \Service\CService::factory("Search");
        $ids = $service->searchUser("name:$key",$offset,$num);
        $clubs = M("MemberBasic")->where(array("id"=>array("in",$ids)))->select();
        $this->ajaxReturn(array("status"=>1,"data"=>$clubs)); 
    }

//查询公共课
    public function publicclassesAction($club_id,$start_time,$end_time,$open_id)
    {
      $condition = array("club_id"=>$club_id,"start"=>array("between",array($start_time,$end_time))); 
       $ret = D("ClubSchedule")->where($condition)->relation(true)->order("start")-> select();  
       foreach ($ret as $key => $value) {
        if($value['class']['uid']!=0)
        {
            $teacher = M("UserExtension")->find($value['class']['uid']);  
            $ret[$key]['class']['teacher_name']=$teacher['name_en'];  
        }
        $open_id=I("open_id");
         $ret[$key]['is_appointed']=0;
        if($open_id)
        {
            $history=D("AppointHistory")->where(array("schedule_id"=>$value['id'],"open_id"=>$open_id))->find();
            if(!empty($history))
            {
                $ret[$key]['is_appointed']=1;
            }
        }

       }
       $this->ajaxReturn(array("status"=>1,"data"=>$ret)); 
    }

    public function getScheduleAction($schedule_id,$member_id)
    {
         $ret = D("ClubSchedule")->relation(true)->find($schedule_id);
         if(empty($ret))
         {
           $this->ajaxReturn(array("status"=>0,"data"=>null)); 
         }
         $appointed=M("AppointHistory")->where(array("schedule_id"=>$schedule_id))->field("pos")->select();
         $mypos = M("AppointHistory")->where(array("schedule_id"=>$ret['id'],"member_id"=>$member_id))->field("pos")->find() ;
         $this->ajaxReturn(array("status"=>1,"data"=>array("schedule"=>$ret,"appointed"=>$appointed,"mypos"=>$mypos))); 
    }

    public function cancelAppointAction($member_id,$schedule_id,$open_id)
    {
      $model = D("AppointHistory");
      $val = $model->where(array("member_id"=>$member_id,"schedule_id"=>$schedule_id))->find();
      if(empty($val))
      {
        $this->ajaxReturn(array("status"=>1,"data"=>"取消预约成功！"));
      }
      $schedule = D("ClubSchedule")->find($schedule_id);
      $deadline = date('Y-m-d H:i:s',strtotime('+2 hours')); 
      if($schedule['start'] < $deadline)
      {
         $this->ajaxReturn(array("status"=>1,"data"=>"课程即将开始,无法取消预约！"));
      }

      $model->delete($val['id']);
       M("AppointOpHistory")->data(array("open_id"=>$open_id, "pos"=>$val['pos'],"schedule_id"=>$schedule_id,"member_id"=>$member_id,"status"=>0))->add(); 
        $this->ajaxReturn(array("status"=>1,"data"=>"取消预约成功！"));
    }
    public function doAppointAction($pos,$schedule_id,$member_id,$open_id)
    {
      //检查黑名单
      $now = date('Y-m-d H:i:s');
      $black_list =M("AppointBlackList")->where(array("member_id"=>$member_id,"status"=>1, "start_time"=>array("lt",$now),"end_time"=>array("gt",$now)))->find();
      if(!empty($black_list))
      {
            $this->ajaxReturn(array("status"=>0,"info"=>"由于您上次预约后未到场，截至到".$black_list['end_time']."之前不能进行预约，详情请联系您的顾问！")); 
      }

      $model = D("AppointHistory");
     $schedule = M("ClubSchedule")->find($schedule_id);
     if(empty($schedule))
     {
         $this->ajaxReturn(array("status"=>0,"info"=>"此课程已取消，请重新选择！")); 
     }
     $now = date('Y-m-d H:i:s');   
     if($now > $schedule['start'])
     {
        $this->ajaxReturn(array("status"=>0,"info"=>"抱歉,课程已经开始,请预约稍后的课程!")); 
     }
         $appointed=$model ->where(array("schedule_id"=>$schedule_id,"pos"=>$pos ) )->find();  
         if($appointed)
         {
            if($appointed['member_id']!=$member_id) 
              $this->ajaxReturn(array("status"=>0,"info"=>"此位置已经被预约，请重新选择！")); 
            else
                 $this->ajaxReturn(array("status"=>1,"data"=>"您已预约！")); 
         }
          $mypos =$model ->where(array("schedule_id"=>$schedule_id,"member_id"=>$member_id))->find();
          if(!empty($mypos))
          {
              $model ->where("id=".$mypos['id'])->setField(array("pos"=>$pos));  
          }
          else
          {
              if(!$model ->create())
              {
                $this->error($model->getError());
              }
              $id = $model ->add();
              if(!$id)
              {
                   $this->ajaxReturn(array("status"=>0,"info"=>"预约失败，请稍后再试！")); 
              }
          }
          M("AppointOpHistory")->data(array("open_id"=>$open_id, "pos"=>$pos,"schedule_id"=>$schedule_id,"member_id"=>$member_id,"status"=>1))->add(); 
          $this->ajaxReturn(array("status"=>1,"data"=>"预约成功！"));
    }

    public function cerAction($id)
    {
      $cer = M("CerHistory")->where(array("member_id"=>$id))->order("level desc")->find();
      if(empty($cer))
      {
         $service=\Service\CService::factory("Image");
           $service->updateCer($id);
            $cer = M("CerHistory")->where(array("member_id"=>$id))->order("level desc")->find();
      }
       $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://'; 
       $root = C("pic_path");
       $file ="/Public/". str_replace("{$root}", "", $cer['file']); 
       $cer['url']=$sys_protocal.$_SERVER['HTTP_HOST']. $file;
 
       $this->ajaxReturn(array("status"=>1,"data"=>$cer));
    }

    public function experienceAction($name,$phone,$addr)
    {
        $model = M("Apply");
        if(!$model->create())
        {
          $this->error($model->getError());
        }
        $model->add();
        $this->ajaxReturn(array("status"=>1,"info"=>"您的申请已经提交，请等待！"));
    }

    public function getGiftAction($uid,$level)
    {
          $model = M("YaaGift");
      for($i=1;$i<=$level;$i++)
      {
           $data = array("member_id"=>$uid,"level"=>$i,'create_time'=>getDbTime());
            $exist = $model->where($data)->select();
            if(empty($exist))
            M("YaaGift")->data($data)->add();
      } 
         
        M("YaaMember")->where("member_id={$uid}")->setField(array("gift_status"=>1));
        $this->ajaxReturn(array("status"=>1,"info"=>"您的申请已经提交，请等待！"));
    }

    public function bodyInfoApplyAction($member_id)
    {
        $member =M("MemberBasic")->find($member_id);
        $data = array("member_id"=>$member_id,"club_id"=>$member['club_id']);
        M("BodyInfoApply")->data($data)->add();
         $this->ajaxReturn(array("status"=>1,"info"=>"您的申请已经提交，我们将安排人员联系您进行体测！"));
    }


    public function getCardTypeAction($club_id)
    {
      $club = M("Club")->find($club_id);
      $cards = D("CardType")->getAllCanSaleCardTypes($club['brand_id'],$club_id);
      foreach ($cards as $key => $value) {
        $cards[$key]['sold_num'] = M("Contract")->where("card_type_id=".$value['id'])->count();
      }
      $this->ajaxReturn(array("status"=>1,"data"=>$cards));
    }

    public function experience_qianAction($class_id,$name,$phone,$addr)
    { 
        $model = D("AppointHistory");
     $schedule = M("ClubSchedule")->find($class_id);
     if(empty($schedule))
     {
         $this->ajaxReturn(array("status"=>0,"info"=>"此课程已取消，请重新选择！")); 
     } 
     
      //创建客户信息

     $member = M("MemberBasic")->where(array("phone"=>$phone,"club_id"=>$schedule['club_id']))->find();
     $club_id=$schedule['club_id'];
 
     $club=M("Club")->find($club_id);
     $model=D("MemberBasic");
     if(empty($member))
     {

        $data=array("desc"=>"瑜伽活动预约潜客", "add_way"=>10,"avatar"=>"default.jpg","club_id"=>$club_id,"brand_id"=>$club['brand_id'],"name"=>$name,"phone"=>$phone,"channel_id"=>0,"home_addr"=>$addr,"record_id"=>0);
        if(!$model->create($data))
        { 
           $this->error($model->getError);
        } 
        $id=$model->data($data)->add();
     }
     else
     {
        $id=$member['id']; 
     }
 
     $aq=M("AppointQian")->where(array("schedule_id"=>$class_id,"member_id"=>$id))->find();
     if(empty($aq))
     {
        M("AppointQian")->data(array("schedule_id"=>$class_id,"member_id"=>$id))->add();
     }
 
      $this->ajaxReturn(array("status"=>1,"info"=>"预约成功！"));
    }



      public function experience_applyAction($club_id,$name,$phone,$addr,$desc)
    { 
        
      //创建客户信息
    $club=M("Club")->find($club_id);
     $member = M("MemberBasic")->where(array("phone"=>$phone,"club_id"=>$club_id))->find();
     $model=D("MemberBasic");
     if(empty($member))
     { 
        $data=array("desc"=>$desc, "add_way"=>11,"avatar"=>"default.jpg","club_id"=>$club_id,"brand_id"=>$club['brand_id'],"name"=>$name,"phone"=>$phone,"channel_id"=>0,"home_addr"=>$addr,"record_id"=>0);
        if(!$model->create($data))
        { 
           $this->error($model->getError);
        } 
       $model->data($data)->add();
     } 
      $this->ajaxReturn(array("status"=>1,"info"=>"成功！"));
    }
}
