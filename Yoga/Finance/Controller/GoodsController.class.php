<?php
namespace Finance\Controller;
use Common\Controller\BaseController;
class GoodsController extends BaseController {
	public function indexAction()
	{   
		if(is_user_brand())
		{
			$clubs = M("Club")->where(array("brand_id"=>get_brand_id()))->field('id,club_name')->order("id desc")->select();
		}
		else
		{
			$permission=D("FinanceClub")->where(array("user_id"=>is_user_login()))->relation(true)->select();
			$clubs=array();
			foreach ($permission as $key => $value) {
				$clubs[]=$value['club'];
			}
		}
		
		$this->assign("clubs",$clubs);
		$this->display();
	} 

	public function queryReportAction($club_ids,$type,$start_time,$end_time)
	{
		$clubs=implode(",", $club_ids);
		$condition_goods=array("sale_club_id"=>array("in",$clubs));
		$condition_bill=array("sale_club_id"=>array("in",$clubs)); 
		switch ($type) {
			case '1': //day
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				$st=$start_time." 00:00:00";
				$et=$start_time." 23:59:59";
				$condition_goods["create_time"]=array("between","$st,$et");
				$condition_recharge["create_time"]=array("between","$st,$et");
				break;
			case '2': //month
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				$st=$start_time."-01 00:00:00";
				$et=$start_time."-31 23:59:59";
				$condition_goods["create_time"]=array("between","$st,$et");
				$condition_recharge["create_time"]=array("between","$st,$et");
				break;
			case '3': //year
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				$st=$start_time."-01-01 00:00:00";
				$et=$start_time."-12-31 23:59:59";
				$condition_goods["create_time"]=array("between","$st,$et");
				$condition_recharge["create_time"]=array("between","$st,$et");
				break;
			case '4': //other
				if(empty($start_time))
				{
					$this->error("请输入开始时间！");
				}
				if(empty($end_time))
				{
					$this->error("请输入结束时间！");
				} 
				$st=$start_time;
				$et=$end_time;
				$condition_goods["create_time"]=array("between","$start_time,$end_time");
				$condition_recharge["create_time"]=array("between","$start_time,$end_time");
				break;
			default:
				# code...
				break;
		}
		 $goodsSaleListModel = M("GoodsSaleList");
		 $goodsModel=M("Goods");
		 $billProjectModel=M("BillProject");
		// //各类商品的销售情况
		 $goods_list = $goodsSaleListModel->where($condition_goods)->field('goods_id,sum(number) as number ,sum(price*number) as total')->group('goods_id')->order("total desc")->select();
		
		 foreach ($goods_list as $key => $value) {
		 	 $goods=$goodsModel->find($value['goods_id']);
		 	 $goods_list[$key]['name']=$goods['name'];
		 	 $goods_list[$key]['price']=$goods['price'];
		 	 $goods_list[$key]['check']="未知";
		 	 $goods_list[$key]['pos']="未知";
		 	 $goods_list[$key]['recharge']="未知";
		 	 $goods_list[$key]['classify']="商品详细"; 
		 	 $goods_list[$key]['paid']="未知";
		 	 $goods_list[$key]['own']="未知";
		 	 $goods_list[$key]['type']=10;
		     $goods_list[$key]['subtype']=$value['goods_id'];
		 } 
		 $response = array("page"=>0,"total"=>0,"records"=>0,"rows"=>$goods_list);
		 $this->ajaxReturn($response); 
	}
}