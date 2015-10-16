<?php
namespace Cashier\Controller;
use Common\Controller\BaseController;
class ReportController extends BaseController {
	public function indexAction()
	{   
		$this->display();
	} 

	public function queryReportAction()
	{
		$limit = date('Y-m-d',strtotime("-7 day"));
		if($limit > I("start_time"))
		{
			$this->error("仅能查询一周的数据");
		}
		$club_id=get_club_id(); 
		 R("Finance/Report/queryReport",array(array($club_id),1,I("start_time"),I("end_time"))); 
	}

	public function detailAction()
	{
		$this->display();
	}
	public function getdetailAction()
	{
		$club_id=get_club_id(); 
		 R("Finance/Report/getdetail",array(I("type"),I("subtype"),I("start_time"),0,1,$club_id));  
	}

}
