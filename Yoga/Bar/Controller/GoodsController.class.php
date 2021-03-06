<?php
namespace Bar\Controller;
use Common\Controller\BaseController;
class GoodsController extends BaseController {
	public function indexAction()
	{ 
		$u = M("UserExtension")->find(is_user_login());
	    $can_grant=$u['can_grant'];
	    $this->can_grant=$can_grant;
		 $club_id=get_club_id();
		$goodstypes=D("GoodsCategory")->where(array("brand_id"=>get_brand_id()))->select();
		foreach ($goodstypes as $key => $value) {
			$goods = M()->table(array("yoga_goods"=>"a","yoga_goods_club"=>"b"))->where("b.club_id={$club_id} and a.status=1 and a.id=b.goods_id and a.category_id=".$value['id'])->field("a.*")->select();
			if(empty($goods))
			{
				unset($goodstypes[$key]);
			}
			else
			{
				$goodstypes[$key]['goods']=$goods;
			}
		}
		$goodstypes= array_values($goodstypes); 
		// $goodstypes=D("GoodsCategory")->relation(true)->where(array("brand_id"=>get_brand_id()))->select();
		$this->assign("goodstypes",$goodstypes);
		$this->assign("goodstypesarr",json_encode($goodstypes));
		$id=I("id");
		$member_id=I("member_id");
		if(!empty($id) && !empty($member_id))
		{
			$member=M("MemberBasic")->find($member_id);
			$this->member=$member;
			$goods = M("Goods")->find($id); 
			$this->goods=$goods;
			$this->category_id=$goods['category_id'];
			$this->goods_id=$id;
			
		}

		$this->extension_id=I("extension_id");
		$this->display();
	}

	public function payAction($id)
	{
		$model = D("GoodsSaleOrder");
		$ret=$model->relation(true)->find($id); 
		$service=\Service\CService::factory("Financial"); 
		$bill_project=$service->getBillProject("2",$ret['id']);
		$this->assign("bill_project",$bill_project);	
		foreach ($ret['goodslist'] as $key => $value) {
		 	$goods=M("Goods")->find($value['goods_id']);
		 	$ret['goodslist'][$key]['info']=$goods;
		 } 
		$this->assign("order",$ret);	

		// echo json_encode($ret);die();
		$this->display();
	}
	public function printAction($id)
	{
		$model = D("GoodsSaleOrder");
		$ret=$model->relation(true)->find($id);
		$this->assign("order",$ret);	
		$this->assign("count",count($ret['goodslist']));	
		$this->assign("print_time",date('Y-m-d H:i:s'));
		$club=M("Club")->find($ret['sale_club_id']);
		$this->assign("club",$club);	
		$service=\Service\CService::factory("Financial"); 
		$bill_project=$service->getBillProject("2",$ret['id']);
		$this->assign("bill",$bill_project);	
		list($historys,$count)=$service->getPayHistoryByBillId($bill_project['id'],0,99);
		$cash=0;
		$recharge=0;
		$check=0;
		$pos=0;
		$network=0;
		$netbank=0;
		foreach ($historys as $key => $value) {
			 $cash+=$value['cash'];
			 $recharge+=$value['recharge'];
			 $check+=$value['check'];
			 $pos+=$value['pos'];
			 $network+=$value['network'];
			 $netbank+=$value['netbank'];
		}
		$this->assign("cash",$cash);	
		$this->assign("recharge",$recharge);	
		$this->assign("check",$check);	
		$this->assign("pos",$pos);	
		$this->assign("network",$network);	
		$this->assign("netbank",$netbank);	

		$cashier = M("UserExtension")->find($historys[count($historys)-1]['record_id']);
		if(empty($cashier))
		{
			$brand = M("Brand")->find($bill_project['brand_id']);
			$this->assign("cashier",$brand['brand_name']);
		}
		else 
		$this->assign("cashier",$cashier['name_cn']);

		$member=M("MemberBasic")->find($ret['member_id']);
		$this->assign("member",$member);
		$this->display();
	}
	public function listAction()
	{
		$this->display();
	}

