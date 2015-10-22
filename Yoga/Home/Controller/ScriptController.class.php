<?php
namespace Home\Controller;
 use Think\Controller;
 use Service\McNewService;
 use Service\CardService;
 /**
  * statistics script
  */
class ScriptController extends Controller {
	
	//statistic mc's data for this month
	public function mcstatAction()
	{ 
       $time =  date('Y-m',strtotime("-1 day"));
       $mc=$this->getAllMc();
       // $all_newplan=$all_newstat=$all_oldplan=$all_oldstat=$all_memberplan=$all_memberstat=array();
       foreach ($mc as $key => $value) {
       	   $user_id=$value['id']; 
	       $ret=McNewService::getInstance()->getUserOneMonthStatistics($user_id,$time); 
	       $data=array("user_id"=>$user_id,"time"=>$time,"value"=>json_encode($ret));
	       M("McPlanArchive")->data($data)->add();
       }
     
	} 

	public function checkRestAction()
	{
		$today='{"start_time":"'.date("Y-m-d").'",';
		$sql="update yoga_card set status=3 where status=0 and extension like '{$today}%'"; 
		$Model = new \Think\Model();
		$Model->query($sql);
	}

	public function checkUnRestAction()
	{
		$today='"end_time":"'.date("Y-m-d").'"}';
		$sql="select * from yoga_card where status=3 and extension like '%{$today}'";  
		$Model = new \Think\Model();
		$ret=$Model->query($sql);
		foreach ($ret as $key => $value) {
			$id=$value['id'];
			$ret=CardService::getInstance()->unrest($id); 
			echo "unrest $id [".$value['extension']."]\n";
		}
	}


public function checkUnRest1Action()
	{ 
		$sql="select * from yoga_card where status=3 ";  
		$Model = new \Think\Model();
		$ret=$Model->query($sql);
		foreach ($ret as $key => $value) {
			$id=$value['id'];
			$extension=$value['extension'];
			$ex=json_decode($extension);
			$end_time=$ex->end_time;
			if($end_time < date("Y-m-d"))
			{
				$ret=CardService::getInstance()->unrest($id); 
			    echo "unrest $id [".$value['extension']."]\n";
			}
			
		}
	}


	public function testAction()
	{
     	$service=\Service\CService::factory("Api"); 
         $service->useAppoint(1022,99920662);
	}


	private function getAllMc()
	{
		  return M()->where("a.id=c.uid and c.group_id=6")->table(array("yoga_user_extension"=>"a","yoga_auth_group_access"=>"c"))->field("a.id,a.name_cn")->select();
	}

	public function importMcAction()
	{
		$sql="select distinct mc_id from yoga_member_basic";
		$Model = new \Think\Model();
		$ret=$Model->query($sql);
		$m=D("User");
		foreach ($ret as $key => $value) {
			$id=$value['mc_id'];
			$ismc=$m->isMc($id);
			if(!$ismc)
			{
				M("AuthGroupAccess")->data(array("uid"=>$id,"group_id"=>6))->add();	
				echo "set $id \r\n";
			}
			else
			{
				echo "mc $id \r\n";
			}
			
			 
		}
	}

	public function initCardTypeAction()
	{
		$card_types=M("CardType")->select();
		foreach ($card_types as $key => $value) {
			$card_id=$value['id'];
			$extension=json_encode($value);
			D("Contract")->where("card_type_id=$card_id")-> setField(array("card_type_extension"=>$extension));
		}
	}

	public function spiderAction()
	{
		$this->autoCreateInviteCode(1000);
	}

	 public function autoCreateInviteCode($num){
        $codeStr = '0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z';
        $codeArr = explode(',',$codeStr); 
        for($i=0;$i<$num;$i++){
            $code = $this->createInvitCodeByauto($codeArr);
                if (!empty($code)){
                     $model=M("SpiderCode");
                     $model->data(array("code"=>$code,"valid"=>0,"create_time"=>date('Y-m-d H:i:s')))->add();
            }
        }
    }
    public function createInvitCodeByauto($codeArr){
        $tree1 = array_rand($codeArr,4);
        $tree2 = array_rand($codeArr,4);
        $tree3 = array_rand($codeArr,4);
        $tree4 = array_rand($codeArr,4);
        $code = $codeArr[$tree1[0]].$codeArr[$tree1[1]].$codeArr[$tree1[2]].$codeArr[$tree1[3]].'-'.$codeArr[$tree2[0]].$codeArr[$tree2[1]].$codeArr[$tree2[2]].$codeArr[$tree2[3]].'-'.$codeArr[$tree3[0]].$codeArr[$tree3[1]].$codeArr[$tree3[2]].$codeArr[$tree3[3]].'-'.$codeArr[$tree4[0]].$codeArr[$tree4[1]].$codeArr[$tree4[2]].$codeArr[$tree4[3]];
        $model=M("SpiderCode");
        $code_isexist = $model->where(array("code"=>$code))->find();
        if($code_isexist){
            return "";
        }else{
            return $code;
        } 
    }

