<?php
namespace Cashier\Controller;
use  Common\Controller\BaseController;
class MemberController extends BaseController {


public function indexAction()
{
	Cookie('__forward__',$_SERVER['REQUEST_URI']);
	$model = D("CardSaleclub");
	$types = $model->getCanSaleCards();
	$this->assign("types",$types);
	$this->assign("typesarr",json_encode($types));	
	 $mcs= D("User")->getMc();
	 $this->assign("mcs",$mcs);	
	$this->display();

}
	public function queryAction($name)
	{

		$club_id = get_club_id(); 
		$service = \Service\CService::factory("Member"); 
		$is_member=I("is_member");
		$members=$service->queryMemberByNameOrPhone($club_id,$name,$is_member);
		foreach ($members as $key => $value) {
			$cards=D("Card")->getAllCards($value['id'],get_brand_id());
			$arr=array();
			foreach ($cards as $k => $v) {
				$arr[]=$v['card_number'];
			}
			$members[$key]['card_number']=implode(",", $arr);
		}
		if(!empty($members))
		{
			$this->ajaxReturn(array("status"=>1,"data"=>$members));
		}
		else
		{
			$this->ajaxReturn(array("status"=>0));
		}
	}

	public function queryWithCardAction($name)
	{ 		 
		$club_id = get_club_id();
		$sql="select a.* from yoga_member_basic  a  where  (a.name='$name' or a.phone='$name') and a.club_id=$club_id order by is_member desc";
		$model=M("MemberBasic");
		
		// $members = $model->where(array("brand_id"=>$brand_id,"name"=>I("name")))->order("is_member asc")->select();
		$members=$model->query($sql);
		if(!empty($members))
		{
			foreach ($members as $key => $value) {
				$card=M("Card")->where(array("member_id"=>$value['id']))->find();
				if(empty($card))continue;
				$members[$key]['card_id']=$card['id'];
				$members[$key]['card_number']=$card['card_number'];
			}
			$this->ajaxReturn(array("status"=>1,"data"=>$members));
		}
		else
		{
			$this->ajaxReturn(array("status"=>0));
		}
	}


	public function showAction($id)
	{
		$model=D("MemberBasic");
		$member = $model->relation(true)->find($id); 
		if($member["club_id"]!=get_club_id())
		{
			$this->error("无权查看此用户信息");
		}

		$this->assign("member",$member);
		$content =$this->fetch();
		$this->ajaxReturn($content);
	}

