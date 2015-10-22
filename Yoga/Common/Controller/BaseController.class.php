<?php
namespace Common\Controller;
use Think\Controller;
use Service\McService;
use Service\ChannelService;
class BaseController extends Controller {
    protected function _initialize(){  
        define('UID',is_user_login());
        if( !UID ){// 还没登录 跳转到登录页面
            $this->redirect('Home/Index/index');
        }    
        if(!IS_AJAX )
           {
               Cookie('__lastpage__',Cookie('__thispage__')); 
               Cookie('__thispage__',$_SERVER['REQUEST_URI']); 
           }
       
        $loginuser=getLoginUser(); 
    	$this->user = $loginuser['UserExtension']['name_cn'];        
        $this->assign("useravatar", "/Public/uploads/em_avatar/". $loginuser['UserExtension']['avatar']);
        $isMc=D("User")->isMc(UID);   
        $isChannel=D("User")->isChannel(UID);         
        
        $isReception = D("User")->isReception(UID);
        if(empty($isReception)) $isReception=0;

        if($isMc)
        {
            $start_time=date("Y-m");
            $st=McService::getInstance()->getUserOneMonthStatistics(UID,$start_time); 
            if(!empty($st))
            {
                 $this->mc_protential_persent =ceil($st[0]["protential_value"] *10000 /$st[0]["protential_plan"])/100; 
                 $this->mc_transform_persent =ceil($st[0]["transform_value"] *10000 /$st[0]["transform_plan"])/100; 
                 $this->mc_protential_value=$st[0]["protential_value"];
                 $this->mc_protential_plan=$st[0]["protential_plan"];
                 $this->mc_transform_value=$st[0]["transform_value"];
                 $this->mc_transform_plan=$st[0]["transform_plan"];
            }
            else
            {
                $isMc=0;
            }
        } 
        if($isChannel)
        {
            $start_time=date("Y-m");
            $st=ChannelService::getInstance()->getUserOneMonthStatistics(UID,$start_time); 
          
            if(!empty($st))
            {
                $this->channel_protential_persent =ceil($st[0]["protential_value"] *10000 /$st[0]["protential_plan"])/100;
                $this->channel_channel_persent =ceil($st[0]["channel_value"] *10000 /$st[0]["channel_plan"])/100; 
                $this->channel_channel_value = $st[0]["channel_value"];
                $this->channel_channel_plan = $st[0]["channel_plan"];
                $this->channel_protential_value = $st[0]["protential_value"];
                $this->channel_protential_plan = $st[0]["protential_plan"];
            }
            else
            {
                $isChannel=0;
            }
        }
        $this->isReception=$isReception;
         $this->show_plan =$isMc||$isChannel; 
        $this->isMc =$isMc;
        $this->uid = UID;
        $this->isChannel =$isChannel; 
        $this->checkRole();

        //通知
        $model = D("Notice");
        $brand_id=get_brand_id();
        $ret = $model->getLatestNotice($brand_id);
        $this->notice =nl2br($ret['content']) ;
        if(!IS_AJAX)
             $this->loadMenus(); 
    }

    //check role,only check first level
    private function checkRole()
    {
        $Model = M("SysConfig");
        $config = $Model->find();
        if(strtolower(MODULE_NAME) == 'home') return true; 
        if(is_user_brand() && in_array(strtolower(MODULE_NAME), json_decode($config['default_role']))) return true;
    	 $auth=new \Think\Auth();
     if( MODULE_NAME!='Teamleader' &&  !$auth->check(MODULE_NAME,is_user_login(),2))
         {
         	$this->error("无此操作权限！");
         }
    }

    //load menu
   //  protected function loadMenus()
   //  {  
   //  	    $model = M("Menu");
			// $menu = $model->where("pid=0")->select();

			// $auth=new \Think\Auth(); 
   //          $Model = M("SysConfig");
   //          $config = $Model->find();

			// foreach ($menu as $key => $value) {
			// 	$url = $value['url'];
			// 	$module = explode('/', $url); 
   //              if(is_user_brand())
   //              {
   //                  if(!in_array(strtolower($module[0]), json_decode($config['default_role'])))
   //                                  {                                      
   //                                      if(!$auth->check($module[0],is_user_login(),2))
   //                                       {  
   //                                          unset($menu[$key]);
   //                                          continue;
   //                                       }
   //                                   }  
   //              }
   //              else
   //              {
   //                                  if(!$auth->check($module[0],is_user_login(),2))
   //                                       { 
   //                                          unset($menu[$key]); 
   //                                          continue;
   //                                       }
   //              }
                		 
			// 	$pid = $value['id'];
			// 	$childs = $model->where("pid=$pid")->select();
   //             if(!empty($childs))
   //             {
   //                  foreach ($childs as $ckey => $cvalue) {
   //                      $pid = $cvalue['id'];
   //                      $cchilds = $model->where("pid=$pid")->select();
   //                      $childs[$ckey]['child']=$cchilds;
   //                  }
   //             }
				
			// 	$menu[$key]['child']=$childs;

