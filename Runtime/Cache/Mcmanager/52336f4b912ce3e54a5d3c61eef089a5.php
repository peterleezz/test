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
			<a href="<?php echo U('Home/Main/main');?>">MC经理</a>
		</li>
		<li class="active">MC业绩统计</li>

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
			<div class="row">
				<div class="space-6"></div>

				<div class="col-sm-6  infobox-container">
					<div class="infobox infobox-green  ">
						<div class="infobox-icon"> <i class="icon-github-alt"></i>
						</div>

						<div class="infobox-data">
							<span class="infobox-data-number"><?php echo ($potential_number); ?></span>
							<div class="infobox-content">新增潜客量</div>
						</div>
						<div class="stat <?php echo ($pr_stat); ?>"><?php echo ($potential_ratio); ?>%</div>
					</div>

					<div class="infobox infobox-blue  ">
						<div class="infobox-icon">
							<i class="icon-user"></i>
						</div>

						<div class="infobox-data">
							<span class="infobox-data-number"><?php echo ($member_number); ?></span>
							<div class="infobox-content">新增会员量</div>
						</div>

						<div class="stat <?php echo ($mr_stat); ?>"><?php echo ($member_ratio); ?>%</div>
					</div>

					<div class="infobox infobox-pink  ">
						<div class="infobox-icon">
							<i class="icon-shopping-cart"></i>
						</div>

						<div class="infobox-data">
							<span class="infobox-data-number">￥<?php echo ($cardsale); ?></span>
							<div class="infobox-content">会员卡销售额</div>
						</div>
						<div class="stat <?php echo ($cs_stat); ?>"><?php echo ($cardsale_ratio); ?>%</div>
					</div>

					<div class="infobox infobox-red  ">
						<div class="infobox-icon">
							<i class="icon-shopping-cart"></i>
						</div>

						<div class="infobox-data">
							<span class="infobox-data-number">￥<?php echo ($goodssale); ?></span>
							<div class="infobox-content">商品销售额</div>
						</div>
						<div class="stat <?php echo ($gs_stat); ?>"><?php echo ($goodssale_ratio); ?>%</div>
					</div>

					<div class="infobox infobox-orange">
						<div class="infobox-icon">
							<i class="icon-mobile-phone"></i>
						</div>

						<div class="infobox-data">
							<span class="infobox-data-number"><?php echo ($cfn); ?></span>
							<div class="infobox-content">潜客跟进</div>
						</div>
						<div class="stat <?php echo ($fn_stat); ?>"><?php echo ($fn_ratio); ?>%</div>

					</div>

					<div class="infobox infobox-orange2  ">
						<div class="infobox-icon">
							<i class="icon-calendar"></i>
						</div>

						<div class="infobox-data">
							<span class="infobox-data-number"><?php echo ($cfsn); ?></span>
							<div class="infobox-content">潜客邀约</div>
						</div>
						<div class="stat <?php echo ($fsn_stat); ?>"><?php echo ($fsn_ratio); ?>%</div>

					</div>

					<div class="infobox infobox-grey  ">
						<div class="infobox-icon">
							<i class="icon-mobile-phone"></i>
						</div>

						<div class="infobox-data">
							<span class="infobox-data-number"><?php echo ($csn); ?></span>
							<div class="infobox-content">会员跟进</div>
						</div>

						<div class="stat <?php echo ($sn_stat); ?>"><?php echo ($sn_ratio); ?>%</div>
					</div>
					<div class="infobox infobox-black ">
						<div class="infobox-icon">
							<i class="icon-share"></i>
						</div>

						<div class="infobox-data">
							<span class="infobox-data-number"><?php echo ($cssn); ?></span>
							<div class="infobox-content">销售成功</div>
						</div>

						<div class="stat <?php echo ($ssn_stat); ?>"><?php echo ($ssn_ratio); ?>%</div>
					</div>
					<div class="space-6"></div>

					<div class="infobox infobox-green infobox-small infobox-dark">
						<div class="infobox-progress">
							<div class="easy-pie-chart percentage" data-percent="61" data-size="39">
								<span class="percent"><?php echo ($finished); ?></span>
								%
							</div>
						</div>

						<div class="infobox-data">
							<div class="infobox-content">任务</div>
							<div class="infobox-content">完成</div>
						</div>
					</div>

					<div class="infobox infobox-blue infobox-small infobox-dark">
						<div class="infobox-icon">
							<i class="icon-money"></i>
						</div>

						<div class="infobox-data">
							<div class="infobox-content">总销售额</div>
							<div class="infobox-content">￥<?php echo ($cardsale+$goodssale); ?></div>
						</div>
					</div>

					<div class="infobox infobox-grey infobox-small infobox-dark">
						<div class="infobox-icon">
							<i class="icon-download-alt"></i>
						</div>

						<div class="infobox-data">
							<div class="infobox-content">邀约来访</div>
							<div class="infobox-content">待统计！</div>
						</div>
					</div>
				</div>

				<div class="vspace-sm"></div>

				<div class="col-sm-5">
					<div class="widget-box">
						<div class="widget-header widget-header-flat widget-header-small">
							<h5>
								<i class="icon-signal"></i>
								最近半年会员/潜客统计
							</h5>

							<div class="widget-toolbar no-border">
								<button id="stat1btn" class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
									门店全体
									<i class="icon-angle-down icon-on-right bigger-110"></i>
								</button>

								<ul class="dropdown-menu pull-right dropdown-125 dropdown-lighter dropdown-caret">
									<li>
										<a href="javascript:void(0)" class="blue" onclick="$('#stat1btn').text('门店全体');reloadmemberstat(null,null,null)">
											<i class="icon-caret-right bigger-110 invisible">&nbsp;</i>
											门店全体
										</a>
									</li>

									<?php if(is_array($mcs)): $i = 0; $__LIST__ = $mcs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mc): $mod = ($i % 2 );++$i;?><li>
											<a href="javascript:void(0)" class="blue" onclick="$('#stat1btn').text('<?php echo ($mc["name_cn"]); ?>');reloadmemberstat(null,null,<?php echo ($mc["id"]); ?>)">
												<i class="icon-caret-right bigger-110 invisible">&nbsp;</i>
												<?php echo ($mc["name_cn"]); ?>
											</a>
										</li><?php endforeach; endif; else: echo "" ;endif; ?>
								</ul>
							</div>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								<canvas id="myChart"  height="260px"></canvas>
							</div>
						</div>
					</div>
				</div>

				<div class="clearfix visible-sm-block"></div>
				<div class="col-sm-6 ">
					<div class="widget-box">
						<div class="widget-header widget-header-flat widget-header-small">
							<h5>
								<i class="icon-signal"></i>
								本月MC潜客量统计
							</h5>

							<div class="widget-toolbar no-border"></div>
						</div>
						<div class="widget-body">
							<div class="widget-main">
								<canvas id="protential_chart"  height="260px"></canvas>
							</div>
						</div>

					</div>
				</div>

				<div class="col-sm-6 ">
					<div class="widget-box">
						<div class="widget-header widget-header-flat widget-header-small">
							<h5>
								<i class="icon-signal"></i>
								本月MC转化量统计
							</h5>

							<div class="widget-toolbar no-border"></div>
						</div>
						<div class="widget-body">
							<div class="widget-main">
								<canvas id="member_chart"  height="260px"></canvas>
							</div>
						</div>

					</div>
				</div>


				<div class="col-sm-6 ">
					<div class="widget-box">
						<div class="widget-header widget-header-flat widget-header-small">
							<h5>
								<i class="icon-signal"></i>
								MC计划完成情况()
							</h5>

							<div class="widget-toolbar no-border"></div>
						</div>
						<div class="widget-body">
							<div class="widget-main">
								<canvas id="finish_chart"  height="260px"></canvas>
							</div>
						</div>

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
	var myNewChart=null ;
	

	function init_protential_chart()
	{
		$.post('/Mcmanager/Mcstatistics/getProtential',{}, function(data,textStatus){
             if(data.status){    
             	var piedata = new Array();
             		if(data.data!=null)
              		for(var i=0;i<data.data.length;i++)
              		{
              			var dt={};
              			dt.value=parseInt(data.data[i].protential_total);
              			if(data.data[i].mc==null || data.data[i].mc.name_cn==null)
              				dt.label='非MC';
              			else 
              				dt.label=data.data[i].mc.name_cn;
              			dt.labelColor='black';
              			dt.labelFontSize=16;
              			dt.color="#"+getRandColorValue(); 
              			piedata[i]=dt; 
              		}
  var myPie = new Chart(document.getElementById("protential_chart").getContext("2d")).Pie(piedata, {
				        labelAlign: 'center'
				    });
              		

              	 
				

			
                } else {
                     bootbox.alert(data.info,null);              
                }
    		}, "json"); 
	}
 
	function init_member_chart()
	{
		$.post('/Mcmanager/Mcstatistics/getTransform',{}, function(data,textStatus){
             if(data.status){    
             	var piedata = new Array();
if(data.data!=null)
              		for(var i=0;i<data.data.length;i++)
              		{
              			var dt={};
              			dt.value=parseInt(data.data[i].transform_total);
              			if(data.data[i].mc==null || data.data[i].mc.name_cn==null)
              				dt.label='非MC';
              			else 
              				dt.label=data.data[i].mc.name_cn;
              			dt.labelColor='black';
              			dt.labelFontSize=16;
              			dt.color="#"+getRandColorValue(); 
              			piedata[i]=dt; 
              		}
  var myPie = new Chart(document.getElementById("member_chart").getContext("2d")).Doughnut(piedata, {
				        labelAlign: 'center'
				    });
              		

              	 
				

			
                } else {
                     bootbox.alert(data.info,null);              
                }
    		}, "json"); 
	}