	//开卡
	public function joinAction($member_id,$type,$card_type_id,$active_type,$present_day,$present_num,$start_time,$end_time,$price,$cash,$pos,$check,$check_num,$description,$card_number,$network,$netbank,$join_mc_id)
	{ 
		$model=D("Contract");
		if(!$model->create())
		{
			$this->error($model->getError());
		} 
		$member=M("MemberBasic")->find($member_id);
		if(empty($member))
		{
			$this->error("此会员不存在!");
		}
		$cardModel = D("Card");
	 	$cardTypeModel=M("CardType");
	 	$cardType=$cardTypeModel->find($card_type_id);
	 	if(empty($cardType))
	 	{
	 		$this->error("卡种不存在!");
	 	}
	  if($cardType['min_price']>I("price"))
	   {
	   		$grant_user_name = I("grant_user_name");
			$grant_user_password=I("grant_user_password");
	   		if(!empty($grant_user_name) && !empty($grant_user_password))
	   		{
					
				$map=array('username'=>$grant_user_name);
			        $user =M("User")->where($map)->find();
			        if(is_array($user)){
			            /* 验证用户密码 */
			            if(ucenter_md5(I("grant_user_password"), C("MD5_SECRET_KEY")) === $user['password'] ){
			              $extension = M("UserExtension")->find($user['id']);
			              if($extension['work_status']==1)
			              {
			                $this->error('授权用户无效!');
			              }
			              else
			              {

			              }
			            }
			            else
			            {
			            	  $this->error("授权无效"); 
			            }
			        }
			        else
			        {
			        	  $this->error("授权无效"); 
			        }

	   		}
	   		else $this->error("收银过低"); 
	   }
	 	if(!empty($card_number) && $cardModel->isExist($card_number,get_brand_id()))
	 	{
	 		$this->error("卡号已存在!");
	 	} 
	 	
		if(empty($card_number))
                {
                        $card_number=date("YmdHis").rand(0,10000);
                         $card=array("free_rest"=>I("free_rest"),"sale_club"=>get_club_id(),"is_active"=>I("active_type")!=2, "brand_id"=>get_brand_id(),"card_number"=>$card_number,"member_id"=>$member_id);
                        $card['update_time']=getDbTime();
                        $card_id=$cardModel->data($card)->add();
                        if(get_club_id()==1023)
                        {
                        	$max_card = M("Card")->where(array("sale_club"=>get_club_id(),"is_auto_create"=>1))->order("card_number desc")->find();
                        	if(empty($max_card))
                        		$card_number="1000001";
                        	else
                        		$card_number=$max_card['card_number']+1; 
                        	$card_number = preg_replace("/4/", "5", $card_number);
			                while(true)
			                {
			                        if($cardModel->isExist($card_number,get_brand_id()))
			                        {
			                                $card_number+=1;
			                                $card_number = preg_replace("/4/", "5", $card_number);
			                        }
			                        else
			                        {
			                                break;
			                        }
			                }
                        }
                        else
                        {

                        	$max_card = M("Card")->where(array("sale_club"=>get_club_id(),"is_auto_create"=>1))->order("card_number desc")->find();
                        	if(empty($max_card))
                        		$card_number=get_club_id()."000001";
                        	else
                        		$card_number=$max_card['card_number']+1; 
                        	$card_number = preg_replace("/4/", "5", $card_number);
			                while(true)
			                {
			                        if($cardModel->isExist($card_number,get_brand_id()))
			                        {
			                                $card_number+=1;
			                                $card_number = preg_replace("/4/", "5", $card_number);
			                        }
			                        else
			                        {
			                                break;
			                        }
			                }



                   //      	 $card_number=get_club_id().'0'. $card_id;   
                   //      	 $card_number = preg_replace("/4/", "5", $card_number);
			                // while(true)
			                // {
			                //         if($cardModel->isExist($card_number,get_brand_id()))
			                //         {
			                //                 $card_number.=rand(0,100);
			                //                 $card_number = preg_replace("/4/", "5", $card_number);
			                //         }
			                //         else
			                //         {
			                //                 break;
			                //         }
			                // }
                        }

                        
                $cardModel->where("id=$card_id")->setField(array("card_number"=>$card_number,"is_auto_create"=>"1"));


                }
                else
                {
                 $card=array("free_rest"=>I("free_rest"),"sale_club"=>get_club_id(),"is_active"=>I("active_type")!=2, "brand_id"=>get_brand_id(),"card_number"=>$card_number,"member_id"=>$member_id);
                $card['update_time']=getDbTime();
                $card_id=$cardModel->data($card)->add();

                }


	
	 	
	 	// $valid_time = $cardType['valid_time'];
	 	// if($cardType['type']==2)
	 	// {
	 	// 	$card["total_num"]=$cardType['valid_number']+$present_value;
	 	// 	$card["end_time"]=date('Y-m-d H:i:s',strtotime("+$valid_time month",strtotime($start_time)));
	 	// }
	 	// else
	 	// { 
	 	// 	$card["end_time"]=date('Y-m-d H:i:s',strtotime("+$valid_time month",strtotime($start_time)+$present_value*24*60*60));
	 	// }

	 	//$cardModel->where("id=$card_id")->setField("card_number",$card_number);

	 	// if(empty($card_number))
	 	// {
	 	// 	$card_number=$card_id;
	 	// 	$cardModel->where(array("id"=>$card_id))->setField("card_number",$card_id);
	 	// }

	 	if(!$card_id)$this->error("开卡失败，请稍后再试!");
	 	$model->total_num=$cardType['valid_number']+ I("present_num");
		$model->sale_club_id=get_club_id();
	 	$model->card_id=$card_id;
		$payed=$cash+$check+$pos+$network+$netbank; 
		$book_price=0;
		if($member['contract_book_price']!=0)
		{
			$book_price = $price-$payed > $member['contract_book_price']?$member['contract_book_price']:$price-$payed;
			$payed+=$book_price;
		}
		$model->payed=$payed;
		$contract_number = date("YmdHis").rand(0,10000);
        $r_contract_number=I("contract_number");
		if(!empty($r_contract_number)) $contract_number=I("contract_number");
		$model->contract_number=$contract_number;
		$model->free_rest=I("free_rest");
		$model->free_trans=I("free_trans")==1 ||I("free_trans")=="true"?1:0 ;
		$model->mc_id=$join_mc_id; 
		$model->card_type_extension=json_encode($cardType);
		if(get_brand_id()==52 || get_brand_id()==50)
		$model->is_review=1;
		if(I('active_type')==2){
			unset($model->start_time);
			unset($model->end_time);
		}	
	 	$contract_id= $model->add();
	 	if(!$contract_id)
	 	{ 
	 		$cardModel->delete($card_id);
	 		$this->error("Error");
	 	}
	 	if($member['is_member']==0)
	 		M("MemberBasic")->where(array("id"=>$member_id))->setField(array("mc_id"=>$join_mc_id,"type"=>1,"maybuy"=>0,"hopeprice"=>0, "is_member"=>1,"join_time"=>getDbTime()));
	 	else
	 		M("MemberBasic")->where(array("id"=>$member_id))->setField(array("mc_id"=>$join_mc_id, "type"=>1,"maybuy"=>0,"hopeprice"=>0));

	 	$service=\Service\CService::factory("Financial");

	 	$bill_id=$service->addBillProject(0,0,$contract_id,$member_id,$price,0,get_brand_id(),is_user_login(),get_club_id(),$join_mc_id,$description);
	 	if(!$bill_id)
	 	{
	 		$cardModel->delete($card_id);
	 		$model->delete($contract_id);
	 		$this->error($service->getError());
	 	}
	 	$ret = $service->pay($bill_id,0,is_user_login(),get_brand_id(),$description,$cash,$pos,$check,$check_num,get_club_id(),0,I("network"),I("netbank"));
	 	if(!$ret)
	 	{
	 		$cardModel->delete($card_id);
	 		$model->delete($contract_id);
	 		M("BillProject")->delete($bill_id);
	 		$this->error($service->getError());
	 	}
	 	if($book_price!=0)
	 	{
	 		M("MemberBasic")->where(array("id"=>$member_id))->setDec("contract_book_price", $book_price);
	 		$bill_project = M("BillProject")->where(array("member_id"=>$member_id,"type"=>9,"object_id"=>0))->select();
	 		$i=$book_price;
	 		foreach ($bill_project as $key => $value) {
	 			 $i-=$value['paid'];
	 			 M("BillProject")->where("id=".$value['id'])->setField(array("object_id"=>$contract_id));
	 			 if($i <=0)break;
	 		}
	 		 M("BillProject")->where("id=$bill_id")->setInc("paid", $book_price);

	 	}
	 	//cash history
	 	// $cashModel = M("CashHistory");
	 	// $cashModel->data(array("cash"=>I("cash"),"check"=>I("check"),"pos"=> I("pos"),"object_id"=>$contract_id,"price"=>I("should_pay"),"record_id"=>is_user_login(),"brand_id"=>get_brand_id()))->add();
	   //contract history
	   M("ContractHistory")->data(array("contract_id"=>$contract_id,"extension"=>json_encode(I("post."))))->add();

	   //review
	   $reason ="新增合同";
	   if($cardType['max_present_num']<I("present_num"))
	   {
	   		$reason.=";新办卡赠送次数过多";
	   }
	    if($cardType['max_present_day']<I("present_day"))
	   {
	   	 $reason.=";新办卡赠送天数过多";
	   }
	    if($cardType['min_price']>I("price"))
	   {
	   	 $reason.=";新办卡收银过低";
	   }
	   if(!empty($reason))
	   {
	   	  $contract = M("Contract")->find($contract_id);
	   	  $data=array("extension"=>json_encode($contract),"reason"=>$reason,"record_id"=>is_user_login(),"club_id"=>get_club_id(),"brand_id"=>get_brand_id(),"type"=>0,"status"=>0);
	   	  M("Review")->data($data)->add();
	   }
	   $this->ajaxReturn(array("status"=>1,"card_id"=>$card_number));
	}

