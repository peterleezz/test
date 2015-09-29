<?php
namespace Service;
class McService 
{
	protected static $instance;
	public static function getInstance($name = 'default'){
        if (empty(self::$instance[$name])){
            self::$instance[$name] = new McService($name);
        }
        return self::$instance[$name];

    }

	public function __construct()
	{
		
	}

	public function getTransform($club_id,$start_time,$end_time)
	{
		$model=D("MemberBasic"); 
		$condition["club_id"]=$club_id;
		// $condition["mc_id"]=array("neq",0);
		$condition["create_time"]=array("between","$start_time,$end_time");
		$field="COALESCE(sum(is_member),0) as transform_total,mc_id";
		$ret = $model->relation("mc")-> where($condition)->field($field)-> group("mc_id")->select(); 
		return $ret;
	}

	public function getProtential($club_id,$start_time,$end_time)
	{
		$model=D("MemberBasic"); 
		$condition["club_id"]=$club_id;
		// $condition["mc_id"]=array("neq",0);
		$condition["create_time"]=array("between","$start_time,$end_time");
		$field="count(*) as protential_total,mc_id";
		$ret = $model->relation("mc")-> where($condition)->field($field)-> group("mc_id")->select(); 
		return $ret;
	}


	/**
	 * [getMemberNumber description]
	 * @param  [type] $start_time [description]
	 * @param  [type] $end_time   [description]
	 * @param  [type] $user_id    [description]
	 * @return  array("month1"=>array("plan"=>$planarray,"actual"=>$actualarray))
	 */
	public function getMemberStatistics($club_id,$start_time,$end_time,$user_id=null)
	{
		$model=M("MemberBasic");
		if(!empty($user_id))
			$condition=array("mc_id"=>$user_id);
		$condition["club_id"]=$club_id;
		$condition["create_time"]=array("between","$start_time,$end_time");
		$field="count(*) as protential_total,COALESCE(sum(is_member),0) as transform_total,date_format(create_time,'%Y-%m') as m";
		$ret = $model->where($condition)->field($field)->group("m")-> select();
	
		return $ret;
	}

	public function getThisMonthPotentialNumber($user_id=null)
	{
		$time=date("Y-m");
		$start_time=$time."-01 00:00:00";
		$end_time=$time."-31 23:59:59";
		return $this->getPotentialNumber($start_time,$end_time,$user_id);
	}
	public function getLastMonthPotentialNumber($user_id=null)
	{
		$time=date("Y-m",strtotime("1 month ago"));
		$start_time=$time."-01 00:00:00";
		$end_time=$time."-31 23:59:59";
		return $this->getPotentialNumber($start_time,$end_time,$user_id);
	}

	public function getPotentialNumber($start_time,$end_time,$user_id=null)
	{
		$model =M("MemberBasic");
		$condition=array("club_id"=>get_club_id(),"create_time"=>array("between","$start_time,$end_time"));
		if(!empty($user_id))
		{
			$condition['record_id']=$user_id;
		}
		return $model->where($condition)->count();
	}



	public function getThisMonthMemberNumber($user_id=null)
	{
		$time=date("Y-m");
		$start_time=$time."-01 00:00:00";
		$end_time=$time."-31 23:59:59";
		return $this->getMemberNumber($start_time,$end_time,$user_id);
	}
	public function getLastMonthMemberNumber($user_id=null)
	{
		$time=date("Y-m",strtotime("1 month ago"));
		$start_time=$time."-01 00:00:00";
		$end_time=$time."-31 23:59:59";
		return $this->getMemberNumber($start_time,$end_time,$user_id);
	}

	public function getMemberNumber($start_time,$end_time,$user_id=null)
	{
		$model =M("MemberBasic");
		$condition=array("is_member"=>1,"club_id"=>get_club_id(),"join_time"=>array("between","$start_time,$end_time"));
		if(!empty($user_id))
		{
			$condition['record_id']=$user_id;
		}
		return $model->where($condition)->count();
	}


	public function getThisMonthCardsSale($user_id=null)
	{
		$time=date("Y-m");
		$start_time=$time."-01 00:00:00";
		$end_time=$time."-31 23:59:59";
		return $this->getCardsSale($start_time,$end_time,$user_id);
	}
	public function getLastMonthCardsSale($user_id=null)
	{
		$time=date("Y-m",strtotime("1 month ago"));
		$start_time=$time."-01 00:00:00";
		$end_time=$time."-31 23:59:59";
		return $this->getCardsSale($start_time,$end_time,$user_id);
	}

