<?php
namespace Service;
class ChannelService extends CService
{
	protected static $instance;
	public static function getInstance($name = 'default'){
        if (empty(self::$instance[$name])){
            self::$instance[$name] = new ChannelService($name);
        }
        return self::$instance[$name];

    }

	public function __construct()
	{
		
	}

   public function getStatistics($user_id,$start_time,$end_time)
    {
        $club_id = get_club_id();
        if(empty($user_id))
        {
            if(empty($end_time))
                $sql="select b.id, b.name,b.level,count(a.channel_id)  as protential,COALESCE(sum(a.is_member),0) as mcount from yoga_channel b left join yoga_member_basic a on a.channel_id=b.id    and a.channel_id!=0 and a.create_time>='$start_time'  where b.club_id=$club_id  group by b.id order by protential desc";
            else
                 $sql="select b.id, b.name,b.level,count(a.channel_id)  as protential,COALESCE(sum(a.is_member),0) as mcount from yoga_channel b left join yoga_member_basic a on a.channel_id=b.id  and a.channel_id!=0 and a.create_time>='$start_time' and a.create_time<'$end_time' where b.club_id=$club_id   group by b.id order by protential desc";
        }
        else
        {
             if(empty($end_time))
                $sql="select b.id, b.name,b.level,count(a.channel_id)  as protential,COALESCE(sum(a.is_member),0) as mcount from yoga_channel b left join yoga_member_basic a on a.channel_id=b.id  and a.channel_id!=0 and a.create_time>='$start_time' where  b.club_id=$club_id   and b.user_id=$user_id  group by b.id order by protential desc";
            else
                 $sql="select b.id, b.name,b.level,count(a.channel_id)  as protential,COALESCE(sum(a.is_member),0) as mcount from yoga_channel b left join yoga_member_basic a on a.channel_id=b.id  and a.channel_id!=0 and a.create_time>='$start_time' and a.create_time<'$end_time'   where  b.club_id=$club_id  and  b.user_id=$user_id   group by b.id  order by protential desc";
  
        }
       $model = new \Think\Model();
        $ret= $model->query($sql);
        foreach ($ret as $key => $value) {
         $end_time=empty($end_time)?$start_time:$end_time;
         $total = $this->getChannelTotal($value["id"],$end_time);   
         $ret[$key]["protential_total"]=$total['protential_total']; 
         $ret[$key]["mcount_total"]=$total['transform_total'];  
       
        }
      
         return $ret;

    }
 
 

public function getChannelTotal($chanenl_id,$end_time)
   {
      $model = M("MemberBasic"); 
      $value=$model->where(array("channel_id"=>$chanenl_id,"create_time"=>array("lt","$end_time")))->field("count(*) as protential_total,COALESCE(sum(is_member),0) as transform_total")->find();
     return $value;
   }



   public function getClubtTotal($start_time,$end_time,$club_id)
   {
      $model = M("MemberBasic"); 
      $value=$model->where(array("club_id"=>$club_id,"create_time"=>array("between","$start_time,$end_time")))->field("count(*) as protential_total,COALESCE(sum(is_member),0) as transform_total")->find();
      $channelModel = M("Channel"); 

      $channel_total=$channelModel->where(array("club_id"=>$club_id,"create_time"=>array("between","$start_time,$end_time")))->count();
      $value["channel_total"]=$channel_total; 
      return $value;
   }

   public function getUsertTotal($start_time,$end_time,$user_id)
   {
      $channels = M("Channel")->where(array("user_id"=>$user_id))->field(" group_concat(id) as channels")->find();
      $channels_id =  $channels['channels'];

      $model = M("MemberBasic"); 
      $value=$model->where(array("channel_id"=>array("in",$channels_id),"create_time"=>array("between","$start_time,$end_time")))->field("count(*) as protential_total,COALESCE(sum(is_member),0) as transform_total")->find();
      $channelModel = M("Channel"); 
      $channel_total=$channelModel->where(array("user_id"=>$user_id,"create_time"=>array("between","$start_time,$end_time")))->count();
      $value["channel_total"]=$channel_total; 
      return $value;
   }


   public function getOneMonthStatistics($club_id,$time)
   {    
         $start_time=$time."-00 00:00:00";
         $end_time=$time."-31 23:59:59";
         return $this->getMonthStatistics($club_id,$start_time,$end_time);
   }

   public function getMonthStatistics($club_id,$start_time,$end_time)
   {
       $start_time=$start_time."-00 00:00:00";
       $end_time=$end_time."-31 23:59:59";
      $club_id=empty($club_id)?get_club_id():$club_id;
      $ret = M("ChannelAllStatistics")->where(array("time"=>array("between","$start_time,$end_time"),"club_id"=>$club_id))->order("time desc")->select();
      $model = M("MemberBasic"); 
      $channelModel = M("Channel"); 
      foreach ($ret as $key => $value) {
      	 $time=$value["time"];
         $time=substr($time,0,7);
         $ret[$key]['time']=$time;
      	 $start_time=$time."-00 00:00:00";
      	 $end_time=$time."-31 23:59:59";      	 
      	 $value=$this->getClubtTotal($start_time,$end_time,$club_id);
         $ret[$key]["protential_value"]=$value["protential_total"];        
         $ret[$key]["transform_value"]=$value["transform_total"]; 
         $ret[$key]["channel_value"]=$value["channel_total"]; 
         $total= $this->getClubtTotal('0000-00-00 00:00:00',$end_time,$club_id);        
         $ret[$key]["protential_total"]=$total['protential_total']; 
         $ret[$key]["transform_total"]=$total['transform_total']; 
         $ret[$key]["channel_total"]=$total['channel_total']; 
      }
      return $ret;
   }

    public function getUserOneMonthStatistics($user_id,$time)
   {
      $start_time=$time."-00 00:00:00";
      $end_time=$time."-31 23:59:59"; 
      return $this->getUserMonthStatistics($user_id,$start_time,$end_time);
   }

   public function getUserMonthStatistics($user_id,$start_time,$end_time)
   {
     $start_time=$start_time."-00 00:00:00";
       $end_time=$end_time."-31 23:59:59";
      $ret = M("ChannelSingleStatistics")->where(array("time"=>array("between","$start_time,$end_time"),"user_id"=>$user_id))->select();
      $channels = M("Channel")->where(array("user_id"=>$user_id))->field(" group_concat(id) as channels")->find();
      $channels_id =  $channels['channels'];
      $model = M("MemberBasic"); 
      $channelModel = M("Channel"); 
      foreach ($ret as $key => $value) {
         $time=$value["time"];
         $time=substr($time,0,7);
         $ret[$key]['time']=$time;
         $start_time=$time."-00 00:00:00";
         $end_time=$time."-31 23:59:59";
         $value=$this->getUsertTotal($start_time,$end_time,$user_id); 
         $ret[$key]["protential_value"]=$value["protential_total"];        
         $ret[$key]["transform_value"]=$value["transform_total"]; 
         $ret[$key]["channel_value"]=$value["channel_total"]; 
         $total = $this->getUsertTotal('0000-00-00 00:00:00',$end_time,$user_id); 
          $ret[$key]["protential_total"]=$total['protential_total']; 
         $ret[$key]["transform_total"]=$total['transform_total']; 
         $ret[$key]["channel_total"]=$total['channel_total']; 
      }
      return $ret;
   }
}