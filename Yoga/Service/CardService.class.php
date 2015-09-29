<?php
namespace Service;
class CardService  extends CService
{
	protected static $instance;
	public static function getInstance($name = 'default'){
        if (empty(self::$instance[$name])){
            self::$instance[$name] = new CardService($name);
        }
        return self::$instance[$name];

    }

	public function __construct()
	{
		
	}
	public function unrest($id)
	{
		$model = M("Card"); 
        $card=  M("Card")->find($id);
        if(empty($card))
        {
             $this->setError("card does not exist！");
             return false;
        }
        if($card['status']!=3)
        {
             $this->setError("该卡不在请假状态！");
             return false;
        }

        $extension =json_decode($card['extension']);
        $interval =strtotime($extension->end_time) - strtotime(date('Y-m-d'));
        $interval1 =strtotime($extension->end_time) - strtotime($extension->start_time);
        $interval = $interval   <$interval1?$interval:$interval1;
        $update = array("status"=>   0,"extension"=>"");
        M("Card")->where(array("id"=>$id))->setField(array("status"=>0,"extension"=>""));
        $contractModel=D("Contract");
        $contracts = D("Contract")->getAllContract($id);
        foreach ($contracts as $key => $value) {
             $valid_time =$value['end_time']; 
             if($interval>0)
            {
                $valid_time =     date('Y-m-d H:i:s',strtotime($value['end_time'])-$interval);        
               $contractModel->where(array("id"=>$value['id']))->setField("end_time",$valid_time);
            }          
        } 

        $contractModel=D("PtContract");
        $contracts = D("PtContract")->getAllContract($card['member_id']);
        foreach ($contracts as $key => $value) {
             $valid_time =$value['end_time']; 
             if($interval>0)
            {
                $valid_time =     date('Y-m-d H:i:s',strtotime($value['end_time'])-$interval);        
               $contractModel->where(array("id"=>$value['id']))->setField("end_time",$valid_time);
            }          
        } 
         M("Card")->where(array("id"=>$id))->setField(array("status"=>0,"extension"=>'')); 
        D("CardOpHistory")->updateStatus($id,0,3);
        return true;
	}
}