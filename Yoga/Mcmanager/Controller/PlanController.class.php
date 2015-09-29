<?php
namespace Mcmanager\Controller;
use  Common\Controller\BaseController;
use Service\McService;
class PlanController extends BaseController {
    public function indexAction(){  

        $users= D("User")->getMc();
        $this->assign("users",$users);
        $time =  date('Y-m');
        $club_id = get_club_id();
        $ret=McService::getInstance()->getOneMonthStatistics($club_id,$time);  

        $this->assign("statistics",$ret);      
        $this->display();
    }

    public function queryAction()
    {
        $club_id = get_club_id(); 
        $user_id = I("user_id"); 
        if(empty($user_id))
        {
             
            $time = I("time");
            if($time==0)
            {
                $start_time = I("start_time");
                if(empty($start_time))
                {
                    $this->error("请输入开始时间！");
                }
                    $ret=McService::getInstance()->getOneMonthStatistics($club_id,$start_time); 
                    $this->ajaxReturn(array("status"=>1,"statistics"=>$ret)); 

            }
            else
            {
                $start_time = I("start_time");
                if(empty($start_time))
                {
                    $this->error("请输入开始时间！");
                }

                $end_time = I("end_time");          
                if(empty($end_time))
                {
                    $this->error("请输入终止时间！");
                }
                $ret=McService::getInstance()->getMonthStatistics($club_id,$start_time,$end_time);  
                $this->ajaxReturn(array("status"=>1,"statistics"=>$ret)); 
            }
        }
        else
        { 
            $time = I("time");
            if($time==0)
            {
                $start_time = I("start_time");
                if(empty($start_time))
                {
                    $this->error("请输入开始时间！");
                }
                    $ret=McService::getInstance()->getUserOneMonthStatistics($user_id,$start_time); 
                        $this->ajaxReturn(array("status"=>1,"statistics"=>$ret)); 

            }
            else
            {
                $start_time = I("start_time");
                if(empty($start_time))
                {
                    $this->error("请输入开始时间！");
                }

                $end_time = I("end_time");
                if(empty($end_time))
                {
                    $this->error("请输入终止时间！");
                }
                $ret=McService::getInstance()->getUserMonthStatistics($user_id,$start_time,$end_time);  

                $this->ajaxReturn(array("status"=>1,"statistics"=>$ret)); 
                }
            }
        
         
    
    }
    public function editAction()
    {
        $time = I("time");
        $time=$time."-01";
        $club_id = get_club_id();
        $model = D("McPlanTotal");        
        $ret = $model->where(array("time"=>$time,"club_id"=>$club_id))->find();
        if(!$model->create())
            {
                $this->error($model->getError());
            }
        $model->time=$time;
        if(empty($ret))
        {    
            $model->add(); 
            $this->success("新增计划成功！");      
        }else
        {
            $model->id=$ret['id'];
        
            $model->save();
            $this->success("修改计划成功！");
        }


    }

    public function editoneAction()
    {
        $time = I("time");
         $time=$time."-01";
        $club_id = get_club_id();
        $user_id=I("user_id");
        $model = D("McPlan");
        $ret = $model->where(array("time"=>$time,"club_id"=>$club_id,"user_id"=>$user_id))->find();

        if(!$model->create())
            {
                $this->error($model->getError());
            }
            $model->time=$time;
        if(empty($ret))
        {    
            $model->add();
            $this->success("新增计划成功！");      
        }else
        {
            $model->id=$ret['id'];      
            $model->save();
            $this->success("修改计划成功！");
        }


    }
}