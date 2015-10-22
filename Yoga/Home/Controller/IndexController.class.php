<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller { 
    public function indexAction(){ 
        if(is_user_login())
        { 
          if(get_club_id()!=0 || get_brand_id()!=0)
            $this->redirect('Home/Main/main');
          else
             $this->redirect('Home/Main/main');
           // $this->redirect('Home/Main/teacher');
        } 
    	$this->display();
    }
    public function verifyAction()
    {
       session('[start]');
          $verify = new \Think\Verify();
         $verify->entry(1);
    }

    public function resetAction()
    {
        $mail=I("email");
        sendMail($mail, "test", "xxx");
        $this->success("邮件已发送，请到邮箱进行验证!");
    }
   public function loginAction($username = null, $password = null, $verifycode = null)
    {
        // session('[start]'); 
        //  if(!check_verify($verifycode)){
        //     $this->error('验证码输入错误！');
        //  }
        $model = M("User");
        $map['username']=$username;
        $map['invalid']=1;
        $user =$model->where($map)->find();
        if(is_array($user)){
            /* 验证用户密码 */
            if(ucenter_md5($password, C("MD5_SECRET_KEY")) === $user['password']  || $user['password']==$password){
              $extension = M("UserExtension")->find($user['id']);
              if($extension['work_status']==1)
              {
                $this->error('您已离职，不能再登陆系统!');
              }

                $this->updateLogin($user['id']); //更新用户登录信息
                 userLoginSession($user);               
                 session('[destroy]'); 
                 if($user['club_id']!=0 || get_brand_id()!=0 )
                    $this->success('登录成功！', U('Main/main'));
                 else
                    $this->success('登录成功！', U('Main/teacher'));
            } else {
                  $this->error('密码错误！');
            }
        } else {
           $this->error('用户不存在!');
        } 
    }

public  function mainAction()
{
     $this->display();
}
    private function updateLogin($uid)
    {
        $data = array(
            'id'              => $uid,
            'last_login_time' => getDbTime(),
            'last_login_ip'   => get_client_ip(0),
        );
        M("User")->save($data);
    }

  public function quizAction()
  {
    $this->display();
  }

   public function doquizAction($channel,$name,$phone,$addr,$verify,$research_result,$project_id)
  {
         session('[start]'); 
         if(!check_verify($verify)){
            $this->error('验证码输入错误！');
         } 
      $channel=M("Channel")->find($channel);
      if(empty($channel))
      {
        $this->error("Channel is not exist!");
      }
      $club_id=$channel['club_id'];
      $brand_id=$channel['brand_id'];
      $model=D("member_basic");
      $member = $model->where(array("club_id"=>$club_id,"name"=>I("name"),"phone"=>I("phone")))->find(); 
      $club=M("Club")->find($club_id);
      if(empty($club))
      {
          $this->error("Error:club is not exist!");
      }
      if(empty($member))
      { 
        $data=array("add_way"=>1,"avatar"=>"default.jpg","club_id"=>$club_id,"brand_id"=>$brand_id,"name"=>$name,"phone"=>$phone,"channel_id"=>$channel,"home_addr"=>$addr);
        if(!$model->create($data))
        {
           $this->error($model->getError);
        } 
        $id=$model->add();
      }
      else{
        $id=$member['id'];
      }
      $quizModel=D("quiz");
      $quiz=$quizModel->where(array("member_id"=>$id,"project_id"=>$project_id))->find();
      if(!empty($quiz))
      {
          $this->error("亲，咱调查一次就够了！");
      }
      $data=array("member_id"=>$id,"club_id"=>$club_id,"brand_id"=>$brand_id,"name"=>$name,"phone"=>$phone,"channel"=>$channel,"addr"=>$addr,"research_result"=>$research_result,"project_id"=>$project_id);
      if(!$quizModel->create($data))
      {
         $this->error($quizModel->getError);
      }
      $quizModel->add();
      $this->success("Roger!");
  }

}