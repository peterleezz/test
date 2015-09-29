<?php
namespace Finance\Controller;
use Common\Controller\BaseController;
class McReportController extends BaseController {
	public function indexAction()
	{   
		if(is_user_brand())
		{
			$clubs = M("Club")->where(array("brand_id"=>get_brand_id()))->field('id,club_name')->order("id desc")->select();
		}
		else
		{
			$permission=D("FinanceClub")->where(array("user_id"=>is_user_login()))->relation(true)->select();
			$clubs=array();
			foreach ($permission as $key => $value) {
				$clubs[]=$value['club'];
			}
		}
		
		$userModel=D("User");
		$mcs=$userModel->getMcByclubs($clubs);
		$pts=$userModel->getPtByclubs($clubs);
		$mcs=array_merge($mcs,$pts);
		$this->assign("mcs",$mcs);
		$this->assign("clubs",$clubs);
		$this->display();
	}

	private function getReport($type,$st,$et,$clubs,$mc_id,$group_id=6)
	{
		 // $model=D("BillProject");
		 // $condition=array("create_time"=>array("between","$st,$et"),"type"=>$type,"sale_club_id"=>array("in",$clubs),"mc_id"=>array("neq","0"));
		 // if(!empty($mc_id))
		 // {
		 // 	 $condition['mc_id']=$mc_id;
		 // } 
		 // $report=$model->where($condition)->field("mc_id,count(*) as number,sum(price) as price,sum(paid) as paid")->group("mc_id")-> select();   
		 // echo $model->getLastSql();die();
		 // foreach ($report as $key => $value) {
		 // 	$report[$key]['mc']=M("UserExtension")->where(array("id"=>$value['mc_id']))->field("id,name_cn")->find();
		 // } 
		 // if(empty($report)) return array();
		 // return $report;
		 $sql="select  a.id as mc_id,a.name_cn,count(*) as number,ifnull(sum(b.price),0) as price,ifnull(sum(b.paid),0) as paid, ifnull((price-paid),0) as own FROM `yoga_user_extension` a  inner join yoga_user c on a.id=c.id left join   `yoga_bill_project` b on a.id=b.mc_id and  b. `create_time` between \"$st\" and \"$et\" and b.type=$type and b.sale_club_id in($clubs)  inner join yoga_auth_group_access d on a.id=d.uid where d.group_id=$group_id and c.club_id in($clubs) ";
		
		if(!empty($mc_id))$sql.=" and a.id=$mc_id ";  
		$sql.=" group by a.id"; 
		$model=M("BillProject"); 
		 
		$ret=$model->query($sql);
		foreach ($ret as $key => $value) {
			if($value['price']==0 && $value['number']==1)
				$ret[$key]['number']=0;
		}
		return $ret;
	} 

	public function queryReportAction($club_ids,$mc_id,$type,$start_time,$end_time)
	{ 
		$clubs=implode(",", $club_ids);  

		switch ($type) {
			case '1': //day
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				$st=$start_time." 00:00:00";
				$et=$start_time." 23:59:59";
			 
				break;
			case '2': //month
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				$st=$start_time."-01 00:00:00";
				$et=$start_time."-31 23:59:59";
			 
				break;
			case '3': //year
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				$st=$start_time."-01-01 00:00:00";
				$et=$start_time."-12-31 23:59:59";
			 
				break;
			case '4': //other
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				if(empty($end_time))
				{
					$this->error("请输入结束时间！");
				} 
				$st=$start_time;
				$et=$end_time; 
				break;
			default:
				# code...
				break;
		}
		
		 $goodsSaleListModel = M("GoodsSaleList");
		 $goodsModel=M("Goods");
		 $billProjectModel=M("BillProject");
		 $list=array();
			//会稽
		  $report=$this->getReport(0,$st,$et,$clubs,$mc_id);  
		   foreach ($report as $key => $value) {
		    	 $report[$key]['classify']="新会员入会";  
		 		 $report[$key]['type']=1;
		    }    

		  $list=array_merge($list,$report);

		  $report=$this->getReport(4,$st,$et,$clubs,$mc_id);   
		   foreach ($report as $key => $value) {
		    	 $report[$key]['classify']="续会";  
		 		 $report[$key]['type']=2;
		    }     
		  $list=array_merge($list,$report);

		   $report=$this->getReport(5,$st,$et,$clubs,$mc_id);   
		 foreach ($report as $key => $value) {
		    	 $report[$key]['classify']="升级";  
		 		 $report[$key]['type']=3;
		    }    
		  $list=array_merge($list,$report);

 			//Pt
		  $report=$this->getReport(1,$st,$et,$clubs,$mc_id,8);   
		  foreach ($report as $key => $value) {
		    	 $report[$key]['classify']="PT";  
		 		 $report[$key]['type']=7;
		    }     
		  $list=array_merge($list,$report);

 			//储值卡  
		  $report=$this->getReport(7,$st,$et,$clubs,$mc_id);   
		   foreach ($report as $key => $value) {
		    	 $report[$key]['classify']="充值卡";  
		 		 $report[$key]['type']=9;
		    }  
		  $list=array_merge($list,$report);

		 //All Goods Order
		 $report=$this->getReport(2,$st,$et,$clubs,$mc_id);   
		 foreach ($report as $key => $value) {
		    	 $report[$key]['classify']="商品订单";  
		 		 $report[$key]['type']=11;
		    }   
		  $list=array_merge($list,$report);

		 $response = array("page"=>0,"total"=>0,"records"=>0,"rows"=>$list);
		 $this->ajaxReturn($response);   
	}