	public function saleListAction()
	{
		 list($page,$sidx,$limit,$sord,$start)=getRequestParams();
			$model = D("GoodsSaleOrder");
			$club_id = get_club_id();

			$valuesql="select a.* ,b.name,b.phone,c.name_cn,d.price,d.paid from yoga_goods_sale_order a inner join  yoga_member_basic b on a.member_id=b.id  inner join  yoga_bill_project d on a.id=d.object_id and d.type=2  inner join yoga_user_extension c on a.record_id=c.id  where a.sale_club_id=$club_id ";
 		$countsql="select count(*) as count  from yoga_goods_sale_order a inner join  yoga_member_basic b on a.member_id=b.id  inner join  yoga_bill_project d on a.id=d.object_id and d.type=2 inner join yoga_user_extension c on a.record_id=c.id  where a.sale_club_id=$club_id ";
 		$filters=I("filters",'','');
 		$filters = json_decode($filters);  
 		$sql="";
 		if($filters->groupOp=='AND')
        {
            $rules = $filters->rules; 
            foreach ($rules as $key => $value) {   
               
                 if($value->field=="name")
                {
                    $sql.=" and b.name ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                  if($value->field=="time")
                {
                    $sql.=" and a.create_time like  '{$value->data}%'"; 
                }
                if($value->field=="phone")
                {
                    $sql.=" and b.phone ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                
            }
        } 
        
        $model = new \Think\Model();
        $countsql=$countsql." ".$sql;
        $count=$model->query($countsql);
        $count=$count[0]["count"];
        $valuesql = $valuesql." ".$sql.$tail." order by $sidx $sord limit $start,$limit"; 
       
        $ret = $model->query($valuesql);
		foreach ($ret as $key => $value) {
			 $order_id = $value['id'];
			 $sale_list =M("GoodsSaleList")->where("order_id=$order_id")->select();
			 $goods = "";
			 foreach ($sale_list as $k => $v) {
			 	$string = $v['goods_name'];
			 	if($v['number']!=1)
			 	{
			 		$string = $v['goods_name']."x".$v['number']." ";
			 	}
			 	 $goods.=$string; 
			 }
			 $ret[$key]['goods']=$goods;

		}
			if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
			} else { 
			    $total_pages = 0; 
			} 	 
			$response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
			$this->ajaxReturn($response); 
		

		// list($page,$sidx,$limit,$sord,$start)=getRequestParams();
		// $model = D("GoodsSaleOrder");
		// $club_id = get_club_id();
		// $condition=array("sale_club_id"=>$club_id);
		// $filters=I("filters",'','');
		// $filters = json_decode($filters); 
		// if($filters->groupOp=='AND')
  //       {
  //           $rules = $filters->rules; 
  //           foreach ($rules as $key => $value) {    
  //                if($value->field=="name")
  //               {
  //                   $sql.=" and b.name ".getOPerationMysql($value->op)."  '{$value->data}'"; 
  //               }
  //               if($value->field=="phone")
  //               {
  //                   $sql.=" and b.phone ".getOPerationMysql($value->op)."  '{$value->data}'"; 
  //               }
                
  //           }
  //       }  
		// $ret = $model->relation("record_user,member")->where(array("sale_club_id"=>$club_id))->select();
	}


	public function buyAction($goods,$member_id,$price,$cash,$check,$pos,$check_num,$description,$use_recharge,$netbank,$network)
	{
		$u = M("UserExtension")->find(is_user_login());
	    $can_grant=$u['can_grant'];
	    if(!$can_grant)
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
			              		 $can_grant=1;
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
	    }
		$total =0;
		$goods=json_decode($goods);
		$goodsModel = M("Goods"); $goodsModel->startTrans();
		$member=M("MemberBasic")->find($member_id);
		foreach ($goods as $key => $value) {
			$num=$value->num;
			$id=$value->id;
			$g=$goodsModel->find($id);
			if(empty($g))
			{  $goodsModel->rollback();
				$this->error("ID={$id}的商品已下架!");
			}
			if($g['min_price'] > $value->unitprice && !$can_grant)
			{
				$goodsModel->rollback();
				$this->error($g['name']."价格低于最低价格，请求授权！");
			}
			// $value->price=$g['price'];	
			$value->price = $value->unitprice;
			$goods[$key]->name=$g['name'];
			$total+=$num * $value->price; 
		}		
		if($total!=$price)
		{ 
			$goodsModel->rollback();
			$this->error("商品已调价！请重新选择！");
		}
		$recharge=0;
		if($use_recharge==1)
		{
			 $recharge=$member['recharge'];
			 $recharge=$recharge>$price?$price:$recharge;
		}
		 
		// if($pay_way==2)
		// {
		// 	if($member['recharge']<$price)
		// 	{
		// 		$this->error("余额不足！");
		// 	} 
		// }
		
		//add sale_order
		$data=array("mc_id"=>$member['mc_id'], "member_id"=>$member_id,"price"=>$price,"sale_club_id"=>get_club_id(),"brand_id"=>get_brand_id(),"record_id"=>is_user_login());
		$order_id= M("GoodsSaleOrder")->data($data)->add(); 
		if(empty($order_id))
		{ $goodsModel->rollback();
			$this->error("Error!请检查参数的正确性");
		}

		$service=\Service\CService::factory("Financial"); 
	 	$bill_id=$service->addBillProject(2,0,$order_id,$member_id,$price,0,get_brand_id(),is_user_login(),get_club_id(),$member['mc_id'],$description);
	 	if(!$bill_id)
	 	{ 
	 		 $goodsModel->rollback();
	 		$this->error($service->getError());
	 	}
	 	$ret = $service->pay($bill_id,0,is_user_login(),get_brand_id(),I("description"),I("cash"),I("pos"),I("check"),I('check_num'),get_club_id(),$recharge,$network,$netbank);
	 	if(!$ret)
	 	{ 
	 		 $goodsModel->rollback();
	 		$this->error($service->getError());
	 	}
 
		$listModel = D("GoodsSaleList");
		foreach ($goods as $key => $value) {
			$num=$value->num;
			$id=$value->id; 
			$listModel->data(array("sale_club_id"=>get_club_id(),"brand_id"=>get_brand_id(),"order_id"=>$order_id,"goods_id"=>$id,"number"=>$num,'price'=>$value->unitprice,"goods_name"=>$value->name))->add();
			
			$goods=M("Goods")->find($id);
			if($goods['is_system'])
			{
				$extension_id=I("extension_id");
				switch ($goods['sys_type']) {
					case '0':
					if(empty($extension_id))
					 {
					 	$extension_id=M("Card")->where("member_id=$member_id")->find();
					 	$extension_id=$extension_id['id'];
					 }
						 M("Card")->where(array("id"=>$extension_id))->setInc('buka',1);
						break;
					case '1':
					if(empty($extension_id))
					 {
					 	$extension_id=M("Contract")->where("member_id=$member_id and invalid=1 and status in(0,3,2,4)")->find();
					 	$extension_id=$extension_id['id'];
					 }
						 M("Contract")->where(array("id"=>$extension_id))->setInc('free_rest',1);
						break;

					default:
						# code...
						break;
				}
			}

		}	 


		if($use_recharge==1&& $recharge>0)
		{ 
			M("MemberBasic")->where(array("id"=>$member_id))->setField("recharge",$member['recharge']-$recharge); 
			$data=array("member_id"=>$member_id,"value"=>"-$recharge","record_id"=>is_user_login(),"description"=>"购物消费,余额".($member['recharge']-$recharge));			 
			M("RechargeHistory")->data($data)->add(); 
		} 
  	    $goodsModel->commit();
		$this->success("购买成功",U("printreceipts",array("id"=>$ret)));	

	}
	public function doPayAction()
	{	$goodsModel = M("Goods"); $goodsModel->startTrans();
		$service=\Service\CService::factory("Financial"); 
		$bill_project=M("BillProject")->find(I("id")); 
		if(empty($bill_project))
		{ $goodsModel->rollback();
			$this->error("Bill is not exist!");
		}
		$recharge=0;
		$member_id=I("member_id");
		$member=M("MemberBasic")->find(I("member_id"));
		$price=$bill_project['price']-$bill_project['paid'];
		if(I('use_recharge')==1)
		{
			 $recharge=$member['recharge'];
			 $recharge=$recharge>$price?$price:$recharge;
		} 

		$ret = $service->pay(I("id"),1,is_user_login(),get_brand_id(),I("description"),I("cash"),I("pos"),I("check"),I('check_num'),get_club_id(),$recharge,I("network"),I("netbank"));
	 	if(!$ret)
	 	{  
	 		 $goodsModel->rollback();
	 		$this->error($service->getError());
	 	}  

		if(I('use_recharge')==1 && $recharge>0)
		{ 
			M("MemberBasic")->where(array("id"=>$member_id))->setField("recharge",$member['recharge']-$recharge); 
			$data=array("member_id"=>$member_id,"value"=>"-$recharge","record_id"=>is_user_login(),"description"=>"支付购物欠款,余额".($member['recharge']-$recharge));			 
			M("RechargeHistory")->data($data)->add(); 
		}  
		 $goodsModel->commit();
		$this->success("支付成功",U("printreceipts",array("id"=>$ret)));	
	}

