<?php
namespace Admin\Controller;
use Think\Controller; 
class SuperController extends AdminController {
	public function exportAction()
	{
		$current_page=I("page");
		$this->current_page=$current_page;
		$start_time = I("start_time");
		$end_time = I("end_time");
		if(empty($start_time)) $start_time='1970-01-01';else  $this->start_time=$start_time;

		if(empty($end_time)) $end_time='2970-01-01';else          $this->end_time=$end_time;
		//查询 
		$brands = D("Brand")->relation(true)->field("id,brand_name")->select(); 
		$this->brands = $brands;
		$this->brandsarr=json_encode($brands);

		$this->club_id = I("club_id");
		$this->brand_id = I("brand_id");

 
	    $brand_id=I("brand_id");
	    $club_id=I("club_id");
	    	  $valuesql="select  b.status as bstatus, b.card_type_extension, b.free_rest,b.free_trans,b.rest_count,b.trans_count, b.is_review,b.description as `desc`, b.id as contract_id,b.contract_number, b.create_time as bc, a.*,e.name,e.sex,e.phone ,c.card_number ,d.name as card_name,d.type as card_type ,d.price as card_type_price,b.invalid,b.type as btype,b.present_day,b.present_num,b.start_time,b.end_time,b.active_type,b.used_num,b.total_num   from yoga_bill_project a inner join yoga_contract b on a.object_id=b.id and a.type in(0,3,4,5) and b.create_time >'{$start_time}' and b.create_time<'{$end_time}' and b.sale_club_id={$club_id} inner join yoga_member_basic e on a.member_id=e.id left join yoga_card c on b.card_id=c.id left join yoga_card_type d on b.card_type_id=d.id where  a.sale_club_id=$club_id  ";
	    	$countsql="select count(*) as count from yoga_bill_project a inner join yoga_contract b on a.object_id=b.id and a.type in(0,4,5) and b.create_time >'{$start_time}' and b.create_time<'{$end_time}' and b.sale_club_id={$club_id}  inner join yoga_member_basic e on a.member_id=e.id left join yoga_card c on b.card_id=c.id left join yoga_card_type d on b.card_type_id=d.id where  a.sale_club_id=$club_id ";
        
  		$tail ="";
  		$model = new \Think\Model();
        $countsql=$countsql." ".$sql.$tail;
        $count=$model->query($countsql);
        $count=$count[0]["count"];
        $start =20*$current_page;
        $limit = 20;
        $pages=ceil($count/20);
        $valuesql = $valuesql." ".$sql.$tail."order by b.id desc limit $start,$limit";  
         $ret =$model->query($valuesql);  
         foreach ($ret as $key => $value) {
         	 $mc = M("UserExtension")->find($value['mc_id']);
         	 $recorder = M("UserExtension")->find($value['record_id']);
         	 $ret[$key]['mc_name']=!empty($mc)?$mc['name_cn']:"NO MC!";
         	 $ret[$key]['recorder_name']=!empty($recorder)?$recorder['name_cn']:"品牌帐号"; 
         }
        
      $this->pages=$pages;
        $this->value=$ret;
		$this->display(); 
	}


	public function exportallAction()
	{
		$current_page=I("page");
		$this->current_page=$current_page;
		$start_time = I("start_time");
		$end_time = I("end_time");
		if(empty($start_time)) $start_time='1970-01-01';
		if(empty($end_time)) $end_time='2970-01-01';
		//查询 
		$brands = D("Brand")->relation(true)->field("id,brand_name")->select(); 
        $brand_id=I("brand_id");
	    $club_id=I("club_id");
	    	  $valuesql="select  b.status as bstatus, b.card_type_extension, b.free_rest,b.free_trans,b.rest_count,b.trans_count, b.is_review,b.description as `desc`, b.id as contract_id,b.contract_number, b.create_time as bc, a.*,e.name,e.sex,e.phone ,c.card_number ,d.name as card_name,d.type as card_type ,d.price as card_type_price,b.invalid,b.type as btype,b.present_day,b.present_num,b.start_time,b.end_time,b.active_type,b.used_num,b.total_num   from yoga_bill_project a inner join yoga_contract b on a.object_id=b.id and a.type in(0,3,4,5) and b.create_time >'{$start_time}' and b.create_time<'{$end_time}' and b.sale_club_id={$club_id} inner join yoga_member_basic e on a.member_id=e.id left join yoga_card c on b.card_id=c.id left join yoga_card_type d on b.card_type_id=d.id where  a.sale_club_id=$club_id  ";
	    	$countsql="select count(*) as count from yoga_bill_project a inner join yoga_contract b on a.object_id=b.id and a.type in(0,4,5) and b.create_time >'{$start_time}' and b.create_time<'{$end_time}' and b.sale_club_id={$club_id}  inner join yoga_member_basic e on a.member_id=e.id left join yoga_card c on b.card_id=c.id left join yoga_card_type d on b.card_type_id=d.id where  a.sale_club_id=$club_id ";
        
  		$tail ="";
  		$model = new \Think\Model();
        $countsql=$countsql." ".$sql.$tail;
        $count=$model->query($countsql);
        $count=$count[0]["count"];
     
        $pages=ceil($count/20);
        $valuesql = $valuesql." ".$sql.$tail."order by b.id desc ";  
         $vv =$model->query($valuesql); 
         foreach ($vv as $key => $value) {
         	 $mc = M("UserExtension")->find($value['mc_id']);
         	 $recorder = M("UserExtension")->find($value['record_id']);
         	 $vv[$key]['mc_name']=!empty($mc)?$mc['name_cn']:"NO MC!";
         	 $vv[$key]['recorder_name']=!empty($recorder)?$recorder['name_cn']:"品牌帐号"; 
         }
        
		 $head = array('姓名','电话', '卡种','卡号',  '合同开始', '合同结束','顾问','入会时间','录入人','备注');
		$file_name="/var/www/tmp/export.csv" ; 
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$start_time.'-'.$end_time.'.csv"');
		header('Cache-Control: max-age=0');
		$fp = fopen('php://output', 'a');
		foreach ($head as $i => $v) {
			$head[$i] = iconv('utf-8', 'GBK', $v);
		}
		fputcsv($fp, $head);
		$cnt = 0;
		$limit = 100000;
		foreach ($vv as $key => $row) {
			$cnt ++;
			if ($limit == $cnt) {
				ob_flush();
				flush();
				$cnt = 0;
			} 
			$ret=array($row['name'],$row['phone'],$row['card_name'],$row['card_number'],$row['start_time'],$row['end_time'],$row['mc_name'],$row['bc'],$row['recorder_name'],$row['desc']);
			foreach ($ret as $i => $v) {
				$ret[$i] = iconv('utf-8', 'GBK', $v);
			} 
			fputcsv($fp, $ret);
		}
	}
}
