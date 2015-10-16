<?php
namespace Common\Model;
use Think\Model\RelationModel;
class UserModel extends RelationModel {
    protected $_validate = array(
        /* 验证用户名 */
        array('username', '1,30', "用户名至少1-30位！", self::MUST_VALIDATE, 'length'), //用户名长度不合法
        array('username', '', "用户名已被注册！", self::MUST_VALIDATE, 'unique'), //用户名被占用
        /* 验证密码 */
        array('password', '[A-Za-z0-9_]{6,30}', "密码名6-30位数字或字母！", self::MUST_VALIDATE, 'regex'), //密码长度不合法    
        array('last_login_ip', '\d+\.\d+\.\d+\.\d+', "IP 地址不合法", self::VALUE_VALIDATE, 'regex'),  
        array('confirm_password','password','确认密码不正确',self::VALUE_VALIDATE,'confirm'),
 
        array('name_cn', 'require', "请输入中文名！",self::MUST_VALIDATE,),  
         array('club_id', 'require', "请输入会所！",self::MUST_VALIDATE,),  
        array('name_en', 'require', "请输入英文名！",self::MUST_VALIDATE,),  
        // array('identity_card', '/^\d{15}$|^\d{17}(\d|[Xx])$/', "身份证号码不对！",2),   
    );

     protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'),    
    ); 


    protected $_link = array(
        'user_extension'=>array(
            "mapping_type"=>self::HAS_ONE,
            "class_name"=>"UserExtension",
            "mapping_name"=>"UserExtension",
            'foreign_key'=>"id",
        ) ,
     );

    public function getMc($club_id=null,$num=99999,$offset=0)
    {
        $club_id=empty($club_id)?get_club_id():$club_id;
        return $this->where("a.id=b.id and a.id=c.uid and b.club_id=$club_id and c.group_id=6")->table(array("yoga_user_extension"=>"a","yoga_user"=>"b","yoga_auth_group_access"=>"c"))->field("a.id,a.name_cn,a.group_id,a.work_status")->order("a.group_id")->limit("$offset,$num")-> select();
    } 

    public function getMcCount($club_id=null)
    {
        $club_id=empty($club_id)?get_club_id():$club_id;
         return $this->where("a.id=b.id and a.id=c.uid and b.club_id=$club_id and c.group_id=6")->table(array("yoga_user_extension"=>"a","yoga_user"=>"b","yoga_auth_group_access"=>"c"))->count();
   
    }

     public function getShopkeeper($club_id=null)
    {
        $club_id=empty($club_id)?get_club_id():$club_id;
        return $this->where("a.id=b.id and a.id=c.uid and b.club_id=$club_id and c.group_id=11")->table(array("yoga_user_extension"=>"a","yoga_user"=>"b","yoga_auth_group_access"=>"c"))->field("a.id,a.name_cn")->select();
    }

     public function getMcByclubs($clubs)
    {
        $club_id="";
        foreach ($clubs as $key => $value) {
            if($key!=0)$club_id.=",";
            $club_id.=$value['id'];
        } 
        return $this->where("a.id=b.id and a.id=c.uid and b.club_id in($club_id) and c.group_id=6")->table(array("yoga_user_extension"=>"a","yoga_user"=>"b","yoga_auth_group_access"=>"c"))->field("a.id,a.name_cn")->select();
    }
    public function getPtByclubs($clubs)
    {
        $club_id="";
        foreach ($clubs as $key => $value) {
            if($key!=0)$club_id.=",";
            $club_id.=$value['id'];
        } 
        return $this->where("a.id=b.id and a.id=c.uid and b.club_id in($club_id) and c.group_id=8")->table(array("yoga_user_extension"=>"a","yoga_user"=>"b","yoga_auth_group_access"=>"c"))->field("a.id,a.name_cn")->select();
    }


     public function getPt($club_id=null)
    {
        $club_id=empty($club_id)?get_club_id():$club_id;
        return $this->where("a.id=b.id and a.id=c.uid and b.club_id=$club_id and c.group_id=8")->table(array("yoga_user_extension"=>"a","yoga_user"=>"b","yoga_auth_group_access"=>"c"))->field("a.id,a.name_cn")->select();
    }


public function getPtAndTuan($club_id=null)
    {
        $club_id=empty($club_id)?get_club_id():$club_id;
        return $this->where("a.id=b.id and a.id=c.uid and b.club_id=$club_id and (c.group_id=8 or c.group_id=19)")->table(array("yoga_user_extension"=>"a","yoga_user"=>"b","yoga_auth_group_access"=>"c"))->field("a.id,a.name_cn")->select();
    }



    public function getChannelUser($club_id=null)
    {
         $club_id=empty($club_id)?get_club_id():$club_id;
        return $this->where("a.id=b.id and a.id=c.uid and b.club_id=$club_id and c.group_id=18")->table(array("yoga_user_extension"=>"a","yoga_user"=>"b","yoga_auth_group_access"=>"c"))->field("a.id,a.name_cn")->select();
    }

    public function isMc($user_id)
    {
        $model = M("AuthGroupAccess");
        $ret = $model->where(array("uid"=>$user_id,"group_id"=>6))->find();
        return !empty($ret);
    }

      public function isMcmanager($user_id)
    {
        $model = M("AuthGroupAccess");
        $ret = $model->where(array("uid"=>$user_id,"group_id"=>7))->find();
        return !empty($ret);
    }

    public function isTeamleader($user_id)
    {
        $model = M("McGroup");
        $ret = $model->where(array("team_leader_id"=>$user_id))->find();
        return !empty($ret);
    }

 public function isPt($user_id)
    {
        $model = M("AuthGroupAccess");
        $ret = $model->where(array("uid"=>$user_id,"group_id"=>8))->find();
        return !empty($ret);
    }


     public function isChannel($user_id)
    {
        $model = M("AuthGroupAccess");
        $ret = $model->where(array("uid"=>$user_id,"group_id"=>18))->find();
        return !empty($ret);
    }

     public function isReception($user_id)
    {
        $model = M("AuthGroupAccess");
        $ret = $model->where(array("uid"=>$user_id,"group_id"=>10))->find(); 
        return !empty($ret);
    }

    public function getRole($user_id)
    {
        $model = M("AuthGroupAccess");
        $ret = $model->table(array("yoga_auth_group_access"=>"a","yoga_auth_group"=>"b"))-> where("a.uid=$user_id and a.group_id=b.id")->field("b.title")->select();
       
        return $ret;
    }
}
