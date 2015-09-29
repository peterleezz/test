<?php
namespace Channelmanager\Controller;
use  Common\Controller\BaseController;
use Service\ChannelService;
class StatisticsController extends BaseController {
    public function indexAction(){
    	  
    	$time =  date('Y-m'); 
        $start_time=$time."-01 00:00:00";
        $end_time=$time."-31 23:59:59";
     //    $sql="select b.id, b.name,b.level,count(a.channel_id)  as protential,COALESCE(sum(a.is_member),0) as mcount from yoga_channel b left join yoga_member_basic a on b.brand_id=$brand_id  and a.channel_id!=0 and a.create_time>=$time and a.channel_id=b.id group by b.id order by protential desc";
    	// $ret = $model->query($sql);
        $ret = ChannelService::getInstance()->getStatistics(null,$start_time,$end_time);

    	$this->assign("statistics",$ret);

        // $users= $model->where("a.id=b.id and a.id=c.uid and b.brand_id=$brand_id and c.group_id=18")->table(array("yoga_user_extension"=>"a","yoga_user"=>"b","yoga_auth_group_access"=>"c"))->field("a.id,a.name_cn")->select(); 
        $users=D("User")->getChannelUser();
        $this->assign("users",$users);
    	$this->display();
    }

     

    public function queryAction()
    {
    	$model = new \Think\Model();
        $brand_id = get_brand_id();
        $time =  date('Y-m'); 
        // $sql="select b.id, b.name,b.level,count(a.channel_id)  as protential,COALESCE(sum(a.is_member),0) as mcount from yoga_channel b left join yoga_member_basic a on b.brand_id=$brand_id  and a.channel_id!=0  and a.channel_id=b.id "; 
       
    	$user_id=I("user_id");
        if(!empty($user_id))
    	{ 
            // $sql.=" and a.recommend_id=$user_id";
    	}
        $time=I("time");
         if(empty($time))
        { 
            $start_month = I("start_month");
            if(empty($start_month))
            {
                    $this->error("请输入月份时间！");
            }
            else
            {
                $start_time = $start_month."-01 00:00:00";
                $end_time = $start_month."-31 23:59:59";
                  // $sql.=" and a.create_time>='{$start_time}' and a.create_time<='{$end_time}'";
            }
           
        }
        else
        {
                 $start_time =  I("start_time");
                  $end_time =  I("end_time");
                  if(empty($start_time))
                  {
                        $this->error("请输入开始时间！");
                  }
                  if(empty($end_time))
                  {
                        $this->error("请输入终止时间！");
                  } 
                // $sql.=" and a.create_time>='{$start_time}' and a.create_time<='{$end_time}'";
        }
        // $sql .=" group by b.id order by protential desc";


    	 // $ret = $model->query($sql); 

         $ret =ChannelService::getInstance()->getStatistics($user_id,$start_time,$end_time);
    	 $this->ajaxReturn(array("status"=>1,"statistics"=>$ret)); 
    
    } 
}