<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>欢迎您登录会所管理系统</title>

  <!-- Bootstrap -->
  <link href="/Public/css//bootstrap.min.css" rel="stylesheet">

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="/Public/js//jquery.min.js"></script>
  <script src="/Public/js/jquery.validate.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="/Public/js//bootstrap.min.js"></script>
  <script src="/Public/js//login.js"></script>
  <link rel="stylesheet" href="/Public/css//font-awesome.min.css" />
  <link rel="stylesheet" href="/Public/css//login.css" />
  <script src="/Public/js//jquery.cookie.js"></script>
<script src="/Public/js/bootbox.min.js"></script>
  <!--[if IE 7]>
  <link rel="stylesheet" href="/Public/css//font-awesome-ie7.min.css" />
  <![endif]-->

  <!-- page specific plugin styles -->

  <!-- fonts -->

  <!--   <link rel="stylesheet" href="/Public/css//googlefonts.css" />
  -->
  <link rel="stylesheet" href="/Public/css//ace.min.css" />
  <link rel="stylesheet" href="/Public/css//ace-rtl.min.css" />
  <!--[if lte IE 8]>
  <link rel="stylesheet" href="/Public/css//ace-ie.min.css" />
  <![endif]-->

  <!-- inline styles related to this page -->

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

  <!--[if lt IE 9]>
  <script src="/Public/js//html5shiv.js"></script>
  <script src="/Public/js//respond.min.js"></script>
  <![endif]-->

</head>

