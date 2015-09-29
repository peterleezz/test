<?php
namespace Bar\Controller;
use Common\Controller\BaseController;
class GoodsController extends BaseController {
	public function indexAction()
	{ 
		$goodstypes=D("GoodsCategory")->relation(true)->where(array("brand_id"=>get_brand_id()))->select();
		$this->assign("goodstypes",$goodstypes);
		$this->assign("goodstypesarr",json_encode($goodstypes));
		
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
		$total =0;
		$goods=json_decode($goods);
		$goodsModel = M("Goods");
		$member=M("MemberBasic")->find($member_id);
		foreach ($goods as $key => $value) {
			$num=$value->num;
			$id=$value->id;
			$g=$goodsModel->find($id);
			if(empty($g))
			{
				$this->error("ID={$id}的商品已下架!");
			}
			// $value->price=$g['price'];	
			$value->price = $value->unitprice;
			$goods[$key]->name=$g['name'];
			$total+=$num * $value->price;
		}		
		if($total!=$price)
		{
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
		{
			$this->error("Error!请检查参数的正确性");
		}

		$service=\Service\CService::factory("Financial"); 
	 	$bill_id=$service->addBillProject(2,0,$order_id,$member_id,$price,0,get_brand_id(),is_user_login(),get_club_id(),$member['mc_id'],$description);
	 	if(!$bill_id)
	 	{ 
	 		M("GoodsSaleOrder")->delete($order_id);
	 		$this->error($service->getError());
	 	}
	 	$ret = $service->pay($bill_id,0,is_user_login(),get_brand_id(),I("description"),I("cash"),I("pos"),I("check"),I('check_num'),get_club_id(),$recharge,$network,$netbank);
	 	if(!$ret)
	 	{ 
	 		M("GoodsSaleOrder")->delete($order_id);
	 		M("BillProject")->delete($bill_id);
	 		$this->error($service->getError());
	 	}
 
		$listModel = D("GoodsSaleList");
		foreach ($goods as $key => $value) {
			$num=$value->num;
			$id=$value->id; 
			$listModel->data(array("sale_club_id"=>get_club_id(),"brand_id"=>get_brand_id(),"order_id"=>$order_id,"goods_id"=>$id,"number"=>$num,'price'=>$value->unitprice,"goods_name"=>$value->name))->add();
		}	 


		if($use_recharge==1&& $recharge>0)
		{ 
			M("MemberBasic")->where(array("id"=>$member_id))->setField("recharge",$member['recharge']-$recharge); 
			$data=array("member_id"=>$member_id,"value"=>"-$recharge","record_id"=>is_user_login(),"description"=>"购物消费,余额".($member['recharge']-$recharge));			 
			M("RechargeHistory")->data($data)->add(); 
		} 
		$this->success("购买成功","list");	

	}
	public function doPayAction()
	{
		$service=\Service\CService::factory("Financial"); 
		$bill_project=M("BillProject")->find(I("id")); 
		if(empty($bill_project))
		{
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
	 		
	 		$this->error($service->getError());
	 	}  

		if(I('use_recharge')==1 && $recharge>0)
		{ 
			M("MemberBasic")->where(array("id"=>$member_id))->setField("recharge",$member['recharge']-$recharge); 
			$data=array("member_id"=>$member_id,"value"=>"-$recharge","record_id"=>is_user_login(),"description"=>"支付购物欠款,余额".($member['recharge']-$recharge));			 
			M("RechargeHistory")->data($data)->add(); 
		}  
		$this->success("支付成功","/Bar/Goods/list");	
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