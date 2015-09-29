<?php
namespace Finance\Controller;
use Common\Controller\BaseController;
class ReportController extends BaseController {
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
		
		$this->assign("clubs",$clubs);
		$this->display();
	} 

	public function queryReportAction($club_ids,$type,$start_time,$end_time)
	{ 
		$clubs=implode(",", $club_ids);
		$condition_goods=array("sale_club_id"=>array("in",$clubs));
		$condition_bill=array("sale_club_id"=>array("in",$clubs));

		switch ($type) {
			case '1': //day
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				$st=$start_time." 00:00:00";
				$et=$start_time." 23:59:59";
				$condition_goods["create_time"]=array("between","$st,$et");
				$condition_recharge["create_time"]=array("between","$st,$et");
				break;
			case '2': //month
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				$st=$start_time."-01 00:00:00";
				$et=$start_time."-31 23:59:59";
				$condition_goods["create_time"]=array("between","$st,$et");
				$condition_recharge["create_time"]=array("between","$st,$et");
				break;
			case '3': //year
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				$st=$start_time."-01-01 00:00:00";
				$et=$start_time."-12-31 23:59:59";
				$condition_goods["create_time"]=array("between","$st,$et");
				$condition_recharge["create_time"]=array("between","$st,$et");
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
				$condition_goods["create_time"]=array("between","$start_time,$end_time");
				$condition_recharge["create_time"]=array("between","$start_time,$end_time");
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
		  $report=$this->getReport(0,$st,$et,$clubs); 
		  $report['name']="新会员入会+余款收费";
		  $report['classify']="会籍收费";  
		  $report['type']=1;
		  $report['subtype']=0;
		  $list[]=$report; 

		   $report=$this->getReport(4,$st,$et,$clubs); 
		  $report['name']="续会+余款收费";
		  $report['classify']="会籍收费";  
		   $report['type']=2;
		  $report['subtype']=0;
		  $list[]=$report; 

		   $report=$this->getReport(5,$st,$et,$clubs); 
		  $report['name']="升级+余款收费";
		  $report['classify']="会籍收费"; 
		   $report['type']=3;
		  $report['subtype']=0; 
		  $list[]=$report; 

		  $report=$this->getPayReport(0,$st,$et,$clubs); 
		  $report['name']="老会员入会余款收费";
		  $report['classify']="会籍收费"; 
		   $report['type']=4;
		  $report['subtype']=0; 
		  $list[]=$report; 

		  $report=$this->getPayReport(4,$st,$et,$clubs); 
		  $report['name']="老会员续会余款收费";
		  $report['classify']="会籍收费";  
		   $report['type']=5;
		  $report['subtype']=0;
		  $list[]=$report; 

		  $report=$this->getPayReport(5,$st,$et,$clubs); 
		  $report['name']="老会员升级余款收费";
		  $report['classify']="会籍收费"; 
		   $report['type']=6;
		  $report['subtype']=0; 
		  $list[]=$report;  

		
		  $report=$this->getReport(9,$st,$et,$clubs); 
		  $report['name']="会籍定金";
		  $report['classify']="会籍收费"; 
		  $report['type']=13;
		  $report['subtype']=0; 
		  $list[]=$report; 



		  $report=$this->getReport(10,$st,$et,$clubs); 
		  $report['name']="退卡";
		  $report['classify']="会籍收费"; 
		  $report['type']=15;
		  $report['subtype']=0; 
		  $list[]=$report; 



 			//Pt
		  $report=$this->getReport(1,$st,$et,$clubs); 
		  $report['name']="新购PT+余款收费";
		  $report['classify']="PT";  
		   $report['type']=7;
		  $report['subtype']=0;
		  $list[]=$report; 

		  $report=$this->getPayReport(1,$st,$et,$clubs); 
		  $report['name']="已购PT余款收费";
		  $report['classify']="PT";  
		   $report['type']=8;
		  $report['subtype']=0;
		  $list[]=$report; 

		  $report=$this->getReport(8,$st,$et,$clubs); 
		  $report['name']="PT定金";
		  $report['classify']="PT"; 
		  $report['type']=14;
		  $report['subtype']=0; 
		  $list[]=$report; 


 			//储值卡  
		  $report=$this->getReport(7,$st,$et,$clubs); 
		  $report['name']="充值";
		  $report['classify']="充值卡"; 
		   $report['type']=9;
		  $report['subtype']=0; 
		  $list[]=$report; 

 		// //各类商品的销售情况
		 // $goods_list = $goodsSaleListModel->where($condition_goods)->field('goods_id,sum(number) as number ,sum(price*number) as price')->group('goods_id')->select();
		 
		 // foreach ($goods_list as $key => $value) {
		 // 	 $goods=$goodsModel->find($value['goods_id']);
		 // 	 $goods_list[$key]['name']=$goods['name'];
		 // 	 $goods_list[$key]['cash']="未知";
		 // 	 $goods_list[$key]['check']="未知";
		 // 	 $goods_list[$key]['pos']="未知";
		 // 	 $goods_list[$key]['recharge']="未知";
		 // 	 $goods_list[$key]['classify']="商品详细"; 
		 // 	 $goods_list[$key]['paid']="未知";
		 // 	 $goods_list[$key]['own']="未知";
		 // 	 $goods_list[$key]['type']=10;
		 //     $goods_list[$key]['subtype']=$value['goods_id'];
		 // }
		 // if(!empty($goods_list))
		 // $list=array_merge($list,$goods_list);

		  $payHistoryModel=M("PayHistory");  
		 //All Goods Order
		 $report=$this->getReport(2,$st,$et,$clubs); 
		  $report['name']="新增商品订单+余款";
		  $report['classify']="商品订单";  
		   $report['type']=11;
		  $report['subtype']=0; 
		  $list[]=$report; 

		  $report=$this->getPayReport(2,$st,$et,$clubs); 
		  $report['name']="老商品订单余款";
		  $report['classify']="商品订单";  
		   $report['type']=12;
		  $report['subtype']=0;
		  $list[]=$report; 

		 


		 

		 // $sql="select count(*) as `number`, sum(`cash`+`pos`+`check`+`recharge`) as price,sum(`recharge`) as `recharge`,sum(`cash`) as `cash` ,sum(`pos`) as `pos`,sum(`check`) as `check` from yoga_pay_history where `bill_project_id` in (select `id` from yoga_bill_project where `sale_club_id` in ($clubs) and `create_time` between \"$st\" and \"$et\" and `type`=7)";
		 
		 // $payHistoryModel=M("PayHistory");  
		 // $recharge_list = $payHistoryModel->query($sql); 
		 // foreach ($recharge_list as $key => $value) { 
		 // 	 $recharge_list[$key]['name']="充值";
		 // 	 $recharge_list[$key]['classify']="充值卡";  
		 // 	 $recharge_list[$key]['paid']=$value['price'];
		 // 	 $recharge_list[$key]['own']="0";
		 // }
		 // $list=array_merge($list,$recharge_list);

		 
		 $userData=array("price"=>0,"paid"=>0,"check"=>0,"cash"=>0,"recharge"=>0,'pos'=>0,'network'=>0,'netbank'=>0,"number"=>"Total:");
		 foreach ($list as $key => $value) {
		 	if($value['type']==10) continue; 
		 	$userData['price']+=$value['price'];
		 	$userData['paid']+=$value['paid'];
		 	$userData['check']+=$value['check'];
		 	$userData['cash']+=$value['cash'];
		 	$userData['recharge']+=$value['recharge'];
		 	$userData['price']-=$value['recharge'];
		 	$userData['pos']+=$value['pos'];
		 	$userData['own']+=$value['own'];
		 	$userData['network']+=$value['network'];
		 	$userData['netbank']+=$value['netbank'];
		 }

		 $response = array("page"=>0,"total"=>0,"records"=>0,"rows"=>$list,"userdata"=>$userData);
		 $this->ajaxReturn($response); 
		 // echo json_encode($list);
		 
	}


	private function getPayReport($type,$st,$et,$clubs)
	{ 
		 $payHistoryModel=M("PayHistory");  
		$sql="select count(*) as pay_number, ifnull(sum(`recharge`),0) as `recharge`,ifnull(sum(`network`),0) as `network`,ifnull(sum(`netbank`),0) as `netbank`,ifnull(sum(`cash`) ,0)as `cash` ,ifnull(sum(`pos`),0) as `pos`,ifnull(sum(`check`),0) as `check` from yoga_bill_project a,yoga_pay_history b where b.`type`=1 and b.`club_id` in ($clubs) and b.`create_time` between \"$st\" and \"$et\" and   a.id=b.`bill_project_id` and a.create_time < \"$st\"  and a.`type`=$type";
		
		$list = $payHistoryModel->query($sql); 
		$report=$list[0]; 
		$report['own']=0;
		$report['price']=$report['paid']=$report['cash']+$report['check']+$report['pos']+$report['recharge']+$report['network']+$report['netbank'];
		return $report;
	}

	public function getdetailAction($type,$subtype,$start_time,$end_time,$reporttype,$clubs)
	{ 
		$response=$this->getDetailData($type,$subtype,$start_time,$end_time,$reporttype,$clubs);
		$this->ajaxReturn($response);  
	}

	private function getDetailData($type,$subtype,$start_time,$end_time,$reporttype,$clubs)
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
		    list($count,$list)=$this->getPayHistory(0,$st,$et,$clubs);
				break; 
			case '2': 
		    list($count,$list)=$this->getPayHistory(4,$st,$et,$clubs);
				break; 
			case '3': 
		    list($count,$list)=$this->getPayHistory(5,$st,$et,$clubs);
				break; 
			case '4': 
		    list($count,$list)=$this->getOldPayHistory(0,$st,$et,$clubs);
				break; 
			case '5': 
		    list($count,$list)=$this->getOldPayHistory(4,$st,$et,$clubs);
				break; 
			case '6': 
		    list($count,$list)=$this->getOldPayHistory(5,$st,$et,$clubs);
				break; 
			case '7': 
		    list($count,$list)=$this->getPayHistory(1,$st,$et,$clubs);
				break; 
			case '8': 
		    list($count,$list)=$this->getOldPayHistory(1,$st,$et,$clubs);
				break;
			case '9': 
		    list($count,$list)=$this->getPayHistory(7,$st,$et,$clubs);
				break;  
			case '11': 
		    list($count,$list)=$this->getPayHistory(2,$st,$et,$clubs);
				break; 
			case '12': 
		    list($count,$list)=$this->getOldPayHistory(2,$st,$et,$clubs);
				break;  
			case '13': 
		    list($count,$list)=$this->getPayHistory(9,$st,$et,$clubs);
				break;  
			case '14': 
		    list($count,$list)=$this->getPayHistory(8,$st,$et,$clubs);
				break;  
			case '15': 
		    list($count,$list)=$this->getPayHistory(10,$st,$et,$clubs);
				break;  
			default:
				# code...
				break;
		} 
		 $billProjectModel=M("BillProject");
		foreach ($list as $key => $value) {
			$list[$key]['recorder']=M("UserExtension")->field("id,name_cn")-> find($value['record_id']); 
			$billProject=$billProjectModel->find($value["bill_project_id"]);
			$list[$key]['member']=M("MemberBasic")->field("id,name")-> find($billProject['member_id']); 
		
			$mc_id=$billProject['mc_id']; 
			if($mc_id==0)
			{
				$mc_id=$list[$key]['member']['mc_id'];
			}
			if(!empty($mc_id))
			$list[$key]['mc']=M("UserExtension")->field("id,name_cn")-> find($mc_id); 

			$list[$key]['number']=1;
					$list[$key]['paid']=$value['cash']+$value['pos']+$value['check']+$value['recharge']+$value['network']+$value['netbank'];
			switch ($type) {
				case '1':
					$list[$key]['project']=$value['type']==0?"新会员入会首付":"新会员入会余款";   
					break;
				case '2':
					$list[$key]['project']=$value['type']==0?"续会首付":"续会余款"; 
					break;
				case '3':
					$list[$key]['project']=$value['type']==0?"升级首付":"升级余款"; 
					break;
				case '4':
					$list[$key]['project']="老会员入会余款"; 
					break;	
				case '5':
					$list[$key]['project']="老会员续会余款"; 
					break;	
				case '6':
					$list[$key]['project']="老会员升级余款"; 
					break;	
				case '7':
					$list[$key]['project']=$value['type']==0?"新购PT首付":"新购PT余款"; 
					break;	
				case '8':
					$list[$key]['project']="已购PT余款"; 
					break; 
				case '9':
					$list[$key]['project']="充值"; 
					break; 
				case '11':
					$list[$key]['project']=$value['type']==0?"商品订单首付":"商品订单余款"; 
					break; 
				case '12': 
					$list[$key]['project']="老商品订单余款"; 
					break; 
				case '13': 
					$list[$key]['project']="会籍定金"; 
					break; 
				case '14': 
					$list[$key]['project']="PT定金"; 
					break; 
				case '15': 
					$list[$key]['project']="退卡"; 
					break; 

				default:
					# code...
					break;
			}
			if($type<=5 ||  $type==12)
			{
				$object_id=$billProject['object_id'];
					$contract=M("Contract")->find($object_id);
					$cardtype=M("CardType")->find($contract['card_type_id']);
					$list[$key]['sub_project']=$cardtype['name'];
			}
			else if($type==8 || $type==7)
			{
				$object_id=$billProject['object_id'];
					$contract=M("PtContract")->find($object_id);
					$class=M("PtClass")->find($contract['class_id']);
					$list[$key]['sub_project']=$class['name'];
			}else if($type==11 || $type==12)
			{
				$object_id=$billProject['object_id'];
				$goods_order=M("GoodsSaleOrder")->find($object_id);
				$goods_sale_list=M("GoodsSaleList")->where("order_id=".$goods_order['id'])->select();
				$sub_project="";
				foreach ($goods_sale_list as $k => $value) {
					if($k!=0)$sub_project.=";";
					$sub_project.=$value['goods_name'];
				}
				$list[$key]['sub_project']=$sub_project;
			}
			else 
			{
				$list[$key]['sub_project']="其他";
			} 
					
		}
		
		if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
			} else { 
			  $total_pages = 0; 
			} 	

		$response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$list);
		return $response;
	}


	public function printdetailAction($type,$subtype,$start_time,$end_time,$reporttype,$clubs)
	{ 
		$response=$this->getDetailData($type,$subtype,$start_time,$end_time,$reporttype,$clubs);
		$rows=$response['rows'];
		$head = array('编号','付费类型', '项目名', '数量', '总金额','现金','POS','支票','储值卡', '网络支付','网银分期','会员','操作者','销售','时间','备注');
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
			$ret=array($row['id'],$row['project'],$rows["sub_project"],$row['number'],$row['paid'],$row['cash'],$row['pos'],$row['check'],$row['recharge'],$row['network'],$row['netbank'],$row['member']['name'],$row['recorder']['name_cn'],$row['mc']['name_cn'],$row['create_time'],$row['description']);
			foreach ($ret as $i => $v) {
				$ret[$i] = iconv('utf-8', 'GBK', $v);
			} 
			fputcsv($fp, $ret);
		}
	}

	private function getOldPayHistory($type,$st,$et,$clubs)
	{
		list($page,$sidx,$limit,$sord,$start)=getRequestParams();
		$payHistoryModel=M("PayHistory");  
		$sql="select b.*,a.discount from yoga_bill_project a,yoga_pay_history b where a.`sale_club_id` in ($clubs) and a.`create_time` < \"$st\"  and b.`create_time` between \"$st\" and \"$et\"  and a.`type`=$type and a.id=b.`bill_project_id` order by $sidx $sord limit $start , $limit";
		$list = $payHistoryModel->query($sql);
		$sql="select count(*) as count from yoga_bill_project a,yoga_pay_history b where  a.`sale_club_id` in ($clubs) and a.`create_time` < \"$st\"  and b.`create_time` between \"$st\" and \"$et\"  and a.`type`=$type and a.id=b.`bill_project_id`  ";
		$count = $payHistoryModel->query($sql); 
		$count=$count[0]['count'];
		return array($count,$list);
	}


	private function getPayHistory($type,$st,$et,$clubs)
	{
		list($page,$sidx,$limit,$sord,$start)=getRequestParams();
		$payHistoryModel=M("PayHistory");  
		$sql="select b.*,a.discount from yoga_bill_project a,yoga_pay_history b where a.`sale_club_id` in ($clubs) and a.`create_time` between \"$st\" and \"$et\"  and b.`create_time` between \"$st\" and \"$et\" and a.`type`=$type and a.id=b.`bill_project_id` order by $sidx $sord limit $start , $limit";
		$list = $payHistoryModel->query($sql);
		$sql="select count(*) as count from yoga_bill_project a,yoga_pay_history b where a.`sale_club_id` in ($clubs) and a.`create_time` between \"$st\" and \"$et\" and b.`create_time` between \"$st\" and \"$et\" and a.`type`=$type and a.id=b.`bill_project_id` ";
		$count = $payHistoryModel->query($sql); 
		$count=$count[0]['count']; 
		return array($count,$list);
	}

	private function getReport($type,$st,$et,$clubs)
	{
		 $payHistoryModel=M("PayHistory");  
		 $sql="select   count(*) as pay_number , ifnull(sum(`network`),0) as `network`, ifnull(sum(`netbank`),0) as `netbank`, ifnull(sum(`recharge`),0) as `recharge`,ifnull(sum(`cash`),0) as `cash` ,ifnull(sum(`pos`),0) as `pos`,ifnull(sum(`check`),0) as `check` from yoga_bill_project a,yoga_pay_history b where a.`sale_club_id` in ($clubs) and a.`create_time` between \"$st\" and \"$et\" and b.`create_time` between \"$st\" and \"$et\" and a.`type`=$type and a.id=b.`bill_project_id`;";
		  $list = $payHistoryModel->query($sql);
		  $report=$list[0];
		  $sql="select   count(*) as number ,ifnull(sum(price),0) as price,ifnull(sum(paid),0) as paid from yoga_bill_project a where a.`sale_club_id` in ($clubs) and a.`create_time` between \"$st\" and \"$et\"  and a.`type`=$type";
		  $list = $payHistoryModel->query($sql);    
		  $vl=$list[0];
		  $report=array_merge($report,$vl);
		  $report['own']=$report['price']-$report['paid'];
		  if($type==10)//tuika
		  {
		  	$report['price']*=-1;
		  	$report['paid']*=-1;
		  	$report['own']*=-1;
		  	$report['cash']*=-1;
		  	$report['check']*=-1;
		  	$report['pos']*=-1;
		  	$report['recharge']*=-1;
		  	$report['network']*=-1;
		  	$report['netbank']*=-1;
		  }

		  //except book 
            if($type==0)
            {
                $sql="select sum(paid) as paid  from yoga_bill_project where `type`=9 and object_id in (select object_id from yoga_bill_project a where a.`sale_club_id` in ($clubs) and a.`create_time` between \"$st\" and \"$et\"  and a.`type`=$type)";
                $book=$payHistoryModel->query($sql);
                $book=$book[0];
                $report['price']-=$book['paid'];
                $report['paid']-=$book['paid'];
            }

		  return $report;
	}
}
