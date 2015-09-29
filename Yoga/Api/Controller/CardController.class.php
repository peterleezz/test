<?php
namespace Api\Controller;
use Think\Controller;
class CardController extends Controller {
     protected $service;
     protected function _initialize(){ 
     	$this->service=\Service\CService::factory("Api"); 
    }

    
    public function uploadBodyInfoAction()
    {
     
       \Think\Log::write(json_encode(I("get.")),'DEBUG');
        \Think\Log::write(json_encode(I("post.")),'DEBUG');

        $model = M("BodyInfo");
        $data = I("post.");  
         $data['card_number']=preg_replace("/.btd/", "",  $data['cardnumber']) ;
        $club_id = I("club_id");
        $card_number= $data['card_number'];
        $card = M("Card")->where(array("sale_club"=>$club_id,"card_number"=>$card_number))->find();
          \Think\Log::write(M()->_sql(),'DEBUG');
        if(empty($card))
        {
            $member_id=0;
        }
        else
        {
            $member_id=$card['member_id'];
        }  
        $data['member_id']=$member_id;
        unset($data['UUID']);
        unset($data['FLOGACCOUNT']);
        unset($data['FDATE']);
        unset($data['FTIME']);
        unset($data['FNAME']);
         unset($data['FSEX']);
          unset($data['FMANTYPE']);
            unset($data['FPJINFO']); unset($data['FYJINFO']);unset($data['FJYINFO']);
            unset($data['FFM_HSTANDARDV']);

       
        unset($data['cardnumber']);
        $model->data($data)->add();
          \Think\Log::write($model->_sql(),'DEBUG');

        if($member_id)
        {
            $latest = M("BodyInfoLatest")->where("member_id=$member_id")->find();
            if(empty($latest))
            {
                M("BodyInfoLatest")->data($data)->add();
            }
            else
            {
                 M("BodyInfoLatest")->data($data)->save();
            }
        }
        $this->ajaxReturn(array("status"=>1,"message"=>"ok!"));
    }
 

    public function testAction()
    {
        $data=array("member_id"=>99930601,"level"=>4,"score"=>100); 
            M("YaaMember")->data($data)->add(); 
    	$service=\Service\CService::factory("Image");
        $service->updateCer(99930601);
    }

     public function indexAction()
     { 
        \Think\Log::write(json_encode(I("get.")),'DEBUG');
        \Think\Log::write(json_encode(I("post.")),'DEBUG');
     	  $cmd=I("op"); 
          $club_id=I("club"); 
     	  if(method_exists($this, $cmd))
     	  { 
     	  		return $this->$cmd();
     	  }
     	  $this->badParams();
     }

     public function response($status,$data,$err)
     {
        \Think\Log::write(json_encode(array("err"=>$err,"status"=>$status, "res"=>$data)),'DEBUG');
     	$this->ajaxReturn(array("err"=>$err,"status"=>$status, "res"=>$data));
     }
     public function badParams()
     {
     	 $this->response(-1,"","pls input correct params!");
     }
     public function get()
     {
     	$cardid=I("no");
     	$clubid=I("clubid");
     	if(empty($cardid) || empty($clubid))
     	{
     		$this->badParams();
     	}
     	list($status,$member)=$this->service->get($cardid,$clubid);
     	$err="";
     	if($status!=0)
     	{
     		$err=$this->service->getError();
     	}
     	$this->response($status==0?0:-1,$member,$err); 
     }

     public function in()
     {
     	$cardid=I("no");
     	$clubid=I("clubid");
     	if(empty($cardid) || empty($clubid))
     	{
     		$this->badParams();
     	}
     	list($status,$member)=$this->service->in($cardid,$clubid);
        $err="";
     	if($status!=0)
     	{
     		$err=$this->service->getError();
     	}
     	$this->response($status==0?0:-1,$member,$err); 
     }

     public function out()
     {
        $cardid=I("no");
        $clubid=I("clubid");
        if(empty($cardid) || empty($clubid))
        {
            $this->badParams();
        }
        list($status,$member)=$this->service->out($cardid,$clubid);
        $err="";
        if($status!=0)
        {
            $err=$this->service->getError();
        }
        $this->response($status==0?0:-1,$member,$err); 
     }

    public function find()
     {
        $mobile=I("mobile");
        $clubid=I("clubid");
        $name=I("name");
        $no=I("no");
        $offset=I("offset");
        $num=I("num");
        $offset=empty($offset)?0:$offset;
        $num=empty($num)?20:$num; 
        list($status,$member)=$this->service->find($clubid,$mobile,$name,$offset,$num,$no);
        $err="";
        if($status!=0)
        {
            $err=$this->service->getError();
        }
        $this->response($status==0?0:-1,$member,$err); 
     } 

