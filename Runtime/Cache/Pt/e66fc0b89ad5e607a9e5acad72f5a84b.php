<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>会所管理平台</title> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <!-- basic styles -->
  <link rel="stylesheet" href="/Public/css/jquery-ui-1.10.3.full.min.css" />
  <link href="/Public/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/Public/css/font-awesome.min.css" />
  <link rel="stylesheet" href="/Public/css/bootstrap-datetimepicker.min.css" />
  <link rel="stylesheet" href="/Public/css/ui.jqgrid.css" />
  <link rel="stylesheet" href="/Public/css/validate.css" />
  <!--[if IE 7]>
  <link rel="stylesheet" href="/Public/css/font-awesome-ie7.min.css" />
  <![endif]-->

  <!-- page specific plugin styles -->

  <!-- fonts -->

  <link rel="stylesheet" href="/Public/css/googlefonts.css" />

  <!-- ace styles -->

  <link rel="stylesheet" href="/Public/css/ace.min.css" />
  <link rel="stylesheet" href="/Public/css/ace-rtl.min.css" />
  <link rel="stylesheet" href="/Public/css/ace-skins.min.css" />
  <!-- <link rel="stylesheet" href="/Public/css/jquery-ui-1.11.2.custom/jquery-ui.theme.css" />
  -->
  <!--[if lte IE 8]>
  <link rel="stylesheet" href="/Public/css/ace-ie.min.css" />
  <![endif]-->

  <!-- inline styles related to this page -->

  <!-- ace settings handler -->
  <link rel="stylesheet" href="/Public/css/fullcalendar.css" />

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

  <!--[if lt IE 9]>
  <script src="/Public/js/html5shiv.js"></script>
  <script src="/Public/js/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
       #hidebg { position:absolute;left:0px;top:0px;
      background-color:#000;
      width:100%;  /*宽度设置为100%，这样才能使隐藏背景层覆盖原页面*/
      filter:alpha(opacity=60);  /*设置透明度为60%*/
      opacity:0.6;  /*非IE浏览器下设置透明度为60%*/
      display:none; /* http://www.jb51.net */
      z-Index:2;}
  </style>

  
</head>

