<?php
namespace Service;
class McNewService 
{
	protected static $instance;
	public static function getInstance($name = 'default'){
        if (empty(self::$instance[$name])){
            self::$instance[$name] = new McNewService($name);
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


	public function getProtentialBymc($mc_id,$start_time,$end_time)
	{
		$model=D("MemberBasic"); 
		$condition["mc_id"]=$mc_id;
		// $condition["mc_id"]=array("neq",0);
		$condition["create_time"]=array("between","$start_time,$end_time"); 
		$ret = $model->where($condition)->count(); 
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

	public function getTodayPotentialNumber($mc_id)
	{
		$time=date("Y-m-d");
		$start_time=$time." 00:00:00";
		$end_time=$time." 23:59:59";
		return $this->getProtentialBymc($mc_id,$start_time,$end_time);
	}
	public function getAllPotentialNumber($mc_id)
	{
		$time=date("Y-m-d");
		$start_time="2001-01-01 00:00:00";
		$end_time=$time." 23:59:59";
		return $this->getProtentialBymc($mc_id,$start_time,$end_time);
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

	public function getTodayCardsSale($mc_id)
	{
		$time=date("Y-m-d");
		$start_time=$time." 00:00:00";
		$end_time=$time." 23:59:59"; 
		return $this->getCardsSale($start_time,$end_time,$mc_id);
	}
	public function getAllCardsSale($mc_id)
	{
		$time=date("Y-m-d");
		$start_time="2001-01-01 00:00:00";
		$end_time=$time." 23:59:59";
		return $this->getCardsSale($start_time,$end_time,$mc_id);
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

   

   public function getOneMonthStatistics($club_id,$time)
   {    
         $start_time=$time."-00 00:00:00";
         $end_time=$time."-31 23:59:59";
         return $this->getMonthStatistics($club_id,$start_time,$end_time);
   }

   public function getMonthStatistics($club_id,$start_time,$end_time)
   {
      $start_time=$time."-00 00:00:00";
      $end_time=$time."-31 23:59:59"; 
   	  $new_plan=M("McPlanNew")->where(array("time"=>$time,"type"=>0,"user_id"=>$user_id))->find(); 
      $new_stat=$this->getUserMonthStatisticsNew($user_id,$start_time,$end_time); 

       $old_plan=M("McPlanNew")->where(array("time"=>$time,"type"=>1,"user_id"=>$user_id))->find(); 
      $old_stat=$this->getUserMonthStatisticsOld($user_id,$start_time,$end_time); 

      $member_plan=M("McPlanNew")->where(array("time"=>$time,"type"=>2,"user_id"=>$user_id))->find(); 
     
      $member_stat=$this->getUserMonthStatisticsMember($user_id,$start_time,$end_time); 
      return array("newplan"=>$new_plan,"newstat"=>$new_stat,"oldplan"=>$old_plan,"oldstat"=>$old_stat,"memberplan"=>$member_plan,"memberstat"=>$member_stat);

   }


   //当月统计，以前的查统计表
    public function getUserOneMonthStatistics($user_id,$time)
   {

   	$today=date("Y-m");
   	if($time < $today)
   	{
   		$ret=M("McPlanArchive")->where(array("user_id"=>$user_id,"time"=>$time))->find(); 
   		if($ret)
   		return json_decode($ret['value'],true);
   	}
   	  $start_time=$time."-00 00:00:00";
      $end_time=$time."-31 23:59:59"; 
   	  $new_plan=M("McPlanNew")->where(array("time"=>$time,"type"=>0,"user_id"=>$user_id))->find(); 
      $new_stat=$this->getUserMonthStatisticsNew($user_id,$start_time,$end_time); 

       $old_plan=M("McPlanNew")->where(array("time"=>$time,"type"=>1,"user_id"=>$user_id))->find(); 
      $old_stat=$this->getUserMonthStatisticsOld($user_id,$start_time,$end_time); 

      $member_plan=M("McPlanNew")->where(array("time"=>$time,"type"=>2,"user_id"=>$user_id))->find(); 
     
      $member_stat=$this->getUserMonthStatisticsMember($user_id,$start_time,$end_time); 
      return array("newplan"=>$new_plan,"newstat"=>$new_stat,"oldplan"=>$old_plan,"oldstat"=>$old_stat,"memberplan"=>$member_plan,"memberstat"=>$member_stat);
   }

   public function getUserMonthStatisticsNew($user_id,$start_time,$end_time)
   {  
      $model = M("MemberBasic"); 
      $value=$model->where(array("mc_id"=>$user_id, "add_way"=>0,"create_time"=>array("between","$start_time,$end_time")))->field("count(*) as protential,COALESCE(sum(is_member),0) as transform")->find(); 
      
	$transform=$model->where(array("mc_id"=>$user_id,"create_time"=>array("between","$start_time,$end_time")))->field("COALESCE(sum(is_member),0) as transform")->find();
	$value['transform']=$transform['transform'] ;
      //card sale and br
     
      $deal_num=$this->getDealNumNew($start_time,$end_time,$user_id);
      //br
      $br_count= $model->where(array("mc_id"=>$user_id,"recommend_id"=>array("neq",0),"create_time"=>array("between","$start_time,$end_time")))->count();
      $value['deal_num']=$deal_num;
      $value['br_total']=$br_count;

      //invit
      $invit = $this->getFollowupNumberNew($start_time,$end_time,$user_id);
      $invit_success= $this->getFollowupSuccessNew($start_time,$end_time,$user_id);
      $invit_come = $this->getFollowupComeNew($start_time,$end_time,$user_id);

      $value['invit']=$invit;
      $value['invit_success']=$invit_success;
      $value['invit_come']=$invit_come;

      $value['pre_sale']=$this->getPreSaleNew($start_time,$end_time,$user_id);
      $a_member=$this->getAmemberNew($start_time,$end_time,$user_id);
      $b_member=$this->getBmemberNew($start_time,$end_time,$user_id);
      $value['a_member']=$a_member;
      $value['b_member']=$b_member;

      //sale  
      $sale=$this->getSaleNew($start_time,$end_time,$user_id);
      $value['sale']=$sale;
      return $value;
   } 

 public function getPreSaleNew($start_time,$end_time,$user_id=null)
	{
	 	$model = M("MemberBasic"); 
        $value=$model->where(array("mc_id"=>$user_id, "is_member"=>0, "type"=>4,"create_time"=>array("between","$start_time,$end_time")))->field("COALESCE(sum(`pre_sale`),0) as price")->find(); 
       
		return $value['price'];
	}



       public function getDealNumNew($start_time,$end_time,$user_id=null)
	{
		$model =M("BillProject"); 
		$club_id=get_club_id();
		return $model->where("b.`type` in(0,4,5) and  a.club_id=$club_id and b.mc_id=$user_id and b.member_id=a.id and a.create_time between \"{$start_time}\" and  \"{$end_time}\"  ")->table(array("yoga_member_basic"=>"a","yoga_bill_project"=>"b"))-> count();
		 
	}


 public function getSaleNew($start_time,$end_time,$user_id=null)
	{
		$model =M("BillProject"); 
		$club_id=get_club_id();
		$ret= $model->where("b.`type` in(0,4,5) and  a.club_id=$club_id and b.mc_id=$user_id and b.member_id=a.id and a.create_time between \"{$start_time}\" and  \"{$end_time}\"  ")->table(array("yoga_member_basic"=>"a","yoga_bill_project"=>"b"))-> sum("b.price");
		return $ret?$ret:0;
	}

   public function getAmemberNew($start_time,$end_time,$user_id=null)
	{
		$model = M("MemberBasic"); 
        $value=$model->where(array("mc_id"=>$user_id, "is_member"=>0,"type"=>4,"create_time"=>array("between","$start_time,$end_time")))->field("count(*) as a_member")->find(); 
       
		return $value['a_member'];
	}

	 public function getBmemberNew($start_time,$end_time,$user_id=null)
	{
		$model = M("MemberBasic"); 
        $value=$model->where(array("mc_id"=>$user_id,"is_member"=>0, "type"=>3,"create_time"=>array("between","$start_time,$end_time")))->field("count(*) as b_member")->find(); 
        return $value['b_member'];
	}

   public function getFollowupComeNew($start_time,$end_time,$user_id=null)
	{
		$model =M("McFollowUp"); 
		$club_id=get_club_id();
		return  $model->where("b.is_come=1 and b.club_id=$club_id and b.mc_id=$user_id and b.member_id=a.id and a.create_time between \"{$start_time}\" and  \"{$end_time}\"  ")->table(array("yoga_member_basic"=>"a","yoga_mc_follow_up"=>"b"))-> count();
		 
	}

   public function getFollowupNumberNew($start_time,$end_time,$user_id=null)
	{
		$model =M("McFollowUp"); 
		$club_id=get_club_id();
		return  $model->where("b.club_id=$club_id and b.mc_id=$user_id and b.member_id=a.id and a.create_time between \"{$start_time}\" and  \"{$end_time}\"  ")->table(array("yoga_member_basic"=>"a","yoga_mc_follow_up"=>"b"))-> count();
		 
	}

	
	public function getFollowupSuccessNew($start_time,$end_time,$user_id=null)
	{
	 	$model =M("McFollowUp"); 
		$club_id=get_club_id();
		return  $model->where("b.ret!=0 and b.club_id=$club_id and b.mc_id=$user_id and b.member_id=a.id and a.create_time between \"{$start_time}\" and  \"{$end_time}\"  ")->table(array("yoga_member_basic"=>"a","yoga_mc_follow_up"=>"b"))-> count();
	 }













	 public function getUserMonthStatisticsOld($user_id,$start_time,$end_time)
   {  
      $model = M("MemberBasic"); 
      $value=array();
      $ret=$model->where(array("mc_id"=>$user_id, "is_member"=>1,"create_time"=>array("lt","$start_time"),"join_time"=>array("between","$start_time,$end_time")))->count(); 
      $value['transform']=$ret;
      $deal_num=$this->getDealNumOld($start_time,$end_time,$user_id);
       
      $value['deal_num']=$deal_num;
      

      //invit
      $invit = $this->getFollowupNumberOld($start_time,$end_time,$user_id);
      $invit_success= $this->getFollowupSuccessOld($start_time,$end_time,$user_id);
      $invit_come = $this->getFollowupComeOld($start_time,$end_time,$user_id);

      $value['invit']=$invit;
      $value['invit_success']=$invit_success;
      $value['invit_come']=$invit_come;

      $value['pre_sale']=$this->getPreSaleOld($start_time,$end_time,$user_id);
      $a_member=$this->getAmemberOld($start_time,$end_time,$user_id);
      $b_member=$this->getBmemberOld($start_time,$end_time,$user_id);
      $value['a_member']=$a_member;
      $value['b_member']=$b_member;

      //sale  
      $sale=$this->getSaleOld($start_time,$end_time,$user_id);
      $value['sale']=$sale;
      return $value;
   } 

 public function getPreSaleOld($start_time,$end_time,$user_id=null)
	{
	 	$model = M("MemberBasic"); 
        $value=$model->where(array("mc_id"=>$user_id, "is_member"=>0,"type"=>4,"level_update_time"=>array("between","$start_time,$end_time"),"create_time"=>array("lt","$start_time")))->field("COALESCE(sum(`pre_sale`),0) as price")->find(); 
       
		return $value['price'];
	}



       public function getDealNumOld($start_time,$end_time,$user_id=null)
	{
		$model =M("BillProject"); 
		$club_id=get_club_id();
		return $model->where("b.`type` in(0,4,5) and  b.create_time between \"{$start_time}\"  and \"{$end_time}\"  and  a.club_id=$club_id and b.mc_id=$user_id and b.member_id=a.id and a.create_time < \"{$start_time}\"  ")->table(array("yoga_member_basic"=>"a","yoga_bill_project"=>"b"))-> count();
		 
	}


 public function getSaleOld($start_time,$end_time,$user_id=null)
	{
		$model =M("BillProject"); 
		$club_id=get_club_id();
		return $model->where("b.`type` in(0,4,5)  and  b.create_time between \"{$start_time}\"  and \"{$end_time}\" and  a.club_id=$club_id and b.mc_id=$user_id and b.member_id=a.id and a.create_time < \"{$start_time}\"  ")->table(array("yoga_member_basic"=>"a","yoga_bill_project"=>"b"))-> sum("b.price");
		 
	}

   public function getAmemberOld($start_time,$end_time,$user_id=null)
	{
		$model = M("MemberBasic"); 
        $value=$model->where(array("mc_id"=>$user_id, "is_member"=>0,"type"=>4,"level_update_time"=>array("between","$start_time,$end_time"),"create_time"=>array("lt","$start_time")))->field("count(*) as a_member")->find(); 
       
		return $value['a_member'];
	}

	 public function getBmemberOld($start_time,$end_time,$user_id=null)
	{
		$model = M("MemberBasic"); 
        $value=$model->where(array("mc_id"=>$user_id, "is_member"=>0,"type"=>3,"level_update_time"=>array("between","$start_time,$end_time"),"create_time"=>array("lt","$start_time")))->field("count(*) as b_member")->find(); 
        return $value['b_member'];
	}

   public function getFollowupComeOld($start_time,$end_time,$user_id=null)
	{
		$model =M("McFollowUp"); 
		$club_id=get_club_id();
		return  $model->where("b.is_come=1 and  b.create_time between \"{$start_time}\"  and \"{$end_time}\"  and  b.club_id=$club_id and b.mc_id=$user_id and b.member_id=a.id and a.create_time < \"{$start_time}\"  ")->table(array("yoga_member_basic"=>"a","yoga_mc_follow_up"=>"b"))-> count();
		 
	}

   public function getFollowupNumberOld($start_time,$end_time,$user_id=null)
	{
		$model =M("McFollowUp"); 
		$club_id=get_club_id();
		return  $model->where("b.club_id=$club_id and  b.create_time between \"{$start_time}\"  and \"{$end_time}\"  and b.mc_id=$user_id and b.member_id=a.id and a.create_time < \"{$start_time}\"   ")->table(array("yoga_member_basic"=>"a","yoga_mc_follow_up"=>"b"))-> count();
		 
	}

	
	public function getFollowupSuccessOld($start_time,$end_time,$user_id=null)
	{
	 	$model =M("McFollowUp"); 
		$club_id=get_club_id();
		return  $model->where("b.ret!=0 and  b.create_time between \"{$start_time}\"  and \"{$end_time}\"  and b.club_id=$club_id and b.mc_id=$user_id and b.member_id=a.id and a.create_time < \"{$start_time}\"")->table(array("yoga_member_basic"=>"a","yoga_mc_follow_up"=>"b"))-> count();
	 }

















	 public function getUserMonthStatisticsMember($user_id,$start_time,$end_time)
   {  
      $model = M("MemberBasic"); 
      $value=array(); 
      $deal_num=$this->getDealNumMember($start_time,$end_time,$user_id);
       
      $value['deal_num']=$deal_num;
       

      $value['pre_sale']=$this->getPreSaleMember($start_time,$end_time,$user_id);
      $a_member=$this->getAmemberMember($start_time,$end_time,$user_id);
      $b_member=$this->getBmemberMember($start_time,$end_time,$user_id);
      $value['a_member']=$a_member;
      $value['b_member']=$b_member;

      //sale  
      $sale=$this->getSaleMember($start_time,$end_time,$user_id);
      $value['sale']=$sale;
      return $value;
   } 

 public function getPreSaleMember($start_time,$end_time,$user_id=null)
	{
	 	$model = M("MemberBasic"); 
        $value=$model->where(array("mc_id"=>$user_id,"is_member"=>1, "type"=>4,"join_time"=>array("lt","$start_time")))->field("sum(`hopeprice`) as price")->find();  
		return $value['price'];
	}



    public function getDealNumMember($start_time,$end_time,$user_id=null)
	{
		$model =M("BillProject"); 
		$club_id=get_club_id();
		return $model->where("b.`type` in(0,4,5) and  a.club_id=$club_id and b.mc_id=$user_id and b.member_id=a.id and a.join_time < \"{$start_time}\"  ")->table(array("yoga_member_basic"=>"a","yoga_bill_project"=>"b"))-> count();
		 
	}


 public function getSaleMember($start_time,$end_time,$user_id=null)
	{
		$model =M("BillProject"); 
		$club_id=get_club_id();
		return $model->where("b.`type` in(0,4,5) and  a.club_id=$club_id and b.mc_id=$user_id and b.member_id=a.id and a.join_time < \"{$start_time}\"  ")->table(array("yoga_member_basic"=>"a","yoga_bill_project"=>"b"))-> sum("b.price");
		 
	}

   public function getAmemberMember($start_time,$end_time,$user_id=null)
	{
		$model = M("MemberBasic"); 
        $value=$model->where(array("mc_id"=>$user_id, "is_member"=>1,"type"=>4,"join_time"=>array("lt","$start_time"),"level_update_time"=>array("between","$start_time,$end_time")))->field("count(*) as a_member")->find(); 
       
		return $value['a_member'];
	}

	 public function getBmemberMember($start_time,$end_time,$user_id=null)
	{
		$model = M("MemberBasic"); 
        $value=$model->where(array("mc_id"=>$user_id, "is_member"=>1,"type"=>3,"join_time"=>array("lt","$start_time"),"level_update_time"=>array("between","$start_time,$end_time")))->field("count(*) as b_member")->find(); 
       
		return $value['b_member'];
	}

  
}
