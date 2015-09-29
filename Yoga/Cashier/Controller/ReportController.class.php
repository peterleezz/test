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