<body >
<div id="hidebg"></div>
<img id="wait_gif" src="/Public/images/demo_wait.gif" style="position: absolute; left: 50%; top: 50%;z-index:100;display:none">

  <div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">try{ace.settings.check('navbar' , 'fixed')}catch(e){}</script>

    <div class="navbar-container" id="navbar-container">
      <div class="navbar-header pull-left">
        <a href="#" class="navbar-brand">
          <small> <i class="icon-leaf"></i>
            会所管理平台
          </small>
        </a>
        <!-- /.brand --> </div>
      <!-- /.navbar-header -->

      <div class="navbar-header pull-right" >
        <ul class="nav ace-nav">
          <li class="grey">

            <?php if(1 == $show_plan): ?><a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="icon-tasks"></i>
                <span class="badge badge-grey">4</span>
              </a>

              <ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
                <li class="dropdown-header">
                  <i class="icon-ok"></i>
                  计划进度
                </li>
                <?php if(isset($channel_protential_persent)): ?><li>
                    <a href="#">
                      <div class="clearfix">
                        <span class="pull-left">渠道潜客量</span>
                        <span class="pull-right"><?php echo ($channel_protential_value); ?>/<?php echo ($channel_protential_plan); ?></span>
                      </div>

                      <div class="progress progress-mini ">
                        <div style="width:<?php echo ($channel_protential_persent); ?>%" class="progress-bar "></div>
                      </div>
                    </a>
                  </li><?php endif; ?>
                <?php if(isset($channel_channel_persent)): ?><li>
                    <a href="#">
                      <div class="clearfix">
                        <span class="pull-left">渠道开发量</span>
                        <span class="pull-right"><?php echo ($channel_channel_value); ?>/<?php echo ($channel_channel_plan); ?></span>
                      </div>

                      <div class="progress progress-mini ">
                        <div style="width:<?php echo ($channel_channel_persent); ?>%" class="progress-bar progress-bar-danger"></div>
                      </div>
                    </a>
                  </li><?php endif; ?>
                <?php if(isset($mc_protential_persent)): ?><li>
                    <a href="<?php echo U('Mc/Visit/mynotmemberlist');?>">
                      <div class="clearfix">
                        <span class="pull-left">MC潜客量</span>
                        <span class="pull-right"><?php echo ($mc_protential_value); ?>/<?php echo ($mc_protential_plan); ?></span>
                      </div>

                      <div class="progress progress-mini ">
                        <div style="width:<?php echo ($mc_protential_persent); ?>%" class="progress-bar progress-bar-warning"></div>
                      </div>
                    </a>
                  </li><?php endif; ?>

                <?php if(isset($mc_transform_persent)): ?><li>
                    <a href="<?php echo U('Mc/Visit/myismemberlist');?>">
                      <div class="clearfix">
                        <span class="pull-left">MC转化量</span>
                        <span class="pull-right"><?php echo ($mc_transform_value); ?>/<?php echo ($mc_transform_plan); ?></span>
                      </div>

                      <div class="progress progress-mini progress-striped active">
                        <div style="width:<?php echo ($mc_transform_persent); ?>%" class="progress-bar progress-bar-success"></div>
                      </div>
                    </a>
                  </li><?php endif; ?>

                <!-- <li>
                <a href="#">
                  查看详细进度
                  <i class="icon-arrow-right"></i>
                </a>
              </li>
              -->
            </ul><?php endif; ?>

        </li>

        <!-- <li class="purple">
          <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <i class="icon-bell-alt icon-animated-bell"></i>
            <span class="badge badge-important">8</span>
          </a>

          <ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
            <li class="dropdown-header">
              <i class="icon-warning-sign"></i>
              提醒
            </li>

            <li>
              <a href="#">
                <i class="btn btn-xs btn-primary icon-user"></i>
                近期生日会员
              </a>
            </li>
            <li>
              <a href="#">
                查看详情
                <i class="icon-arrow-right"></i>
              </a>
            </li>
          </ul>
        </li> -->

        <li class="light-blue">
          <a data-toggle="dropdown" href="#" class="dropdown-toggle">
            <img class="nav-user-photo" src="<?php echo ($useravatar); ?>"  onerror="this.src='/Public/uploads/em_avatar/default.jpg'"/>
            <span class="user-info">
              <small>Welcome,</small>
              <?php echo ($user); ?>
            </span>

            <i class="icon-caret-down"></i>
          </a>

          <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
            <li>
              <a  href="javascript:void(0)"  data-toggle="modal" data-target="#chpasswdModel">
                <i class="icon-cog"></i>
                修改密码
              </a>
            </li>

            <li>
              <a href="#">
                <i class="icon-user"></i>
                个人详情
              </a>
            </li>

            <li class="divider"></li>

            <li>
              <a href="<?php echo U('Home/Main/logout');?>">
                <i class="icon-off"></i>
                退出
              </a>
            </li>
          </ul>
        </li>
      </ul>
      <!-- /.ace-nav --> </div>
    <!-- /.navbar-header --> </div>
  <!-- /.container -->
</div>

