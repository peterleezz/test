<?php
namespace Reception\Controller;
use  Common\Controller\BaseController;
class YaaController extends BaseController {
	public function indexAction()
	{     
        $this->assign("active","#menu_4");
        $this->assign("active_open","#menu_81");
		$this->display();
	}

	public function doAction($id,$gift_desc)
	{
        $record_id=is_user_login();
		M("YaaGift")->where("id=$id")->setField(array("record_id"=>$record_id,"gift_status"=>1,"gift_desc"=>$gift_desc));
        $gift = M("YaaGift")->find($id);
        M("YaaMember")->where(array("member_id"=>$gift['member_id']))->setField(array("gift_status"=>2));
		$this->success("领奖成功！");
	}

	

	public function queryAction()
	{
		list($page,$sidx,$limit,$sord,$start)=getRequestParams();  
		$condition=array("a.club_id"=>get_club_id());
		 $filters=I("filters",'','');
        $filters = json_decode($filters);   
        if($filters->groupOp=='AND')
        {
            $rules = $filters->rules; 
            foreach ($rules as $key => $value) {               
                  
                 if($value->field=="name" && !empty($value->data))
                {
                    $condition["a.name"] = array("like","%{$value->data}%") ;   
                } 
                 if($value->field=="phone" && !empty($value->data))
                {
                    $condition["a.phone"] = $value->data;   
                } 
            }
        }  

        $model=M("YaaGift");
		$ret = $model->table(array("yoga_yaa_gift"=>"b","yoga_member_basic"=>"a"))->where($condition)->where("b.member_id=a.id")->field("a.name,a.sex,b.*")-> order("$sidx $sord")->limit("$start,$limit")-> select();  
		foreach ($ret as $key => $value) {
           $record_id=$value['record_id'];
           if($record_id!=0)
           {
            $ret[$key]['recorder'] = M("UserExtension")->find($record_id);
           }
        }

        $count = $model->table(array("yoga_yaa_gift"=>"a","yoga_member_basic"=>"a","yoga_user_extension"=>"c"))->where($condition)->where("a.member_id=b.id")->order(" $sidx $sord")->limit("$start,$limit")-> count();

		  if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }  
         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
         $this->ajaxReturn($response); 
	}
}