			// }
   //          echo json_encode($menu);die();
            
			// $this->assign("menus",$menu);
   //  }


    protected function loadMenus()
    {  
            
            $menu =C("menus");  

            //check if i'm a teamleader
            $model = D("User");
            $uid=is_user_login();
            // if(!$model->isMcmanager($uid) && $model->isTeamleader($uid) )
              if($model->isTeamleader($uid) )
            {
                $menu=array_merge($menu,C("menus_team_leader")); 
            }

            $auth=new \Think\Auth(); 
            $Model = M("SysConfig");
            $config = $Model->find(); 
            foreach ($menu as $key => $value) {
                $url = $value['url'];
                $module = explode('/', $url); 
                if(is_user_brand())
                {
                    // if(!in_array(strtolower($module[0]), json_decode($config['default_role'])))
                    //                 {                                      
                    //                     if(!$auth->check($module[0],is_user_login(),2))
                    //                      {  
                    //                         unset($menu[$key]);
                    //                         continue;
                    //                      }
                    //                  }  
                    
                    if($module[0]!="Brand")
                    {
                         unset($menu[$key]);
                                            continue;
                    }
                }
                else
                { 
                                    if( $module[0]!='Teamleader' &&  !$auth->check($module[0],is_user_login(),2))
                                         { 
                                            unset($menu[$key]); 
                                            continue;
                                         }
                } 
            }
         
            $brand_id=get_brand_id();
            if($brand_id==35)
            {
                $isReception = D("User")->isReception(UID); 
                if($isReception)
                {
                    foreach ($menu as $key => $value) {
                       if($value['title']=="前台")
                       {
                            $menu[$key]['child'][]=array("id"=>0,"title"=>"活动","pid"=>4,"url"=>"Reception/Spider/index");
                       }
                    }
                }
            } 
            $this->assign("menus",$menu);
    }


    protected function getClub($club_id,$brand_id=null)
    {
        $model = M("Club");
        $club = $model->find($club_id);

        $brand_id=empty($brand_id)? get_brand_id():$brand_id;
        if(empty($club))
        {
            $this->error("会所不存在!");
        }
        if($club['brand_id'] != $brand_id)
        {
            $this->error("无权操作此会所!");
        }
        return $club;

    }




//basic operation
public  function indexAction()
    {   
        $this->display();
    }
 protected function getModel()
 {
    return new \Think\MOdel();
 }
    
    protected function add()
    { 
        $model =$this->getModel();
      unset($_POST['id']);  
        if(!$model->create())
        {
            $response=array("success"=>false,"message"=>$model->getError());
            $this->ajaxReturn($response);
        } 
        $id=$model->add();  
        if(!$id)
        {
             $response=array("success"=>false,"message"=>"Error");
             $this->ajaxReturn($response);
        }  
        $response=array("success"=>true,"message"=>"success!","new_id"=>$id);
        $this->ajaxReturn($response);
    }
    protected function edit()
    {
       $model =$this->getModel();
        $id=I("id");
        if(!$model->create())
        {
            $response=array("success"=>false,"message"=>$model->getError(),"new_id"=>$id);
            $this->ajaxReturn($response);
        } 
        $model->save(); 
        $response=array("success"=>true,"message"=>"success!","new_id"=>$id);
        $this->ajaxReturn($response);
    }
    protected function del()
    { 
        $id=I("id");
       $model =$this->getModel();
        $ret=$model->where(array("brand_id"=>get_brand_id()))->delete($id);
        if(!$ret)
        {
            $response=array("success"=>false,"message"=>"failed!","new_id"=>$id);
            $this->ajaxReturn($response);
        } 
        $response=array("success"=>true,"message"=>"failed!","new_id"=>$id);
        $this->ajaxReturn($response);
    }
 
    public function setAction()
    {
        $oper = I("oper");       
        switch ($oper) {
            case 'add':
                $this->add();
                break;
            case 'edit':
                $this->edit();
                break;
            case 'del':
                $this->del();
                break;
            default:
                $response=array("success"=>false,"message"=>"unknow operation!","new_id"=>0);
                $this->ajaxReturn($response);
                break;
        }        
    }

    // /**
    //  * [buildSql description]
    //  * @param  [type] $result_filed  array("a.id","b.cid")
    //  * @param  [type] $filters   '{"groupOp":"AND","rules":[{"field":"card_id","op":"eq","data":"11"},{"field":"name","op":"eq","data":"22"},{"field":"phone","op":"eq","data":"33"}]}';
    //  * @param  [type] $tables  array("table1","table2","table3")
    //  * @param  [type] $relation  array("table1.id=table2.id")
    //  * @param  [type] $query_filed  array("card_id"=>"table1.id","name"=>"table2.name")
    //  * @return [type]           [description]
    //  */
    // protected function buildEasySql($result_filed,$filters,$tables,$query_filed,$relation)
    // {
    //      $filters = json_decode($filters); 
    //      $sql="SELECT ";
    //      foreach ($result_filed as $key => $value) {
    //          $sql.="$value,";
    //      }
    //      $sql.=" FROM ";
    //      foreach ($tables as $key => $value) {
    //          $sql.=" $value,";
    //      } 
    //      $sql.="WHERE ";
    //     if($filters->groupOp=='AND')
    //     {
    //         $rules = $filters->rules; 
    //         foreach ($rules as $key => $value) {
    //                 if($key!=0)$sql.=" AND ";
    //                 if(!empty($query_filed[$value->field]))
    //                 {
    //                     $sql.=$query_filed[$value->field]." ".$value->op." "."'{$value->data}'";
    //                 }
    //                 else
    //                 {
    //                     $sql.=$tables[0].".{$value->field}"." ".$value->op." "."'{$value->data}'";
    //                 } 
    //             }
    //     }
    //     foreach($relation as $key => $value)
    //     {
    //         $sql.=" AND $value ";
    //     }
    //     return $sql;
                 
