<?php
namespace Shopkeeper\Controller;
use Common\Controller\BaseController;
class ImportController extends BaseController {
	public  function indexAction()
	{   
		$this->display();
	}

	public function doImportAction()
	{

		$brand_id=get_brand_id();
		$upload = new \Think\Upload();// 实例化上传类
				    // $upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('csv');// 设置附件上传类型
		$upload->rootPath  =      './Public/uploads/'; // 设置附件上传根目录
		$upload->savePath="import/";
		$upload->autoSub=false;
		$upload->replace=false;
		$upload->saveName=$brand_id."_".time().".csv"; 
		$info   =   $upload->uploadOne($_FILES['users']);
		if(!$info) {   
			$this->error($upload->getError());
		}else{  
			 $file= './Public/uploads/'.$info['savepath'].$info['savename'];
			 $handle = fopen($file, 'r');
			 $a=array("D","C","B","A");
			 if ($handle) {
			 	$model=D("MemberBasic");
			 	$count=0;
			 	$arr=array();
                while ($users = fgetcsv($handle)) {
                	try
                	{
                	   $count++;
	                   $data=array();
	                   $data['name']=$users[0];
	                   $data['phone']=$users[1];
	                   if(empty($data['phone'])) $data['phone']=time();
	                   $data['type']= array_search($users[2],$a);
	                   $data['sex']=$users[3];
	                   $data['email']=$users[4];
	                   $data['birthday']=$users[5];
	                   $data['home_phone']=$users[6];
	                   $data['home_addr']=$users[7];
	                   $data['country']=$users[8];
	                   $data['nation']=$users[9];
	                   $data['job']=$users[10];
	                   $data['desc']=$users[11];
	                   $data['brand_id']=get_brand_id();
	                   $data['club_id']=get_club_id();
	                   $data['in_pool']=1;
	                   if(!$model->create($data))
	                   {
	                   		 fclose($handle);
	                   		$this->error("{$count}行数据有误--".$model->getError());
	                   }
	                   $arr[]=$data;
                   }
                  catch(Exception $e) {
                   fclose($handle); 
                  	$this->error($e->getMessage()); 
                }}
                foreach ($arr as $key => $value) {
                	$model->data($value)->add(); 
                }
            }
                else
                {
                	 fclose($handle);
                	$this->error("error!");
                }
		}
		 fclose($handle);
		$this->success("Success!");
	}


	private function clean($club_id)
	{
		 
		M("MemberBasic")->where("club_id=$club_id")->delete();
		M("Card")->where("sale_club=$club_id")->delete();
		M("Contract")->where("sale_club_id=$club_id")->delete();
		M("PayHistory")->where("club_id=$club_id")->delete();
		M("BillProject")->where("sale_club_id=$club_id")->delete();

	}

