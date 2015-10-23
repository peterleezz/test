<?php
namespace Common\Controller;
use Think\Controller;
class VisitBase extends BaseController {

public function getMembersAction()
    {
         $service = \Service\CService::factory("Member");  
         $response = $service->getMembers();
         $this->ajaxReturn($response); 
    }

public function mynotmemberlistAction()
    {  
        $this->setcolshow();
        $this->assign("action",DIRECTORY_SEPARATOR.MODULE_NAME.DIRECTORY_SEPARATOR.CONTROLLER_NAME.DIRECTORY_SEPARATOR."getMembers");
        $this->setNotMemberActiveClass(); 
        $this->assign("is_member",0);    
        $this->assign("show_add",$this->show_add());    
        $this->assign("show_edit",$this->show_edit());    
        $this->assign("show_url", U("show"));    
        $this->assign("display_card_number",$this->display_card_number());   
        $this->assign("display_channel",$this->display_channel());   
        $this->assign("display_member_type",$this->display_member_type());   
        $this->assign("addurl",DIRECTORY_SEPARATOR.MODULE_NAME.DIRECTORY_SEPARATOR.CONTROLLER_NAME.DIRECTORY_SEPARATOR."index");
        $this->assign("editurl",DIRECTORY_SEPARATOR.MODULE_NAME.DIRECTORY_SEPARATOR.CONTROLLER_NAME.DIRECTORY_SEPARATOR."index".DIRECTORY_SEPARATOR."id".DIRECTORY_SEPARATOR);
        $this->display("Mc@Manage:index");
    } 
public function myismemberlistAction()
    {
         $this->setcolshow();
        $this->assign("action",DIRECTORY_SEPARATOR.MODULE_NAME.DIRECTORY_SEPARATOR.CONTROLLER_NAME.DIRECTORY_SEPARATOR."getMembers");
        $this->assign("is_member",1); 
        $this->setIsMemberActiveClass();    
        $this->assign("show_add",0);    
        $this->assign("show_edit",$this->show_edit());    
        $this->assign("show_url",U("show"));    
        $this->assign("display_card_number",$this->display_card_number());   
        $this->assign("display_channel",$this->display_channel());   
        $this->assign("display_member_type",$this->display_member_type());   
        $this->assign("addurl",DIRECTORY_SEPARATOR.MODULE_NAME.DIRECTORY_SEPARATOR.CONTROLLER_NAME.DIRECTORY_SEPARATOR."index");
        $this->assign("editurl",DIRECTORY_SEPARATOR.MODULE_NAME.DIRECTORY_SEPARATOR.CONTROLLER_NAME.DIRECTORY_SEPARATOR."index".DIRECTORY_SEPARATOR."id".DIRECTORY_SEPARATOR);
        $this->display("Mc@Manage:index");
    }
 public function myallmemberlistAction()
    {
         $this->setcolshow();
        $this->assign("action",DIRECTORY_SEPARATOR.MODULE_NAME.DIRECTORY_SEPARATOR.CONTROLLER_NAME.DIRECTORY_SEPARATOR."getMembers");
        $this->assign("is_member",-1); 
        $this->setAllMemberActiveClass();    
        $this->assign("show_add",$this->show_add());     
        $this->assign("show_edit",$this->show_edit());    
        $this->assign("show_url",U("show"));    
        $this->assign("display_card_number",$this->display_card_number());   
        $this->assign("display_channel",$this->display_channel());   
        $this->assign("display_member_type",$this->display_member_type());   
        $this->assign("addurl",DIRECTORY_SEPARATOR.MODULE_NAME.DIRECTORY_SEPARATOR.CONTROLLER_NAME.DIRECTORY_SEPARATOR."index");
        $this->assign("editurl",DIRECTORY_SEPARATOR.MODULE_NAME.DIRECTORY_SEPARATOR.CONTROLLER_NAME.DIRECTORY_SEPARATOR."index".DIRECTORY_SEPARATOR."id".DIRECTORY_SEPARATOR);
        $this->display("Mc@Manage:index");
    }

public function  setcolshow()
{

}
public function showAction($id)
    {
        $model=D("MemberBasic");
        $member = $model->relation(true)->find($id);
        if(!is_user_brand())
        {
            if($member["club_id"]!=get_club_id())
             $this->error("无权查看此用户信息");
        }
        else
        {
            if($member["brand_id"]!=get_brand_id())
             $this->error("无权查看此用户信息");
        }

        $contracts = D("Contract")->getAllContractByUid($id); 
        $this->contracts = $contracts;
        $ptcontracts=D("PtContract")->getAllContract($id);
        $this->ptcontracts = $ptcontracts;
 
        $this->assign("member",$member);
        $content =$this->fetch("Cashier@Member:show");

        $this->ajaxReturn($content);
}


public function setNotMemberActiveClass()
{
     
}
public function setIsMemberActiveClass()
{
     
}
public function setAllMemberActiveClass()
{
     
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
    return 0;
}
public function display_channel()
{
    return 0;
}
public function getMcId()
{
    return 0;
}
public function getAddWay()
{
    return 0;
}
public function getAddRedirectUrl($is_member=0)
{
    return U('Mc/Manage/index');
}

public function addAction()
    {
        $channel = I("channel_id");
        $model =D("MemberBasic");     
       if (!$model->create()){      
                $this->error($model->getError());
        }else{   

            //check if this customer is exsited
            
            $brand_id = get_brand_id();
            $club_id  = get_club_id();
            $condition = array();
            $condition['club_id']=$club_id;
            $where['phone']  = I("phone");
            $certificate_number = I("certificate_number");
            if(!empty($certificate_number))
                 $where['certificate_number']  = I("certificate_number");
            else
                $where['1']='0';
            $where['_logic'] = 'or';
            $condition['_complex']=$where;
            $member = $model->where($condition)->find();
       
            if(!empty($member))
            {   
                $this->error("此访客信息已存在，不能再添加！");
            }
                $model->avatar="default.jpg";
                if(!empty($model->mc_id))
                // $model->mc_id=$this->getMcId();
                $model->level_update_time=getDbTime();
                $rn=I('recommend_name');
                $rp=I("recommend_phone");
                if(!empty($rn) && !empty($rp))
                {
                    $recommender = M("MemberBasic")->where( array("club_id"=>get_club_id(), "phone"=>I("recommend_phone"),"name"=>I('recommend_name')))->field("id")->find();
                    if(!empty($recommender))
                    {
                        $model->recommend_id=$recommender['id'];
                    }
                } 
                $model->add_way=$this->getAddWay();
                $id = $model->add();
                if(!empty($_FILES["avatar"]["name"]))
                {
                 
                    $upload = new \Think\Upload();// 实例化上传类
                    $upload->maxSize   =     31457280 ;// 设置附件上传大小
                    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                    $upload->rootPath  =      './Public/uploads/'; // 设置附件上传根目录
                    $upload->savePath="mmb_avatar/";
                    $upload->autoSub=false;
                    $upload->replace=true;
                    $upload->saveName="$id"; 
                    $info   =   $upload->upload();
                    if(!$info) {  
                        $model->delete($id);
                        $this->error($upload->getError());
                    }else{                          
                        $avatar=$info["avatar"]['savename'];
                        $model->where("id=$id")->setField("avatar",$avatar);
                    }
                }   
        } 
        
         $this->success('成功！', $this->getAddRedirectUrl(),1);  
    }

