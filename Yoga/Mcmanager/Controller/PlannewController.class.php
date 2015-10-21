<?php
namespace Mcmanager\Controller;
use  Common\Controller\BaseController;
use Service\McNewService;
class PlannewController extends BaseController {

	public function indexAction()
	{
	   $users= D("User")->getMc();
        $this->assign("users",$users);
        $time =  date('Y-m');
        $club_id = get_club_id();
        $ret=McNewService::getInstance()->getOneMonthStatistics($club_id,$time);  
 
        $this->assign("statistics",$ret);      
        $this->display();
	}

        public function planAction()
        {
                $users= D("User")->getMc();
                $this->assign("users",$users);
               
                $this->display();
        }
        public function newmonthAction()
        {
                $this->makePlanAction(0);
        }

public function oldmonthAction()
        {
                $this->makePlanAction(1);
        }
public function membermonthAction()
        {
                $this->makePlanAction(2);
        }
        public function makePlanAction($type)
        {
                $time = I("time"); 
                $club_id = get_club_id();
                $model = D("McPlanNew");        
                $user_id=I("user_id");
                $ret = $model->where(array("time"=>$time,"club_id"=>$club_id,"user_id"=>$user_id,"type"=>$type))->find();
                if(!$model->create())
                    {
                        $this->error($model->getError());
                    } 
                    $model->type=$type;
                    $model->time = I("time")."-01 00:00:00";
                if(empty($ret))
                {    
                    $model->add(); 

                    $this->avg($user_id,I("protential"),I("invit"),I("invit_success"),I("invit_come"),I("deal_num"),I("a_member"),I("b_member"),I("pre_sale"),I("sale"),I("transform"),$type,I("time"));
                    $this->success("新增计划成功！");      
                }else
                {
                    $model->id=$ret['id']; 
                    $model->save();
                     $this->avg($user_id,I("protential"),I("invit"),I("invit_success"),I("invit_come"),I("deal_num"),I("a_member"),I("b_member"),I("pre_sale"),I("sale"),I("transform"),$type,I("time"));
                    $this->success("修改计划成功！");
                } 
        }

        private function avg($userid,$protential,$invit,$invit_success,$invit_come,$deal_num,$a_member,$b_member,$pre_sale,$sale,$transform,$type,$time)
        {
             //cal days
             $fd=$time."-01"; 
             $ld=strtotime("$fd +1 month");
             $days= ($ld-strtotime($fd))/(60*60*24); 
             $protential_avg=round($protential/$days);
             $invit_avg=round($invit/$days);
             $invit_success_avg=round($invit_success/$days);
             $invit_come_avg=round($invit_come/$days);
             $deal_num_avg=round($deal_num/$days);
             $a_member_avg=round($a_member/$days);
             $b_member_avg=round($b_member/$days);
             $pre_sale_avg=round($pre_sale/$days);
             $sale_avg=round($sale/$days);
             $transform_avg=round($transform/$days);
             $dao = M("McPlanDayNew");
             $dao->where(array("type"=>$type,"user_id"=>$userid,"time"=>array("between","{$time}-01,{$time}-31")))->delete();
             $data=array("type"=>$type,"brand_id"=>get_brand_id(),"club_id"=>get_club_id(), "user_id"=>$userid, "protential"=>$protential_avg,"invit"=>$invit_avg,"invit_success"=>$invit_success_avg,"invit_come"=>$invit_come_avg,"deal_num"=>$deal_num_avg,"a_member"=>$a_member_avg,"b_member"=>$b_member_avg,"pre_sale"=>$pre_sale_avg,"sale"=>$sale_avg,"transform"=>$transform_avg);
             for($i=1;$i<$days;$i++)
             {
                $day=$time."-".str_pad($i,2,"0",STR_PAD_LEFT);  
                $data['time']=$day;
                $dao->data($data)->add();
             }
             $day=$time."-".str_pad($days,2,"0",STR_PAD_LEFT);  
             $days=$days-1;
             $data=array("type"=>$type,"brand_id"=>get_brand_id(),"club_id"=>get_club_id(),"user_id"=>$userid, "protential"=>$protential-$protential_avg*$days,"invit"=>$invit-$invit_avg*$days,"invit_success"=>$invit_success-$invit_success_avg*$days,"invit_come"=>$invit_come-$invit_come_avg*$days,"deal_num"=>$deal_num-$deal_num_avg*$days,"a_member"=>$a_member-$a_member_avg*$days,"b_member"=>$b_member-$b_member_avg*$days,"pre_sale"=>$pre_sale-$pre_sale_avg*$days,"sale"=>$sale-$sale_avg*$days,"transform"=>$transform-$transform_avg*$days);
             $data['time']=$day;
             $dao->data($data)->add();

        }

        public function getnewjsonAction()
        {
               
                $this->getjson(0);
        }

 public function getmemberjsonAction()
        {
               
                $this->getjson(2);
        }

        public function getoldjsonAction()
        {
               
                $this->getjson(1);
        }

