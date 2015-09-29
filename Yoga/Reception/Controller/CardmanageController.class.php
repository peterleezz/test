<?php
namespace Reception\Controller;
use Common\Controller\BaseController;
 use Service\CardService;
class CardmanageController extends BaseController {
  public function indexAction()
  {
    $this->display();
  }

  public function destroycardAction($id)
  {
        $model = M("Card");
        $card=  M("Card")->find($id);
        if(empty($card))
        {
             $this->error("card does not exist！");
        }
        if($card['status']==5 )
        {
             $this->error("非正常状态不能退卡！");
        }


        $member_id=$card['member_id'];
        $cards=D("Card")->getAllCards($member_id);
        if(count($cards)==1 && $card['status']!=4)
        {
            $this->error("此会员只有一张会员卡，不能单独退卡，请先进行退会操作！");
        }
        foreach ($cards as $key => $value) {
            if($value['id']!=$id)
            { 
                $new_id=$value['id'];
                break;
            }
        }
       
        $contracts=D("Contract")->getAllContract($id);
        foreach ($contracts as $key => $value) {
             D("Contract")->where("id=".$value['id'])-> setField(array("card_id"=>$new_id));
        }
        $service=\Service\CService::factory("Financial");
        $bill_id=$service->addBillProject(10,0,$id,$member_id,I("should_pay"),0,get_brand_id(),is_user_login(),get_club_id(),0,'');
        if(!$bill_id)
        {   
            $this->error($service->getError());
        }
        $ret = $service->pay($bill_id,0,is_user_login(),get_brand_id(),'',I("should_pay"),0,0,0,get_club_id(),0);
        if(!$ret)
        {  
            M("BillProject")->delete($bill_id);
            $this->error($service->getError());
        }

        M("Card")->where(array("id"=>$id))->setField("status",5);
        $this->success("退卡成功！",U("Reception/Cardmanage/printreceipts/id/$ret")); 
  }
 

  public function destroyAction($id)
  {
        $model = M("Card");
        $card=  M("Card")->find($id);
        if(empty($card))
        {
             $this->error("card does not exist！");
        }
        if($card['status']!=0 && $card['status']!=2)
        {
             $this->error("非正常状态不能退会！");
        }

        M("Card")->where(array("id"=>$id))->setField("status",4);
        D("CardOpHistory")->updateStatus($id,4,0);

       // $reason ="退会"; 
       // if(!empty($reason))
       // { 
       //    $data=array("extension"=>json_encode($card), "reason"=>$reason,"record_id"=>is_user_login(),"club_id"=>get_club_id(),"brand_id"=>get_brand_id(),"type"=>2,"status"=>0);
       //    M("Review")->data($data)->add();
       // }
        $contracts=D("Contract")->getAllContract($id);
        $paybackmodel=M("PayBack");
        foreach ($contracts as $key => $value) {
             $data=array("contract_id"=>$value['id'],"apply_id"=>is_user_login(),"club_id"=>get_club_id(),"brand_id"=>get_brand_id());
             $ret=$paybackmodel->where(array("contract_id"=>$value['id']))->find();
             if(empty($ret))
                M("PayBack")->data($data)->add();
        }  
        $this->success("退会成功,稽核后将有人联系此客户！");
  }

    public function lostAction($id)
    {
        $model = M("Card");
        $card=  M("Card")->find($id);
        if(empty($card))
        {
             $this->error("card does not exist！");
        }
        if($card['status']!=0 && $card['status']!=2)
        {
             $this->error("非正常状态不能挂失！");
        }

        M("Card")->where(array("id"=>$id))->setField("status",1);
        D("CardOpHistory")->updateStatus($id,1,0);

        $this->success("挂失成功！");
    }
       public function unlostAction($id)
    {
         $model = M("Card");
        $card=  M("Card")->find($id);
        if(empty($card))
        {
             $this->error("card does not exist！");
        }
        if($card['status']!=1)
        {
             $this->error("此卡未被挂失！");
        }
        M("Card")->where(array("id"=>$id))->setField("status",0);
         D("CardOpHistory")->updateStatus($id,0,1);
        $this->success("解除挂失成功！");
    }


