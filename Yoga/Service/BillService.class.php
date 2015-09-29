<?php
namespace Service;
class BillService  extends CService
{
	protected static $instance;
	public static function getInstance($name = 'default'){
        if (empty(self::$instance[$name])){
            self::$instance[$name] = new BillService($name);
        }
        return self::$instance[$name];

    }

	public function __construct()
	{
		
	}

	private function getPayHistory($type,$st,$et,$clubs,$sidx,$limit,$sord,$start)
	{
		list($page,$sidx,$limit,$sord,$start)=getRequestParams();
		$payHistoryModel=M("PayHistory");  
		$sql="select b.* from yoga_bill_project a,yoga_pay_history b where a.`sale_club_id` in ($clubs)  and b.`create_time` between \"$st\" and \"$et\" and a.`type`=$type and a.id=b.`bill_project_id` order by $sidx $sord limit $start , $limit";
		$list = $payHistoryModel->query($sql);
		$sql="select count(*) as count from yoga_bill_project a,yoga_pay_history b where a.`sale_club_id` in ($clubs)  and b.`create_time` between \"$st\" and \"$et\" and a.`type`=$type and a.id=b.`bill_project_id`  ";
		$count = $payHistoryModel->query($sql); 
		$count=$count[0]['count'];
		return array($count,$list);
	}
}