    public function editAction()
    {
        $channel = I("channel_id"); 
        $model =D("MemberBasic");     
        $id=I("id");
        $member = $model->find($id);            
            if(empty($member))
            {   
                $this->error("此访客不存在，不能修改！");
            } 
            if(!is_user_brand())
            {
                 $is_reception = D("User")->isReception(is_user_login());
                if(!$is_reception && $member["mc_id"]!=is_user_login() && $member['record_id']!=is_user_login())
                {
                    $this->error("无权查看此用户信息");
                } 
            }
            else
            {
                if($member['brand_id']!=get_brand_id())
                {
                    $this->error("无权查看此用户信息");
                }
            }

            
       if (!$model->create()){      
                $this->error($model->getError());
        }else{   
                if($member['type']!=I('type') || $member['pre_sale']!=I('pre_sale') )
                 $model->level_update_time=getDbTime();
                $model->save(); 
                if(!empty($_FILES["avatar"]["name"]))
                {
                 
                    $upload = new \Think\Upload();// 实例化上传类
                    $upload->maxSize   =     31457280 ;// 设置附件上传大小
                    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                    $upload->rootPath  =      './Public/uploads/'; // 设置附件上传根目录
                    $upload->savePath="mmb_avatar/";
                    $upload->autoSub=false;
                    $upload->replace=true;
                    $upload->saveName="$id"; 
                    $info   =   $upload->upload();
                    if(!$info) {                 
                        $this->error($upload->getError());
                    } 
                    else
                    {
                        $avatar=$info["avatar"]['savename'];
                        $model->where("id=$id")->setField("avatar",$avatar);
                    }
                }   
        }  
          $this->success('成功！',  Cookie('__forward__'));  
         // $this->success('成功！', $this->getAddRedirectUrl($member['is_member']),1);  
    }