     public function query()
     {
        $mobile=I("mobile");
        $clubid=I("clubid");
        if(empty($mobile) || empty($clubid))
        {
            $this->badParams();
        }
        list($status,$member)=$this->service->query($mobile,$clubid);
        $err="";
        if($status!=0)
        {
            $err=$this->service->getError();
        }
        $this->response($status==0?0:-1,$member,$err); 
     }

     public function bind()
     {
        $mobile=I("mobile");
        $no=I("no");
         $name=I("name");
        if(empty($mobile) || empty($no) || empty($name))
        {
            $this->badParams();
        }
        list($status,$member)=$this->service->bind($mobile,$no,$name);
        $err="";
        if($status!=0)
        {
            $err=$this->service->getError();
        }
        $this->response($status==0?0:-1,$member,$err); 
     }

      public function check()
     {
        $card=I("card");
        $time=I("time"); 
        $club_id=I("club"); 
         if(empty($club_id))
          {
            $club_id=1002;
          }
        if(empty($card) || empty($time) || empty($club_id))
        {
            $this->badParams();
        }
        $ret = $this->service->checkpeak($card,$club_id,$time);
        $ret=!$ret?1:0;
        $arr=array("busy"=>$ret); 
        $this->response(0,$arr,''); 
     } 

public function ptcheckout()
     {
        $cardid=I("no");
        $clubid=I("clubid"); 
        if(empty($cardid) || empty($clubid))
        {
            $this->badParams();
        }
        list($status,$member)=$this->service->ptout($cardid,$clubid);
        $err="";
        if($status!=0)
        {
            $err=$this->service->getError();
        }
        $this->response($status==0?0:-1,$member,$err); 
     }

     public function ptcheckin()
     {
        $cardid=I("no");
        $clubid=I("clubid"); 
        if(empty($cardid) || empty($clubid))
        {
            $this->badParams();
        }
        list($status,$member)=$this->service->ptin($cardid,$clubid);
        $err="";
        if($status!=0)
        {
            $err=$this->service->getError();
        }
        $this->response($status==0?0:-1,$member,$err); 
     }
     public function showCardAction($card_id,$club_id)
     {
        $card=M("Card")->where(array("card_number"=>$card_id))->find();
        $this->assign("card",$card);
        $member=M("MemberBasic")->find($card['member_id']);
        $this->assign("member",$member);

        list($ret,$contract) = $this->service->findOneContract($card['id'],$club_id);
        if($ret!=0)
        { 
            echo($this->service->getError());return;
        }  
         
        $this->assign("contracts",$contracts); 
        $this->display();
     }


     public function addLock()
     { 
        $model = D("Lock");
        $data = array("club_id"=>I("club_id"),"locknum"=>I("locknum"),"gender"=>I("gender"),"key"=>I("key"));
        if(!$model->create($data))
        { 
              $this->ajaxReturn(array("state"=>0,"error"=>$model->getError()));
           
        }
        $model->add();
        $this->ajaxReturn(array("state"=>1,"data"=>"添加柜子成功！"));
     }

     public function delLocks()
     {
        $ids = I("ids");
        $club_id=I("club_id");
        $model = M("Lock");
        $model->where(array("club_id"=>$club_id, "id"=>array("in",$ids)))->delete(); 
        $this->ajaxReturn(array("state"=>1,"data"=>"删除柜子成功！"));
     }

     public function  myinfo()
     {
        $club_id=I("club_id");
        $card_number=I("card_number");
        $ret = $this->service->myinfo($club_id,$card_number);
        if(!$ret)
        {
            $this->ajaxReturn(array("state"=>0, "error"=>$this->service->getError())); 
        }
        else
        {
           $this->ajaxReturn(array("state"=>1, "data"=>$ret,"error"=>$this->service->getError())); 
        } 
     }