    public function fixPtAction()
    {
    	$handle = fopen("/home/pli/Desktop/bbb.csv", 'r');
    	$users=array();
    	 if ($handle) {
                while ($values = fgetcsv($handle)) { 
                  
                       $name = $values[0];
                       $total_num=$values[2];
                       $left_num=$values[3];
                       $used_num=$total_num-$left_num;
                       $price = $values[1]; 
                       if(!in_array($name, $users))
                       {	
                       		$user_id = $this->getOne($name);  
                       		if($user_id)
                       			$users[$user_id]=$name;
                       		else
                       			continue; 
                       }
                       else
                       {
                       		$key = array_search($name, $users);
                       		$user_id=$key;
                       }

                       //添加合同
 
                       $member_id=$user_id;
		$member=M("MemberBasic")->find(I("member_id")); 
		$class_id=22;
		$class=M("PtClass")->find($class_id); 
		$model = D("PtContract"); 
		$paid=$price;  
		$book_price=0; 
	 	$data = array("record_id"=>172, "club_id"=>1002,"class_id"=>$class_id, "total_num"=>$total_num,"used_num"=>$used_num,"member_id"=>$member_id,"should_pay"=>$price,"paid"=>$paid);
 		 $contract_number = date("YmdHis").rand(0,10000);
		$data['contract_number']=$contract_number;
		$model->pt_id=$member['pt_id'];  
		if(empty($start_time))
		{
			$start_time=date('Y-m-d');
		}
		if(empty($end_time))
		{
			$end_time=date('Y-m-d',strtotime("+2 years"));
		}
		$data['start_time']=$start_time;
		$data['end_time']=$end_time;
		$contract_id=$model->data($data)->add(); 
		if(empty($contract_id))
		{
			echo "添加失败！！！！！\r\n"; echo M()->_sql();die();
			continue;
		} 
		
		$service=\Service\CService::factory("Financial"); 
	 	$bill_id=$service->addBillProject(1,0,$contract_id,$member_id,$price,0,35,172,1002,0,'2015-07-29财务对帐补录');
	 	if(!$bill_id)
	 	{ 
	 		 echo "添加bill失败！！！！！\r\n";echo M()->_sql();die();
	 		 continue;
	 	}
	 	$ret = $service->pay($bill_id,0,172,35,'2015-07-29财务对帐补录',$price,0,0,0,1002,0,0,0);
	 	if(!$ret)
	 	{
	 		echo "添加pay失败！！！！！\r\n";echo M()->_sql();die();
	 		continue;
	 	}
  

            
                    
                }
                fclose($handle);
            } else {
                echo "cannot open file : {$singleJob->file}, exit!";
            }

            // foreach ($users as $key => $value) {
            // 	 $this->fixOne($value);
            // }
 
    }

    public function getOne($name)
    {
    	$condition = array("name"=>$name,"club_id"=>1002);
    	$users = M("MemberBasic")->where($condition)->select();
    	if(empty($users))
    	{
    		echo $name."无此用户\r\n";
    		// echo M()->_sql()."\r\n";
    		return false;
    	}
    	foreach ($users as $key => $value) {
    		$pt_contracts = M("PtContract")->where(array("member_id"=>$value['id']))->select();
    		if(!empty($pt_contracts)){
    			// echo $name."  ".count($pt_contracts)."\r\n"; 

    			//clean all contract
    			foreach ($pt_contracts as $k => $v) {
    				 $billproject = M("BillProject")->where(array("member_id"=>$value['id'], "type"=>1,"object_id"=>$v['id']))->find();
    				 M("PayHistory")->where("bill_project_id=".$billproject['id'])->delete();
    				 M("BillProject")->where(array("member_id"=>$value['id'], "type"=>1,"object_id"=>$v['id']))->delete();
    				 M("PtContract")->where("id=".$v['id'])->delete();
    			}
    			 
    			return  $value['id'];
    		}
    		
    	}
    	 
    		if(count($users)==1)
    		{
    			return $users[0]['id'];
    		}
    		else
    		{
    			$condition = array("name"=>$name,"club_id"=>1002,"is_member"=>1);
    			$users = M("MemberBasic")->where($condition)->select();

    			if(count($users)==1)
	    		{
	    			return $users[0]['id'];
	    		}
	    		else
	    		{ 
	    			echo $name."没有pt合同,"."有多个{$name},不能确定是哪个!\r\n";
	    		} 
    		}

    		return false;
    
    }

