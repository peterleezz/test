<?php
namespace Api\Controller;
use Think\Controller;
class IndexController extends Controller {
    protected function _initialize(){
        define('UID',is_user_login());
        if( !UID ){// 还没登录 跳转到登录页面
            $this->redirect('Home/Index/index');
        }     
        // if(!IS_AJAX)
        //      $this->error("error");

    }

    public function getChannelAction()
    {
        $club_id = get_club_id();
        $model  = M("Channel");
        $ret = $model->where(array("club_id"=>$club_id))->field("id,name")->select();
        $this->ajaxReturn(array("status"=>1,"data"=>$ret));
    }

    public function getUserChannelAction()
    { 
        $model  = M("Channel");
        $ret = $model->where(array("user_id"=>is_user_login()))->select();
        $this->ajaxReturn(array("status"=>1,"data"=>$ret));
    }

     public function getClubsAction()
    {
        $brand_id = get_brand_id();
        $model  = M("Club");
        $ret = $model->where(array("brand_id"=>$brand_id))->field("id,club_name")->select();
        $this->ajaxReturn(array("status"=>1,"data"=>$ret));
    }

  public function getPeaktimeAction()
    {
        $brand_id = get_brand_id();
        $model  = M("PeakTime");
        $ret = $model->where(array("brand_id"=>$brand_id))->field("id,peak_name")->select();  
        $this->ajaxReturn(array("status"=>1,"data"=>$ret));
    }



     public function getPtsAction()
    {
         $ret=D("User")->getPt();
        $this->ajaxReturn(array("status"=>1,"data"=>$ret));
    }


     public function getGroupsAction()
    {
        $club_id=get_club_id();
         $ret=D("McGroup")->getAllGroups($club_id);
        $this->ajaxReturn(array("status"=>1,"data"=>$ret));
    }


     public function getMcsAction()
    {
        $ret=D("User")->getMc();
        $this->ajaxReturn(array("status"=>1,"data"=>$ret));
    }



    public function getChannelUsersAction()
    {
         $club_id = get_club_id();
         $users= D("User")->getChannelUser($club_id); 
         $this->ajaxReturn(array("status"=>1,"data"=>$users)); 
    }


    public function getCardTypeAction()
    {
         $brand_id = get_brand_id();
         $cardtypes= D("CardType")->getAllBrandCardTypes($brand_id); 
         $this->ajaxReturn(array("status"=>1,"data"=>$cardtypes));

    } 
    
}