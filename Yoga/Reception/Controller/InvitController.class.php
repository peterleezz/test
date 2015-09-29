<?php
namespace Reception\Controller;
use  Common\Controller\BaseController;
class InvitController extends BaseController {
	public function indexAction()
	{    
		$mc=D("User")->getMc();
		$this->assign("mcs",$mc);
        $this->assign("active","#menu_4");
        $this->assign("active_open","#menu_70");
		$this->display();
	}

	public function doAction($id)
	{
		M("McFollowUp")->where("id=$id")->setField(array("is_come"=>1,"come_time"=>getDbTime()));
		$this->success("到场记录成功！");
	}

	

	public function queryAction()
	{
		list($page,$sidx,$limit,$sord,$start)=getRequestParams(); 
		$model=M("McFollowUp");
		$condition=array("a.club_id"=>get_club_id(),"a.ret"=>array("gt",0));
		 $filters=I("filters",'','');
        $filters = json_decode($filters);   
        if($filters->groupOp=='AND')
        {
            $rules = $filters->rules; 
            foreach ($rules as $key => $value) {               
                 if($value->field=="mc_id" && $value->data!=-1)
                {
                    $condition["b.mc_id"] = $value->data;   
                } 
                 if($value->field=="name" && !empty($value->data))
                {
                    $condition["b.name"] = array("like","%{$value->data}%") ;   
                } 
                 if($value->field=="phone" && !empty($value->data))
                {
                    $condition["b.phone"] = $value->data;   
                } 
            }
        }  


		$ret = $model->table(array("yoga_mc_follow_up"=>"a","yoga_member_basic"=>"b","yoga_user_extension"=>"c"))->where($condition)->where("a.member_id=b.id and b.mc_id=c.id")->field("c.name_cn as mc,b.name,b.sex,b.type,a.is_come,a.come_time,a.appoint_time,a.appoint_time,a.is_come,a.come_time,a.ret,a.id")->order("a.$sidx $sord")->limit("$start,$limit")-> select();

		
		 $count = $model->table(array("yoga_mc_follow_up"=>"a","yoga_member_basic"=>"b","yoga_user_extension"=>"c"))->where($condition)->where("a.member_id=b.id and b.mc_id=c.id")->count();  
		  if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }  
         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
         $this->ajaxReturn($response); 
	}
}