 public function fixCardNumberAction()
{
	$card_number=27100290;
	$cards = M("Card")->where(array("sale_club"=>27,"card_number"=>array("like","271%4")))->select();
        foreach($cards as $card)
	{
		if($card_number%10 ==4)
		{
			$card_number++;
		}
		M("Card")->where("id=".$card['id'])->setField(array("card_number"=>$card_number));
		$card_number++;
		echo M("Card")->_sql()."\r\n";
	}
}

	public function autoCheckOutAction()
	{
		$time = date('Y-m-d',strtotime("1 day ago"));
		$sql = "select contract_id,club_id from yoga_check_history  a where create_time > '{$time}' and status=1 and not exists(select * from yoga_check_history b where  a.contract_id=b.contract_id and b.create_time > a.create_time and b.status=0);";
		$Model = new \Think\Model();
		$ret=$Model->query($sql); 
		$service=\Service\CService::factory("Api");
		$time = date('Y-m-d H:i:s');
		foreach ($ret as $key => $value) {
			$contract_id=$value['contract_id'];
			$club_id = $value['club_id'];
			echo "$time : $contract_id  auto checkout!\r\n";
			$service->myout($contract_id,$club_id);
		}

	}
	
	public function fixContractAction()
	{ 
		$contracts  = M("Contract")->where("active_type=2 or active_type=3")->select();  
		foreach ($contracts as $key => $contract) {
			$contract_id = $contract['id'];  
			$history =M("CheckHistory")->where("contract_id=$contract_id")->order("id")->find();
			if(!empty($history))
			{
				$start_time = $history['create_time'];
				$contract['start_time']=$start_time;
	              $start_time=strtotime($start_time);
	              $card_type=json_decode($contract['card_type_extension'],true);
	              $valid_time=$card_type['valid_time'];
	              $end_time=strtotime("+$valid_time months",$start_time);
	              $present_day=$contract["present_day"];
	              $end_time=strtotime("+$present_day days",$end_time);
	              $contract['end_time']=date("Y-m-d",$end_time); 
	              $contract['active_type']=3;
                M("Contract")->data($contract)->save(); 
                echo M()->_sql()."\r\n";
			}
		}
	}


