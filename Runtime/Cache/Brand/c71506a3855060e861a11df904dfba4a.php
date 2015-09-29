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
			<a href="<?php echo U('Home/Main/main');?>">品牌管理</a>
		</li>

		<li class="active"><a href="<?php echo U('Brand/Employee/index');?>">员工管理</a></li>
		<li class="active">添加/修改员工</li>

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
    
	<div class="row">
		<div class="col-xs-12">
			<form   enctype="multipart/form-data" class="form-horizontal" role="form" id="addEmployeeForm" <?php if(empty($employee)): ?>action="<?php echo U('Brand/Employee/add');?>" <?php else: ?> action="<?php echo U('Brand/Employee/edit');?>"<?php endif; ?>method="post">
			<input type="hidden" name="id" value="<?php echo ($employee["id"]); ?>">
	<div class="form-group">
					<label class="col-sm-1 control-label no-padding-right" for="club">选择会所:</label>
					<div class="col-sm-3">
					<select name="club_id" id="club_id"  class="form-control col-xs-10 col-sm-5">
					<?php if(is_array($clubs)): $i = 0; $__LIST__ = $clubs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$club): $mod = ($i % 2 );++$i;?><option value="<?php echo ($club["id"]); ?>"  <?php if($club['id'] == $employee['club_id']): ?>selected="selected"<?php endif; ?>><?php echo ($club["club_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>						
					</select>					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-1 control-label no-padding-right" for="name_cn">中文名:</label>
					<div class="col-sm-3">
						<input type="text" id="name_cn"  class="form-control col-xs-10 col-sm-5" name="name_cn" value="<?php echo ($employee["name_cn"]); ?>"/>
					</div>
					<label class="col-sm-1 control-label no-padding-right" for="name_en">英文名:</label>
					<div class="col-sm-3">
						<input type="text" id="name_en"  class="form-control col-xs-10 col-sm-5" name="name_en" value="<?php echo ($employee["name_en"]); ?>"/>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-1 control-label no-padding-right" for="username">用户名:</label>
					<div class="col-sm-3">
						<input type="text" id="username"  class="form-control col-xs-10 col-sm-3" name="username" value="<?php echo ($employee["username"]); ?>"/>  
					</div>
					<label class="col-sm-1 control-label no-padding-right" for="password">密码:</label>
					<div class="col-sm-3">
						<input type="password" id="password"  class="form-control col-xs-10 col-sm-5" name="password" />
					</div>
					<label class="col-sm-1 control-label no-padding-right" for="confirm_password">确认密码:</label>
					<div class="col-sm-3">
						<input type="password" id="confirm_password"  class="form-control col-xs-10 col-sm-5" name="confirm_password"  />
					</div>
				</div>
				    

				

				<div class="form-group">
					
				</div>
			<div class="form-group">
					<label class="col-sm-1 control-label no-padding-right" for="level">员工等级:</label>
					<div class="col-sm-3">
					<select name="level" id="level"  class="form-control col-xs-10 col-sm-5">
					<?php $__FOR_START_1000738046__=1;$__FOR_END_1000738046__=10;for($i=$__FOR_START_1000738046__;$i < $__FOR_END_1000738046__;$i+=1){ ?><option value="<?php echo ($i); ?>"  <?php if($i == $employee['level']): ?>selected="selected"<?php endif; ?> ><?php echo ($i); ?>级</option><?php } ?>
					
					</select>
				</div>
				<label class="col-sm-1 control-label no-padding-right" for="sex">性别:</label>
					<div class="col-sm-3">
					<select name="sex" id="sex" class="form-control">
						<option value="male">男</option>
						<option value="female" <?php if(female == $employee['sex']): ?>selected="selected"<?php endif; ?>>女</option>
					</select>
					</div>

					<label class="col-sm-1 control-label no-padding-right" for="marriage">婚姻状况:</label>
					<div class="col-sm-3">
					<select name="marriage" id="marriage" class="form-control">
						<option value="0">未婚</option>
						<option value="1" <?php if(1 == $employee['marriage']): ?>selected="selected"<?php endif; ?>> 已婚</option>
					</select>
					</div>
				</div>

				<div class="form-group">
					
				</div>
<div class="form-group">
					<label class="col-sm-1 control-label no-padding-right" for="identity_card">身份证:</label>
					<div class="col-sm-3">
						<input type="text" id="identity_card"  class="form-control col-xs-10 col-sm-5" name="identity_card" value="<?php echo ($employee["identity_card"]); ?>"/>
					</div>
					<label class="col-sm-1 control-label no-padding-right" for="phone">手机:</label>
					<div class="col-sm-3">
						<input type="text" id="phone"  class="form-control col-xs-10 col-sm-5" name="phone" value="<?php echo ($employee["phone"]); ?>"/>
					</div>
					<label class="col-sm-1 control-label no-padding-right" for="email">E-mail:</label>
					<div class="col-sm-3">
						<input type="email" id="email"  class="form-control col-xs-10 col-sm-5" name="email" value="<?php echo ($employee["email"]); ?>"/>
					</div>
				</div>
  

				 <div class="form-group">
					<label class="col-sm-1 control-label no-padding-right" for="birthday">出生日期:</label>
					<div class="col-sm-2">
						<input type="text" id="birthday"  name="birthday" class="date_ymd form-control col-xs-10 col-sm-5" value="<?php echo ($employee["birthday"]); ?>"/>						 
					 
					</div>
					<label class="col-sm-1 control-label no-padding-right" for="origin">籍贯:</label>
					<div class="col-sm-2">
						<input type="text" id="origin"  name="origin" class=" form-control col-xs-10 col-sm-5" value="<?php echo ($employee["origin"]); ?>" />		 
					</div>
					<label class="col-sm-1 control-label no-padding-right" for="hukou">户口:</label>
					<div class="col-sm-2">
						<input type="text" id="hukou"  name="hukou" class=" form-control col-xs-10 col-sm-5" value="<?php echo ($employee["hukou"]); ?>"  />						 
					 
					</div>
					<label class="col-sm-1 control-label no-padding-right" for="address">住址:</label>
					<div class="col-sm-2">
						<input type="text" id="address"  name="address" class=" form-control col-xs-10 col-sm-5" value="<?php echo ($employee["address"]); ?>"  />						 
					 
					</div>
				</div>

<div class="form-group">				 
					<label class="col-sm-1 control-label no-padding-right" for="school">毕业院校:</label>
					<div class="col-sm-2">
						
						<input type="text" id="school"  name="school" class="form-control col-xs-10 col-sm-4"  value="<?php echo ($employee["school"]); ?>"/>	
					</div>
					 <label class="col-sm-1 control-label no-padding-right" for="major">专业:</label>
					<div class="col-sm-2">
						<input type="text" id="major"  name="major" class="form-control col-xs-10 col-sm-4"  value="<?php echo ($employee["major"]); ?>"/>	
					</div>
					<label class="col-sm-1 control-label no-padding-right" for="school">学历:</label>
					<div class="col-sm-2">
						<select name="education" id="education" class="form-control">
							<option value="0" <?php if(0 == $employee['education']): ?>selected="selected"<?php endif; ?>>专科</option>
							<option value="1" <?php if(1 == $employee['education']): ?>selected="selected"<?php endif; ?>>本科</option>
							<option value="2" <?php if(2 == $employee['education']): ?>selected="selected"<?php endif; ?>>研究生</option>
							<option value="3" <?php if(3 == $employee['education']): ?>selected="selected"<?php endif; ?>>博士生</option>
							<option value="4" <?php if(4 == $employee['education']): ?>selected="selected"<?php endif; ?>>其他</option>
						</select>
					</div>
					<label class="col-sm-1 control-label no-padding-right" for="graduate_time">毕业时间:</label>
					<div class="col-sm-2">
						<input type="text" id="graduate_time"  value = "<?php echo ($employee["graduate_time"]); ?>" name="graduate_time" class="date_ymd form-control col-xs-10 col-sm-5" />						 
					 
					</div>
				</div>
 
				<div class="form-group">
					<label class="col-sm-1 control-label no-padding-right" for="bank_card">工资卡号:</label>
					<div class="col-sm-3">
						<input type="text" id="bank_card"  class="form-control col-xs-10 col-sm-5" name="bank_card" value="<?php echo ($employee["bank_card"]); ?>"/>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-1 control-label no-padding-right" for="work_status">在职状态:</label>
					<div class="col-sm-3">
						<select name="work_status" id="work_status" class="form-control">
						<option value="0" <?php if(0 == $employee['work_status']): ?>selected="selected"<?php endif; ?>>在职</option>
						<option value="1" <?php if(1 == $employee['work_status']): ?>selected="selected"<?php endif; ?>>离职</option>
						<option value="2" <?php if(2 == $employee['work_status']): ?>selected="selected"<?php endif; ?>>实习</option>
						<option value="3" <?php if(3 == $employee['work_status']): ?>selected="selected"<?php endif; ?>>兼职</option>
						</select>
					</div>
					<label class="col-sm-1 control-label no-padding-right" for="work_in_time">入职日期:</label>
					<div class="col-sm-3">
						<input type="text" id="work_in_time"  name="work_in_time" class="date_ymd form-control col-xs-10 col-sm-5" value="<?php echo ($employee["work_in_time"]); ?>"/>	 
					</div>					
					<label class="col-sm-1 control-label no-padding-right" for="work_out_time">离职日期:</label>
					<div class="col-sm-3">
						<input type="text" id="work_out_time"  name="work_out_time" class="date_ymd form-control col-xs-10 col-sm-5" value="<?php echo ($employee["work_out_time"]); ?>"/>	 				 
					 
					</div>
				</div> 
				<div class="form-group">
					<label class="col-sm-1 control-label no-padding-right" for="avatar">照片:</label>
					<div class="col-sm-2"> 
						<div class="profile-picture">
               	 		<a href="javascript:void(0)">
                        	<img src="/Public/uploads/em_avatar/<?php echo ($employee["avatar"]); ?>?<?php echo ($employee["update_time"]); ?>" alt="" style="width:100px;height:100px"   onerror="this.src='/Public/uploads/em_avatar/default.jpg'" onclick="change_avatar(this)">
                        	</a>
                        </div> 
                        <div class="avatardiv hide" >
							<input type="file" name="avatar" id="avatar">
						</div> 
					</div>  
					
					<label class="col-sm-1 control-label no-padding-right" for="desc">备注:</label>
					<div class="col-sm-7"> 
						<textarea type="text" id="desc"  rows="6" class="form-control col-xs-10 col-sm-5" name="desc" ><?php echo ($employee["desc"]); ?></textarea>
					</div>
				</div>
 

				<div class="form-group">
					<label class="col-sm-1 control-label no-padding-right" for="roles">权限:</label>
					<div class="col-sm-11">  
						 	<?php if(is_array($groups)): $i = 0; $__LIST__ = $groups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$group): $mod = ($i % 2 );++$i;?><label class="checkbox-inline">
								  <input type="checkbox" name="roles[]" id="roles" value="<?php echo ($group["id"]); ?>" <?php if (in_array($group['id'],$roles)) { echo 'checked="true"';}?> > <?php echo ($group["title"]); ?>
								</label><?php endforeach; endif; else: echo "" ;endif; ?>
						 
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-1 control-label no-padding-right" for="roles">财务权限:</label>
					<div class="col-sm-11">   
							 	<?php if(is_array($clubs)): $i = 0; $__LIST__ = $clubs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$club): $mod = ($i % 2 );++$i;?><label class="checkbox-inline">
							 	 <input type="checkbox" name="financeroles[]" id="financeroles" value="<?php echo ($club["id"]); ?>" <?php if (in_array($club['id'],$financeroles)) { echo 'checked="true"';}?> > <?php echo ($club["club_name"]); ?>
								</label><?php endforeach; endif; else: echo "" ;endif; ?>		

						 
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
	$(function(){$("#menu_1").addClass("active open");
    $("#menu_14").addClass("active");})

     function change_avatar(obj)
     {
     	$(obj).parents().find(".profile-picture").hide();
     	$(".avatardiv").removeClass("hide");
     }
</script>
	 

</body>
</html>