     public function useLock($club_id,$card_number,$gender)
     {
        $club_id=I("club_id");
        $card_number=I("card_number");
        $gender=I("gender");

        $club = M("Club")->find($club_id);
        $brand_id=$club['brand_id'];


        $model = M("Lock");
           $model->where(array("club_id"=>$club_id,"last_use_card"=>$card_number))->setField(array("is_use"=>0));
         $lock = $model->where(array("club_id"=>$club_id,"last_use_card"=>$card_number,"gender"=>$gender,"is_use"=>1))->find(); 
        if(empty($lock))
        $lock = $model->where(array("club_id"=>$club_id,"gender"=>$gender,"is_use"=>0))->order("rand()")-> find(); 
        if(!empty($lock))
        {
            $card = D("Card")->getCard($card_number,$brand_id);
            if(empty($card))
            {
                 $this->ajaxReturn(array("state"=>0,"error"=>"卡号不存在！"));
            }
            $member_id=$card['member_id'];

            M("MemberBasic")->where(array("id"=>$member_id))->setField(array("confirm_sex"=>1,"sex"=>$gender?"male":"female"));
            $model->where(array("id"=>$lock['id']))->setField(array("is_use"=>1,"last_user"=>$member_id,"last_use_card"=>$card_number,"last_use_time"=>getDbTime()));
           \Think\Log::write("use lock $member_id  -- $card_number --- ".$lock['locknum'],'DEBUG');
            M("LockUseHistory")->data(array("card_id"=>$card_number,"lock_id"=>$lock['id'],"status"=>1,"via"=>0,"create_time"=>getDbTime()))->add;
             $this->ajaxReturn(array("state"=>1,"data"=>$lock));
             
        }
        else
        {
            $this->ajaxReturn(array("state"=>0,"error"=>"无空闲柜子！"));
        }
     }

     public function freeLocks()
     {
        $ids = I("ids");
        $club_id=I("club_id");
        $model = M("Lock"); 
        $model->where(array("club_id"=>$club_id, "id"=>array("in",$ids)))->setField(array("is_use"=>0)); 
        foreach ($ids as $key => $value) {
               M("LockUseHistory")->data(array("card_id"=>"0","lock_id"=>$value,"status"=>0,"via"=>1,"create_time"=>getDbTime()))->add;
              \Think\Log::write("free lock by manual ".$value,'DEBUG');
         } 
         $this->ajaxReturn(array("state"=>1,"data"=>"释放锁！"));
     }

     public function getLocks()
     {
        $club_id=I("club_id");
        $model = M("Lock");
        $locks = $model->where(array("club_id"=>$club_id))->select();
 
        $this-> ajaxReturn(array("state"=>1,"data"=>$locks));
     }

     public function myin()
     {
        $contract_id=I("contract_id");
        $club_id=I("club_id");
        $ret =$this->service->myin($contract_id,$club_id);
        if(!$ret)
        {
            $this->ajaxReturn(array("state"=>0, "error"=>$this->service->getError())); 
        }
        else
        {
            $this->ajaxReturn(array("state"=>1, "data"=>"进馆！")); 
        }
     }
	
    public function mymoretime()
    {
       $contract_id=I("contract_id");
        $club_id=I("club_id");
        $num = I("num");
        $ret =$this->service->mymoretime($contract_id,$club_id,$num);
        if(!$ret)
        {
            $this->ajaxReturn(array("state"=>0, "error"=>$this->service->getError()));
        }
        else
        {
            $this->ajaxReturn(array("state"=>1, "data"=>"进馆！"));
        }

    }
	
      public function myout()
     {
        $contract_id=I("contract_id");
        $club_id=I("club_id");

        $card_number=I("card_number");
	if(!empty($card_number))
	{
		$card =M("Card")->where(array("card_number"=>$card_number))->find();
		$checktype = $card['checktype'];
                if($checktype==0)
                   $ret =$this->service->myout($contract_id,$club_id);
	        else
                    $ret =$this->service->myptout($checktype,$club_id);

	}
	else
        $ret =$this->service->myout($contract_id,$club_id);


        if(!$ret)
        {
            $this->ajaxReturn(array("state"=>0, "error"=>$this->service->getError())); 
        }
        else
        {
            $this->ajaxReturn(array("state"=>1, "data"=>"出馆！")); 
        }
     }
    public function myptcheckout()
     {
        $contract_id=I("contract_id");
        $club_id=I("club_id");
        list($status,$member)=$this->service->ptout($cardid,$clubid);
        $err="";
        if($status!=0)
        {
            $err=$this->service->getError();
        }
        $this->response($status==0?0:-1,$member,$err); 
     }

     public function myptcheckin()
     {
        $cardid=I("card_number");
        $clubid=I("club_id"); 
       $contract_id = I("contract_id");
       $pt_id=I("pt_id");
        if(empty($cardid) || empty($clubid))
        {
            $this->badParams();
        }
        $ret=$this->service->myptin($contract_id,$clubid,$pt_id,$cardid);
    if(!$ret)
        {
            $this->ajaxReturn(array("state"=>0, "error"=>$this->service->getError()));
        }
        else
        {
            $this->ajaxReturn(array("state"=>1, "data"=>"进馆！"));
        }

	}

     public function getPts()
    {
	$club_id=I("club_id");
         $ret=D("User")->getPt($club_id);
        $this->ajaxReturn(array("state"=>1,"data"=>$ret));
    }
       
}