	public function fixContract1Action()
	{ 
		$contracts  = M("Contract")->where("active_type!=2 and end_time='0000-00-00'")->select();  
		foreach ($contracts as $key => $contract) {
			$contract_id = $contract['id'];   
				$start_time = $contract['start_time'];
				if(empty($start_time)) $start_time=$contract['create_time'];
				$contract['start_time']=$start_time;
	              $start_time=strtotime($start_time);
	              $card_type=json_decode($contract['card_type_extension'],true);
	              $valid_time=$card_type['valid_time'];
	              $end_time=strtotime("+$valid_time months",$start_time);
	              $present_day=$contract["present_day"];
	              $end_time=strtotime("+$present_day days",$end_time);
	              $contract['end_time']=date("Y-m-d",$end_time);  
                M("Contract")->data($contract)->save(); 
                echo M()->_sql()."\r\n";
			 
		}
	}


//run per 2 hours
	public function weixinblacklistAction()
	{
		//检查当日没来的，进入黑名单
		$model=M("AppointHistory");
		$yesterday=date('Y-m-d H:i:s',strtotime("-2 hour"));
		$values = $model->field("a.*,b.start as starttime")->table(array("yoga_appoint_history"=>"a","yoga_club_schedule"=>"b"))->where("a.is_check=0 and a.come=0 and a.schedule_id=b.id and b.start<='{$yesterday}'")->select();
		$month = date('Y-m'); 
		foreach ($values as $key => $value) { 
				$model->where("id=".$value['id'])->setField("is_check",1); 
			$starttime = $value['starttime'];
			$starttime = substr($starttime,0,10);
			$ct=M("CheckHistory")->where(array("member_id"=>$value['member_id'],"create_time"=>array("like",$starttime."%")))->count();
			if($ct>0)
			{
				M("AppointHistory")->where("id=".$value['id'])->setField("come",1);
				continue;
			}
			//本月爽约历史记录次数次数
			//$history=M("AppointBlackList")->where(array("member_id"=>$value['member_id'],"create_time"=>array("gt",$month)))->count();
			$count = $model-> where(array("create_time"=>array("gt",$month),"come"=>0,"member_id"=>$value['member_id']))->count(); 
		   if($count==0){  continue; } 
//爽约原因
                 $schedule_id = $value['schedule_id'];
                   $schedule = D("ClubSchedule")->find($schedule_id);
                    if(!empty($schedule)){
                          $class = M("PtClassPublic")->find($schedule['class_id']);
                          $reason = "缺席".$schedule['start']."的".$class['name'];}
                         else
                           $reason="缺席";
			if($count==1)
			{
				$end_time = date('Y-m-d H:i:s',strtotime("+4 day"));
				//4天
				M("AppointBlackList")->data(array("reason"=>$reason,"member_id"=>$value['member_id'],"history_id"=>$value['id'],"create_time"=>getDbTime(),"start_time"=>getDbTime(),"end_time"=>$end_time ))->add();
			}
			else if($count==2)
			{
				//2周

				$end_time = date('Y-m-d H:i:s',strtotime("+2 week"));
				//4天
				M("AppointBlackList")->data(array("reason"=>$reason,"member_id"=>$value['member_id'],"history_id"=>$value['id'],"create_time"=>getDbTime(),"start_time"=>getDbTime(),"end_time"=>$end_time ))->add();
	
			}
			else
			{
				//本月
				$end_time =date('Y-m-d H:i:s', strtotime(date('Y-m-01') . ' +1 month -1 day'));
				//4天
				M("AppointBlackList")->data(array("reason"=>$reason,"member_id"=>$value['member_id'],"history_id"=>$value['id'],"create_time"=>getDbTime(),"start_time"=>getDbTime(),"end_time"=>$end_time ))->add();
	
			}
			  
		}
	}


	public function createSystemCardsAction()
	{
		$brands = M("Brand")->select();
		foreach ($brands as $key => $value) {
			 M("GoodsCategory")->data(array("is_system"=>1, "name"=>"系统停补卡收费","property"=>3,"type"=>1,"brand_id"=>$value['id']))->add(); 
		 
		} 
		$clubs = M("Club")->select(); 
		$this->createclubsysinfo($clubs);
	}

