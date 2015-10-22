<?php
namespace Common\Model;
use Think\Model;
class NoticeModel extends Model {
    protected $_validate = array( 
        array('start_time','require','请选择通知的开始生效时间!',self::MUST_VALIDATE),
        array('end_time','require','请选择通知的结束生效时间！',self::MUST_VALIDATE),
        array('content','require','请输入内容!',self::MUST_VALIDATE),  
  );
 
   protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'), 
       array('create_time','getDbTime',self::MODEL_INSERT,'function'), 
       array('brand_id','get_brand_id',self::MODEL_BOTH,'function'), 
       array('user_id','is_user_login',self::MODEL_BOTH,'function'), 
    ); 

  	public function getNotice()
  	{ 
  		list($page,$sidx,$limit,$sord,$start)=getRequestParams();
			 
			$brand_id = get_brand_id();
			$condition = array("brand_id"=>$brand_id);	 
			$notice = $this->where($condition)->order("$sidx $sord")->limit("$start,$limit")->select(); 
			$count = 	$this->where($condition)->count();	
			if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
			} else { 
			              $total_pages = 0; 
			} 	 
			$response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$notice);
			return $response;
  	}

  	public function getLatestNotice($brand_id)
  	{
  		$timenow = date('Y-m-d H:i:s');
  		$condition = array("brand_id"=>$brand_id,"start_time"=>array("lt",$timenow),"end_time"=>array("gt",$timenow));
  		$ret = $this->where($condition)->order("id desc")->find(); 
  		// if(empty($ret))
  		// {
  		// 	$ret = $this->where("brand_id=$brand_id")->order("id desc")->find();
  		// }
  		return $ret;
  	}
    
}