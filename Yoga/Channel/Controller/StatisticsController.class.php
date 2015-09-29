<?php
namespace Channel\Controller;
use  Common\Controller\BaseController;
use Service\ChannelService;
class StatisticsController extends BaseController {
    public function indexAction(){
         $user_id = is_user_login();
        $time =  date('Y-m'); 
        $start_time=$time."-01 00:00:00";
        $end_time=$time."-31 23:59:59"; 
        $ret = ChannelService::getInstance()->getStatistics($user_id,$start_time,$end_time);      
     
        $this->assign("statistics",$ret); 
    	$this->display();
    }

    public function queryAction()
    {
    	$model = new \Think\Model();
        $brand_id = get_brand_id();
        $time =  date('Y-m');  
    	$user_id=is_user_login(); 
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
        }
        
    	  $ret =ChannelService::getInstance()->getStatistics($user_id,$start_time,$end_time);
    	 $this->ajaxReturn(array("status"=>1,"statistics"=>$ret)); 
    
    } 
}