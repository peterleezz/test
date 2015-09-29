<?php
namespace Reception\Controller;
use Common\Controller\BaseController;
 use Service\CardService;
class AppointController extends BaseController {

	public function indexAction($id)
	{

		$member = M("MemberBasic")->find($id);
		if(empty($member))
		{
			echo "找不到此用户";
			return;
		}
		 $this->member=$member;   
		$start_time = date('Y-m-d H:i:s');
        $end_time=date('Y-m-d 23:59:59',strtotime("+1 day"));
       $club_id= get_club_id();
       $club =M("Club")->find($club_id);

        $condition = array("club_id"=>$club_id,"start"=>array("between",array($start_time,$end_time))); 
       $ret = D("ClubSchedule")->where($condition)->relation(true)->order("start")-> select();  
       foreach ($ret as $key => $value) { 
        if($value['pt_id'] !=0)
        {
            $teacher = M("UserExtension")->find($value['pt_id']);  
            $ret[$key]['class']['teacher_name']=$teacher['name_en'];  
        }
        else if($value['class']['uid']!=0)
        {
            $teacher = M("UserExtension")->find($value['class']['uid']);  
            $ret[$key]['class']['teacher_name']=$teacher['name_en'];  
        }
       
         $ret[$key]['is_appointed']=0;
       
          $history=D("AppointHistory")->where(array("schedule_id"=>$value['id'],"member_id"=>$id))->find();
            if(!empty($history))
            {
                $ret[$key]['is_appointed']=1;
            }
        

       }
       $classes = $ret;
       $ret = array();
        foreach ($classes as $key => $value) {
            $start = substr($value['start'], 0,10);
            $ret[$start][]=$value;
        }

         $this->classes=$ret;   
$this->club_name=$club['club_name']; 
        $this->member_id = $id;
       
		$this->display();
	}

	public function chooseposAction($member_id,$schedule_id)
	{
		$class = D("ClubSchedule")->relation(true)->find($schedule_id);
         if(empty($class))
         {
            echo "error...";return;
         }
         $appointed=M("AppointHistory")->where(array("schedule_id"=>$schedule_id))->field("pos")->select();
         $mypos = M("AppointHistory")->where(array("schedule_id"=>$class['id'],"member_id"=>$member_id))->field("pos")->find() ; 

        $chars = str_pad("", $class['room']['num'],"a"); 
        foreach ($appointed as $key => $value) {
            $chars = substr_replace($chars,"c",$value['pos']-1,1);
        }
        if($mypos!=0)
        {
            $chars =  substr_replace($chars,"b",$mypos['pos']-1,1);
        } 
        $extension = $class['room']['extension'];
        $list = json_decode($extension);
        $arr   = array();
        $start = 0;
        $max = 0;
        foreach ($list as $key => $value) {
             $arr[]=substr( $chars, $start,$value);
             $start+=$value;
             $max = $value>$max?$value:$max;
        }

        foreach ($arr as $key => $value) {
            $arr[$key] = str_pad($value, $max,"-"); 
        } 
        $this->arr = json_encode($arr);

        $this->mypos=$mypos;
        $this->schedule_id=$schedule_id;
        $this->openid = $openid;
        $this->member_id = $member_id;
        $this->class=$class;
        $this->display();
	}
 
	public function doappointAction()
	{
		R('Weixin/Index/doAppoint',array(I("pos"),I("schedule_id"),I("member_id"),"1111111111"));
	}
	public function cancelappointAction()
	{
		// R('Weixin/Index/cancelAppoint',array(I("member_id"), I("schedule_id"),''));
        $member_id = I("member_id");
        $schedule_id= I("schedule_id");
         $model = D("AppointHistory");
      $val = $model->where(array("member_id"=>$member_id,"schedule_id"=>$schedule_id))->find();
      if(empty($val))
      {
        $this->ajaxReturn(array("status"=>1,"data"=>"取消预约成功！"));
      }
      $schedule = D("ClubSchedule")->find($schedule_id);
      // $deadline = date('Y-m-d H:i:s',strtotime('+2 hours')); 
      // if($schedule['start'] < $deadline)
      // {
      //    $this->ajaxReturn(array("status"=>1,"data"=>"课程即将开始,无法取消预约！"));
      // }

      $model->delete($val['id']);
       M("AppointOpHistory")->data(array("open_id"=>$open_id, "pos"=>$val['pos'],"schedule_id"=>$schedule_id,"member_id"=>$member_id,"status"=>0))->add(); 
        $this->ajaxReturn(array("status"=>1,"data"=>"取消预约成功！"));


	}