        private function getjson($type)
        {
                 $dao=M("McPlanDayNew");
                $start=I("start");
                $start=date('Y-m',$start+7*24*3600);
                $start_time=$start."-01";
                $end_time=$start."-31";
                $ret=$dao->where(array("user_id"=>I("user_id"),"type"=>$type, "time"=>array("between",("$start_time,$end_time"))))-> select();
  
                $arr=array();
                foreach ($ret as $key => $value) {
                        if($type==0)
                                $arr[]=array("title"=>"新增潜客:". $value['protential'],"start"=>$value['time']." 01:00","className"=>"label label-success");
                        if($type!=2)
                       $arr[]=array("title"=>"到场量:".$value['invit_come'],"start"=>$value['time']." 02:00","className"=>"label label-warning");
                       $arr[]=array("title"=>"A类客户:".$value['a_member'],"start"=>$value['time']." 03:00","className"=>"label label-danger");
                       $arr[]=array("title"=>"预购金额:".$value['pre_sale'],"start"=>$value['time']." 04:00","className"=>"label label-info");
                       $arr[]=array("title"=>"售出金额:".$value['sale'],"start"=>$value['time']." 05:00","className"=>"label label-inverse");
                       $arr[]=array("title"=>"成交单数:".$value['deal_num'],"start"=>$value['time']." 06:00","className"=>"label");
                }

                $this->ajaxReturn(($arr));
        }

        protected static $type = array("01:00"=>"protential","02:00"=>"invit_come","03:00"=>"a_member","04:00"=>"pre_sale","05:00"=>"sale","06:00"=>"deal_num");

        public function loadTotalPlanAction($user_id,$time,$type)
        {
                $time = $time ."-01 00:00:00";
                $ret=M("McPlanNew")->where(array("time"=>$time,"type"=>$type,"user_id"=>$user_id))->find();
                $recently_num=0;
                if($type==2)
                {
                    $start_time=$time."-01";
                    $end_time=date("Y-m-d",strtotime("$start_time +3 month"));
                    $club_id=get_club_id();
                    $sql="select count(*) as cnt from yoga_member_basic a, yoga_contract b where b.end_time >= \"{$start_time}\" and b.end_time<= \"{$end_time}\" and a.id=b.member_id and a.club_id=$club_id and  not exists(select * from yoga_contract c where c.member_id=b.member_id and c.end_time >  \"{$end_time}\" )";
                    $sum =M("McPlanNew")->query($sql);
                    $recently_num=$sum[0]['cnt'];  
                }
                $response=array("data"=>$ret,"status"=>1,"recently_num"=>$recently_num);
                $this->ajaxReturn($response);
        }

        public function setdayoldAction()
        {
                 $this->setday(1);
        }

        private function setday($tt)
        {
                $dao=M("McPlanDayNew");
               $type=date('Y-m-d H:i',strtotime(I("type"))); 
               $type=explode(" ", $type);
               $key=$type[1];
               $time=$type[0];
                 $month=substr($time,0,7);
               $property=self::$type[$key]; 
               $processway=I("processway");
               if($processway==1)
               {
                     $current=$dao->where(array("time"=>$time,"type"=>$tt,"user_id"=>I("user_id")))->field($property)->find();
                     $value=I("value");
                     $inc=$value-$current[$property];
                     $dao->where(array("time"=>$time,"type"=>$tt,"user_id"=>I("user_id")))->setField(array("$property"=>I("value"))); 
                     M("McPlanNew")->where(array("time"=>$month,"type"=>$tt,"user_id"=>I("user_id")))->setInc($property,$inc);
                   
                     $this->success("ok");
               }

                $end_=$month."-31";
                 $sum=$dao->where(array("time"=>array("between","$time,$end_"),"type"=>$tt,"user_id"=>I("user_id")))->sum($property);
               
                 if($sum < I("value"))
                 {
                    $this->error("分配值超过余下能分配的额度！请重新分配！");
                 }

               $dao->where(array("time"=>$time,"type"=>$tt,"user_id"=>I("user_id")))->setField(array("$property"=>I("value"))); 
               //余下的平均分配
             
               $start=$month."-01";
               $sum=$dao->where(array("time"=>array("between","$start,$time"),"type"=>$tt,"user_id"=>I("user_id")))->sum($property);

               $total=M("McPlanNew")->where(array("time"=>$month,"type"=>$tt,"user_id"=>I("user_id")))->field($property)->find();
               $total=$total[$property];

               $left=$total-$sum; 
               $ld=strtotime("$start +1 month -1 day");
               $left_day=($ld-strtotime($time))/(60*60*24); 
               if($left_day==0)
               {
                        $this->error("本月最后一天数据禁止修改！");
               }


               $property_avg=floor($left/$left_day);

               //update after today before the last day 
               $end=date("Y-m-d", strtotime("$start +1 month -2 day")); 
               $tomorrow=date("Y-m-d", strtotime("$time +1 day")); 
               if($left_day >1)
                        $dao->where(array("time"=>array("between","$tomorrow,$end"),"type"=>$tt,"user_id"=>I("user_id")))->setField(array("$property"=>$property_avg)); 
                
                $left_property=$left - $property_avg * ($left_day-1);
                $dao->where(array("time"=>date("Y-m-d",$ld),"type"=>$tt,"user_id"=>I("user_id")))->setField(array("$property"=>$left_property)); 
               
                $this->success("ok");
        }
        public function setdaynewAction()
        {
               $this->setday(0);
        }
         public function setdaymemberAction()
        {
               $this->setday(2);
        }



    public function queryAction()
    {
        $club_id = get_club_id(); 
        $user_id = I("user_id"); 
          $start_time = I("start_time");
                if(empty($start_time))
                {
                    $this->error("请输入开始时间！");
                }
        if(empty($user_id))
        {
             
          
                    $ret=McNewService::getInstance()->getMonthStatistics($club_id,$start_time);  
               
                    $this->ajaxReturn(array("status"=>1,"statistics"=>$ret)); 
 
        }
        else
        { 
           
                    $ret=McNewService::getInstance()->getUserOneMonthStatistics($user_id,$start_time); 
               
                    $this->ajaxReturn(array("status"=>1,"statistics"=>$ret)); 
 
            
            }
        
         
    
    }
}