	public function getCardsSale($start_time,$end_time,$user_id=null)
	{
		$model =M("Contract");
		$condition=array("sale_club_id"=>get_club_id(),"create_time"=>array("between","$start_time,$end_time"));
		if(!empty($user_id))
		{
			$condition['mc_id']=$user_id;
		}
		$ret= $model->where($condition)->sum("price");
		return $ret==null?0:$ret;
	}


	public function getThisMonthGoodsSale($user_id=null)
	{
		$time=date("Y-m");
		$start_time=$time."-01 00:00:00";
		$end_time=$time."-31 23:59:59";
		return $this->getGoodsSale($start_time,$end_time,$user_id);
	}
	public function getLastMonthGoodsSale($user_id=null)
	{
		$time=date("Y-m",strtotime("1 month ago"));
		$start_time=$time."-01 00:00:00";
		$end_time=$time."-31 23:59:59";
		return $this->getGoodsSale($start_time,$end_time,$user_id);
	}

	public function getGoodsSale($start_time,$end_time,$user_id=null)
	{
		$model =M("GoodsSaleOrder");
		$condition=array("sale_club_id"=>get_club_id(),"create_time"=>array("between","$start_time,$end_time"));
		if(!empty($user_id))
		{
			$condition['mc_id']=$user_id;
		}
		$ret= $model->where($condition)->sum("price");
		return $ret==null?0:$ret;
	}


	public function getThisMonthFollowupNumber($user_id=null)
	{
		$time=date("Y-m");
		$start_time=$time."-01 00:00:00";
		$end_time=$time."-31 23:59:59";
		return $this->getFollowupNumber($start_time,$end_time,$user_id);
	}
	public function getLastMonthFollowupNumber($user_id=null)
	{
		$time=date("Y-m",strtotime("1 month ago"));
		$start_time=$time."-01 00:00:00";
		$end_time=$time."-31 23:59:59";
		return $this->getFollowupNumber($start_time,$end_time,$user_id);
	}

	public function getFollowupNumber($start_time,$end_time,$user_id=null)
	{
		$model =M("McFollowUp");
		$condition=array("club_id"=>get_club_id(),"create_time"=>array("between","$start_time,$end_time"));
		if(!empty($user_id))
		{
			$condition['mc_id']=$user_id;
		}
		return  $model->where($condition)->count();
		 
	}

	public function getThisMonthFollowupSuccess($user_id=null)
	{
		$time=date("Y-m");
		$start_time=$time."-01 00:00:00";
		$end_time=$time."-31 23:59:59";
		return $this->getFollowupSuccess($start_time,$end_time,$user_id);
	}
	public function getLastMonthFollowupSuccess($user_id=null)
	{
		$time=date("Y-m",strtotime("1 month ago"));
		$start_time=$time."-01 00:00:00";
		$end_time=$time."-31 23:59:59";
		return $this->getFollowupSuccess($start_time,$end_time,$user_id);
	}

	public function getFollowupSuccess($start_time,$end_time,$user_id=null)
	{
		$model =M("McFollowUp");
		$condition=array("ret"=>array("neq",0), "club_id"=>get_club_id(),"create_time"=>array("between","$start_time,$end_time"));
		if(!empty($user_id))
		{
			$condition['mc_id']=$user_id;
		}
		return  $model->where($condition)->count();
		 
	}


	public function getThisMonthService($user_id=null)
	{
		$time=date("Y-m");
		$start_time=$time."-01 00:00:00";
		$end_time=$time."-31 23:59:59";
		return $this->getService($start_time,$end_time,$user_id);
	}
	public function getLastMonthService($user_id=null)
	{
		$time=date("Y-m",strtotime("1 month ago"));
		$start_time=$time."-01 00:00:00";
		$end_time=$time."-31 23:59:59";
		return $this->getService($start_time,$end_time,$user_id);
	}

	public function getService($start_time,$end_time,$user_id=null)
	{
		$model =M("McServiceList");
		$condition=array("club_id"=>get_club_id(),"create_time"=>array("between","$start_time,$end_time"));
		if(!empty($user_id))
		{
			$condition['mc_id']=$user_id;
		}
		return  $model->where($condition)->count();
		 
	}

	public function getThisMonthServiceSuccess($user_id=null)
	{
		$time=date("Y-m");
		$start_time=$time."-01 00:00:00";
		$end_time=$time."-31 23:59:59";
		return $this->getServiceSuccess($start_time,$end_time,$user_id);
	}
	public function getLastMonthServiceSuccess($user_id=null)
	{
		$time=date("Y-m",strtotime("1 month ago"));
		$start_time=$time."-01 00:00:00";
		$end_time=$time."-31 23:59:59";
		return $this->getServiceSuccess($start_time,$end_time,$user_id);
	}