<div class="main-container" id="main-container">
  <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
      </script>

  <div class="main-container-inner">
    <a class="menu-toggler" id="menu-toggler" href="#">
      <span class="menu-text"></span>
    </a>

    <div class="sidebar" id="sidebar">
      <script type="text/javascript">try{ace.settings.check('sidebar' , 'fixed')}catch(e){}</script>

      <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
          <button class="btn btn-success">
            <i class="icon-signal"></i>
          </button>

          <button class="btn btn-info">
            <i class="icon-pencil"></i>
          </button>

          <button class="btn btn-warning">
            <i class="icon-group"></i>
          </button>

          <button class="btn btn-danger">
            <i class="icon-cogs"></i>
          </button>
        </div>

      </div>
      <!-- #sidebar-shortcuts -->
      <ul class="nav nav-list">

        <?php if(is_array($menus)): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li id="menu_<?php echo ($menu["id"]); ?>" >
            <a href="javascript:void(0)" class="dropdown-toggle">
              <i class="<?php echo ($menu["icon"]); ?>"></i>
              <span class="menu-text"><?php echo ($menu["title"]); ?></span> <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
              <?php if(is_array($menu['child'])): $i = 0; $__LIST__ = $menu['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?><li id="menu_<?php echo ($child["id"]); ?>">

                  <?php if($child['child'] == null ): ?><a href="<?php echo U($child['url']); ?>
                      ">
                      <i class="icon-double-angle-right"></i>
                      <?php echo ($child["title"]); ?>
                    </a>
                    <?php else: ?>
                    <a href="#" class="dropdown-toggle">
                      <i class="icon-double-angle-right"></i>
                      <?php echo ($child["title"]); ?> <b class="arrow icon-angle-down"></b>
                    </a>
                    <ul class="submenu">
                      <?php if(is_array($child['child'])): $i = 0; $__LIST__ = $child['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$grandchild): $mod = ($i % 2 );++$i;?><li id="menu_<?php echo ($grandchild["id"]); ?>">
                          <a href="<?php echo U($grandchild['url']); ?>
                            ">
                            <i class="<?php echo ($grandchild["icon"]); ?>"></i>
                            <?php echo ($grandchild["title"]); ?>
                          </a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul><?php endif; ?>

                </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>

          </li><?php endforeach; endif; else: echo "" ;endif; ?>
        <li>
          <a href="#" class="dropdown-toggle">
            <i class="icon-file-alt"></i>

            <span class="menu-text">其他页面</span>

            <b class="arrow icon-angle-down"></b>
          </a>

          <ul class="submenu">
            <li>
              <a href="faq.html">
                <i class="icon-double-angle-right"></i>
                帮助
              </a>
            </li>

          </ul>
        </li>
      </ul>
      <!-- /.nav-list -->

      <div class="sidebar-collapse" id="sidebar-collapse">
        <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
      </div>

      <script type="text/javascript">try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}</script>
    </div>

    <div class="main-content">
      <div class="breadcrumbs" id="breadcrumbs">
        <script type="text/javascript">try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}</script>
        
    <ul class="breadcrumb">
        <li> <i class="icon-home home-icon"></i>
            <a href="<?php echo U('Home/Main/main');?>">前台</a>
        </li>

        <li class="active">来访登记</li>

    </ul>

        <!-- .breadcrumb -->

        <!-- <div class="nav-search" id="nav-search">
        <form class="form-search">
          <span class="input-icon">
            <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
            <i class="icon-search nav-search-icon"></i>
          </span>
        </form>
      </div>
      -->
    </div>

    <div class="page-content">
      <!-- <div class="page-header" ></div>
    -->
    