	public function queryMemberAction($name)
	{
		if(empty($name)) $this->ajaxReturn(array("status"=>0,"info"=>"请输入查询信息！"));
		$club_id = get_club_id(); 
		$model=M("MemberBasic"); 
		$condition=array("club_id"=>$club_id,"_complex"=>array("name"=>array("like","%{$name}%"),"phone"=>$name,"_logic"=>"or"));
		$members=$model->where($condition)->select();

			$this->ajaxReturn(array("status"=>1,"data"=>$members));
		 
	}
 
 	public function queryAction()
 	{
 		list($page,$sidx,$limit,$sord,$start)=getRequestParams();
 		//query member card
 		$valuesql="select a.* ,b.name,b.phone from yoga_card a,yoga_member_basic b where a.member_id=b.id ";
 		$countsql="select count(*) as count from yoga_card a,yoga_member_basic b where a.member_id=b.id ";
 		$filters=I("filters",'','');
 		$filters = json_decode($filters);  
 		$sql="";
 		if($filters->groupOp=='AND')
        {
            $rules = $filters->rules; 
            foreach ($rules as $key => $value) {   
                 if($value->field=="card_number")
                {
                    $sql.=" and a.card_number ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                 if($value->field=="name")
                {
                    $sql.=" and b.name ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                if($value->field=="phone")
                {
                    $sql.=" and b.phone ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                
            }
        } 

        $model = new \Think\Model();
        $countsql=$countsql." ".$sql;
        $count=$model->query($countsql);
        $count=$count[0]["count"];
        $valuesql = $valuesql." ".$sql.$tail." order by $sidx $sord limit $start,$limit"; 
       
         $ret =$model->query($valuesql); 
            if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }     
         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
         $this->ajaxReturn($response); 
 	}
}