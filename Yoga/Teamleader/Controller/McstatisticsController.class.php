<?php
namespace Teamleader\Controller;
use Common\Controller\BaseController;
use Service\McService;
class McstatisticsController extends BaseController {


	public function getProtentialFinishAction()
	{
		$start_time=date("Y-m");
		$club_id=get_club_id();
		$mcs= D("User")->getMc();
		$ret = array();
		foreach ($mcs as $key => $value) {
			$st=McService::getInstance()->getUserOneMonthStatistics($value['id'],$start_time); 
			$value = array("name"=>$value["name_cn"],"st"=>$st);
			$ret[]=$value;
		}
		
		$this->ajaxReturn(array("status"=>1,"data"=>$ret));
	}

	public function getProtentialAction()
	{
		$start_time=date("Y-m")."-01 00:00:00";
		$end_time=date("Y-m")."-31 23:59:59";
		$club_id=get_club_id();
		$ret= McService::getInstance()->getProtential($club_id,$start_time,$end_time);
		$this->ajaxReturn(array("status"=>1,"data"=>$ret));
	}

	public function getTransformAction()
	{
		$start_time=date("Y-m")."-01 00:00:00";
		$end_time=date("Y-m")."-31 23:59:59";
		$club_id=get_club_id();
		$ret= McService::getInstance()->getTransform($club_id,$start_time,$end_time);
		$this->ajaxReturn(array("status"=>1,"data"=>$ret));
	}

	public function getMemberStatisticsAction()
	{
		$user_id=I("user_id");
		$start_time=I("start_time");
		$end_time=I("end_time");
		$club_id=get_club_id();
		if(empty($start_time) && empty($end_time))
		{
			$start_time=date("Y-m",strtotime("-5 month"))."-01 00:00:00";
			$end_time=date("Y-m")."-31 23:59:59";
		} 
		$rslt = array();

		for($i=5;$i>=0;$i--)
		{
			$v=array();
			$v['m']=date("Y-m",strtotime("-{$i} month"));
			$v['protential_total']=0;
			$v['transform_total']=0;
			$rslt[]=$v;
		} 

		$ret= McService::getInstance()->getMemberStatistics($club_id,$start_time,$end_time,$user_id);
		
		foreach ($ret as $key => $value) {
			foreach ($rslt as $k => $v) {
				if($v['m']==$value['m'])
				{
					$rslt[$k]['protential_total']=$value['protential_total'];
					$rslt[$k]['transform_total']=$value['transform_total'];
				}
			}
		}
		$this->ajaxReturn(array("status"=>1,"data"=>$rslt));
	}



	public function indexAction()
	{
		$cPotentialNumber=McService::getInstance()->getThisMonthPotentialNumber();
		$lPotentialNumber=McService::getInstance()->getLastMonthPotentialNumber(); 
		$potential_ratio=$lPotentialNumber==0?"+∞":ceil(abs($lPotentialNumber-$cPotentialNumber)*100/$lPotentialNumber);
		$this->assign("potential_number",$cPotentialNumber);
		$this->assign("potential_ratio",$potential_ratio);
		$this->assign("pr_stat",$lPotentialNumber<=$cPotentialNumber?"stat-success":"stat-important");

		$cMemberNumber=McService::getInstance()->getThisMonthMemberNumber();
		$lMemberNumber=McService::getInstance()->getLastMonthMemberNumber(); 
		$member_ratio= $lMemberNumber==0?"+∞":ceil(abs($lMemberNumber-$cMemberNumber)*100/$lMemberNumber);
		$this->assign("member_number",$cMemberNumber);
		$this->assign("member_ratio",$member_ratio); 
		$this->assign("mr_stat",$lMemberNumber<=$cMemberNumber?"stat-success":"stat-important");


		$cCardSale=McService::getInstance()->getThisMonthCardsSale(); 
		$lCardSale=McService::getInstance()->getLastMonthCardsSale(); 
		$cardsale_ratio=ceil(abs($lCardSale-$cCardSale)*100/$lCardSale);
		$this->assign("cardsale",$cCardSale);
		$this->assign("cardsale_ratio",$cardsale_ratio);
		$this->assign("cs_stat",$lCardSale<=$cCardSale?"stat-success":"stat-important");


		$cGoodsSale=McService::getInstance()->getThisMonthGoodsSale(); 
		$lGoodsSale=McService::getInstance()->getLastMonthGoodsSale();
		$goodssale_ratio=$lGoodsSale==0?"+∞":ceil(abs($lGoodsSale-$cGoodsSale)*100/$lGoodsSale);
		$this->assign("goodssale",$cGoodsSale);
		$this->assign("goodssale_ratio",$goodssale_ratio);
		$this->assign("gs_stat",$lGoodsSale<=$cGoodsSale?"stat-success":"stat-important");


		$cfn=McService::getInstance()->getThisMonthFollowupNumber();
		$lfn=McService::getInstance()->getLastMonthFollowupNumber(); 
		$fn_ratio= $lfn==0?"+∞":ceil(abs($lfn-$cfn)*100/$lfn);
		$this->assign("cfn",$cfn);
		$this->assign("fn_ratio",$fn_ratio); 
		$this->assign("fn_stat",$lfn<=$cfn?"stat-success":"stat-important");

		

		$cfsn=McService::getInstance()->getThisMonthFollowupSuccess();
		$lfsn=McService::getInstance()->getLastMonthFollowupSuccess(); 
		$fsn_ratio= $lfsn==0?"+∞":ceil(abs($lfsn-$cfsn)*100/$lfsn);
		$this->assign("cfsn",$cfsn);
		$this->assign("fsn_ratio",$fsn_ratio); 
		$this->assign("fsn_stat",$lfsn<=$cfsn?"stat-success":"stat-important");


		$csn=McService::getInstance()->getThisMonthService();
		$lsn=McService::getInstance()->getLastMonthService(); 
		$sn_ratio= $lsn==0?"+∞":ceil(abs($lsn-$csn)*100/$lsn);
		$this->assign("csn",$csn);
		$this->assign("sn_ratio",$sn_ratio); 
		$this->assign("sn_stat",$lsn<=$csn?"stat-success":"stat-important");

		$cssn=McService::getInstance()->getThisMonthServiceSuccess();
		$lssn=McService::getInstance()->getLastMonthServiceSuccess(); 
		$ssn_ratio= $lssn==0?"+∞":ceil(abs($lssn-$cssn)*100/$lssn);
		$this->assign("cssn",$cssn);
		$this->assign("ssn_ratio",$ssn_ratio); 
		$this->assign("ssn_stat",$lssn<=$cssn?"stat-success":"stat-important");

		$time =  date('Y-m');
        $club_id = get_club_id();
        $plan=McService::getInstance()->getOneMonthStatistics($club_id,$time);  
       
        $this->assign("finished",ceil($plan[0]['protential_value'] * 10000 /$plan[0]['protential_plan']  )/100);
		

		$mcs=D("User")->getMc();
        $this->assign("mcs",$mcs);
        //recently member record
		$this->display();

	}
}