    public function checkappointAction()
    {
        $time = I("time");
        if(empty($time))
        {
            $start_time = date('Y-m-d 00:00:00');
            $end_time=date('Y-m-d 23:59:59');
        }
        else
        {
             $start_time =$time." 00:00:00";
             $end_time=$time." 23:59:59";
        }
      
       $club_id= get_club_id();
       $club =M("Club")->find($club_id);

        $condition = array("club_id"=>$club_id,"start"=>array("between",array($start_time,$end_time))); 
       $ret = D("ClubSchedule")->where($condition)->relation(true)->order("start")-> select();  
       foreach ($ret as $key => $value) {
        if($value['class']['uid']!=0)
        {
            $teacher = M("UserExtension")->find($value['class']['uid']);  
            $ret[$key]['class']['teacher_name']=$teacher['name_en'];  
        } 

       }
       $classes = $ret;
       $ret = array();
        foreach ($classes as $key => $value) {
            $start = substr($value['start'], 0,10);
            $ret[$start][]=$value;
        }

         $this->classes=$ret;   
        $this->club_name=$club['club_name'];  
        $this->display();
    }

    public function appointlistAction($id)
    {
        if(IS_GET) 
        {
            $this->id=$id;
            $this->display();   
        }
        else {
              list($page,$sidx,$limit,$sord,$start)=getRequestParams(); 
             $list = D("AppointHistory")->relation(true)->where(array("schedule_id"=>$id))->order("$sidx $sord")->limit("$start,$limit")->select();   
            foreach ($list as $key => $value) {
                $schedule = $value['schedule'];
                $class = M("PtClassPublic")->find($schedule['class_id']); 
                $list[$key]['schedule']['classname']=$class['name'];
            }
              $count = D("AppointHistory")->where(array("schedule_id"=>$id))->count();  
         if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }  
         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$list);
             $this->ajaxReturn($response); 
         } 
    }

    public function appointblacklistAction()
    {
        $this->display();
    }


    public function cancelblacklistAction()
    {
          $model=M("AppointBlackList");
          $model->where("id=".I("id"))->setField("status",0);
          $this->success("已经取消！");
    }
    public function queryAction()
    {
        list($page,$sidx,$limit,$sord,$start)=getRequestParams();  
        $condition=array("a.club_id"=>get_club_id());
         $filters=I("filters",'','');
        $filters = json_decode($filters);   
        if($filters->groupOp=='AND')
        {
            $rules = $filters->rules; 
            foreach ($rules as $key => $value) {               
                  
                 if($value->field=="name" && !empty($value->data))
                {
                    $condition["a.name"] = array("like","%{$value->data}%") ;   
                } 
                 if($value->field=="phone" && !empty($value->data))
                {
                    $condition["a.phone"] = $value->data;   
                } 
            }
        }  

        $model=M("AppointBlackList");
        $ret = $model->table(array("yoga_appoint_black_list"=>"b","yoga_member_basic"=>"a","yoga_card"=>"c"))->where($condition)->where("b.member_id=a.id and a.id=c.member_id and b.status=1")->field("a.name,a.sex,b.*,c.card_number")-> order("$sidx $sord")->limit("$start,$limit")-> select();  
     
        $count =$model->table(array("yoga_appoint_black_list"=>"b","yoga_member_basic"=>"a","yoga_card"=>"c"))->where($condition)->where("b.member_id=a.id and a.id=c.member_id and b.status=1")->field("a.name,a.sex,b.*,c.card_number")-> count();  
        if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }  
         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
         $this->ajaxReturn($response); 
    }
}