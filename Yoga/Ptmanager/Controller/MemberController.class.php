<?php
namespace Ptmanager\Controller;

class MemberController extends \Common\Controller\VisitBase {
	public function indexAction()
	{  
        $pts=D("User")->getPt();
        $this->assign("pts",$pts);
        $this->assign("ptsarr",json_encode($pts));        
        $this->assign("is_member",1);
        $this->assign("active","#menu_61");
        $this->assign("active_open","#menu_9");
		$this->display();
	}
    

    public function assignAction($members,$pt_id)
    {
        if(empty($pt_id)) $this->error("Please choose one pt!"); 
        $model=M("MemberBasic");
        foreach ($members as $key => $value) {
           $model->where("id=$value")->setField(array("pt_id"=>$pt_id,"pt_assign_time"=>getDbTime()));
        }
        $this->success("指派成功!");
        
    }
    public function setNotMemberActiveClass()
{ 
    $this->assign("active_open","#menu_8");
    $this->assign("active","#menu_48");
}
public function setIsMemberActiveClass()
{
      $this->assign("active_open","#menu_8");
    $this->assign("active","#menu_52");
}
public function setAllMemberActiveClass()
{
     
}

 public function setIndexActiveClass()
    {
          $this->assign("active_open","#menu_8");
        $this->assign("active","#menu_42");
    }



public function show_add()
{
    return 0;
}

public function show_edit()
{
    return 0;
}

public function is_member()
{
    return null;
}
public function display_card_number()
{
    return 0;
}
public function display_member_type()
{
    return 1;
}
public function display_channel()
{
    return 0;
}

 public function getMcId()
{
    return is_user_login();
}
public function getAddWay()
{
    return 0;
}
public function getAddRedirectUrl()
{
    return U('Mc/Visit/mynotmemberlist');
}

 
}