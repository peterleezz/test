<?php
namespace Brand\Controller;
use Common\Controller\BaseController;
class ReviewController extends BaseController {

public function editcontractAction()
{
    R("Cashier/Member/edit",array(I('id'),I('card_number'),I('btype'),I('card_type_id'),I('present_day'),I('present_num'),I('price'),I('start_time'),I('end_time'),I('active_type'))); 
}

public function queryNewAction()
{
  R("Cashier/Contract/queryNew"); 

}
	public function contractAction()
	{
    $clubs = M("Club")->where(array("brand_id"=>get_brand_id()))->field('id,club_name')->select(); 
    $this->assign("clubarray",$clubs);
    $mcs=D("User")->getMc();
    $this->assign("mcs",$mcs);
		$this->display();
	}

  public function passnewAction($id)
  {
     $bill = M("BillProject")->find($id);
     
    M("Contract")->where(array("id"=>$bill['object_id']))->setField("is_review",1);
    
     $this->success("审核通过!");
  }

public function showAction($id)
{  

    $bill = M("BillProject")->find($id);
    $this->assign("bill",$bill); 
    $contract = D('Contract')->relation('card_type')->find($bill['object_id']);  
    $member_id = $contract['member_id'];
    $member = M('MemberBasic')->find($member_id);
    $card_id=$contract['card_id'];
    $card=M("Card")->find($card_id);
    $this->assign("member",$member);
    $this->assign("card",$card);
    $this->assign("contract",$contract);

    $mc_id=$contract['mc_id'];
    if($mc_id!=0)
    {
      $mc=M("UserExtension")->find($mc_id);
      $mc_name=$mc['name_cn'];
      $this->assign("mc_name",$mc_name);
    } 
 
    $useClubs=D("CardUseclub")->getAllUseClub($contract['card_type']['id']);
    $clubs="";
    
    foreach ($useClubs as $key => $value) {
      if($key!=0)$clubs.="、";
      $clubs.=$value['club_name'];
    }
    $this->assign("useClubs",$clubs);

    //pasy history
    $service=\Service\CService::factory("Financial");  
    list($history,$count)=$service->getPayHistoryByBillId($id,0,999);
    $via=array();
    $via_cash=$via_check=$via_pos=false;
    $cashier_id=$contract['record_id'];
    foreach ($history as $key => $value) {
       if($value['cash'] > 0 && !$via_cash)
       {
         $via[]="现金/Cash";
         $via_cash=true;
       }
       if($value['check'] > 0 && !$via_check)
       {
         $via[]="支票/Check";
         $via_cash=true;
       }
       if($value['pos'] > 0 && !$via_pos)
       {
         $via[]="刷卡/Pos";
         $via_cash=true;
       }
       $cashier_id=$value['record_id']; 
    }
    $cashier=M("UserExtension")->find($cashier_id);
    $cashier_name=$cashier['name_cn'];
    $this->assign("cashier_name",$cashier_name); 
    $via=implode(",", $via);

    $this->assign("via",$via); 
    $this->assign("history",$history); 
    $this->assign("historycount",count($history)); 
    //all cardtypes that can upgrade to 
    $card_type = $card['card_type'];
    $cardtypes = D("CardType")->getAllCanUpgrade($contract['start_time'],$contract['card_type']['id']);
    $this->assign("typesarr",json_encode($cardtypes));
    $this->assign("cardtypes",$cardtypes);
    $this->assign("current_contract",json_encode($contract));

    $shopkeeper=D("User")->getShopkeeper(); 
    if(!empty($shopkeeper))
    {
      $shopkeeper_name=$shopkeeper[0]['name_cn'];
      $this->assign("shopkeeper_name",$shopkeeper_name);
    }
    
    $club = M("Club")->find(get_club_id());

    $this->assign("club",$club);
    $this->assign("print_time",date('Y-m-d H:i:s'));  
    $content =$this->fetch(""); 
    $this->ajaxReturn($content);
}