function init_finish_chart()
	{
		$.post('/Mcmanager/Mcstatistics/getProtentialFinish',{}, function(data,textStatus){
             if(data.status){  
             if(data.data==null){ 
             	return;
             }  
             	var labels=new Array();
             	var data1=new Array();
             	var data2=new Array();
             	var value=data.data; 
             	if(value!=null)
              		for(var i=0;i<value.length;i++)
              		{
              			 
              			labels[i]=value[i].name; 
              			if(value[i].st!=null){
              			data1[i]=value[i].st[0].protential_plan;
              			data2[i]=value[i].st[0].protential_value; 
              			}
              		}
              		 
              	var data = {
					labels : labels,
					datasets : [
						{
							label: "Protential Plan",
				            fillColor: "rgba(220,220,220,0.2)",
				            strokeColor: "rgba(220,220,220,1)",
				            pointColor: "rgba(220,220,220,1)",
				            pointStrokeColor: "#fff",
				            pointHighlightFill: "#fff",
				            pointHighlightStroke: "rgba(220,220,220,1)",
							data : data1
						}, 
						{
							 label: "Protential Real",
				            fillColor: "rgba(151,187,205,0.2)",
				            strokeColor: "rgba(151,187,205,1)",
				            pointColor: "rgba(151,187,205,1)",
				            pointStrokeColor: "#fff",
				            pointHighlightFill: "#fff",
				            pointHighlightStroke: "rgba(151,187,205,1)",
							data : data2
						}
					]
				}

  var myPie = new Chart(document.getElementById("finish_chart").getContext("2d")).Radar(data, {
				        labelAlign: 'center'
				    });
              		

              	 
				

			
                } else {
                     bootbox.alert(data.info,null);              
                }
    		}, "json"); 
	}



	function reloadmemberstat(start_time,end_time,user_id)
	{
		 $.post('/Mcmanager/Mcstatistics/getMemberStatistics',{start_time:start_time,end_time:end_time,user_id:user_id}, function(data,textStatus){
             if(data.status){
             	var labels=new Array();
             	var data1=new Array();
             	var data2=new Array();
             	var value=data.data;

             	var ctx = document.getElementById("myChart").getContext("2d");
				if(myNewChart!=null) 
				{
					var length=myNewChart.datasets[1].bars.length;
					for(var i=0;i<length;i++)
	             	{
	             		myNewChart.removeData();
	             	} 
	             	myNewChart.update(); 
				}
	             	
              		for(var i=0;i<value.length;i++)
              		{
              			labels[i]=value[i].m;
              			data1[i]=value[i].protential_total;
              			data2[i]=value[i].transform_total;
              			if(myNewChart!=null) 
              				myNewChart.addData([value[i].protential_total, value[i].transform_total], value[i].m);
              		}
              	var data = {
					labels : labels,
					datasets : [
						{
							fillColor : "rgba(220,220,220,0.5)",
							strokeColor : "rgba(220,220,220,1)",
							data : data1
						}, 
						{
							fillColor : "rgba(151,187,205,0.5)",
							strokeColor : "rgba(151,187,205,1)",
							data : data2
						}
					]
				}
				 
				var ctx = document.getElementById("myChart").getContext("2d");
				if(myNewChart==null)
				{
				  myNewChart = new Chart(ctx).Bar(data,{}); 
				}
				else
				{ 
				 	
					myNewChart.update();

				}

			
                } else {
                     bootbox.alert(data.info,null);              
                }
    		}, "json");
	}

	$(function(){	
	$("#menu_7").addClass("active");
 $("#menu_58").addClass("active open");

		reloadmemberstat(null,null,null);
		init_protential_chart();
		init_member_chart();
		init_finish_chart();
	})
	</script>
</body>
</html>