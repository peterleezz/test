<?php
namespace Admin\Controller;
use Think\Controller;
use Service\SysUserService; 
class IndexController extends Controller {
    public function indexAction(){    
       $this->display();
    }

    public function loginAction($username = null, $password = null, $verifycode = null)
	{
		 // if(!check_verify($verifycode)){
   //          $this->error('验证码输入错误！');
   //       }
		$sysUserService = new SysUserService();
    $user=$sysUserService->login($username, $password);
		 if(0 < $user['id']){ //UC登录成功
              loginSession($user);
               $this->success('登录成功！', U('Admin/Brand/index'));
            } else { //登录失败
            	
                switch($user['id']) {
                    case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
                    case -2: $error = '密码错误！'; break;
                    default: $error = '未知错误！'; break; // 0-接口参数错误（调试阶段使用）
                }
                $this->error($error);
            }
		
	}

  private function init()
  {


        
         


// $model = M("AuthRule");
// $role = 'Shopkeeper';
// $model->add(array('module'=>$role,'type'=>2,'name'=>$role,'title'=>$role,'status'=>1));


    //menu manage
    // $model = M("Menu");

    // $data->title="品牌管理";
    // $data->sort=1;
    // $data->url="Brand/index";
    // $data->icon="icon-sitemap";
    // $data->status=1;
    // $model->data($data)->add();
    // $data->sort=2;$data->title="店长";$data->url="Shopkeeper/index";$data->icon="icon-home";$model->data($data)->add();
    // $data->sort=3;$data->title="财务";$data->url="Finance/index";$data->icon="icon-bar-chart";$model->data($data)->add();
    // $data->sort=4;$data->title="前台";$data->url="Reception/index";$data->icon="icon-coffee";$model->data($data)->add();
    // $data->sort=5;$data->title="水吧";$data->url="Bar/index";$data->icon="icon-beer";$model->data($data)->add();
    // $data->sort=6;$data->title="收银";$data->url="Cashier/index";$data->icon="icon-money";$model->data($data)->add();
    // $data->sort=7;$data->title="MC经理";$data->url="Mcmanager/index";$data->icon="icon-user-md";$model->data($data)->add();
    // $data->sort=8;$data->title="MC";$data->url="Mc/index";$data->icon="icon-user";$model->data($data)->add();
    // $data->sort=9;$data->title="PT经理";$data->url="Ptmanager/index";$data->icon="icon-user-md";$model->data($data)->add();
    // $data->sort=10;$data->title="PT";$data->url="Pt/index";$data->icon="icon-user";$model->data($data)->add();
    // $data->sort=11;$data->title="PT";$data->url="Pt/index";$data->icon="icon-user";$model->data($data)->add();
    // $data->sort=12;$data->title="渠道经理";$data->url="Channelmanager/index";$data->icon="icon-user-md";$model->data($data)->add();
    // $data->sort=13;$data->title="渠道";$data->url="Channel/index";$data->icon="icon-user";$model->data($data)->add();


// $data->pid=1;$data->sort=0;$data->title="员工管理";$data->url="Brand/Employee/index";$data->icon="";$model->data($data)->add();
// $data->pid=1;$data->sort=0;$data->title="会员批量延期";$data->url="Brand/Shop/delay";$data->icon="";$model->data($data)->add();
// $data->pid=1;$data->sort=0;$data->title="会籍合同查询";$data->url="Brand/Mcontract/index";$data->icon="";$model->data($data)->add();
// $data->pid=1;$data->sort=0;$data->title="基础设置";$data->url="Brand/Shop/config";$data->icon="";$model->data($data)->add();
// $data->pid=1;$data->sort=0;$data->title="稽核";$data->url="Brand/Review/index";$data->icon="";$model->data($data)->add();

// $data->pid=17;$data->sort=0;$data->title="会所信息管理";$data->url="Brand/Shop/info";$data->icon="icon-leaf";$model->data($data)->add();
// $data->pid=17;$data->sort=0;$data->title="高峰时段设置";$data->url="Brand/Shop/peak";$data->icon="icon-leaf";$model->data($data)->add();
// $data->pid=17;$data->sort=0;$data->title="商品管理";$data->url="Brand/Shop/goods";$data->icon="icon-leaf";$model->data($data)->add();
// $data->pid=17;$data->sort=0;$data->title="PT课程设置";$data->url="Brand/Shop/ptclass";$data->icon="icon-leaf";$model->data($data)->add();
// $data->pid=17;$data->sort=0;$data->title="卡种设置";$data->url="Brand/Shop/card";$data->icon="icon-leaf";$model->data($data)->add();
// $data->pid=17;$data->sort=0;$data->title="系统设置";$data->url="Brand/Shop/sysconfig";$data->icon="icon-leaf";$model->data($data)->add();

// $data->pid=18;$data->sort=0;$data->title="合同修改审批";$data->url="Brand/Review/contractchange";$data->icon="icon-leaf";$model->data($data)->add();
// $data->pid=18;$data->sort=0;$data->title="合同金额异常审批";$data->url="Brand/Review/contractexception";$data->icon="icon-leaf";$model->data($data)->add();
// $data->pid=18;$data->sort=0;$data->title="退会申请";$data->url="Brand/Review/departure";$data->icon="icon-leaf";$model->data($data)->add();
// $data->pid=18;$data->sort=0;$data->title="消费明细";$data->url="Brand/Review/consume";$data->icon="icon-leaf";$model->data($data)->add();



    // $model = M("AuthRule");
    // $model->add(array("module"=>"Brand","type"=>"2","name"=>"Brand/Index/index","title"=>"Brand index","status"=>1));
    

    // $model = M("AuthGroup");
    // $model->add(array("module"=>"Brand","type"=>"2","description"=>"Brand Group","title"=>"Brand Group","status"=>1,"rules"=>"1,2,3,4,5,6,7,8,9,10")); 

    // $model = M("AuthGroupAccess");
    // $model->add(array("uid"=>"23","group_id"=>"1")); 
    // 
    // $auth=new \Think\Auth();
    // var_dump($auth->check("Brand/Index/index","233"));
  }
	public function testAction()
	{
         $this->display();
	}
}