<body class="login-layout">
  <div class="main-container">
    <div class="main-content">
      <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
          <div class="login-container">
            <div class="center">
              <h1> <i class="icon-leaf green"></i>
                <span class="red">会所</span>
                <span class="white">管理平台</span>
              </h1>
              <h4 class="blue">&copy; Yaa Co. Ltd</h4>
            </div>

            <div class="space-6"></div>

            <div class="position-relative">
              <div id="login-box" class="login-box visible widget-box no-border">
                <div class="widget-body">
                  <div class="widget-main">
                    <h4 class="header blue lighter bigger"> <i class="icon-coffee green"></i>
                      请输入登录信息
                    </h4>

                    <div class="space-6"></div>

                    <form action="<?php echo U('login');?>" method="post" id="login_form">
                      <fieldset>
                        <label class="block clearfix">
                          <span class="block input-icon input-icon-right">
                            <input type="text" class="form-control" placeholder="" name="username"/>
                            <i class="icon-user"></i>
                          </span>
                        </label>

                        <label class="block clearfix">
                          <span class="block input-icon input-icon-right">
                            <input type="password" class="form-control" placeholder="" name="password"/>
                            <i class="icon-lock"></i>
                          </span>
                        </label>

                        <!-- <label class="block clearfix">
                        <label for="verifycode" class="control-label sr-only">验证码:</label>
                        <div id="verifycode" class="col-sm-8" >
                          <span class="block input-icon input-icon-right">
                            <input type="text" class="form-control" placeholder="验证码" name="verifycode"/>
                            <i class="icon-barcode"></i>
                          </span>
                        </div>
                        <div class="col-sm-4 form-control-static">
                          <a class="reloadverify" title="换一张" href="javascript:void(0)">换一张？</a>
                        </div>
                      </label>
                      <div>
                        <img  class="verifyimg reloadverify" alt="点击切换" src="<?php echo U('Home/Index/verify');?>"></div>
                      -->
                      <div class="space"></div>

                      <div class="clearfix">

                        <button id="loginbtn" type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                          <i class="icon-key"></i>
                          登录
                        </button>
                        <button  id="refreshbtn" type="button" class="width-35 pull-right btn btn-sm btn-primary">
                          <i class="icon-refresh icon-spin"></i>
                          登录中...
                        </button>

                      </div>

                      <div class="space-4"></div>
                    </fieldset>
                  </form>

                </div>

                <div class="toolbar clearfix">
                  <div>
                    <a href="#" onclick="show_box('forgot-box'); return false;" class="forgot-password-link">
                      <i class="icon-arrow-left"></i>
                      忘记密码
                    </a>
                  </div>

                  <div>
                    <a href="#" onclick="show_box('signup-box'); return false;" class="user-signup-link">
                      教练注册
                      <i class="icon-arrow-right"></i>
                    </a>
                  </div>

                </div>
              </div>
            </div>

            <div id="forgot-box" class="forgot-box widget-box no-border">
              <div class="widget-body">
                <div class="widget-main">
                  <h4 class="header red lighter bigger">
                    <i class="icon-key"></i>
                    重置密码
                  </h4>

                  <div class="space-6"></div>
                  <p>请输入邮件地址:</p>

                  <form id="forget_form" action="<?php echo U('reset');?>">
                    <fieldset>
                      <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                          <input type="email" class="form-control" placeholder=""  name="email" id="email"/>
                          <i class="icon-envelope"></i>
                        </span>
                      </label>

                      <div class="clearfix">
                        <button type="button" class="width-35 pull-right btn btn-sm btn-danger" onclick="forget_password()">
                          <i class="icon-lightbulb"></i>
                          发送!
                        </button>
                      </div>
                    </fieldset>
                  </form>
                </div>

                <div class="toolbar center">
                  <a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
                    登录
                    <i class="icon-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>

            <div id="signup-box" class="signup-box widget-box no-border">
              <div class="widget-body">
                <div class="widget-main">
                  <h4 class="header green lighter bigger">
                    <i class="icon-group blue"></i>
                    教练注册
                  </h4>

                  <div class="space-6"></div>
                  <p>请输入详细信息:</p>

                  <form   id="teacherregist"   action="<?php echo U('Home/Teacher/regist');?>"  method="post">
                    <fieldset>
                      <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                          <input type="email" class="form-control" placeholder="Email"  id="email" name="email"/>
                          <i class="icon-envelope"></i>
                        </span>
                      </label>

                      <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                          <input type="text" class="form-control" placeholder="用户名"  id="username" name="username"/>
                          <i class="icon-user"></i>
                        </span>
                      </label>

                      <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                          <input type="password" class="form-control" placeholder="密码"  id="password" name="password"/>
                          <i class="icon-lock"></i>
                        </span>
                      </label>

                      <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                          <input type="password" class="form-control" placeholder="重复密码"  id="confirm_password" name="confirm_password" />
                          <i class="icon-retweet"></i>
                        </span>
                      </label>
  
                        <label class="block clearfix">
                        <label for="verifycode" class="control-label sr-only">验证码:</label>
                        <div id="verifycode" class="col-sm-8" >
                          <span class="block input-icon input-icon-right">
                            <input type="text" class="form-control" placeholder="验证码" name="verifycode"/>
                            <i class="icon-barcode"></i>
                          </span>
                        </div>
                        <div class="col-sm-4 form-control-static">
                          <a class="reloadverify" title="换一张" href="javascript:void(0)">换一张？</a>
                        </div>
                      </label>
                      <div>
                        <img  class="verifyimg reloadverify" alt="点击切换" src="<?php echo U('Home/Index/verify');?>"></div>
                     
                      
                      <div class="space-24"></div>

                      <div class="clearfix">
                        <button type="reset" class="width-30 pull-left btn btn-sm">
                          <i class="icon-refresh"></i>
                          重置
                        </button>

                        <button   type="submit" class="width-65 pull-right btn btn-sm btn-success" >
                          确认注册
                          <i class="icon-arrow-right icon-on-right"></i>
                        </button>
                      </div>
                    </fieldset>
                  </form>
                </div>

                <div class="toolbar center">
                  <a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
                    <i class="icon-arrow-left"></i>
                    返回登录
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
      if("ontouchend" in document)
       document.write("<script src='/Public/js//jquery.mobile.custom.min.js'>"+"<"+"/script>");</script>

<!-- inline scripts related to this page -->

<script type="text/javascript">
      function show_box(id) {
       jQuery('.widget-box.visible').removeClass('visible');
       jQuery('#'+id).addClass('visible');
      }
    </script>
<!-- <div style="display:none">
<script src='http://v7.cnzz.com/stat.php?id=155540&web_id=155540' language='JavaScript' charset='gb2312'></script>
</div>
-->
</body>
</html>