	public function importMemberAction()
	{
		setlocale(LC_ALL, 'en_US.UTF-8');
		set_time_limit (0);
		$club_id=get_club_id();	$this->clean($club_id);
		$brand_id=get_brand_id();
		$upload = new \Think\Upload();// 实例化上传类
				    // $upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('csv');// 设置附件上传类型
		$upload->rootPath  =      './Public/uploads/'; // 设置附件上传根目录
		$upload->savePath="import/";
		$upload->autoSub=false;
		$upload->replace=false;
		$upload->saveName=$brand_id."_".time(); 
		$info   =   $upload->uploadOne($_FILES['users']);
		if(!$info) {   
			$this->error($upload->getError());
		}else{  
			 $file= './Public/uploads/'.$info['savepath'].$info['savename'];
			 // $this->checkFile($file);
			 $handle = fopen($file, 'r'); 
			 if ($handle) {
			 	
			 	$count=0;
			 	$arr=array();
                while ($users = fgetcsv($handle)) {
                	try
                	{
                	   $count++;
	                   $data=array(); 
	                   $data['name']=$users[0];
	                   $data['phone']=$users[1];  
	                    if(empty($data['phone'])) $data['phone']=time();
	                   $mc_id=trim($users[14]);
	                   if(empty($mc_id))
	                   {
	                   		$mc_id=0;
	                   		$users[14]=0;
	                   } 
	                   else 
	                   {
	                   		if(!is_numeric($mc_id))
		                   {
		                   		$mcs=M("UserExtension")->where(array("name_cn"=>$mc_id))->select();
		                   		$mc=null;
		                   		foreach ($mcs as $key => $value) {
		                   			$m=M("User")->find($value['id']);
		                   			if($m['club_id']==get_club_id())
		                   			{
		                   				$mc=$m;
		                   			}
		                   		}
		                   		if(empty($mc))
		                   		{
		                   			$mc_id=M("User")->data(array("username"=>"zj". $users[14],"password"=>md5('111111'),"club_id"=>get_club_id(),"brand_id"=>get_brand_id()))->add();
		                   			M("UserExtension")->data(array("work_status"=>0, "id"=>$mc_id,"name_cn"=>$users[14],"name_en"=>$users[14]))->add();
		                   			M("AuthGroupAccess")->data(array("uid"=>$mc_id,"group_id"=>6))->add();	
		                   			$users[14]=$mc_id;

		                   		}
		                   		else
		                   		{
		                   			$users[14]=$mc['id'];
		                   		}
		                   	
		                   }
	                   }
	                   
	                   $m=M("MemberBasic")->where(array("club_id"=>get_club_id(),"name"=>trim($users[0]),"phone"=>trim($users[1])))->find();
	                   if(!empty($m))
	                   {
	                   	$uid=$m['id'];
	                   }
	                   else
	                   {$model=D("MemberBasic");
	                   	   $data['sex']=$users[2];
		                   $data['type']=1;
		                   $data['email']=$users[3];
		                   $data['birthday']=$users[4];
		                   $data['home_phone']=$users[5];
		                   $data['home_addr']=$users[6];
		                   $data['country']=$users[7];
		                   $data['nation']=$users[8];
		                   $data['job']=$users[9];
		                   $data['desc']=$users[10];
		                   $data['brand_id']=get_brand_id();
		                   $data['club_id']=get_club_id();
		                   $data['in_pool']=0;
		                   $data['is_member']=1;
		                   $data['join_time']=trim($users[24]); 
		                   if(empty($data['join_time']))
		                   	{
		                   		$data['join_time'] = $users[15];
		                   	}
		                    $data['mc_id']=trim($users[14]);
		                    $data['certificate_number']=trim($users[23]);
		                   if(!$model->create($data))
		                   {
		                   	$this->clean($club_id);
		                   		$this->error("{$count}行数据有误--".$model->getError());
		                   }
		                   $uid=$model->data($data)->add(); 	
		               }

		               	$card_type ="国会". trim($users[11]);
		               	$cardTypeModel=M("CardType");
							$cardType=$cardTypeModel->where(array("name"=>$card_type))->find(); 
							//添加卡种
						 		 if($users[12]==0)
						 		 {
						 		 	$valid_number=0;
						 		 	  $valid_time = $users[13];
						 		 } 
						 		 else 
						 		 {
						 		 	$valid_number=$users[13];
						 		 	 $valid_time = 12;
						 		 }

						 	if(empty($cardType))
						 	{
						 		
						 		$data = array("name"=>$card_type,"category"=>1,"type"=>1+$users[12],"valid_time"=>$valid_time,"brand_id"=>get_brand_id(),"start_time"=>"2015-01-01","end_time"=>"2019-01-01","price"=>$users[18],"valid_number"=>$valid_number,"sold_num"=>999999,"min_price"=>$users[18]-500);
						 	 	$cardtypeid = M("CardType")->data($data)->add();
						 	 	M("CardSaleclub")->data(array("card_type_id"=>$cardtypeid,"club_id"=>get_club_id()))->add();
						 	 	M("CardUseclub")->data(array("card_type_id"=>$cardtypeid,"club_id"=>get_club_id()))->add();
						 	}
						 	else
						 	{
						 		$cardtypeid = $cardType['id'];

						 	}  
		                    $card_type_id=$cardtypeid;
		                    $mc_id=trim($users[12]);
		                    $start_time=trim($users[15]);
		                    $end_time=trim($users[16]);
	                  		$card_number=trim($users[17]);
	                  		$cardModel = D("Card");
	                  		$cardTypeModel=M("CardType");
							$cardType=$cardTypeModel->find($card_type_id);
						 	if(empty($cardType))
						 	{
						 			$this->clean($club_id);
						 		$this->error("{$count}行卡种不存在!");
						 	}
						 	if(empty($card_number))
						 	{
						 		$card_number=date("YmdHis").rand(0,10000);
						 		$card=array("free_rest"=>0,"sale_club"=>get_club_id(),"is_active"=>0, "brand_id"=>get_brand_id(),"card_number"=>$card_number,"member_id"=>$uid);
		 						$card_id=$cardModel->data($card)->add();  
		 						$card_number=get_club_id(). $card_id;
		 						while(true)
							 	{
							 		if($cardModel->isExist($card_number,get_brand_id()))
							 		{
							 			$card_number.=rand(0,100);
							 		}
							 		else
							 		{
							 			break;
							 		}
							 	}
							 		$cardModel->where("id=$card_id")->setField("card_number",$card_number);
						 	}
						 	else
						 	{
						 		$card=array("free_rest"=>0,"sale_club"=>get_club_id(),"is_active"=>0, "brand_id"=>get_brand_id(),"card_number"=>$card_number,"member_id"=>$uid);
		 						$card_id=$cardModel->data($card)->add();  
						 	}
						 	
						 
						 	if(!$card_id)
						 		{$this->error("{$count}行开卡失败，请稍后再试!");	$this->clean($club_id);}
						 	$model=D("Contract");
						 	$payed=trim( $users[19]); $contract_number = date("YmdHis").rand(0,10000);
						 	$data=array("total_num"=>$valid_number, "member_id"=>$uid, "start_time"=>$start_time,"end_time"=>$end_time, "brand_id"=>get_brand_id(), "card_type_id"=>$card_type_id, "type"=>0,"description"=>$users[22],"price"=>$payed,"sale_club_id"=>get_club_id(),"card_id"=>$card_id,"payed"=>$payed,"contract_number"=>$contract_number,"mc_id"=>trim($users[14]),"card_type_extension"=>json_encode($cardType),"active_type"=>0);
						 	 $contract_id = $model->data($data)->add();
 
						 	 $service=\Service\CService::factory("Financial");

						 	$bill_id=$service->addBillProject(0,0,$contract_id,$uid,$payed,0,get_brand_id(),is_user_login(),get_club_id(),trim($users[14]),$users[22]);
						 	if(!$bill_id)
						 	{
						 		 	$this->clean($club_id);
						 		$this->error("{$count}行数据有误--".$service->getError());
						 	}
						 	$ret = $service->pay($bill_id,0,is_user_login(),get_brand_id(),$users[22],$payed,0,0,0,get_club_id(),0,0,0);
						 	if(!$ret)
						 	{ 	$this->clean($club_id);
						 		$this->error("{$count}行数据有误--".$service->getError());
						 	}  
	                   
                   }
                  catch(Exception $e) { 	$this->clean($club_id);
                  	$this->error($e->getMessage()); 
                }} 
            }
                else
                {	$this->clean($club_id);
                	$this->error("error!");
                }
		}
		$this->success("Success!");
	}


