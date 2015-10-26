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
			<a href="<?php echo U('Home/Main/main');?>">收银</a>
		</li>
		<li class="active">用户入会</li>

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
    
	<div class="row-fluid">
		<div class="span12">
			<div class="widget-box">
				<div class="widget-header widget-header-blue widget-header-flat">
					<h4 class="lighter">用户入会</h4>

				</div>

				<div class="widget-body">
					<div class="widget-main">
						<div id="fuelux-wizard" class="row-fluid" data-target="#step-container">
							<ul class="wizard-steps">
								<li data-target="#step1"  class="active">
									<span class="step">1</span>
									<span class="title">潜在用户查询</span>
								</li>

								<li data-target="#step2" >
									<span class="step">2</span>
									<span class="title">合同信息录入</span>
								</li>

								<li data-target="#step3">
									<span class="step">3</span>
									<span class="title">收款</span>
								</li>

								<li data-target="#step4">
									<span class="step">4</span>
									<span class="title">完成</span>
								</li>
							</ul>
						</div>

						<hr />
						<div class="step-content row-fluid position-relative" id="step-container">
							<div class="step-pane active" id="step1">

								<form id="join_form_query" action="<?php echo U('Cashier/Member/query');?>">
									<span class="input-icon" style="float:left">
										<input type="text" placeholder="姓名或手机号码或身份证"  name="name"/> <i class="icon-search nav-search-icon"></i>
									</span>
									<!-- <input type="hidden" value="0" name="is_member"> -->
									<button type="submit" class="btn  btn-info btn-sm">
										<i class="icon-search"></i>
										查询
									</button> <strong class="red" style="float:right"><i class="icon-hand-right icon-animated-hand-pointer blue"></i>
										如果用户信息尚未录入访客信息库，请先到前台进行录入！</strong> 
								</form>
								<table class="table " id="member_info">
									<thead>
										<tr>
											<th>选择</th>
											<th>姓名</th>
											<th>电话</th>
											<th>性别</th>
											<th>会员类型</th>
											<th></th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
								<div id="show_detail"></div>
							</div>

							<div class="step-pane" id="step2">

								<div class="row-fluid">
									<div class="col-xs-12">
										<form class="form-horizontal" id="validation-form" method="post">


										<div class="form-group">
		                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="join_mc_id">会籍顾问:</label>
		                                <div class="col-xs-12 col-sm-9">
		                                 <select name="join_mc_id" id="join_mc_id" class="col-xs-12 col-sm-6">
		                                  <option value="0" >无MC</option>
		                                        <?php if(is_array($mcs)): $i = 0; $__LIST__ = $mcs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mc): $mod = ($i % 2 );++$i;?><option value="<?php echo ($mc["id"]); ?>" ><?php echo ($mc["name_cn"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		                                    </select> 
		                                </div>
		                            	</div> 

											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-3 no-padding-right">合同类型</label>

												<div class="col-xs-12 col-sm-9">
													<label class="radio-inline">
														<input type="radio" name="type" value="0" checked="checked">普通合同</label>
													<label class="radio-inline">
														<input type="radio" name="type" value="1">团卡合同</label>

												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="card_type_id">选择卡种:</label>

												<div class="col-xs-12 col-sm-9">
													<div class="clearfix">
														<select name="card_type_id" id="card_type_id" class="col-xs-12 col-sm-6">
															<option value="0">请选择卡种</option>
															<?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?><option value="<?php echo ($type["id"]); ?>"><?php echo ($type["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
														</select>

													</div>
												</div>
											</div>

											<div class="form-group hide" id="detail">

												<label class="control-label col-xs-6 col-sm-3 no-padding-right" for="cardtype"></label>
												<label >卡种类型:</label>
												<label  id="cardtype" ></label>

												<label >&nbsp;&nbsp;&nbsp;有效时间:</label>
												<label  id="valid_time" ></label>

												<label >&nbsp;&nbsp;&nbsp;有效次数:</label>
												<label  id="valid_number"></label>
												<label >&nbsp;&nbsp;&nbsp;报价:</label>
												<label  id="i_price"></label>

												<label >&nbsp;&nbsp;&nbsp;最低价:</label>
												<label  id="i_min_price"></label>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="active_type">开卡方式:</label>

												<div class="col-xs-12 col-sm-9">
													<div class="clearfix">
														<select name="active_type" id="active_type" class="col-xs-12 col-sm-6">
															<option value="0">买卡当天开卡</option>
															<option value="1">指定日期开卡</option>
															<option value="2">第一次到开卡</option>
															<!-- <option value="3">指定天数内开卡</option>
														-->
													</select>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="present_day">新办赠送天数:</label>

											<div class="col-xs-12 col-sm-9">
												<div class="clearfix">
													<input type="text" class="col-xs-12 col-sm-6" name="present_day" id="present_day" value="0">
													<label   class="col-xs-12 col-sm-2" name="day_tip" id="day_tip" ></label>
												</div>
											</div>

										</div>

										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="present_num">新办赠送次数:</label>

											<div class="col-xs-12 col-sm-9">
												<div class="clearfix">
													<input type="text" class="col-xs-12 col-sm-6" name="present_num" id="present_num" value="0">
													<label   class="col-xs-12 col-sm-2" id="num_tip" ></label>
												</div>
											</div>

										</div>

										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="start_time">合同开始日期:</label>

											<div class="col-xs-12 col-sm-9">
												<input type="text" class="col-xs-12 col-sm-6" name="start_time" id="start_time" disabled></div>

										</div>

										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="end_time" >合同结束日期:</label>

											<div class="col-xs-12 col-sm-9">
												<input type="text" class="date_ymd col-xs-12 col-sm-6 " name="end_time" id="end_time" disabled></div>

										</div>
	 

										<div class="form-group">
										<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="free_trans">免费转会籍一次:</label>

										<div class="col-sm-9"> 
											<span class="help-inline col-xs-12 col-sm-7">
												<label class="middle">
													<input class="ace" type="checkbox" name="free_trans" id="free_trans" /> 
														<span class="lbl"> &nbsp</span>
												</label>
											</span>
										</div>
										</div>



										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="free_rest" >免费停卡次数:</label>

											<div class="col-xs-12 col-sm-9">
												<input type="text" class="col-xs-12 col-sm-6 " name="free_rest" id="free_rest" value="0"></div>

										</div> 
  

										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="card_number" >人工输入卡号:</label>

											<div class="col-xs-12 col-sm-9">
												<input type="text" class="col-xs-12 col-sm-6 " name="card_number" id="card_number"></div>

										</div>

									</div>
								</form>

							</div>
						</div>

						<div class="step-pane" id="step3">
							<div class="row-fluid">
								<div class="col-xs-12">
									<form class="form-horizontal" id="validation-form" method="post">

										<div class="form-group">
											<label for="should_pay" class="control-label col-xs-12 col-sm-3 no-padding-right">应收金额</label>

											<div class="col-xs-12 col-sm-9">
												<input class="col-xs-12 col-sm-6" type="text" name="should_pay" id="should_pay"></div>
										</div>

										<div class="form-group">
											<label for="should_pay" class="control-label col-xs-12 col-sm-3 no-padding-right">已交定金</label>

											<div class="col-xs-12 col-sm-9">
												<input class="col-xs-12 col-sm-6" type="text" name="book_price" id="book_price" value="0" disabled></div>
										</div>


										<div class="form-group">
											<label for="cash" class="control-label col-xs-12 col-sm-3 no-padding-right">现金</label>
											<div class="col-xs-12 col-sm-9">
												<input class="col-xs-12 col-sm-6" type="text" name="cash" id="cash" value="0"></div>
										</div>
										<div class="form-group">
											<label for="pos" class="control-label col-xs-12 col-sm-3 no-padding-right">刷卡</label>
											<div class="col-xs-12 col-sm-9">
												<input value="0" class="col-xs-12 col-sm-6" type="text" name="pos" id="pos"></div>
										</div>
										<div class="form-group">
											<label for="check" class="control-label col-xs-12 col-sm-3 no-padding-right">支票</label>
											<div class="col-xs-12 col-sm-9">
												<input value="0" class="col-xs-12 col-sm-6" type="text" name="check" id="check"></div>
										</div>
										<div class="form-group">
											<label for="check_num" class="control-label col-xs-12 col-sm-3 no-padding-right">支票号</label>
											<div class="col-xs-12 col-sm-9">
												<input class="col-xs-12 col-sm-6" type="text" name="check_num" id="check_num"></div>
										</div>

	 <div class="form-group">
              <label for="network" class="control-label col-xs-12 col-sm-3 no-padding-right">网络支付</label>
              <div class="col-xs-12 col-sm-9">
                <input value="0" class="col-xs-12 col-sm-6" type="text" name="network" id="network"></div>
            </div>
            <div class="form-group">
              <label for="netbank" class="control-label col-xs-12 col-sm-3 no-padding-right">网银分期</label>
              <div class="col-xs-12 col-sm-9">
                <input value="0" class="col-xs-12 col-sm-6" type="text" name="netbank" id="netbank"></div>
            </div>

            <div class="form-group">
              <label for="contract_number" class="control-label col-xs-12 col-sm-3 no-padding-right">合同号</label>
              <div class="col-xs-12 col-sm-9">
                <input value="0" class="col-xs-12 col-sm-6" type="text" name="contract_number" id="contract_number"></div>
            </div>


										<div class="form-group">
											<label for="description" class="control-label col-xs-12 col-sm-3 no-padding-right">备注</label>
											<div class="col-xs-12 col-sm-9">
												<textarea class="col-xs-12 col-sm-6"  name="description" id="description" rows="3"></textarea>
											</div>
										</div>

									</div>
								</div>
							</form>
						</div>

						<div class="step-pane" id="step4">
							<div class="center">
								<h3 class="green">恭喜您合同签订成功!</h3>
								<div >
									<h4 id="info" class="red">恭喜您合同签订成功!</h4>
								</div>
							</div>
						</div>
					</div>

					<hr />
					<div class="row-fluid wizard-actions">
						<button class="btn btn-prev">
							<i class="icon-arrow-left"></i>
							上一步
						</button>

						<button class="btn btn-success btn-next" id="nextbtn" data-last="Finish ">
							下一步
							<i class="icon-arrow-right icon-on-right"></i>
						</button>
					</div>
				</div>

			</div>

		</div>
	</div>







<div class="modal fade " id="grantModal" tabindex="-1" role="dialog" aria-labelledby="grantModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
 			 <div class="modal-header">
 
   				 <h4 class="modal-title" id="chpasswdModalLabel">输入有授权超低价卡价的账号</h4>
  			</div>
	 		 	<div class="modal-body"> 

			      <div class="form-group">
			        <label for="original_password" class="col-sm-3 control-label">帐号：</label>
			        <div class="col-sm-9">
			            <input type="text"  class="form-control" id="grant_user_name" >
			        </div>
			      </div>

			      <div class="form-group">
			        <label for="ptchoose_name" class="col-sm-3 control-label">密码：</label>
			        <div class="col-sm-9">
			          <input type="password" class="form-control" id="grant_user_password" ></div>
			      </div> 
			 </div>
		    <div class="modal-footer">
		       <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>  
		      <button type="button" class="btn btn-primary" onclick="grant()">确认</button>
		    </div>
		</div>
	</div>
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
 $("#menu_6").addClass("active open");
    $("#menu_37").addClass("active");

var can_grant = <?php echo ($can_grant); ?>;
function grant()
{
	$('#grantModal').modal("hide"); 
	var grant_user_name = $("#grant_user_name").val();
	var grant_user_password = $("#grant_user_password").val();
	$.ajax({
						    type:"post",
						    async:false,
						    url:"/Cashier/Member/join",
						    data:{contract_number:$("#contract_number").val(),grant_user_name:grant_user_name,grant_user_password:grant_user_password,member_id:id,type:$("[name=type]:checked").val(),card_type_id:$("#card_type_id").val(),active_type:$("#active_type").val(),present_day:$("#present_day").val(),present_num:$("#present_num").val(),start_time:$("#start_time").val(),end_time:$("#end_time").val(),price:$("#should_pay").val(),cash:$("#cash").val(),card_number:$("#card_number").val(),pos:$("#pos").val(),free_trans:$("#free_trans").prop("checked"), check:$("#check").val(),check_num:$("#check_num").val(),description:$("#description").val(),free_rest:$("#free_rest").val(),network:$("#network").val(),netbank:$("#netbank").val(),join_mc_id:$("#join_mc_id").val()},
						    success:function(data,textStatus){   
						                if(data.status){          
						                $("#info").text("您的卡号为："+data.card_id);  
						                ret=success=true; 
						                $("#nextbtn").click();
	                            } else {
	                                bootbox.alert(data.info);    
	                               ret= false;            
	                            }       
						    }

						  });
}



	var id;
	var success=false;
	var saletypes = eval("(" + '<?php echo ($typesarr); ?>' + ")");
	$(function(){ 

		$("#start_time").datetimepicker({
      format: 'yyyy-mm-dd',
      minView:'2',
      startView:'2',
      language:'zh-CN',
      autoclose:true,
    }).on('changeDate', function(ev){
      calEndTime();
	});


	function   DateAdd(interval,number,date)  
{  
/* 
  *   功能:实现VBScript的DateAdd功能. 
  *   参数:interval,字符串表达式，表示要添加的时间间隔. 
  *   参数:number,数值表达式，表示要添加的时间间隔的个数. 
  *   参数:date,时间对象. 
  *   返回:新的时间对象. 
  *   var   now   =   new   Date(); 
  *   var   newDate   =   DateAdd( "d ",5,now); 
  *---------------   DateAdd(interval,number,date)   ----------------- 
  */  
        switch(interval)  
        {  
                case   "y"   :   {  
                        date.setFullYear(date.getFullYear()+number);  
                        return   date;  
                        break;  
                }  
                case   "q"   :   {  
                        date.setMonth(date.getMonth()+number*3);  
                        return   date;  
                        break;  
                }  
                case   "m"   :   {  
                        date.setMonth(date.getMonth()+number);  
                        return   date;  
                        break;  
                }  
                case   "w"   :   {  
                        date.setDate(date.getDate()+number*7);  
                        return   date;  
                        break;  
                }  
                case   "d"   :   {  
                        date.setDate(date.getDate()+number);  
                        return   date;  
                        break;  
                }  
                case   "h"   :   {  
                        date.setHours(date.getHours()+number);  
                        return   date;  
                        break;  
                }  
                case   "m"   :   {  
                        date.setMinutes(date.getMinutes()+number);  
                        return   date;  
                        break;  
                }  
                case   "s"   :   {  
                        date.setSeconds(date.getSeconds()+number);  
                        return   date;  
                        break;  
                }  
                default   :   {  
                        date.setDate(d.getDate()+number);  
                        return   date;  
                        break;  
                }  
        }  
}  



		function calEndTime()
		{
			if($("#active_type").val()=="2") return;
			if(current_card_type==null) return;
			var start_time=$("#start_time").val();
			 s_start_time = start_time.replace(/-/g,"/");
  			var start = new Date(s_start_time );
  			var end = start; 
 			end = DateAdd("m",parseInt(current_card_type.valid_time),end);	
 			end = DateAdd("d",parseInt($("#present_day").val()),end);	 
			$("#end_time").val(end.format("yyyy-MM-dd"));
		};
		// $("#present_day").blur(function(){
		// 	calEndTime();
		// });
		$("#present_day").on('input',function(e){  
   				calEndTime();
		});  

		$("#active_type").change(function(){
			var value = $(this).val();
			var now = new Date();			 
			$("#start_time").val(now.format("yyyy-MM-dd"));  
			switch(value)
			{
				case "0":
					$("#start_time").attr("disabled",true);	 
					calEndTime();
				break;
				case "1": 
					$("#start_time").attr("disabled",false);	
					calEndTime();				
				break;
				case "2":
					$("#start_time").attr("disabled",true);	 
					$("#start_time").val("");
					$("#end_time").val("");
				break;				 
				default:
				break;
			}
		});
			var current_card_type=null;

			$("#card_type_id").change(function(){
				$("#start_time").val("");
				$("#end_time").val("");
				var card_type_id = $(this).val();
				if(card_type_id==0)
				{
					$("#detail").addClass("hide");
				}
				current_card_type=null;
				for(var i=0;i<saletypes.length;i++)
				{
					if(saletypes[i].id==card_type_id)
					{
						var ct=saletypes[i].type==1?"时间卡":"次数卡"
						$("#cardtype").text(ct);
						var vt=saletypes[i].valid_time+" 月";						
						$("#valid_time").text(vt);
						var vn=saletypes[i].type==1?"不限次数":saletypes[i].valid_number+" 次"					
						$("#valid_number").text(vn);
						$("#i_price").text(saletypes[i].price);
						$("#i_min_price").text(saletypes[i].min_price);

						$("#detail").removeClass("hide");
						  $("#day_tip").text("<"+saletypes[i].max_present_day);
                        $("#num_tip").text("<"+saletypes[i].max_present_num);
						$("#present_value").val(saletypes[i].max_present_value);
						var now = new Date();
						var year = now.getFullYear();
						var month = now.getMonth()+1;
						var day = now.getDate();
						$("#start_time").val(year+"-"+padLeft(month,2)+"-"+padLeft(day,2)); 
						
						$("#should_pay").val(saletypes[i].price);
						current_card_type=saletypes[i];
						 calEndTime();
						return;
					}
					$("#detail").addClass("hide");
				}
			}); 
				$('#fuelux-wizard').ace_wizard().on('change' , function(e, info){ 
					if(info.step == 1) {
						 var ele=$("#member_info tbody :radio:checked");						
						 if(ele.length==0) return false; 
						   if($("#member_info tbody :radio:checked").parent().parent().find(".can_modify").length==0)
						  {
						   
						  	bootbox.alert("提示：该会员已是正式会员，应该到会籍合同管理中进行续会或者升级！继续入会会重新生成一张会员卡！~~");
						   
						  	// 
						  	// $("#card_number").val($("#member_info tbody :radio:checked").parent().parent().find("td:last").html());
						  	// $("#card_number").attr("readonly","readonly");
						  }
						 id = (ele.val());						 
					}
					else if(info.step == 2 && info.direction=='next') {
						if($("#card_type_id").val()==0)
						{
							bootbox.alert("请选择卡种",null);
							return false;
						}
						if($("#start_time").val()=='' && $("#active_type").val()!="2")
						{
							bootbox.alert("请选择开始日期",null);
							return false;
						}
						if($("#end_time").val()=='' && $("#active_type").val()!="2")
						{
							bootbox.alert("请选择结束日期",null);
							return false;
						}
					}
					else if(info.step == 3 && info.direction=='next') {
						if(success) return;
						var ret = false;
                        var min_price = $("#i_min_price").text();
                        min_price= parseInt(min_price);

                        var price = $("#should_pay").val();
                        price = parseInt(price);

                         var grant_user_name="";
                           var grant_user_password="";
                        if(price < min_price && can_grant!=1)
                        {
                        	  $('#grantModal').modal("show"); 
                        }
                        else
                        {
                        	grant();
                        }
						
                          

 						return ret;		 
 
					}

				}).on('finished', function(e) {
					 window.location.href = "/Cashier/Member/index";
				}).on('stepclick', function(e){

				});
			  
	})
	</script>
</body>
</html>