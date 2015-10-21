<?php
namespace Brand\Controller;
use Common\Controller\BaseController;
class ShopController extends BaseController {

	// public  function clubsinfoAction()
	// {
	// 	if(IS_AJAX)
	// 	{
	// 		$page = empty(I("page"))?0:I("page");
	// 		$limit = empty(I("rows"))?0:I("rows");
	// 		$sidx = empty(I("sidx"))?0:I("sidx");
	// 		$sord = empty(I("sord"))?0:I("sord");
	// 		$model = M("Club");
	// 		$brand_id = is_user_brand();
	// 		$condition = array("brand_id"=>$brand_id);
	// 		$clubs = $model->where($condition)->select();
	// 		$response = array("page"=>10,"total"=>100,"records"=>1000,"rows"=>$clubs);
	// 		$this->ajaxReturn($response); 
	// 	}
	// 	else
	// 	{
	// 		$this->display();
	// 	}
		
	// }
	


	//高峰时段
   public function delPeakAction($id)
	{
		$model = M("PeakTime");
		$peaktime = $model->find($id);
		$club_id = $peaktime['club_id'];		 
		// $this->getClub($club_id);
		$ret = $model->delete($peaktime['id']);
		if($ret!==1)
		{
			$this->error("删除失败!");
		}
		$this->success("删除成功!");
	}

	public function peakAction()
	{
		$model = M("PeakTime");
		$peaks = $model->where(array("brand_id"=>get_brand_id()))->select();
		foreach ($peaks as $key => $value) {
			// $peaks[$key]["club"]=M("Club")->find($value['club_id']);
			$peaks[$key]['peak_time']=json_decode($value['peak_time'],true);
		}
		
		$this->assign("peaks",$peaks);
		$this->display();
	}

public function editPeakAction()
{ 
	$data = array("peak_name"=>I("peak_name"),"club_id"=>I("club_id"),"peak_time"=>json_encode(I("times")));	
	$model = D("PeakTime"); 
	if (!$model->create($data)){
	     $this->error(($model->getError()));
	}else{
	   $club_id = I("club_id");	    
	   $id=I("id");
	   if(!empty($id)) //update
	   {
	   		// $this->getClub($club_id);
	   		$model->where("id=$id")->data($data)->save();
	   }
	   else  //insert
	   {
	   	   $model->add();
	   }
	}
	$this->success("123",U("Brand/Shop/peak"));
}
	public function showEditPeakAction()
	{
		$id = I("id");
		if(isset($id))
		{
			$model=M("PeakTime");
			$peak = $model->find($id);
			// echo json_encode($peak);die();
			$this->assign("peak",$peak);
			// $this->assign("selectid",$peak['club_id']);
		}
		$clubs = M("Club")->where(array("brand_id"=>get_brand_id()))->field('id,club_name')->select();
		$this->assign("clubs",$clubs);
		$this->display();
	}


	//会所信息
	public  function clubsinfoAction()
	{
		 
			$model = M("Club");
			$brand_id = get_brand_id();
			$condition = array("brand_id"=>$brand_id);
			$clubs = $model->where($condition)->order('id desc')->select();
			$this->assign("clubs",$clubs);
			$this->display();		 
	}


	public  function clubinfoAction($id)
	{
		$club = $this->getClub($id);
		$this->assign("club",$club);
		$this->display();
	}

	public function showAddAction()
	{
		$this->assign("baidu_key",C("baidu_key"));
		$this->assign("lat",0);
		$this->assign("lon",0);
		$this->display();
	}
	public function showEditAction($id)
	{
		$this->assign("baidu_key",C("baidu_key"));
		$club = $this->getClub($id);
		$this->assign("lat",$club['lat']);
		$this->assign("lon",$club['lon']);
		$this->assign("club",$club);
		$this->display("showAdd");
	}

	public function addAction()
	{
		$model = D("Club");
		if(!$model->create())
		{
			$this->error(($model->getError()));
		}		
		$model->brand_id=get_brand_id();
		$id = $model->add();
		$this->createSysinfo($id);


		$this->success("添加成功！",U("Brand/Shop/clubsinfo"));
	}

	private function createSysinfo($club_id)
	{
		$clubs = M("Club")->where("id=$club_id")->select();
		$a = A("Home/Script");
		$a->createclubsysinfo($clubs);

	}

	public function editAction($id)
	{
		$model = D("Club");
		if(!$model->create())
		{
			$this->error(($model->getError()));
		}	
		$club = $this->getClub($id);
		$model->save(); 
		$this->success("添加成功！",U("Brand/Shop/clubsinfo"));
	}


	public function delAction($id)
	{
		$model = M("Club");
		$brand_id=get_brand_id();
		$condition = array("id"=>$id,"brand_id"=>$brand_id);
		$ret = $model->where($condition)->delete();
		if($ret!==1)
		{
			$this->error("删除失败!");
		}
		$this->success("删除成功!");
	}

 

 	public function delayAction()
 	{
 		$clubs = M("Club")->where(array("brand_id"=>get_brand_id()))->field('id,club_name')->select();	 
		$this->assign("clubs",$clubs); 	
		$delay_history = D("DelayHistory")->relation(true)->where(array("brand_id"=>get_brand_id()))->order("id desc")->select();
		$this->assign("history",$delay_history); 		 
		$this->display();
 	}

 	public function adddelayAction()
 	{
 		$model =  D("DelayHistory");
 		if(!$model->create())
 		{
 			$this->error($model->getError());
 		}
 		$id=$model->add();
 		if(!$id)
 		{
 			$this->error("Error!");
 		}	

 		$delay_day=I("delay_day");
 		$delay = $model->relation(true)->find($id);
 		$model = D("Card");

 		$model->query("update yoga_contract set end_time=date_add(end_time,interval {$delay_day} day)  where card_type_id in(select card_type_id from yoga_card_useclub where club_id=".I("club_id").")");
 		$this->ajaxReturn(array("status"=>1,"data"=>$delay));
 	}
}