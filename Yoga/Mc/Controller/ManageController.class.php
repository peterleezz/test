<?php
namespace Mc\Controller;
class ManageController extends  \Common\Controller\VisitBase {
  
  
    public function docheckAction($id)
    {
        M("McFollowUp")->where("id=$id")->setField(array("is_come"=>1,"come_time"=>getDbTime()));
        $this->success("到场记录成功！");
    }

    public function mymemberAction()
    {
        $this->assign("is_member",1); 
        $this->display("index");
    }

    public function myappointAction()
    {
        $this->display();
    }

    public function changeappointAction($appoint_id,$modify,$appoint_time,$desc)
    {
        $model=M("McFollowUp");
        $record=$model->find($appoint_id);
        if(empty($record))
        {
            $this->error("This appoint is not exist!");
        }
        if($modify==0)
        {
            $model->where("id=$appoint_id")->setField("desc",$desc);
        }
        else if($modify==1)
        {
            $model->where("id=$appoint_id")->setField(array("ret"=>0,"failed_reason"=>"取消"));
        }
        if($modify==2)
        {
            $model->where("id=$appoint_id")->setField(array("desc"=>$desc,"appoint_time"=>$appoint_time));
        }
        $this->success("修改成功!");
    }


    public function getAppointsAction()
    {
        list($page,$sidx,$limit,$sord,$start)=getRequestParams(); 
        $start=$start/2;
        $limit=$limit/2;
        $mc_id=is_user_login();
        $condition = array("mc_id"=>$mc_id,"ret"=>array("neq",0));  
         $filters=I("filters",'','');
        $filters = json_decode($filters);  
        $valuesql="select b.*,a.name,a.sex,a.phone from yoga_member_basic a,yoga_mc_follow_up b where b.mc_id=$mc_id and ret!=0 and a.id=b.member_id ";
        $countsql="select count(*) as count from yoga_member_basic a,yoga_mc_follow_up b where b.mc_id=$mc_id and ret!=0 and a.id=b.member_id ";

        $sql="";
        if(empty($filters))
        {
            $now=date('Y-m-d H:i:s');
            $day=$value->data;
            $time=date('Y-m-d',strtotime("-1 days ago"));
            $sql.=" and b.appoint_time >='{$now}' and  b.appoint_time <='{$time}' ";
        }
        else if($filters->groupOp=='AND')
        {
            $rules = $filters->rules; 
            foreach ($rules as $key => $value) {   
                if($value->field=="time"  && $value->data!=0)
                {
                    $now=date('Y-m-d');
                    $day=$value->data;
                    $time=date('Y-m-d',strtotime("-$day days ago"));
                    $sql.=" and b.appoint_time >='{$now}' and  b.appoint_time <='{$time}' ";
                }
                if($value->field=="name")
                {
                    $sql.=" and a.name like '%{$value->data}%'"; 
                }
                if($value->field=="phone")
                {
                     $sql.=" and a.phone='{$value->data}'"; 
                }
                if($value->field=="day" && $value->data!=0)
                {
                    $now=date('Y-m-d');
                    $day=$value->data;
                    $time=date('Y-m-d',strtotime("-$day days ago"));
                    $sql.=" and b.appoint_time >='{$now}' and  b.appoint_time <'{$time}' ";
                }
                 
                
            }
        }  
        $model = new \Think\Model();
        $countsql=$countsql." ".$sql;
        $count=$model->query($countsql);
        $count=$count[0]["count"]*2;
      
        $valuesql = $valuesql." ".$sql.$tail." order by $sidx $sord limit $start,$limit"; 

         $ret =$model->query($valuesql); 
         $newret=array();
         foreach ($ret as $key => $value) {
             $newret[]=$value;
             // if(!empty($value['desc']))
             {
                $newvalue=$value;
                $newvalue['desc']="备注：".$newvalue['desc'];
                $newvalue['name']="";
                $newret[]=$newvalue;
             }
            
         }
            if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }     
         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$newret);
         $this->ajaxReturn($response); 
    }


    public function followlistAction($id)
    {
        $list = M("McFollowUp")->where("member_id=$id")->order("create_time desc")->select();
        $this->ajaxReturn(array("status"=>1,"data"=>$list));
    }
    public function addservicelistAction()
    {
        $now=date('Y-m-d H:i:s');
        $model = D("McServiceList");
        if(!$model->create())
        {
            $this->error($model->getError());
        } 
       $id=$model->add();
       if($id)
       {
             M("MemberBasic")->where(array("id"=>I("member_id")))->setField("mc_service_time",$now);
            $this->success("添加记录成功！");
       }
       else
       {
            $this->error($model->getLastSql());
       }
    }
    public function addfollowupAction()
    {
        $now=date('Y-m-d H:i:s');
        $model = D("McFollowUp");
        if(!$model->create())
        {
            $this->error($model->getError());
        }
        $appoint_time=I("appoint_time");
        if(empty($appoint_time))
        {
            unset($model->appoint_time);
        }
       $id=$model->add();
       if($id)
       {
             M("MemberBasic")->where(array("id"=>I("member_id")))->setField("follow_up_time",$now);

             $this->success("添加记录成功！");
       }
       else
       {
            $this->error($model->getLastSql());
       }
       
    }
    
 
    public function saleAction()
    { 
        $this->display();
    }

    public function serviceAction()
    {
         $goods=D("GoodsClub")->getAllCanSaleGoods();
        $this->assign("goodslist",$goods);
     
        $this->display();
    } 
      public function servicelistAction($id)
    {
        $list = D("McServiceList")->relation(true)->where("member_id=$id")->order("create_time desc")->select();
        $this->ajaxReturn(array("status"=>1,"data"=>$list));
    }
}