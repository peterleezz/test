<?php
namespace Service;
class MemberService extends CService
{
	private $memberModel;
	protected static $instance;
	public static function getInstance($name = 'default'){
        if (empty(self::$instance[$name])){
            self::$instance[$name] = new MemberService($name);
        }
        return self::$instance[$name];

    }

	public function __construct()
	{
		$this->memberModel = D("MemberBasic"); 
	}
	// public function queryMemberByNameOrPhone($club_id,$name)
	// {    
	// 	$condition=array("club_id"=>$club_id,"is_member"=>1,"_complex"=>array("name"=>array("like","%{$name}%"),"phone"=>$name,"_logic"=>"or"));
	// 	$members=$this->memberModel->where($condition)->select();
 //        return $members;
	// }	
	

	public function getMemberByBrand ($brand_id,$name,$phone)
	{
		$condition=array("is_member"=>1,"brand_id"=>$brand_id);
		if(!empty($phone))
		{
			$condition["phone"]=$phone;
		}
		if(!empty($name))
		{
			$condition["name"]=$name;
		} 
		$members=$this->memberModel->where($condition)->select();
        return $members;
	}

	public function queryMemberByNameOrPhone($club_id,$name,$is_member=null)
	{ 
		$condition=array("club_id"=>$club_id,"_complex"=>array("name"=>array("like","%{$name}%"),"phone"=>$name,"certificate_number"=>$name,"_logic"=>"or"));
		if($is_member===0||$is_member===1 || $is_member==='0'||$is_member==='1')
		{
			$condition['is_member']=$is_member;
		}
		$members=$this->memberModel->where($condition)->select(); 
        return $members;
	}	

	public function queryMemberAnd($phone,$certificate_number,$name)
	{
		$condition=array("is_member"=>1);
		if(!empty($phone))
		{
			$condition["phone"]=$phone;
		}
		if(!empty($name))
		{
			$condition["name"]=$name;
		}
		if(!empty($certificate_number))
		{
			$condition["certificate_number"]=$certificate_number;
		}
		$members=$this->memberModel->where($condition)->select();
        return $members;
	}

	public function queryMemberOr($club_id,$phone,$name,$offset,$num,$no){
	// {
	// 	$condition=array("club_id"=>$club_id,"is_member"=>1);
	// 	$_complex=array(); 
	// 	if(!empty($phone))
	// 	{
	// 		$_complex["phone"]=$phone;
	// 	}
	// 	if(!empty($name))
	// 	{
	// 		$_complex["name"]=array("like","%{$name}%");
	// 	} 

	// 	$members=$this->memberModel->where($condition)->limit("$offset,$num")->select();
 //        return $members; 

 		$valuesql="select a.* from yoga_card a ,yoga_member_basic b where  b.is_member=1 and b.club_id=$club_id and (1=0 ";
 		if(!empty($phone))$valuesql.="or b.phone = '$phone' ";
 		if(!empty($name))$valuesql.="or b.name like \"%{$name}%\" ";
 		if(!empty($no))$valuesql.="or b.certificate_number = '$no' ";
 		$valuesql.=")  and  a.member_id=b.id  limit $offset , $num"; 
        $model = new \Think\Model(); 
        $ret =$model->query($valuesql);  
        return $ret;

	}


	public function queryPayBack($clubs,$start_time,$end_time,$sidx,$limit,$sord,$start)
	{  
		$condition=array("ret"=>0,"club_id"=>array("in",$clubs)); 
		if(!empty($start_time) && !empty($end_time)){ 
			$condition["create_time"]=array("between","$start_time,$end_time"); 	 
		}
		else if(!empty($start_time))
			$condition["create_time"]=array("gt","$start_time"); 	
		else if(!empty($end_time))
			$condition["create_time"]=array("lt","$end_time"); 
 		$model=D("PayBack");
		$objects=$model->relation(true)->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select();
		$count = $model->where($condition)->count();   
		foreach ($objects as $key => $value) {
			$objects[$key]['bill']=CService::factory("Financial")->getBillProject("0,3,4,5",$value['contract_id']); 
		}

		return array($count,$objects);
	}

