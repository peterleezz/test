<?php
namespace Pt\Controller; 
class VisitController extends \Common\Controller\VisitBase {

public function setNotMemberActiveClass()
{ 
    $this->assign("active_open","#menu_10");
    $this->assign("active","#menu_48");
}
public function setIsMemberActiveClass()
{
	  $this->assign("active_open","#menu_10");
    $this->assign("active","#menu_52");
}
public function setAllMemberActiveClass()
{
	   $this->assign("active_open","#menu_10");
    $this->assign("active","#menu_85");
}

 public function setIndexActiveClass()
    {
          $this->assign("active_open","#menu_10");
    	$this->assign("active","#menu_84");
    }



public function show_add()
{
	return 1;
}

public function show_edit()
{
	return 1;
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
	return 2;
}
public function getAddRedirectUrl($is_member=0)
{
	if(!$is_member)
	return U('Pt/Visit/mynotmemberlist');
	return U('Pt/Visit/myismemberlist');
}

}