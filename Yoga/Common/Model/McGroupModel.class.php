<?php
namespace Common\Model;
use Think\Model\RelationModel;
class McGroupModel extends RelationModel {
    protected $_validate = array(  
        array('name','require','请输入组名!',self::MUST_VALIDATE),  
  );
 
   protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'),  
       array('brand_id','get_brand_id',self::MODEL_BOTH,'function'), 
       array('club_id','get_club_id',self::MODEL_BOTH,'function'), 
    ); 
    protected $_link = array( 
   
      'team_leader'=>array(
          "mapping_type"=>self::BELONGS_TO,
          "class_name"=>"UserExtension",
          "mapping_name"=>"team_leader",
          'foreign_key'=>"team_leader_id",
            'relation_foreign_key'  =>  'id',
            'relation_table'    =>  'yoga_user_extension',
            'mapping_fields'=>"id,name_cn"
        ) ,   
     );  


  	 public function getGroups()
    { 
      list($page,$sidx,$limit,$sord,$start)=getRequestParams();
       
      $club_id = get_club_id();
      $condition = array("club_id"=>$club_id);   
      $notice = $this->where($condition)->relation(true)->order("$sidx $sord")->limit("$start,$limit")->select(); 
      $count =  $this->where($condition)->count();  
      if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
      } else { 
                    $total_pages = 0; 
      }    
      $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$notice);
      return $response;
    }

    public function getAllGroups($club_id)
    {
       $condition = array("club_id"=>$club_id);  
       return $this->where($condition)->relation(true)->select();
    }

    public function getMcs()
    {
       list($page,$sidx,$limit,$sord,$start)=getRequestParams(); 
        $club_id=empty($club_id)?get_club_id():$club_id;
        $where="a.id=b.id and a.id=c.uid and b.club_id=$club_id and c.group_id=6";
            $filters=I("filters",'',''); 
             $filters = json_decode($filters);  
       $sql="";
        if($filters->groupOp=='AND')
        {
             $rules = $filters->rules; 
            foreach ($rules as $key => $value) {  

               if($value->field=="name"&& !empty($value->data))
                {
                  $name = $value->data;
                    $where.=" and (a.name_cn like '%{$name}%' or a.name_en like '%{$name}%')"; 
                }
              }
        }
        $mcs = M()->where($where)->table(array("yoga_user_extension"=>"a","yoga_user"=>"b","yoga_auth_group_access"=>"c"))->field("a.id,a.name_cn,a.group_id,a.work_status")->order("a.group_id")->limit("$offset,$num")-> select();
       foreach ($mcs as $key => $value) {
        if($value['work_status']==1)
        {
           $group =array("name"=>"离职");
            $mcs[$key]['group']=$group;
        }
        else
        {
            if($value['group_id']!=0)
           {
              $group =$this->find($value['group_id']);
              $mcs[$key]['group']=$group;
           }
           else
           {
             $mcs[$key]['group']=null;
           }
        }
        
       }
      $count = D("User")->getMcCount ();  
      if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
      } else { 
                    $total_pages = 0; 
      }    
      $response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$mcs);
      return $response;
       
    }


    public function getMyGroupMc($id=null)
    { 
      if(empty($id))$id=is_user_login();
       $group_ids =M("McGroup")->where("team_leader_id=$id")->field("id")->select();
       $group_id=array();
       foreach ($group_ids as $key => $value) {
         $group_id[]=$value['id'];
       }
        $group_id[]=is_user_login();
       $condition = array("group_id"=>array("in",$group_id));
       $mcs = D("UserExtension")-> where($condition)->select(); 
     
      return $mcs;
       
    }
    
}