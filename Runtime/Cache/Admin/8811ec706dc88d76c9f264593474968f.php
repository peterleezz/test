<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>欢迎您登录Yoga Cms</title>

  <!-- Bootstrap -->
  <link href="/Public/css//bootstrap.min.css" rel="stylesheet">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="/Public/js//jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="/Public/js//bootstrap.min.js"></script>
  <script src="/Public/js//syslogin.js"></script>
  <link rel="stylesheet" href="/Public/css/login.css"></head>
<body>
  <div class="container">

    <form class="form-horizontal form-signin" role="form" id="login_form" action="<?php echo U('index/login');?>">
      <h3 class="welcome text-center"> <i class="login-logo"></i>Yoga CMS</h3>
      <div class="form-group">
        <label for="username" class="col-sm-2 control-label">用户名:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="username" name="username" placeholder="Username"></div>
      </div>
      <div class="form-group">
        <label for="password" class="col-sm-2 control-label">密　码:</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password"></div>
      </div>
      <div class="form-group">
        <label for="verifycode" class="col-sm-2 control-label">验证码:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="verifycode" name="verifycode" placeholder="VerifyCode"></div>
          <div class="col-sm-4 form-control-static"><a class="reloadverify" title="换一张" href="javascript:void(0)">换一张？</a></div>
      </div>
       <div class="col-sm-2 "></div>
    <div>
             <img  class="verifyimg reloadverify" alt="点击切换" src="<?php echo U('Home/Index/verify');?>"></div>

      <!-- <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <div class="checkbox">
            <label>
              <input type="checkbox">记住密码</label>
          </div>
        </div>
      </div> -->
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-lg btn-primary btn-block" id="admin_login_btn">登录</button>
        </div>
      </div>
    </form>

  </div>
  <!-- /container -->
</body>
</html>