	function checkFile($path)
	{
		$arr1=array(); 
		 $handle = fopen($path, 'r');
		 if ($handle) {
		 	$x=0;
		 	 while ($users = fgetcsv($handle)) {
                	try
                	{ 
	                   $card_type_id=trim($users[11]);
	                   $card_number=trim($users[15]);
	                   $name=trim($users[0]);
	                   $phone=trim($users[1]);
	                   $m=M("CardType")->where("id=$card_type_id")->find();
	                   if(empty($m))
	                   {$x++;
	                   	 fclose($handle);
	                   		$this->error("第{$x}行 卡种id{$card_type_id}不存在，请先到品牌管理中进行卡种添加");
	                   }
	                   // if(in_array("{$card_number}", $arr))
	                   // {
	                   // 		$key = array_search($card_number, $arr);
	                   // 		if($key!="{$name}-{$phone}")
	                   // 		{
	                   // 			 fclose($handle);
	                   // 			$this->error(" 卡号冲突({$card_number}----{$name}-{$phone} vs {$key})");
	                   // 		}
	                   // }
	                   // else
	                   // {
	                   // 		$card=D("Card")->getCard($card_number,get_brand_id());
	                   // 		if(!empty($card))
	                   // 		{
	                   // 			$member=M("MemberBasic")->find($card['member_id']); 
	                   // 			if($member['name']!=$name || $member['phone']!=$phone)
	                   // 			{
	                   // 				 fclose($handle);
	                   // 				$this->error(" 卡号冲突({$card_number}----{$name}-{$phone} vs ".$member['name'].'-'.$member['phone']);
	                   // 			}
	                   // 		}
	                   // 		$arr1["{$name}-{$phone}"]=$card_number;
	                   // }
	                   $arr[]=$data;
                   }
                  catch(Exception $e) { 
                  	 fclose($handle);
                  	$this->error($e->getMessage()); 
                }}
                return true;
		 }
		 else
		 {
		 	 fclose($handle);
		 	$this->error("error");
		 }
	}
}