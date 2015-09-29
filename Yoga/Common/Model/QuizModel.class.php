<?php
namespace Common\Model;
use Think\Model;
class QuizModel extends Model {
    protected $_validate = array( 
      array('member_id','require','会员不存在!'), 
        array('cahnnel','require','渠道不存在!'),
        array('name','require','姓名不能为空!'),
        array('phone','require','手机号码不能为空!'),  
        array('research_result','require','结果不能为空!'),  
         array('project_id','require','问卷项目不能为空!'),  

  ); 
}