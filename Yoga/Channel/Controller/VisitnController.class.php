<?php
namespace Channel\Controller; 
class VisitnController extends \Common\Controller\VisitBase {

public function  setcolshow()
{  
     $this->assign("show_channel_col","1");
     $this->assign("show_status_col","1");
}

public function getchannels()
{
	$channels=D("Channel")->getChannelNameByUser(is_user_login());	  
	return $channels;
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
	$this->assign("active_open","#menu_13");
    $this->assign("active","#menu_43");
}

 public function setIndexActiveClass()
    {
          $this->assign("active_open","#menu_13");
    	$this->assign("active","#menu_34");
    }


public function show_add()
{
	return 1;
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
	 $channels=D("Channel")->getChannelNameByUser(is_user_login());	 
	 $this->assign("channels",$channels);
	return 1;
}

 public function getMcId()
{
	return 0;
}
public function getAddWay()
{
	return 1;
}
public function getAddRedirectUrl()
{
	return U('Channel/Visitn/myallmemberlist');
}

}