	public function getServiceSuccess($start_time,$end_time,$user_id=null)
	{
		$model =M("McServiceList");
		$condition=array("ret"=>2, "club_id"=>get_club_id(),"create_time"=>array("between","$start_time,$end_time"));
		if(!empty($user_id))
		{
			$condition['mc_id']=$user_id;
		}
		return  $model->where($condition)->count();
		 
	}




/**
 * 总的潜客量  只算mc添加的
 * @param  [type] $start_time [description]
 * @param  [type] $end_time   [description]
 * @param  [type] $club_id    [description]
 * @return [type]             [description]
 */
	public function getClubtTotal($start_time,$end_time,$club_id)
   {
      $model = M("MemberBasic"); 
      $value=$model->where(array("add_way"=>0,"club_id"=>$club_id,"create_time"=>array("between","$start_time,$end_time")))->field("count(*) as protential_total,COALESCE(sum(is_member),0) as transform_total")->find();
      //card sale and br
      $contractModel=M("Contract");
      $cardsale =$contractModel->where(array("club_id"=>$club_id,"create_time"=>array("between","$start_time,$end_time"),"status"=>1))->count();
      
      //br
      $br_count=$model->where(array("recommend_id"=>array("neq",0),"club_id"=>$club_id,"create_time"=>array("between","$start_time,$end_time")))->count();
      $value['cardsale_total']=$cardsale;
      $value['br_total']=$br_count;
      return $value;
   }

   public function getUsertTotal($start_time,$end_time,$user_id)
   { 
      $model = M("MemberBasic"); 
      $value=$model->where(array("mc_id"=>$user_id, "add_way"=>0,"create_time"=>array("between","$start_time,$end_time")))->field("count(*) as protential_total,COALESCE(sum(is_member),0) as transform_total")->find();

      //card sale and br
      $contractModel=M("Contract");
      $cardsale =$contractModel->where(array("mc_id"=>$user_id,"create_time"=>array("between","$start_time,$end_time"),"status"=>1))->count();
      
      //br
      $br_count= $model->where(array("mc_id"=>$user_id,"recommend_id"=>array("neq",0),"create_time"=>array("between","$start_time,$end_time")))->count();
      $value['cardsale_total']=$cardsale;
      $value['br_total']=$br_count;
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
      $ret = M("McPlanTotal")->where(array("time"=>array("between","$start_time,$end_time"),"club_id"=>$club_id))->order("time desc")->select();
      $model = M("MemberBasic");  
      foreach ($ret as $key => $value) {
      	 $time=$value["time"];
         $time=substr($time,0,7);
         $ret[$key]['time']=$time;
      	 $start_time=$time."-00 00:00:00";
      	 $end_time=$time."-31 23:59:59";      	 
      	 $value=$this->getClubtTotal($start_time,$end_time,$club_id);
         $ret[$key]["protential_value"]=$value["protential_total"];        
         $ret[$key]["transform_value"]=$value["transform_total"]; 
         $ret[$key]["cardsale_value"]=$value["cardsale_total"]; 
         $ret[$key]["br_value"]=$value["br_total"]; 
         $total= $this->getClubtTotal('0000-00-00 00:00:00',$end_time,$club_id);        
         $ret[$key]["protential_total"]=$total['protential_total']; 
         $ret[$key]["transform_total"]=$total['transform_total']; 
         $ret[$key]["cardsale_total"]=$value["cardsale_total"]; 
         $ret[$key]["br_total"]=$value["br_total"]; 
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
     // $start_time=$start_time."-00 00:00:00";
     //   $end_time=$end_time."-31 23:59:59";
      $ret = M("McPlanNew")->where(array("time"=>array("between","$start_time,$end_time"),"user_id"=>$user_id))->select();
 
    foreach ($ret as $key => $value) {
         $time=$value["time"];
         $time=substr($time,0,7);
         $ret[$key]['time']=$time; 
         $start_time=$time."-00 00:00:00";
         $end_time=$time."-31 23:59:59"; 
         $value=$this->getUsertTotal($start_time,$end_time,$user_id);  
         $ret[$key]["protential_value"]=$value["protential_total"];        
         $ret[$key]["transform_value"]=$value["transform_total"]; 
         $ret[$key]["cardsale_value"]=$value["cardsale_total"]; 
         $ret[$key]["br_value"]=$value["br_total"]; 
         $total= $this->getUsertTotal('0000-00-00 00:00:00',$end_time,$user_id);        
         $ret[$key]["protential_total"]=$total['protential_total']; 
         $ret[$key]["transform_total"]=$total['transform_total']; 
         $ret[$key]["cardsale_total"]=$value["cardsale_total"]; 
         $ret[$key]["br_total"]=$value["br_total"]; 
      }
      return $ret;
   }
}