	public function editAction($id,$card_number,$btype,$card_type_id,$present_day,$present_num,$price,$start_time,$end_time,$active_type,$desc,$free_rest,$free_trans,$mc_name)
	{
		$rules = array(
		     array('id','require','合同ID必须！',1),  
		     array('card_number','require','卡号必须！',1), 
		     array('btype',array(0,1),'类型不对!',1,'in'),
		     array('card_type_id','number','卡类型不对!',1),  
		     array('present_day','number','赠送天数需要为整数!',1),  
		     array('present_num','number','赠送次数需要为整数!',1),  
		     array('price','number','请输入正确的应付价格!',1),   
       		 array('active_type',array(0,1,2),'请选择开卡方式!',1,'in'),
		);
		$bill=M("BillProject")->find($id);
		$model=D("Contract");
		if (!$model->validate($rules)->create()){
		    $this->error($model->getError());
		}  
		if($active_type!=2)
		{
			$rules =array(
			  array('start_time','/^\d{4}-\d{2}-\d{2}$/','请选择合同开始日期!',1),
       		  array('end_time','/^\d{4}-\d{2}-\d{2}$/','请选择合同结束日期!',1),
       		);
       		if (!$model->validate($rules)->create()){
		   		$this->error($model->getError());
			}  
		}
		$cardTypeModel=M("CardType");
	 	$cardType=$cardTypeModel->find($card_type_id);
	 	if(empty($cardType))
	 	{
	 		$this->error("卡种不存在!");
	 	}

		$model=D("Contract");
		$original_contract=$model->find($bill['object_id']);
		$member_id=$original_contract['member_id'];
		$card_id=$original_contract['card_id'];
		$original_extension=json_encode($original_contract); 
		if(empty($original_contract))
		{
			$this->error("Error");
		}
		if($original_contract['is_review']==1 && !is_user_brand())
		{
			$this->error("此合同已审核，如需修改，请联系管理员！ ");
		}
		if($original_contract['is_review']==2)
		{
			$this->error("此合同已升级作废，如需修改请联系管理员！  ");
		}

		$cardModel = D("Card");
		if($card_number!=$original_contract['card_number'])
		{
			$c=$cardModel->getCard($card_number,get_brand_id());
			if(empty($c))
		 	{
		 		//delete this card is no relate contract
			 	$count=$model->where("card_id=".$original_contract['card_id'])->count();
			 	if($count==1)
			 	{
			 		$card = $cardModel->find($original_contract['card_id']);
			 		if(empty($card))
			 		{
			 			$card=array("card_number"=>$card_number,"member_id"=>$member_id,"brand_id"=>get_brand_id());
			 			$card_id=$cardModel->data($card)->add(); 
			 			 
			 		}
			 		else
			 		{
			 			M("Card")->where("id=".$original_contract['card_id'])->setField(array("card_number"=>$card_number,"is_auto_create"=>0));
			 		} 
			 		
			 	}
			 	else
			 	{
			 		$card = $cardModel->find($card_id);
			 		unset($card['id']);
			 		 $card['create_time']=getDbTime(); 
			 		 $card['update_time']=getDbTime(); 
			 		  $card['card_number']=$card_number;  
		 			 $card_id=$cardModel->data($card)->add(); 
			 	}
 
		 	} 
		 	else
		 	{
		 		if($c['member_id']!=$member_id)
		 		{
		 			$this->error("此卡已被占用！请输入其他卡号！");
		 		}
		 		$card_id=$c['id'];
		 	}

		} 
	 	if(!$card_id)$this->error("开卡失败，请稍后再试!"); 

		if(I('active_type')==2){
			unset($model->start_time);
			unset($model->end_time);
		}		
	 	$new_contract = $original_contract;
	 	$new_contract['card_id']=$card_id;
	 	$new_contract['type']=$btype;
	 	if($original_contract['card_type_id']!=$card_type_id)
	 		$new_contract['card_type_extension']=json_encode($cardType);
	 	$new_contract['card_type_id']=$card_type_id;
	 	$new_contract['present_day']=$present_day;
	 	$new_contract['present_num']=$present_num;
	 	$new_contract['price']=$price;
	 	$new_contract['start_time']=$start_time;
	 	$new_contract['end_time']=$end_time;
	 	$new_contract['active_type']=$active_type;
	 	$new_contract['free_rest']=$free_rest;
	 	$new_contract['free_trans']=$free_trans;
	 	if($original_contract['mc_id']!=$mc_name)
	 	{
	 		M("MemberBasic")->where("id=$member_id")->setField(array("mc_id"=>$mc_name));
	 		M("BillProject")->where("id=$id")->setField(array("mc_id"=>$mc_name));
	 	}
	 	$new_contract['mc_id']=$mc_name;
	 	if(!empty($desc))
	 	$new_contract['description']=$desc.";".$original_contract['description'];
	 	$new_contract['total_num']=$present_num+$cardType['valid_number'];
  		$model->data($new_contract)->save();

  		M("BillProject")->where("id=$id")->setField(array("price"=>$price));
	   //review
	   $reason ="合同修改"; 
	   if(!empty($reason))
	   {
	   	  $contract = M("Contract")->find($new_contract["id"]);
	   	  $data=array("original_extension"=>$original_extension,"extension"=>json_encode($contract), "reason"=>$reason,"record_id"=>is_user_login(),"club_id"=>get_club_id(),"brand_id"=>get_brand_id(),"type"=>0,"status"=>0);
	   	  M("Review")->data($data)->add();
	   }
	   $this->success("修改成功");
	}
}
