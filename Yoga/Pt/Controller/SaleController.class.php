<?php
namespace Pt\Controller;
class SaleController extends \Common\Controller\VisitBase  {

	public function indexAction()
	{
		$classes=D("PtClass")->getAllCanSaleClasses();
		$this->assign("classes",$classes);
		$this->display();
	}

   public function followlistAction($id)
    {
        $list =D("PtFollowUp")->relation("ptclass")->where("member_id=$id")->order("create_time desc")->select();
        $this->ajaxReturn(array("status"=>1,"data"=>$list));
    }

	public function addfollowupAction()
    {
        $now=date('Y-m-d H:i:s');
        $model = D("PtFollowUp");

        if(!$model->create())
        {
            $this->error($model->getError());
        } 
        $appoint_time=I("appoint_time");
        if(empty($appoint_time))
        {
            unset($model->appoint_time);
        }
       $id=$model->add();

       if($id)
       {
             M("MemberBasic")->where(array("id"=>I("member_id")))->setField("pt_follow_up_time",$now);

             $this->success("添加记录成功！");
       }
       else
       {
            $this->error($model->getLastSql());
       }
       
    }

}