	public function getdetailAction($type,$start_time,$end_time,$reporttype,$mc_id)
	{ 
		$response=$this->getDetailData($type,$start_time,$end_time,$reporttype,$mc_id);
		$this->ajaxReturn($response);  
	}

	private function getDetailData($type,$start_time,$end_time,$reporttype,$mc_id)
	{
		list($page,$sidx,$limit,$sord,$start)=getRequestParams();
		switch ($reporttype) {
			case '1': //day
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				$st=$start_time." 00:00:00";
				$et=$start_time." 23:59:59"; 
				break;
			case '2': //month
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				$st=$start_time."-01 00:00:00";
				$et=$start_time."-31 23:59:59"; 
				break;
			case '3': //year
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				$st=$start_time."-01-01 00:00:00";
				$et=$start_time."-12-31 23:59:59"; 
				break;
			case '4': //other
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				if(empty($end_time))
				{
					$this->error("请输入结束时间！");
				} 
				$st=$start_time;
				$et=$end_time; 
				break;
			default:
				# code...
				break;
		} 
		switch ($type) {
			case '1': 
		    list($count,$list)=$this->getBillProjectHistory(0,$st,$et,$mc_id);
				break; 
			case '2': 
		     list($count,$list)=$this->getBillProjectHistory(4,$st,$et,$mc_id);
				break; 
			case '3': 
		     list($count,$list)=$this->getBillProjectHistory(5,$st,$et,$mc_id);
				break;  
			case '7': 
		    list($count,$list)=$this->getBillProjectHistory(1,$st,$et,$mc_id);
				break;  
			case '9': 
		    list($count,$list)=$this->getBillProjectHistory(7,$st,$et,$mc_id);
				break;  
			case '11': 
		    list($count,$list)=$this->getBillProjectHistory(2,$st,$et,$mc_id);
				break;  
			default:
				# code...
				break;
		}  
		
		if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
			} else { 
			  $total_pages = 0; 
			} 	

		$response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$list);
		return $response;
	}

	public function getBillProjectHistory($type,$start_time,$end_time,$mc_id)
	{
		list($page,$sidx,$limit,$sord,$start)=getRequestParams();
		$condition=array("type"=>$type,"create_time"=>array("between","$start_time,$end_time"),"mc_id"=>$mc_id);
		$model=D("BillProject");
		$bill_project=$model->relation(true)->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select(); 
		$count = $model->where($condition)->count();  
		return array($count,$bill_project);
	}
 

	public function printdetailAction($type,$start_time,$end_time,$reporttype,$mc_id)
	{ 
		  $a=array("","新会员入会","续会","升级","老会员入会余款收费","老会员续会余款收费","老会员升级余款收费","PT","已购PT余款收费","充值","",'商品订单');
          $project=$a[$type];

		$response=$this->getDetailData($type,$start_time,$end_time,$reporttype,$mc_id);
		$rows=$response['rows'];
		$head = array('编号','销售','项目名','总金额','会员','操作者','时间','备注');
		$file_name="/var/www/tmp/test.csv" ; 
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$start_time.'-'.$end_time.'-'.$reporttype.'-'.$type.'.csv"');
		header('Cache-Control: max-age=0');
		$fp = fopen('php://output', 'a');
		foreach ($head as $i => $v) {
			$head[$i] = iconv('utf-8', 'GBK', $v);
		}
		fputcsv($fp, $head);
		$cnt = 0;
		$limit = 100000;
		foreach ($rows as $key => $row) {
			$cnt ++;
			if ($limit == $cnt) {
				ob_flush();
				flush();
				$cnt = 0;
			} 
			$ret=array($row['id'],$row['mc']['name_cn'],$project,$row['price'],$row['member']['name'],$row['recorder']['name_cn'],$row['create_time'],$row['description']);
			foreach ($ret as $i => $v) {
				$ret[$i] = iconv('utf-8', 'GBK', $v);
			} 
			fputcsv($fp, $ret);
		}
	}
}