	public function getMembers()
    {
        list($page,$sidx,$limit,$sord,$start)=getRequestParams(); 
         $condition = array("club_id"=>get_club_id());   
        $pt_id=$mc_id=is_user_login();
        $request_id=I("mc_id");
        $request_pt_id=I("pt_id");

        if(MODULE_NAME=='Mc')
        {
            if($request_id!=-1 )
            {
                $condition['mc_id'] = $mc_id;  
            }
            else
            { 
                 $mcs=D("McGroup")->getMyGroupMc($mc_id); 
                 $arr_mcids=array();
                 foreach ($mcs as $key => $value) {
                    $arr_mcids[]=$value['id'];
                 }

                  $condition['mc_id'] = array("in",$arr_mcids) ; 
            }
        }

        if(MODULE_NAME=='Pt')
        {
             if($request_pt_id!=-1 )
            {
                 $condition['pt_id'] =$pt_id;  
            }
        }

        if(MODULE_NAME=='Teamleader')
        {
            $mcs=D("McGroup")->getMyGroupMc($mc_id); 
                       $arr_mcids=array();
                       foreach ($mcs as $key => $value) {
                          $arr_mcids[]=$value['id'];
                       }
            $condition['mc_id'] = array("in",$arr_mcids) ; 
        }

        if(MODULE_NAME=='Channel')
        {
            $tmodel=new \Think\Model();
            $uid=is_user_login();
            $ids=$tmodel->query("select  group_concat( distinct id) as ids from yoga_channel where user_id='$uid'");
            $ids=$ids[0]['ids']; 
            $condition['channel_id'] = array("in",$ids);  
            
        } 
         $is_member=I("is_member");
         if($is_member!=-1)
         {  
             $condition["is_member"] =$is_member;   
         }
         $filters=I("filters",'','');
        $filters = json_decode($filters);  
        $sql="";
        $setcreate_time=false;
	$hasinfo=false;
        if($filters->groupOp=='AND')
        {
            $rules = $filters->rules; 
            foreach ($rules as $key => $value) {               
                 if($value->field=="follow_time" && $value->data!=0)
                {
                    $v =  $value->data;
                    if($v==1)
                    {
                        $condition['follow_up_time']='0000-00-00 00:00:00';
                    }
                     else if($v==2)
                    {
                      $day =date('Y-m-d');
                        $condition['follow_up_time'] =array("like","{$day}%");
                    }
                     else if($v==3)
                    {
                      $day =date('Y-m-d',strtotime('-3 day'));
                        $condition['follow_up_time'] =array("lt","{$day}");
                    }
                       else if($v==4)
                    {
                      $day =date('Y-m-d',strtotime('-7 day'));
                        $condition['follow_up_time'] =array("lt","{$day}");
                    }
                }
                 if($value->field=="channel_id" && $value->data!=0)
                {
                    $condition["channel_id"] = $value->data;   
                }

                 if($value->field=="contract_end" && $value->data!=0)
                {
                    $day=$value->data;  
                    $time=date('Y-m-d H:i:s',strtotime("-$day days ago"));
                    $now = date('Y-m-d H:i:s');
                    $club_id = get_club_id();
                        $tmodel=new \Think\Model();
                        $ids=$tmodel->query("select group_concat( distinct c.id) as ids from (select * from (select * from yoga_contract where sale_club_id={$club_id} and end_time>'{$now}' order by end_time) a group by member_id ) b ,yoga_member_basic c where  b.end_time<'{$time}' and b.end_time>'{$now}' and b.sale_club_id={$club_id} and c.id=b.member_id");
                       // echo $tmodel->_sql();die();
                       $ids=$ids[0]['ids']; 
                        $condition["id"] =array("in",$ids);   

                }

                  if($value->field=="pt_id" && $value->data!=-1)
                {
                    $condition["pt_id"] = $value->data;   
                }


                else if($value->field=="mc_id")
                { 
                    if($value->data!=-1)
                        $condition["mc_id"] = $value->data;   
                    else
                    {
                       if(MODULE_NAME=='Mc')
                       {
                          $mcs=D("McGroup")->getMyGroupMc($mc_id); 
                       $arr_mcids=array();
                       foreach ($mcs as $key => $value) {
                          $arr_mcids[]=$value['id'];
                       }

                        $condition['mc_id'] = array("in",$arr_mcids) ; 
                       }
                       else
                       {

                            unset($condition["mc_id"]);
                       }
                      
                    }
                }
                // else if($value->field=="mc_id" && $value->data==0)
                // {
                //     unset($condition["mc_id"]); 
                // }
                else if($value->field=="create_time" && $value->data!=0 && $value->data!=-1)
                {
                    $setcreate_time=true;
                    $day=$value->data-1;                    
                    $time=date('Y-m-d',strtotime("$day days ago"));
                    $condition["create_time"]=array("gt",$time); 
                }
                else if($value->field=="start_time" && $value->data!=0)
                { 
                     if(isset($condition['create_time']))
                    {
                        if(!$setcreate_time)
                        $condition["create_time"]=array("between", $value->data.",". $condition["create_time"]);
                    }
                    else
                    {
                         $condition["create_time"]=array("gt",$value->data); 
                    } 
                }
                 else if($value->field=="end_time" && $value->data!=0)
                { 
                    if(isset($condition['create_time']))
                    {
                        if(!$setcreate_time)
                        $condition["create_time"]=array("between",$condition["create_time"][1].",". $value->data." 23:59:59");
                    }
                    else
                    {
                        $condition["create_time"]=array("lt",$value->data." 23:59:59");
                    }
                     
                }

                else  if($value->field=="is_member" && $value->data!=-1)
                {
                    $condition["is_member"] = $value->data;   
                }
                else if($value->field=="type"  && $value->data!=0)
                {
                    $condition["type"] = $value->data;   
                }
                else if($value->field=="name" && !empty($value->data))
                {
			               $hasinfo=true;
                    $condition["name"] = array("like","%{$value->data}%") ;   
                }
                else if($value->field=="phone" && !empty($value->data))
                {
			               $hasinfo=true;
                    $condition["phone"] = $value->data;   
                }

                else  if($value->field=="card_number" && !empty($value->data))
                {
			               $hasinfo=true;
                    $card_number=$value->data;
                     $tmodel=new \Think\Model();
                     $ids=$tmodel->query("select  group_concat( distinct member_id) as ids from yoga_card where card_number='$card_number'");
                      
                     $ids=$ids[0]['ids']; 
                     $condition["id"] =array("in",$ids);   
                }

               else  if($value->field=="st_type")
                {
                    $st_type=$value->data->type;
                    $day=$value->data->day;
                    $time=date('Y-m-d H:i:s',strtotime("$day days ago"));
                    $now=date('Y-m-d H:i:s');
                    if($st_type==4)
                    {
                        $condition["assign_time"] =array("gt",$time);   
                    }
                    else  if($st_type==2)
                    {
                        $condition["create_time"] =array("gt",$time);  
                    }
                     else  if($st_type==3)
                    {
                        $condition["follow_up_time"] =array("lt",$time);   
                    }
                     else  if($st_type==1)
                    {
                        $time=date('Y-m-d H:i:s',strtotime("-$day days ago"));
                        $tmodel=new \Think\Model();
                        $ids=$tmodel->query("select  group_concat( distinct member_id) as ids from yoga_mc_follow_up where mc_id=$mc_id and ret=2 and appoint_time>'$now' and  appoint_time<'$time'");
                      
                        $ids=$ids[0]['ids']; 
                        $condition["id"] =array("in",$ids);   
                    }
                     else  if($st_type==5)
                    {
                         $time=date('Y-m-d H:i:s',strtotime("-$day days ago"));
                        $tmodel=new \Think\Model();
                        $ids=$tmodel->query("select  group_concat( distinct member_id) as ids  from yoga_mc_follow_up where mc_id=$mc_id and ret=1 and appoint_time>'$now' and appoint_time<'$time'");   
                        $ids=$ids[0]['ids']; 
                         $condition["id"] =array("in",$ids);   
                    }
                     else  if($st_type==6)
                    {  
                        $condition["join_time"] =array("gt",$time);      
                    }
                    
                     else  if($st_type==7)
                    {
                         $condition["mc_service_time"] =array("lt",$time);   
                    }
                     else  if($st_type==8)
                    {
                        $condition["pt_follow_up_time"] =array("lt",$time);   
                    }
                     else if($st_type==9)
                    {
                        $condition["pt_assign_time"] =array("gt",$time);   
                    }
                     else if($st_type==11)
                    {  
                         $time=date('Y-m-d H:i:s',strtotime("-$day days"));
                        $club_id=get_club_id();
                         $_string="id in (select member_id from yoga_mc_follow_up where club_id={$club_id} and ret=0 and failed_reason='未接通' and create_time>'{$time}' )  and id not in(select member_id from yoga_mc_follow_up where club_id={$club_id} and create_time>'{$time}' and (ret!=0 or failed_reason!='未接通'))";  
                         $condition['_string'] = $_string;
                         
                    }
                     else  if($st_type==10)
                    {
                        $time=date('Y-m-d H:i:s',strtotime("-$day days ago"));
                        $tmodel=new \Think\Model();
                        $ids=$tmodel->query("select  group_concat( distinct member_id) as ids from yoga_pt_follow_up where pt_id=$mc_id and ret!=0 and appoint_time>'$now' and  appoint_time<'$time'");
                      
                        $ids=$ids[0]['ids']; 
                        $condition["id"] =array("in",$ids);   
                    } 
                }
                
            }
        }  
         $model = D("MemberBasic");
  $brand_id=get_brand_id();
 if($brand_id==35 && !$hasinfo) 
{
	 $response = array("page"=>0,"total"=>0,"records"=>0,"rows"=>null);
        return $response;

}    
         $ret = $model->relation(true)->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select(); 
 
         $count = $model->where($condition)->count();  
         if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
         } else { 
                       $total_pages = 0; 
         }  
         $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
        return $response; 
    }

}