    // }
       

    public function printreceiptsAction($id)
    { 
        $service=\Service\CService::factory("Financial"); 
        $history=$service->getPayRecord($id);
        $this->assign("history",$history);  
        $project=M("BillProject")->find($history["bill_project_id"]);
        $this->assign("bill",$project); 
        $num=1;
        $items=array();
        switch ($project['type']) {
            case '8':
                $title="PT定金收费";
                break;
            case '9':
                $title="会籍定金收费";
                break;
            case '10':
                $title="退卡费用";
                break;
            case '0':
                $title="合同收款";
                $items[]=array("key"=>"合同类型","value"=>"新办合同");
                break;
            case '1':
                $title="PT合同收款";
                break;
            case '2':
                $order_id = $project['object_id'];
                $order = M("GoodsSaleList")->where(array("order_id"=>$order_id))->select();

                $title="商品收款";
                break;
            case '3':
                $title="转让收款";
                $items[]=array("key"=>"合同类型","value"=>"转让合同");
                break;
            case '4':
                $title="续会收款";
                $items[]=array("key"=>"合同类型","value"=>"续会合同");
                break;
             case '5':
                $title="升级收款";
                $items[]=array("key"=>"合同类型","value"=>"升级合同");
                break;
             case '7':
                $title="充值收款";
                break;
            
            default:
                # code...
                break;
        }
        $head="收款票据";
        if($history['is_printed']>0)
        {
            $head=$head."(补)"; 
        }
        $this->assign("title",$title);
        $this->assign("head",$head);
        if(empty($order))
        {
            $order=array(array("goods_name"=>$title,"number"=>1,"price"=>$project['price']));
        }
        $this->assign("order",$order);
       
        if($project['type']==0 || $project['type']==3 ||$project['type']==4 ||$project['type']==5)
        {
             $contract = M("Contract")->find($project['object_id']);
             $card_type=M("CardType")->find($contract['card_type_id']);
             $items[]=array("key"=>"购买卡种","value"=>$card_type['name']); 
             if(!empty($contract['mc_id']))
             {
                $mc= M("UserExtension")->find($contract['mc_id']);
                $items[]=array("key"=>"会籍顾问","value"=>$mc['name_cn']);
             } 
             else
             {
                $items[]=array("key"=>"会籍顾问","value"=>"");
             }
        }
        else if($project['type']==1 )
        {
            $contract = M("PtContract")->find($project['object_id']);
            switch ($contract['sale_type']) {
                case '1':
                    $type="新会员购买";
                    break;
                case '2':
                    $type="续课";
                    break;
                case '3':
                    $type="POS销售";
                    break;
                case '4':
                    $type="场地开发";
                    break; 
                default:  
                    break;
            }
            $items[]=array("key"=>"合同类型","value"=>$type);
            if(!empty($contract['pt_id']))
             {
                $mc= M("UserExtension")->find($contract['pt_id']);
                $items[]=array("key"=>"私教名","value"=>$mc['name_cn']);
             } 
             $class_id=$contract['class_id'];
             $class=M("PtClass")->find($class_id);
             $items[]=array("key"=>"课程名称","value"=>$class['name']);
             $num=$contract['total_num'];
        }

         $this->assign("num",$num);
        $this->assign("items",$items); 
        $club = M("Club")->find(get_club_id());
        $cashier = M("UserExtension")->find($history['record_id']);
        if(empty($cashier))
        {
            $brand = M("Brand")->find($history['brand_id']);
            $this->assign("cashier",$brand['brand_name']);
        }
        else 
        $this->assign("cashier",$cashier['name_cn']);

        $member=M("MemberBasic")->find($project['member_id']);
        $this->assign("member",$member); 
        $this->assign("club",$club);
        $this->assign("print_time",date('Y-m-d H:i:s'));  

        M("PayHistory")->where(array("id"=>$id))->setInc("is_printed"); 
        $new_printer_club = C("new_printer_club");
        $club_id= get_club_id();
        if(in_array($club_id, $new_printer_club))
        {
            $this->display(('Common@Base:printreceiptsnew'));
        }
        else
        { 
            $this->display(('Common@Base:printreceipts'));
        }
        
    } 

 }