    public function setIndexActiveClass()
    {
         
    }
    public function indexAction()
    { 
        $this->setIndexActiveClass();
        $id=I("id");
        $this->assign("edit",DIRECTORY_SEPARATOR.MODULE_NAME.DIRECTORY_SEPARATOR.CONTROLLER_NAME.DIRECTORY_SEPARATOR."index");
        $this->assign("exist",DIRECTORY_SEPARATOR.MODULE_NAME.DIRECTORY_SEPARATOR.CONTROLLER_NAME.DIRECTORY_SEPARATOR."exist");
        $this->assign("queryRecommend",DIRECTORY_SEPARATOR.MODULE_NAME.DIRECTORY_SEPARATOR.CONTROLLER_NAME.DIRECTORY_SEPARATOR."queryRecommend");
        $this->assign("action",DIRECTORY_SEPARATOR.MODULE_NAME.DIRECTORY_SEPARATOR.CONTROLLER_NAME.DIRECTORY_SEPARATOR."add");
        if(!empty($id))
        {
            $this->assign("action",DIRECTORY_SEPARATOR.MODULE_NAME.DIRECTORY_SEPARATOR.CONTROLLER_NAME.DIRECTORY_SEPARATOR."edit");
            $model=D("MemberBasic");
            $member = $model->find($id);
            if(!is_user_brand())
            {
                $is_reception = D("User")->isReception(is_user_login());
                if(!$is_reception && $member["mc_id"]!=is_user_login() && $member['record_id']!=is_user_login() && $member["pt_id"]!=is_user_login())
                {
                    $this->error("无权查看此用户信息");
                }
            }
            else
            {
                if($member['brand_id']!=get_brand_id())
                {
                    $this->error("无权查看此用户信息");
                }
            }
            // $mc
                
            $this->assign("member",$member);
        }
        $model = M("Channel");
        $channles = $this->getchannels();
        $this->assign("channels",$channles);
        if((D("User")->isMc(is_user_login())||D("User")->isPt(is_user_login()) )&& empty($id) && MODULE_NAME!='Reception')
        {
            // $mcs=array( D("UserExtension")->find(is_user_login()));
             $mcs= D("User")->getMc();
        }
        else
        {
            $mcs= D("User")->getMc();
        } 
        
        $this->assign("mcs",$mcs);
        // $brand_id=get_brand_id();
        // $users= $model->where("a.id=b.id and a.id=c.uid and b.brand_id=$brand_id and c.group_id=18")->table(array("yoga_user_extension"=>"a","yoga_user"=>"b","yoga_auth_group_access"=>"c"))->field("a.id,a.name_cn")->select();
  //    $this->assign("users",$users);

        $model = M("Club");
        $clubs = $model->where(array("brand_id"=>get_brand_id()))->field("id,club_name")->select();

        $model = D("CardSaleclub");
        $types = $model->getCanSaleCards();
        $this->assign("types",$types);

        $this->assign("clubs",$clubs);

        // $mcs= $model->where("a.id=b.id and a.id=c.uid and b.brand_id=$brand_id and c.group_id=6")->table(array("yoga_user_extension"=>"a","yoga_user"=>"b","yoga_auth_group_access"=>"c"))->field("a.id,a.name_cn")->select();
        // $this->assign("mcs",$mcs);

        $this->display("Mc@Visit:index");
    }

    public function getchannels()
    {
        $model = M("Channel");
        $channels = $model->where(array("club_id"=>get_club_id()))->select();
        return $channels;
    }

    public function queryRecommendAction($phone)
    {
        if(empty($phone))
        {
            $this->error("empty phone number!");
        }
        $members = M("MemberBasic")->where( array("phone"=>$phone))->field("id,name")->select();
        $this->ajaxReturn(array("status"=>1,"members"=>$members));
    }

    public function existAction()
    {
        $club_id = get_club_id();
        $model=M("MemberBasic");
        $member = $model->where(array("club_id"=>$club_id,"name"=>I("name"),"phone"=>I("phone")))->find();
        if(!empty($member))
        {
            $this->ajaxReturn(array("status"=>0,"id"=>$member["id"]));
        }
        else
        {
            $this->ajaxReturn(array("status"=>1));
        }
    }
}