	public function queryAction()
	{
	list($page,$sidx,$limit,$sord,$start)=getRequestParams();
	        $filters=I("filters",'',''); 
	        $brand_id=get_brand_id();  
 	   $condition=array("brand_id"=>$brand_id,"type"=>0);
       // $filters = json_decode($filters);  
       // $sql="";
       //  if($filters->groupOp=='AND')
       //  {
       //      $rules = $filters->rules; 
       //      foreach ($rules as $key => $value) {  

       //      	 if($value->field=="type")
       //          {
       //          	$condition["type"]=$value->data;
       //          }
       //      }
       //  }
    $search=I("_search");
            if(!empty($search))
            {
                $condition = array_merge($condition,getOneSearchParams()) ;
            }           

        $model=D("Review"); 
        $count=$model->where($condition)->count();
        $ret=$model->relation(true)->where($condition)->order("$sidx $sord,id desc")->limit("$start,$limit")->select();   
    
        foreach ($ret as $key => $value) {
        	$contract =json_decode($value['extension'],true);
          $original_contract=!empty($value['original_extension'])?json_decode($value['original_extension'],true):null; 
        	$ret[$key]['extension']=$contract;
          $ret[$key]['original_extension']=$original_contract;
        	if($value['type']==0)
        	{ 
        		$ret[$key]['extension']["cardtype"]=M("CardType")->find($contract['card_type_id']); 
            if($original_contract!=null)$ret[$key]['original_extension']["cardtype"]=M("CardType")->find($original_contract['card_type_id']);
        		$ret[$key]['extension']['member']=M("MemberBasic")->find($contract['member_id']);
             if($original_contract!=null)$ret[$key]['original_extension']["member"]=M("MemberBasic")->find($original_contract['member_id']);

             $mc_id=$contract['mc_id'];
             if(!empty($mc_id))
             {
                $mc=M("UserExtension")->find($mc);
                $ret[$key]['extension']['mc']=$mc;
             }
        	}
        }
        if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
			} else { 
			              $total_pages = 0; 
			} 	 
			$response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
			$this->ajaxReturn($response); 
	}


public function ptQueryAction()
  {
  list($page,$sidx,$limit,$sord,$start)=getRequestParams();
          $filters=I("filters",'',''); 
          $brand_id=get_brand_id();  
     $condition=array("brand_id"=>$brand_id,"type"=>1); 
    $search=I("_search");
            if(!empty($search))
            {
                $condition = array_merge($condition,getOneSearchParams()) ;
            }     
        $model=D("Review");
        $count=$model->where($condition)->count();
        $ret=$model->relation(true)->where($condition)->order("$sidx $sord,id desc")->limit("$start,$limit")->select();   
    
        foreach ($ret as $key => $value) {
          $contract =json_decode($value['extension'],true);
          $original_contract=!empty($value['original_extension'])?json_decode($value['original_extension'],true):null; 
          $ret[$key]['extension']=$contract;
          $ret[$key]['original_extension']=$original_contract;
          if($value['type']==1)
          { 
            $ret[$key]['extension']["ptclass"]=M("PtClass")->find($contract['class_id']); 
            if($original_contract!=null)$ret[$key]['original_extension']["ptclass"]=M("PtClass")->find($original_contract['class_id']);
            $ret[$key]['extension']['member']=M("MemberBasic")->find($contract['member_id']);
             if($original_contract!=null)$ret[$key]['original_extension']["member"]=M("MemberBasic")->find($original_contract['member_id']);
          }
        }
        if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
      } else { 
                    $total_pages = 0; 
      }    
      $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
      $this->ajaxReturn($response); 
  }

public function quitQueryAction()
  {
  list($page,$sidx,$limit,$sord,$start)=getRequestParams();
          $filters=I("filters",'',''); 
          $brand_id=get_brand_id();  
     $condition=array("brand_id"=>$brand_id); 
    $search=I("_search");
    if(!empty($search))
    {
        $condition = array_merge($condition,getOneSearchParams()) ;
    }     
        $model=D("PayBack");
        $count=$model->where($condition)->count();
        $ret=$model->relation(true)->where($condition)->order("$sidx $sord,id desc")->limit("$start,$limit")->select();   
    
        foreach ($ret as $key => $value) { 
            $ret[$key]['member']=M("MemberBasic")->find($value['contract']['member_id']); 
        }
        if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
      } else { 
                    $total_pages = 0; 
      }    
      $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
      $this->ajaxReturn($response); 
  }