	public function createclubsysinfo($clubs)
	{
			foreach ($clubs as $key => $value) {
			 $model = D("Goods");
			 $category = M("GoodsCategory")->where(array("brand_id"=>$value['brand_id'],"is_system"=>1))->find();
	   	 	 $data =array("sys_type"=>0,"name"=>$value['club_name']."--补卡费","category_id"=>$category['id'],"brand_id"=>$value['brand_id'],"price"=>100,"total_num"=>"999999","is_system"=>1);
	   	 	 $model->data($data); 
	   	 	 $id=$model->add();
	   	 	 $goodsClubModel = M("GoodsClub");
	   	     $goodsClubModel->data(array("goods_id"=>$id,"club_id"=>$value['id']))->add();  
		}

		foreach ($clubs as $key => $value) {
			 $model = D("Goods");
			 $category = M("GoodsCategory")->where(array("brand_id"=>$value['brand_id'],"is_system"=>1))->find();
	   	 	 $data =array("sys_type"=>1,"name"=>$value['club_name']."--停卡费","category_id"=>$category['id'],"brand_id"=>$value['brand_id'],"price"=>100,"total_num"=>"999999","is_system"=>1);
	   	 	 $model->data($data); 
	   	 	 $id=$model->add();
	   	 	 $goodsClubModel = M("GoodsClub");
	    
	   	     $goodsClubModel->data(array("goods_id"=>$id,"club_id"=>$value['id']))->add();  
		}

		foreach ($clubs as $key => $value) {
			 $model = D("Goods");
			 $category = M("GoodsCategory")->where(array("brand_id"=>$value['brand_id'],"is_system"=>1))->find();
	   	 	 $data =array("sys_type"=>2,"name"=>$value['club_name']."--续会费","category_id"=>$category['id'],"brand_id"=>$value['brand_id'],"price"=>100,"total_num"=>"999999","is_system"=>1);
	   	 	 $model->data($data); 
	   	 	 $id=$model->add();
	   	 	 $goodsClubModel = M("GoodsClub");
	   	 	 
	   	     $goodsClubModel->data(array("goods_id"=>$id,"club_id"=>$value['id']))->add();  
		}


		foreach ($clubs as $key => $value) {
			 $model = D("Goods");
			 $category = M("GoodsCategory")->where(array("brand_id"=>$value['brand_id'],"is_system"=>1))->find();
	   	 	 $data =array("sys_type"=>3,"name"=>$value['club_name']."--升级费","category_id"=>$category['id'],"brand_id"=>$value['brand_id'],"price"=>100,"total_num"=>"999999","is_system"=>1);
	   	 	 $model->data($data); 
	   	 	 $id=$model->add();
	   	 	 $goodsClubModel = M("GoodsClub");
	   	  
	   	     $goodsClubModel->data(array("goods_id"=>$id,"club_id"=>$value['id']))->add();  
		}

		foreach ($clubs as $key => $value) {
			 $model = D("Goods");
			 $category = M("GoodsCategory")->where(array("brand_id"=>$value['brand_id'],"is_system"=>1))->find();
	   	 	 $data =array("sys_type"=>4,"name"=>$value['club_name']."--合同转让费","category_id"=>$category['id'],"brand_id"=>$value['brand_id'],"price"=>100,"total_num"=>"999999","is_system"=>1);
	   	 	 $model->data($data); 
	   	 	 $id=$model->add();
	   	 	 $goodsClubModel = M("GoodsClub");
	   	  
	   	     $goodsClubModel->data(array("goods_id"=>$id,"club_id"=>$value['id']))->add();  
		}
	}


	public function mailStatisticsAction()
	{
		$c = C("st");
		foreach ($c as $key => $value) {
			$this->st($key,$mailto);;
		}

	}

	private function st($club_id,$mailto)
	{ 
		$club = M("Club")->find($club_id);
		$club_name = $club['club_name'];
		$month = date('Y-m');
		$subject = "统计数据---".date('Y-m')."---".$club_name;
		$txt="---------------当月进馆统计---------------\r\n";
		$checkin = $this->st_checkin($club_id,$month);
		$txt.="进馆人次：".$checkin."\r\n";

		$checkinp = $this->st_checkinp($club_id,$month);
		$txt.="进馆会员数：".$checkinp."\r\n";

	    $txt.="---------------历史数据统计---------------\r\n";
		$membercount = $this->st_membercount($club_id,$month);
		$txt.="截止目前会员人数：".$membercount."\r\n";

		$nmembercount = $this->st_nmembercount($club_id,$month);
		$txt.="截止目前潜在会员人数：".$nmembercount."\r\n";


		$usedcard = $this->st_usedcard($club_id,$month);
		$txt.="截止目前有使用过卡人数：".$usedcard."\r\n";

 
		$txt.="截止目前未使用过卡人数：".($membercount- $usedcard)."\r\n"; 
		mail($mailto,$subject,$txt);
	}

	private function st_checkin($club_id,$month)
	{
		$count = M("CheckHistory")->where(array("club_id"=>$club_id,"status"=>1,"create_time"=>array("like","{$month}%")))->count();
		return $count;
	}
	private function st_checkinp($club_id,$month)
	{
		$count = M("CheckHistory")->where(array("club_id"=>$club_id,"status"=>1,"create_time"=>array("like","{$month}%")))->count("distinct member_id");
		return $count;
	}

	private function st_membercount($club_id,$month)
	{
		$count = M("Contract")->where(array("sale_club_id"=>$club_id))->count("distinct member_id");
		return $count;
	}

	private function st_nmembercount($club_id,$month)
	{
		$countall = M("MemberBasic")->where("club_id=$club_id")->count();
		$count = M("Contract")->where(array("sale_club_id"=>$club_id))->count("distinct member_id");
		return $countall-$count;
	}

	private function st_usedcard($club_id,$month)
	{
		$count = M("CheckHistory")->where(array("club_id"=>$club_id,"status"=>1))->count("distinct member_id");
		return $count;
	}

}
