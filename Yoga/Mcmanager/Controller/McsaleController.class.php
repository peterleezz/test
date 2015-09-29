<?php
namespace Mcmanager\Controller;
use Common\Controller\BaseController;
class McsaleController extends BaseController { 

	public function followuplistAction()
	{ 
        $mcs=D("User")->getMc();
        $this->assign("mcs",$mcs);

		$this->display();
	}

	public function servicelistAction()
	{ 
        $mcs=D("User")->getMc();
        $this->assign("mcs",$mcs);

		$this->display();
	}

	public function queryservicelistAction()
	{
		list($page,$sidx,$limit,$sord,$start)=getRequestParams(); 
         $condition = array("club_id"=>get_club_id());  
        
         $filters=I("filters",'','');
 		$filters = json_decode($filters);  
 		$sql="";
        $setcreate_time=false;
 		if($filters->groupOp=='AND')
        {
            $rules = $filters->rules; 
            foreach ($rules as $key => $value) {               
                 if($value->field=="mc_id" && $value->data!=0)
                {
                    $condition["mc_id"] = $value->data;   
                } 
                else if($value->field=="ret" && $value->data!=-1)
                {
                    $condition["ret"] = $value->data;   
                } 
                else if($value->field=="create_time" && $value->data!=0 && $value->data!=-1)
                {
                    $setcreate_time=true;
                    $day=$value->data-1;                    
                    $time=date('Y-m-d',strtotime("$day days ago"));
                    $condition["create_time"]=array("gt",$time); 
                }
                else if($value->field=="start_time" && $value->data!=0)
                { 
                     if(isset($condition['create_time']))
                    {
                        if(!$setcreate_time)
                        $condition["create_time"]=array("between", $value->data.",". $condition["create_time"]);
                    }
                    else
                    {
                         $condition["create_time"]=array("gt",$value->data); 
                    } 
                }
                 else if($value->field=="end_time" && $value->data!=0)
                { 
                    if(isset($condition['create_time']))
                    {
                        if(!$setcreate_time)
                        $condition["create_time"]=array("between",$condition["create_time"][1].",". $value->data." 23:59:59");
                    }
                    else
                    {
                        $condition["create_time"]=array("lt",$value->data." 23:59:59");
                    } 
                } 
            }
        } 
  
         $model = D("McServiceList");

         $ret = $model->relation(true)->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select();   
       // echo $model->getLastSql();die();
         $count = $model->where($condition)->count();  
         if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }  
         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
         $this->ajaxReturn($response); 
	}
	public function queryfollowupAction()
	{
		list($page,$sidx,$limit,$sord,$start)=getRequestParams(); 
         $condition = array("club_id"=>get_club_id());  
        
         $filters=I("filters",'','');
 		$filters = json_decode($filters);  
 		$sql="";
        $setcreate_time=false;
 		if($filters->groupOp=='AND')
        {
            $rules = $filters->rules; 
            foreach ($rules as $key => $value) {               
                 if($value->field=="mc_id" && $value->data!=0)
                {
                    $condition["mc_id"] = $value->data;   
                } 
                else if($value->field=="ret" && $value->data!=-1)
                {
                    $condition["ret"] = $value->data;   
                } 
                else if($value->field=="create_time" && $value->data!=0 && $value->data!=-1)
                {
                    $setcreate_time=true;
                    $day=$value->data-1;                    
                    $time=date('Y-m-d',strtotime("$day days ago"));
                    $condition["create_time"]=array("gt",$time); 
                }
                else if($value->field=="start_time" && $value->data!=0)
                { 
                     if(isset($condition['create_time']))
                    {
                        if(!$setcreate_time)
                        $condition["create_time"]=array("between", $value->data.",". $condition["create_time"]);
                    }
                    else
                    {
                         $condition["create_time"]=array("gt",$value->data); 
                    } 
                }
                 else if($value->field=="end_time" && $value->data!=0)
                { 
                    if(isset($condition['create_time']))
                    {
                        if(!$setcreate_time)
                        $condition["create_time"]=array("between",$condition["create_time"][1].",". $value->data." 23:59:59");
                    }
                    else
                    {
                        $condition["create_time"]=array("lt",$value->data." 23:59:59");
                    } 
                } 
            }
        } 
  
         $model = D("McFollowUp");

         $ret = $model->relation(true)->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select();   
       // echo $model->getLastSql();die();
         $count = $model->where($condition)->count();  
         if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }  
         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
         $this->ajaxReturn($response); 
	}
}