    public function getnewAction($id)
    {
        $model =D("Card");
        $card=  M("Card")->find($id);
        if(empty($card))
        {
             $this->error("card does not exist！");
        }
        if($card['status']!=0 && $card['status']!=2)
        {
             $this->error("非正常状态不能补卡！");
        }

        unset($card['id']);
        $card_number=I('card_number');
          if(!empty($card_number) && $model->isExist($card_number,get_brand_id()))
          {
            $this->error("卡号已存在!");
          }
          if(empty($card_number))
          {
            $card_number=date("YmdHis").rand(0,10000);
          }
     
        if(!empty($card_number))
        {
           
            M("Card")->where(array("id"=>$id))->setField("card_number",$card_number);
        } 
  
        D("CardOpHistory")->updateStatus($id,2,0,$new_id);
        $this->ajaxReturn(array("new_card_number"=>$card_number,"status"=>1,"info"=>"补卡成功！新的卡号为 $card_number!"));

    }

      public function restAction($id,$start_date,$end_date)
    {
        $start_time=strtotime($start_date);
        $end_time=strtotime($end_date);

        $interval = $start_time-strtotime(date("Y-m-d"));
        if($interval<0) 
        {
            // $this-> error("起始日期必须大于当前日期!");
        }

        $interval = $end_time-$start_time;
        if($interval  <=0) 
        {
            $this->    error("终止日期必须大于起始日期！");
        }
         $model = M("Card"); 
        $card=  M("Card")->find($id);
        if(empty($card))
        {
             $this->error("card does not exist！");
        }
        if($card['status']!=0 && $card['status']!=2)
        {
             $this->error("非正常状态不能请假！");
        }

        $extension =json_encode(array("start_time"=>$start_date,"end_time"=>$end_date));

        //find all contract
        $contractModel=D("Contract");
        $contracts = D("Contract")->getAllContract($id);
        foreach ($contracts as $key => $value) {
            $valid_time =date('Y-m-d', strtotime($value['end_time'])+$interval); 
            $contractModel->where(array("id"=>$value['id']))->setField("end_time",$valid_time);
        }

        $contracts = D("PtContract")->getAllContract($card['member_id']);
        foreach ($contracts as $key => $value) {
            $valid_time =date('Y-m-d', strtotime($value['end_time'])+$interval); 
            D("PtContract")->where(array("id"=>$value['id']))->setField("end_time",$valid_time);
        }
        
        if($start_date<=date('Y-m-d'))
          M("Card")->where(array("id"=>$id))->setField(array("status"=>3,"extension"=>$extension));
        else
          M("Card")->where(array("id"=>$id))->setField(array("extension"=>$extension));
          M("Card")->where(array("id"=>$id))->setInc("rest_count",1);
        //change card valid time 
         D("CardOpHistory")->updateStatus($id,3,0,$extension);

          $rest_count=$card['rest_count'];
          $free_rest=$card['free_rest'];
          if($rest_count>=$free_rest)
          {
               $this->ajaxReturn(array("status"=>1,"info"=>"请假成功！免费请假次数已经用尽，请到商品中购买请假次数！","url"=>"/index.php/Bar/Goods/index/memberid/".$card['member_id']."/goodsid/"));
          }
          
         $this->ajaxReturn(array("status"=>1,"info"=>"请假成功！"));
         
    }

     public function unrestAction($id)
    { 
        $ret=CardService::getInstance()->unrest($id); 
        if(!$ret)
        {
            $this->error(CardService::getInstance()->getError());
        }
        $this->ajaxReturn(array("status"=>1,"info"=>"销假成功！","end_time"=>$ret)) ;
    } 