public function quitQueryAction_Old()
  {
  list($page,$sidx,$limit,$sord,$start)=getRequestParams();
          $filters=I("filters",'',''); 
          $brand_id=get_brand_id();  
     $condition=array("brand_id"=>$brand_id,"type"=>2); 
    $search=I("_search");
    if(!empty($search))
    {
        $condition = array_merge($condition,getOneSearchParams()) ;
    }     
        $model=D("Review");
        $count=$model->where($condition)->count();
        $ret=$model->relation(true)->where($condition)->order("$sidx $sord,id desc")->limit("$start,$limit")->select();   
    
        foreach ($ret as $key => $value) {
          $card =json_decode($value['extension'],true);
          $ret[$key]['extension']=$card;
          $ret[$key]['extension']['member']=M("MemberBasic")->find($card['member_id']);
          $contracts=D("Contract")->getAllContract($card['id']);
          $ret[$key]["contracts"]=$contracts;
        }
        if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
      } else { 
                    $total_pages = 0; 
      }    
      $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
      $this->ajaxReturn($response); 
  }

  public function payHistoryQueryAction()
  {
  list($page,$sidx,$limit,$sord,$start)=getRequestParams();
          $filters=I("filters",'',''); 
          $brand_id=get_brand_id();  
     $condition=array("brand_id"=>$brand_id,"type"=>3); 
    $search=I("_search");
    if(!empty($search))
    {
        $condition = array_merge($condition,getOneSearchParams()) ;
    }     
        $model=D("Review");
        $count=$model->where($condition)->count();
        $ret=$model->relation(true)->where($condition)->order("$sidx $sord,id desc")->limit("$start,$limit")->select(); 

        foreach ($ret as $key => $value) {
          $contract =json_decode($value['extension'],true);
          $original=!empty($value['original_extension'])?json_decode($value['original_extension'],true):null; 
          $ret[$key]['extension']=$contract;
          $ret[$key]['original_extension']=$original; 
        }

        if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
      } else { 
                    $total_pages = 0; 
      }    
      $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
      $this->ajaxReturn($response); 
  }




	public function passAction()
	{
		$ids=I("ids");
    $rt=I("result")==1?"通过":"不通过";
		$note=I("note")."(".date('Y-m-d H:i:s')."-$rt)";
		$result=I("result");
    $sql="update yoga_review set `status`=$result,`result`=$result,`note`=concat_ws(',','$note',`note`) where id in ($ids)";
    $ret = M("Review")->query($sql); 

		// M("Review")->where(array("id"=>array("in",$ids)))->setField(array("status"=>$result,"result"=>$result,"note"=>$note));
		$this->success("success");
	}


  public function consumeAction()
  {
    $clubs = M("Club")->where(array("brand_id"=>get_brand_id()))->field('id,club_name')->select(); 
    $this->assign("clubarray",$clubs); 
    $this->display();
  }

  public function queryConsumeAction()
  {
     $service = \Service\CService::factory("Member"); 
      list($page,$sidx,$limit,$sord,$start)=getRequestParams(); 
      $condition = array("brand_id"=>get_brand_id());   
      $filters=I("filters",'','');
    $filters = json_decode($filters);   
    if($filters->groupOp=='AND')
        {
            $rules = $filters->rules;
            $name="";
            $phone="";  
            foreach ($rules as $key => $value) {               
                 if($value->field=="club_id" && $value->data!=-1)
                {
                    $condition["club_id"] = $value->data;   
                } 
                else if($value->field=="name")
                {  
                   $name=$value->data;   
                }  
                 else if($value->field=="phone")
                {  
                   $phone=$value->data;   
                }  
                 else if($value->field=="contract_number")
                {  
                    $contract=M("Contract")->where(array("contract_number"=>$value->data))->find();
                    if(empty($contract))
                    {
                        $response = array("page"=>0,"total"=>0,"records"=>0,"rows"=>null);
                        $this->ajaxReturn($response); 
                    }
                    $condition["contract_id"]=$contract['id'];
                }  else if($value->field=="card_number")
                {
                    $card=M("Card")->where(array("card_number"=>$value->data))->find();
                     if(empty($card))
                    {
                        $response = array("page"=>0,"total"=>0,"records"=>0,"rows"=>null);
                        $this->ajaxReturn($response); 
                    }
                    $condition["card_id"]=$card['id'];
                }
            }
            if(!empty($name) || !empty($phone))
            {
                $members=$service->getMemberByBrand(get_brand_id(),$name,$phone);
                 if(empty($members))
                    {
                        $response = array("page"=>0,"total"=>0,"records"=>0,"rows"=>null);
                        $this->ajaxReturn($response); 
                    }
                 $ids="";
                 foreach ($members as $k => $v) {
                    if($k!=0)$ids.=",";
                        $ids.=$v['id'];
                  } 
                 $condition["member_id"]=array("in",$ids);
            }
        } 

         $model = D("CheckHistory"); 
         $ret = $model->relation(true)->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select();    
         $count = $model->where($condition)->count();  
         if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }  
         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
         $this->ajaxReturn($response); 
  }
}