<h4 class="green"> <i class="icon-hand-right icon-animated-hand-pointer blue"></i>
        访客信息不能重复录入！
    </h4>
    <div class="row">
        <div class="col-xs-12">
            <form  enctype="multipart/form-data"  class="form-horizontal" role="form" id="addEmployeeForm"   action="<?php echo ($action); ?>"      method="post">
            <input type="hidden" name="id" value=<?php echo ($member["id"]); ?> id="hiddenid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">必填信息</h3>
                </div>
                <div class="panel-body">

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="col-sm-4  control-label no-padding-right" for="channel_id">获取渠道:</label>
                                <div class="col-sm-8">
                                    <select name="channel_id" id="channel_id" class=" form-control">
                                       <!--  <option value="-2">路过看看-_-!</option>
                                        <option value="0">朋友推荐</option>
                                        <option value="-1">MC推荐</option>  -->
                                        <?php if(is_array($channels)): $i = 0; $__LIST__ = $channels;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$channel): $mod = ($i % 2 );++$i;?><option value="<?php echo ($channel["id"]); ?>"  <?php if($channel['id'] == $member['channel_id']): ?>selected="selected"<?php endif; ?>><?php echo ($channel["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                            </div> 

                             <div class="col-sm-4">
                                <label class="col-sm-4  control-label no-padding-right" for="mc">MC:</label>
                                <div class="col-sm-8">
                                 <select name="mc_id" id="mc_id" class=" form-control"> 
                                        <?php if(is_array($mcs)): $i = 0; $__LIST__ = $mcs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mc): $mod = ($i % 2 );++$i;?><option value="<?php echo ($mc["id"]); ?>"  <?php if($mc['id'] == $member['mc_id']): ?>selected="selected"<?php endif; ?>><?php echo ($mc["name_cn"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select> 
                                </div>
                            </div>

                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="col-sm-4  control-label no-padding-right" for="name">潜客姓名:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="name" id="name"  class=" form-control"  value="<?php echo ($member["name"]); ?>" onblur="check_exsit()"></div>
                            </div>

                            <div class="col-sm-4">
                                <label class="col-sm-4  control-label no-padding-right" for="phone">手机号码:</label>
                                <div class="col-sm-8">
                                    <input type="text" value="<?php echo ($member["phone"]); ?>" name="phone" id="phone"  class=" form-control"  onblur="check_exsit()"></div>
                            </div>
                        </div>
                    </div> 
    
                    <div class="form-group">
                        <div class="row"> 
                            <div class="col-sm-4 ">
                                <label class="col-sm-4  control-label no-padding-right" for="recommend_phone">推荐人手机:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="recommend_phone" id="recommend_phone" class=" form-control"  value="<?php echo ($member["recommend_phone"]); ?>"  onblur="query_recommend()"></div>
                            </div>

                            <div class="col-sm-4 " >
                                <label class="col-sm-4  control-label no-padding-right" for="recommend_name">推荐人名:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="recommend_name" id="recommend_name" class="col-xs-6" value="<?php echo ($member["recommend_name"]); ?>">
                                    <select class=" col-xs-6" id="recommeders" >
                                        <option value="0">Or?</option>
                                    </select>
                                  
                                </div>
                            </div>

                         </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="col-sm-4  control-label no-padding-right" for="sex">性别:</label>
                                <div class="col-sm-8">
                                    <label class="radio-inline">
                                        <input type="radio" name="sex" id="sex" value="female" checked="checked">女</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="sex" id="sex" value="male" <?php if(male == $member['sex']): ?>checked="checked"<?php endif; ?>>男</label>
                                </div>
                            </div>

                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="type">访客分类:</label>
                                <div class="col-sm-8">
                                    <select name="type" id="type"  class=" form-control">
                                     <option value="1" <?php if(1 == $member['type']): ?>selected="selected"<?php endif; ?>>D类</option>
                                       <option value="2" <?php if(2 == $member['type']): ?>selected="selected"<?php endif; ?>>C类</option>
                                        <option value="3" <?php if(3 == $member['type']): ?>selected="selected"<?php endif; ?>>B类</option>
                                        <option value="4"  <?php if(4 == $member['type']): ?>selected="selected"<?php endif; ?>>A类</option>  
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
 

                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">选填信息</h3>
                </div>
                <div class="panel-body">

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="col-sm-4  control-label no-padding-right" for="name">潜在意向:</label>
                                <div class="col-sm-8">
                                <select name="maybuy" id="maybuy" class=" form-control">
                                     <option value="0">无购卡意向</option>
                                        <?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?><option value="<?php echo ($type["id"]); ?>" <?php if($type['id'] == $member['maybuy']): ?>selected="selected"<?php endif; ?>><?php echo ($type["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select> 
                                    </div>
                            </div>

                            <div class="col-sm-4">
                                <label class="col-sm-4  control-label no-padding-right" for="hopeprice">期望价格:</label>
                                <div class="col-sm-8">
                                    <input type="text" value=
                                    <?php if(empty($member)): ?>0
                                    <?php else: ?>
                                        <?php echo ($member["hopeprice"]); endif; ?>
 
                                     name="hopeprice" id="hopeprice"  class=" form-control"></div>
                            </div>

                            <div class="col-sm-4" id="rid">
                                <label class="col-sm-4  control-label no-padding-right" for="birthday">预购金额:</label>
                               <div class="col-sm-8">
                                    <input type="text" value=
                                    <?php if(empty($member)): ?>0
                                    <?php else: ?>
                                        <?php echo ($member["pre_sale"]); endif; ?>
 
                                     name="pre_sale" id="pre_sale"  class=" form-control"></div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="col-sm-4  control-label no-padding-right" for="email">邮箱:</label>
                                <div class="col-sm-8">
                                    <input type="email" value="<?php echo ($member["email"]); ?>" name="email" id="email"  class=" form-control"></div>
                            </div>

                            <div class="col-sm-4" id="rid">
                                <label class="col-sm-4  control-label no-padding-right" for="birthday">生日:</label>
                                <div class="col-sm-8">
                                    <input type="text" value="<?php echo ($member["birthday"]); ?>" class="date_ymd form-control" name="birthday" id="birthday"></div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="home_phone">家庭座机:</label>
                                <div class="col-sm-8">
                                    <input type="text"  value="<?php echo ($member["home_phone"]); ?>" name="home_phone" id="home_phone" class=" form-control"></div>
                            </div>
                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="home_addr">家庭地址:</label>
                                <div class="col-sm-8">
                                    <input type="text" value="<?php echo ($member["home_addr"]); ?>" name="home_addr" id="home_addr" class=" form-control"></div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="country">国籍:</label>
                                <div class="col-sm-8">
                                    <input type="text" value="<?php echo ($member["country"]); ?>" name="country" id="country" class=" form-control"></div>
                            </div>
                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="nation">民族:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="nation" value="<?php echo ($member["nation"]); ?>" id="nation" class=" form-control"></div>
                            </div>
                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="job">职业:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="job" value="<?php echo ($member["job"]); ?>" id="job" class=" form-control"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="office_name">公司名:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="office_name" value="<?php echo ($member["office_name"]); ?>"  id="office_name" class=" form-control"></div>
                            </div>
                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="office_addr">公司地址:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="office_addr"  value="<?php echo ($member["office_addr"]); ?>" id="office_addr" class=" form-control"></div>
                            </div>
                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="office_phone">公司电话:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="office_phone" value="<?php echo ($member["office_phone"]); ?>"  id="office_phone" class=" form-control"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="hobby">兴趣爱好:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="hobby" id="hobby" value="<?php echo ($member["hobby"]); ?>"  class=" form-control"></div>
                            </div>
                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="near_club">最近会馆:</label>
                                <div class="col-sm-8">
                                    <select name="near_club" id="near_club" class=" form-control">
                                        <?php if(is_array($clubs)): $i = 0; $__LIST__ = $clubs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$club): $mod = ($i % 2 );++$i;?><option value="<?php echo ($club["id"]); ?>" <?php if($club['id'] == $member['near_club']): ?>selected="selected"<?php endif; ?>><?php echo ($club["club_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="purpose">目的:</label>
                                <div class="col-sm-8">
                                    <select name="purpose" id="purpose" class=" form-control">
                                        <option value="1"  <?php if(1 == $member['purpose']): ?>selected="selected"<?php endif; ?>>减肥</option>
                                        <option value="2"  <?php if(2 == $member['purpose']): ?>selected="selected"<?php endif; ?>>增肌</option>
                                        <option value="3"  <?php if(3 == $member['purpose']): ?>selected="selected"<?php endif; ?>>保持健康</option>
                                        <option value="4"  <?php if(4 == $member['purpose']): ?>selected="selected"<?php endif; ?>>时尚</option>
                                        <option value="5"  <?php if(5 == $member['purpose']): ?>selected="selected"<?php endif; ?>>习惯</option>
                                        <option value="6"  <?php if(6 == $member['purpose']): ?>selected="selected"<?php endif; ?>>其他</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="certificate_type">证件类型:</label>
                                <div class="col-sm-8">
                                    <select name="certificate_type" id="certificate_type" class=" form-control">
                                        <option value="1"  <?php if(1 == $member['certificate_type']): ?>selected="selected"<?php endif; ?>>身份证</option>
                                        <option value="2" <?php if(2 == $member['certificate_type']): ?>selected="selected"<?php endif; ?>> 护照</option>
                                        <option value="3" <?php if(3 == $member['certificate_type']): ?>selected="selected"<?php endif; ?>>其他</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="certificate_number">证件号码:</label>
                                <div class="col-sm-8">
                                    <input type="text" value="<?php echo ($member["certificate_number"]); ?>" name="certificate_number" id="certificate_number" class=" form-control"></div>
                            </div>
                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="how_getinfo">获取咨询习惯:</label>
                                <div class="col-sm-8">
                                    <select  name="how_getinfo" id="how_getinfo" class=" form-control">
                                        <option value="1" <?php if(1 == $member['how_getinfo']): ?>selected="selected"<?php endif; ?>>网络</option>
                                        <option value="2" <?php if(2 == $member['how_getinfo']): ?>selected="selected"<?php endif; ?>>杂志</option>
                                        <option value="3" <?php if(3 == $member['how_getinfo']): ?>selected="selected"<?php endif; ?>>报纸</option>
                                        <option value="4" <?php if(4 == $member['how_getinfo']): ?>selected="selected"<?php endif; ?>>电视</option>
                                        <option value="5" <?php if(5 == $member['how_getinfo']): ?>selected="selected"<?php endif; ?>>广播</option>
                                        <option value="6" <?php if(6 == $member['how_getinfo']): ?>selected="selected"<?php endif; ?>>短信</option>
                                        <option value="7" <?php if(7 == $member['how_getinfo']): ?>selected="selected"<?php endif; ?>>其他</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="marriage">婚姻状况:</label>
                                <div class="col-sm-8">
                                    <select name="marriage" id="marriage" class=" form-control">
                                        <option value="0" <?php if(0 == $member['marriage']): ?>selected="selected"<?php endif; ?>>未婚</option>
                                        <option value="1"  <?php if(1 == $member['marriage']): ?>selected="selected"<?php endif; ?>>已婚</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="has_child">子女状况:</label>
                                <div class="col-sm-8">
                                    <select name="has_child" id="has_child" class=" form-control">
                                        <option value="0"  <?php if(0 == $member['has_child']): ?>selected="selected"<?php endif; ?>>无子女</option>
                                        <option value="1" <?php if(1 == $member['has_child']): ?>selected="selected"<?php endif; ?>>有子女</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="emergency_name">紧急联系人:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="emergency_name" value="<?php echo ($member["emergency_name"]); ?>" id="emergency_name" class=" form-control"></div>
                            </div>
                            <div class="col-sm-4" >
                                <label class="col-sm-4  control-label no-padding-right" for="emergency_phone">联系人电话:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="emergency_phone" value="<?php echo ($member["emergency_phone"]); ?>" id="emergency_phone" class=" form-control"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12" >
                                <label class="col-sm-2  control-label no-padding-right" for="other_clubs">参加过的其他品牌:</label>
                                <div class="col-sm-10 col-xs-12">
                                    <input type="text" name="other_clubs" id="other_clubs" value="<?php echo ($member["other_clubs"]); ?>" class="form-control"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right" for="avatar">照片:</label>
                        <div class="col-sm-2">
                        
                        <?php if(empty($member)): ?><input type="file" name="avatar" id="avatar" >
                <?php else: ?>
                 <div class="profile-picture">
                        <a href="javascript:void(0)">
                              <img src="<?php if(strpos($member['avatar'],'http')!==false)echo $member['avatar'];else echo '/Public/uploads/mmb_avatar/'. $member['avatar'] ?>?<?php echo ($member["update_time"]); ?>" alt="" style="width:100px;height:100px" onclick="change_avatar(this)">  
                            </a>
                        </div> 
                        <div class="avatardiv hide" >
                            <input type="file" name="avatar" id="avatar" >
                        </div><?php endif; ?>

            </div> 
                                            
                           
                        <label class="col-sm-1 control-label no-padding-right" for="desc">备注:</label>
                        <div class="col-sm-7">
                            <textarea type="text" id="desc"  rows="6" class="form-control col-xs-10 col-sm-5" name="desc" ><?php echo ($member["desc"]); ?></textarea>
                        </div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="btn btn-info" type="submit"> <i class="icon-ok bigger-110"></i>
                                提交
                            </button>
                            &nbsp; &nbsp; &nbsp;
                            <button class="btn" type="reset">
                                <i class="icon-undo bigger-110"></i>
                                重置
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


  </div>
</div>
<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
  <i class="icon-double-angle-up icon-only bigger-110"></i>
</a>
</div>
</div>

<div class="modal fade " id="chpasswdModel" tabindex="-1" role="dialog" aria-labelledby="chpasswdModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">
      <span aria-hidden="true">&times;</span>
      <span class="sr-only">Close</span>
    </button>
    <h4 class="modal-title" id="chpasswdModalLabel">修改密码</h4>
  </div>
  <div class="modal-body">

    <form class="form-horizontal" role="form" id="change_password_form" action="<?php echo U('Home/Main/changePassword');?>">

      <div class="form-group">
        <label for="original_password" class="col-sm-2 control-label">原始密码</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" name="original_password" id="original_password" ></div>
      </div>

      <div class="form-group">
        <label for="new_password" class="col-sm-2 control-label">新密码</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" name="new_password" id="password" ></div>
      </div>

      <div class="form-group">
        <label for="confirm_password" class="col-sm-2 control-label">确认密码</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" name="confirm_password" id="confirm_password" ></div>
      </div>

    </form>

  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-primary" onclick="change_password()">确认</button>
  </div>
</div>
</div>
</div>

<div class="modal fade " id="chooseptModel" tabindex="-1" role="dialog" aria-labelledby="chooseptModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
<!--     <button type="button" class="close" data-dismiss="modal">
      <span aria-hidden="true">&times;</span>
      <span class="sr-only">Close</span>
    </button> -->
    <h4 class="modal-title" id="chpasswdModalLabel">选择PT</h4>
  </div>
  <div class="modal-body">

    <form class="form-horizontal" role="form" id="choosept_form" action="<?php echo U('Home/Task/choosept');?>">
      <input type="hidden" id="ptchoose_id" value="0">
      <div class="form-group">
        <label for="original_password" class="col-sm-3 control-label">选择PT：</label>
        <div class="col-sm-9">
          <select class="form-control" id="pts">
            <option value="xxx">123</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="ptchoose_name" class="col-sm-3 control-label">会员姓名：</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" id="ptchoose_name" readOnly="true"></div>
      </div>

      <div class="form-group">
        <label for="ptchoose_gender" class="col-sm-3 control-label">会员性别：</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" id="ptchoose_gender" readOnly="true"></div>
      </div>
      <div class="form-group">
        <label for="ptchoose_card" class="col-sm-3 control-label">卡号：</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" id="ptchoose_card" readOnly="true"></div>
      </div>

      <div class="form-group">
        <label for="ptchoose_avatar" class="col-sm-3 control-label">头像：</label>
        <div class="col-sm-9">
          <img src="http://localhost:84/Public/uploads/mmb_avatar/default.jpg" alt="" width="100px" id="ptchoose_avatar"></div>
      </form>

    </div>
    <div class="modal-footer">
      <!-- <button type="button" class="btn btn-default" data-dismiss="modal">取消</button> -->
      <button type="button" class="btn btn-primary" onclick="choosept()">确认</button>
    </div>
  </div>
</div>
</div>
</div>

<script type="text/javascript"> var isReception = <?php echo ($isReception); ?> ;</script>
<!-- /.main-container -->

<!-- basic scripts -->
<script src="/Public/js/ace-extra.min.js"></script>
<script src="/Public/js/jquery.min.js"></script>
<script src="/Public/js/jquery.json-2.2.js"></script>

<script src="/Public/js/bootstrap.min.js"></script>
<script src="/Public/js/typeahead-bs2.min.js"></script>
<script src="/Public/js/fuelux/fuelux.wizard.min.js"></script>

<script src="/Public/js/bootstrap-datetimepicker.min.js"></script>
<script src="/Public/js/bootstrap-datetimepicker.zh-CN.js"></script>

<script src="/Public/js/jqGrid/jquery.jqGrid.min.js"></script>
<!-- page specific plugin scripts -->
<script src="/Public/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="/Public/js/jquery.dataTables.min.js"></script>
<script src="/Public/js/jquery.dataTables.bootstrap.js"></script>

<!-- ace scripts -->

<script src="/Public/js/ace-elements.min.js"></script>
<script src="/Public/js/ace.min.js"></script>
<script src="/Public/js/bootbox.min.js"></script>
<script src="/Public/js/yoga.js?a=5.0"></script>
<script src="/Public/js/x-editable/bootstrap-editable.min.js"></script>
<script src="/Public/js/x-editable/ace-editable.min.js"></script>

<script src="/Public/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="/Public/js/jquery.ui.touch-punch.min.js"></script>
<script src="/Public/js/jquery.gritter.min.js"></script>
<script src="/Public/js/jquery.slimscroll.min.js"></script>
<script src="/Public/js/jquery.easy-pie-chart.min.js"></script>
<script src="/Public/js/jquery.sparkline.min.js"></script>
<script src="/Public/js/jquery.hotkeys.min.js"></script>
<script src="/Public/js/bootstrap-wysiwyg.min.js"></script>
<script src="/Public/js/select2.min.js"></script>
<script src="/Public/js/jquery.easy-pie-chart.min.js"></script>
<script src="/Public/js/fuelux/fuelux.spinner.min.js"></script>
<script src="/Public/js/jquery.maskedinput.min.js"></script>
<script src="/Public/js/Chart.js"></script>
<script src="/Public/js/jquery.validate.min.js"></script>
<script src="/Public/js/messages_zh.js"></script>

<!-- <script src='/Public/js/fullcalendar/fullcalendar.min.js'></script>
-->
<!-- <script src="/Public/js/fullcalendar/lib/fullcalendar.min.js"></script>
-->
<script src="/Public/js/fullcalendar.min.js"></script>

<!-- ace scripts -->

<!-- inline scripts related to this page -->


<script>
      
    $("<?php echo ($active_open); ?>").addClass("active open");
    $("<?php echo ($active); ?>").addClass("active");



   $("#addEmployeeForm").submit(function(){ 
  
     var type=$("#type").val();
     var pre_sale=$("#pre_sale").val();
     var maybuy=$("#maybuy").val();
     var hopeprice=$("#hopeprice").val();
     if(type==4)
     {
        if (pre_sale=='' ||pre_sale=='0')
        {
                bootbox.alert("A类用户请输入预购金额！");
                return false;
        }
        if ( maybuy==0)
        {
                bootbox.alert("A类用户请输入潜在意向！");
                return false;
        }
        if (hopeprice=='' ||hopeprice=='0')
        {
                bootbox.alert("A类用户请输入期望价格:！");
                return false;
        }
            
     }

  });
     
     
    function query_recommend()
    {
        var obj =document.getElementById("recommeders");
        obj.options.length=1;
        var phone=$("#recommend_phone").val().trim();
        if(phone =="") return;
        $.post("<?php echo ($queryRecommend); ?>", {phone:phone}, function(data,textStatus){  
               if(data.status){ 
                     var members = data.members; 
                    for(var i=0;i<members.length;i++)
                    {
                      var member=members[i]; 
                       obj.options[obj.length]=new Option(member.name,member.id); 
                    }
                    var recommend_name = $("#recommend_name").val().trim();                     
                    $("#recommend_name").val(members[0].name);
                     
                } else { 
                }            
        }, "json");
    }
     function check_exsit()
     {
        var hiddenid=$("#hiddenid").val();
        if(hiddenid!=null && hiddenid!=0) return;
        var name = $("#name").val().trim();
        var phone =$("#phone").val().trim();
        if(name=="" || phone =="") return;
         $.post("<?php echo ($exist); ?>", {name:name,phone:phone}, function(data,textStatus){ 
                      
               if(data.status==2){ 
                    bootbox.alert("该潜在客户已由其他MC管理！",null);
                } 
                else   if(data.status==0){
                   bootbox.confirm("该访客已存在，是否修改原信息?", function(result) {
                      if (result) {
                          window.location.href ="<?php echo ($edit); ?>"+"/id/"+data.id;
                      }
                      else
                      {
                         $("#name").val("");
                         $("#phone").val("");
                      }
                     });                
                }            
        }, "json");
     }
     function change_avatar(obj)
     {
        $(obj).parents().find(".profile-picture").hide();
        $(".avatardiv").removeClass("hide");
     }
     $(function(){
           
           $("#recommeders").click(function(){
                if($("#recommeders").val()!=0)
                {
                    $("#recommend_name").val($("#recommeders  option:selected").text());
                }
           });
            if($("#channel_id").val()==0)
             {
                $("#rid,#mcid").addClass("hide");
                $(".friend").removeClass("hide");
             }
             else if($("#channel_id").val()==-1)
             {
                 $("#rid,.friend").addClass("hide");
                 $("#mcid").removeClass("hide");
             }else if($("#channel_id").val()==-2)
             {
                 $("#rid,.friend,#mcid").addClass("hide"); 
             }
             else
             {
                $(".friend,#mcid").addClass("hide");
                $("#rid").removeClass("hide");
             }

        $("#channel_id").change(function(){
            if($("#channel_id").val()==0)
             {
                $("#rid,#mcid").addClass("hide");
                $(".friend").removeClass("hide");
             }
             else if($("#channel_id").val()==-1)
             {
                 $("#rid,.friend").addClass("hide");
                 $("#mcid").removeClass("hide");
             }else if($("#channel_id").val()==-2)
             {
                 $("#rid,.friend,#mcid").addClass("hide"); 
             }
             else
             {
                $(".friend,#mcid").addClass("hide");
                $("#rid").removeClass("hide");
             }
        });
     });


  </script>

</body>
</html>