<?php
namespace Reception\Controller;
use Common\Controller\QueryController;
class MemberController extends QueryController {
 
  public function indexAction()
  { 
  	if(IS_GET)
     	$this->display();
     else
     {
     	var_dump(I(".post"));
     }
  }

}