  public function queryAction()
   {  
        list($page,$sidx,$limit,$sord,$start)=getRequestParams();
        $filters=I("filters",'','');
      
        if(empty($filters))
        {
            $this->error("Error");
        } 
            $brand_id = get_brand_id();
            $club_id=get_club_id();

        $valuesql="select a.*,b.name as member_name,b.id as memberid ,b.phone from yoga_card a ,yoga_member_basic b where a.brand_id=$brand_id and a.sale_club=$club_id and a.member_id=b.id  ";
        $countsql="select count(*) as count from yoga_card a, yoga_member_basic b where a.brand_id=$brand_id and a.sale_club=$club_id and a.member_id=b.id  ";
        if(is_user_brand())
        {
             $valuesql="select a.*,b.name as member_name,b.id as memberid ,b.phone from yoga_card a ,yoga_member_basic b where a.brand_id=$brand_id and a.member_id=b.id  ";
             $countsql="select count(*) as count from yoga_card a, yoga_member_basic b where a.brand_id=$brand_id and a.member_id=b.id  ";
        }
       $filters = json_decode($filters);  
       $sql="";
        if($filters->groupOp=='AND')
        {
            $rules = $filters->rules;
           $hasInfo=false; 
            foreach ($rules as $key => $value) { 
             $hasInfo=true;
                if($value->field=="card_id")
                {
                    $sql.=" and a.card_number ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                 if($value->field=="name")
                {
                    $sql.=" and b.name ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                 if($value->field=="phone")
                {
                    $sql.=" and b.phone ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                
            }

		if(!$hasInfo)
		{
			$response = array("page"=>0,"total"=>0,"records"=>0,"rows"=>null);
         $this->ajaxReturn($response);
		}
        } 
        $model = new \Think\Model();
        $countsql=$countsql." ".$sql;
        $count=$model->query($countsql);
        $count=$count[0]["count"];
        $valuesql = $valuesql." ".$sql." order by $sidx $sord limit $start,$limit";

         $ret =$model->query($valuesql);  
         if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }     
         $contractModel = D("Contract");
         $clubModel = M("Club"); 
         foreach ($ret as $key => $value) {
            $club = $clubModel->find($value['sale_club']);
            $ret[$key]['club_name']=!empty($club)? $club['club_name']:""; 
            $contracts=$contractModel->getAllContract($value['id']); 
            $cardsname="";
            foreach ($contracts as $c_k => $c_v) {
                if($c_k!=0)$cardsname.="|";
                $cardsname.=$c_v['card_type']['name']."(".$c_v['start_time']."--".$c_v['end_time'].")"; 
            } 
            // if(!isset($ret[$key]['club_name']))
            // {
            //           $ret[$key]['club_name']='相关合同已转让！';
            // }
            // 
            if($cardsname=='')
            {
               $cardsname='无相关合同！';
            }
            $ret[$key]['card_type_name']=$cardsname;
          }      
         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
         $this->ajaxReturn($response); 
   }


public function queryNewAction()
   {  
        list($page,$sidx,$limit,$sord,$start)=getRequestParams();
        $filters=I("filters",'','');
      
        if(empty($filters))
        {
            $this->error("Error");
        } 
            $brand_id = get_brand_id();
            $club_id=get_club_id();

        $valuesql=" select   a.*,c.start_time,c.end_time , c.free_rest as cfree_rest,c.rest_count as crest_count,c.card_type_extension, b.name as member_name,b.id as memberid ,b.phone from yoga_card a,yoga_member_basic b,yoga_contract c  where a.brand_id=$brand_id and a.sale_club=$club_id and a.member_id=b.id  and a.id=c.card_id";
        $countsql="select count(*) as count from yoga_card a,yoga_member_basic b,yoga_contract c where a.brand_id=$brand_id and a.sale_club=$club_id and a.member_id=b.id  and a.id=c.card_id";
        if(is_user_brand())
        {
             $valuesql=" select   a.*,c.start_time,c.end_time , c.card_type_extension,c.free_rest as cfree_rest,c.rest_count as crest_count, b.name as member_name,b.id as memberid ,b.phone from yoga_card a,yoga_member_basic b,yoga_contract c where a.brand_id=$brand_id  and a.member_id=b.id  and a.id=c.card_id";
             $countsql="select count(*) as count from yoga_card a,yoga_member_basic b,yoga_contract c where a.brand_id=$brand_id  and a.member_id=b.id  and a.id=c.card_id";
        }
       $filters = json_decode($filters);  
       $sql="";
        if($filters->groupOp=='AND')
        {
            $rules = $filters->rules; 
            foreach ($rules as $key => $value) { 
                if($value->field=="card_id")
                {
                    $sql.=" and a.card_number ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                 if($value->field=="name")
                {
                    $sql.=" and b.name ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                 if($value->field=="phone")
                {
                    $sql.=" and b.phone ".getOPerationMysql($value->op)."  '{$value->data}'"; 
                }
                
            }
        } 
        $model = new \Think\Model();
        $countsql=$countsql." ".$sql;
        $count=$model->query($countsql);
        $count=$count[0]["count"];
        $valuesql = $valuesql." ".$sql." order by $sidx $sord limit $start,$limit"; 
        $clubModel = M("Club"); 
         $ret =$model->query($valuesql);  
         foreach ($ret as $key => $value) {
             $ret[$key]["card_type_extension"]=json_decode($ret[$key]["card_type_extension"]);
             $club = $clubModel->find($value['sale_club']);
            $ret[$key]['club_name']=!empty($club)? $club['club_name']:""; 
         }
         
         if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }   
         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
         $this->ajaxReturn($response); 
   }


   public function querycardophistoryAction($id)
   {
     list($page,$sidx,$limit,$sord,$start)=getRequestParams();
      $ret=D("CardOpHistory")->where("card_id=$id")->relation(true)->order("$sidx $sord")->limit("$start,$limit")-> select();

      $count=M("CardOpHistory")->where("card_id=$id")->count();  
        if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }  
         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
         $this->ajaxReturn($response); 
   }
}
