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

  
	<link rel="stylesheet" href="/Public/css/ace.min.css" />
	<style type="text/css">
		table input{width:100%;}
		table,input{margin:0px;padding:0px;}
		.intr{margin-top:30px;padding:0px}
		.intr div{width:100%;}
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
		<li class="active">计划</li>

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
    

	<div class="form-group ">
		<label for="user_id">选择MC:</label>
		<select name="user_id" id="user_id">
			<?php if(is_array($users)): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?><option value="<?php echo ($user["id"]); ?>"><?php echo ($user["name_cn"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		</select>
	</div>

	<div class="row">
		<div class="col-sm-12">

			<div class="tabbable">
				<ul class="nav nav-tabs" id="myTab">
					<li  class="active">
						<a data-toggle="tab" href="#new"> <i class="green icon-shopping-cart bigger-110"></i>
							新潜客产出计划
						</a>
					</li >

					<li >
						<a data-toggle="tab" href="#old">
							<i class="green icon-home bigger-110"></i>
							老潜客产出计划
						</a>
					</li>

					<li >
						<a data-toggle="tab" href="#member">
							<i class="green icon-home bigger-110"></i>
							会员产出计划
						</a>
					</li>
				</ul>

				<div class="tab-content">
					<div id="new" class="tab-pane in  active">

						<form action="<?php echo U('Mcmanager/Plannew/newmonth');?>" method="post"  id="new_plan_form" class="plan_form">

							<table class="table table-condensed">
								<thead>
									<tr>
										<th>新增潜客量</th>
										<th>邀约次数</th>
										<th>邀约量</th>
										<th>到场量</th>
										<th>A类客户量</th>
										<th>B类客户量</th>
										<th>预购金额</th>
										<th>售出金额</th>
										<th>成交单数</th>
										<th>转换量</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<input type="text" name="protential"></td>
										<td>
											<input type="text" name="invit"></td>
										<td>
											<input type="text" name="invit_success"></td>
										<td>
											<input type="text" name="invit_come"></td>
										<td>
											<input type="text" name="a_member"></td>
										<td>
											<input type="text" name="b_member"></td>
										<td>
											<input type="text" name="pre_sale"></td>
										<td>
											<input type="text" name="sale"></td>
										<td>
											<input type="text" name="deal_num"></td>
										<td>
											<input type="text" name="transform"></td>
										<td>
											<button type="submit" class="btn  btn-info btn-sm" >
												<i class="icon-signin"></i>
												自动分配
											</button>
										</td>
									</tr>

								</tbody>
							</table>
						</form>
						<div class="space" ></div>

						<div id="calendar" class="col-xs-11 calendar_c"></div>
						<div  class="col-xs-1 intr">
							
							 
											
											<div class="label label-success label-lg">新增潜客量</div>
											
											<div class="label label-warning label-lg"> 
												到场量
											</div>
											<div class="label label-danger label-lg">A类客户量</div>
											<div class="label label-info label-lg">预购金额</div>
											<div class="label label-inverse label-lg">售出金额</div>
											<div class="label label-lg">成交单数</div>
									 

						</div>

						<div class="space" ></div>
						<button type="submit" class="" style="width:100%;height:1px">
							<i class="icon-ok"></i>
							
						</button>
					</div>

					<div id="old" class="tab-pane ">
						

						<form action="<?php echo U('Mcmanager/Plannew/oldmonth');?>" method="post"  id="old_plan_form" class="plan_form">

							<table class="table table-condensed">
								<thead>
									<tr> 
										<th>邀约次数</th>
										<th>邀约量</th>
										<th>到场量</th>
										<th>A类客户量</th>
										<th>B类客户量</th>
										<th>预购金额</th>
										<th>售出金额</th>
										<th>成交单数</th>
										<th>转换量</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										
										<td>
											<input type="text" name="invit"></td>
										<td>
											<input type="text" name="invit_success"></td>
										<td>
											<input type="text" name="invit_come"></td>
										<td>
											<input type="text" name="a_member"></td>
										<td>
											<input type="text" name="b_member"></td>
										<td>
											<input type="text" name="pre_sale"></td>
										<td>
											<input type="text" name="sale"></td>
										<td>
											<input type="text" name="deal_num"></td>
										<td>
											<input type="text" name="transform"></td>
										<td>
											<button type="submit" class="btn  btn-info btn-sm" >
												<i class="icon-signin"></i>
												自动分配
											</button>
										</td>
									</tr>

								</tbody>
							</table>
						</form>
						<div class="space" ></div>

						<div id="calendar_old" class="col-xs-11 calendar_c"></div>
						<div  class="col-xs-1 intr">
							 
											
											<div class="label label-warning label-lg"> 
												到场量
											</div>
											<div class="label label-danger label-lg">A类客户量</div>
											<div class="label label-info label-lg">预购金额</div>
											<div class="label label-inverse label-lg">售出金额</div>
											<div class="label label-lg">成交单数</div>
									 

						</div>

						<div class="space" ></div>
						<button type="submit" class="" style="width:100%;height:1px">
							<i class="icon-ok"></i>
							
						</button>

					</div>

					<div id="member" class="tab-pane ">
						

						<form action="<?php echo U('Mcmanager/Plannew/membermonth');?>" method="post"  id="member_plan_form" class="plan_form">

							<table class="table table-condensed">
								<thead>
									<tr>  
										<th>A类客户量</th>
										<th>B类客户量</th>
										<th>预购金额</th>
										<th>售出金额</th>
										<th>成交单数</th> 
										<th>三个月内到期</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr> 
									 
										<td>
											<input type="text" name="a_member"></td>
										<td>
											<input type="text" name="b_member"></td>
										<td>
											<input type="text" name="pre_sale"></td>
										<td>
											<input type="text" name="sale"></td>
										<td>
											<input type="text" name="deal_num"></td>
										<td>
											<input type="text" id="recently_num" ></td>
										<td>
											<button type="submit" class="btn  btn-info btn-sm" >
												<i class="icon-signin"></i>
												自动分配
											</button>
										</td>
									</tr>

								</tbody>
							</table>
						</form>
						<div class="space" ></div>

						<div id="calendar_member" class="col-xs-11 calendar_c"></div>
						<div  class="col-xs-1 intr"> 
											<div class="label label-danger label-lg">A类客户量</div>
											<div class="label label-info label-lg">预购金额</div>
											<div class="label label-inverse label-lg">售出金额</div>
											<div class="label label-lg">成交单数</div>
									 

						</div>

						<div class="space" ></div>
						<button type="submit" class="" style="width:100%;height:1px">
							<i class="icon-ok"></i>
							
						</button> 

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

 
	<script src="/Public/js/jquery-ui-1.10.3.full.min.js"></script>
	
	<script type="text/javascript"> 

	function spinner_init()
	{

			$( ".spinner" ).spinner({
					create: function( event, ui ) {
						//add custom classes and icons
						$(this)
						.next().addClass('btn btn-success').html('<i class="icon-plus"></i>')
						.next().addClass('btn btn-danger').html('<i class="icon-minus"></i>')
						
						//larger buttons on touch devices
						if(ace.click_event == "tap") $(this).closest('.ui-spinner').addClass('ui-spinner-touch');
					}
				});

	}
function loadTotalPlan(type)
{
	 if(type==0)
             {
             	var id="#new_plan_form";
             }else if(type==1)
             {
             	var id="#old_plan_form";
             }else  if(type==2)
             {
             	var id="#member_plan_form";
             }
	user_id=$("#user_id").val();
	time = $(id).parent().find(".calendar_c").fullCalendar( 'getDate' );
	time=time.format('yyyy-MM'); 
	var now=new Date();
	now=now.format('yyyy-MM'); 
	if(now >=time)
	{
		$(id+" button[type=submit]").attr('disabled',"true");
	}
	else
	{
		$(id+" button[type=submit]").removeAttr("disabled");
	}
	 $.post("<?php echo U('Mcmanager/Plannew/loadTotalPlan');?>", {user_id:user_id,time:time,type:type }, function(data,textStatus){
      if(data.status){ 
             var info=data.data;    
             $(id+" input[type=text]").val(0);
             if(info==null)
             {
             	$(id+" button[type=submit]").removeAttr("disabled");
             	return;
             } 
             $(id+" input[name=protential]").val(info.protential) ;
             $(id+" input[name=invit]").val(info.invit) ;
             $(id+" input[name=invit_success]").val(info.invit_success) ;
             $(id+" input[name=invit_come]").val(info.invit_come) ;
             $(id+" input[name=deal_num]").val(info.deal_num) ;
             $(id+" input[name=a_member]").val(info.a_member) ;
             $(id+" input[name=b_member]").val(info.b_member) ;
             $(id+" input[name=pre_sale]").val(info.pre_sale) ;
             $(id+" input[name=sale]").val(info.sale) ;
             $(id+" input[name=transform]").val(info.transform) ;

              $("#recently_num").val(data.recently_num) ;
         } 
     }, "json"); 
}
$(".plan_form").submit(function(){   
  var self = $(this); 
  var data = self.serialize();
  var user_id=$("#user_id").val();
  var calendar=$(this).parent().find('.calendar_c');
  var d = $(this).parent().find('.calendar_c').fullCalendar('getDate');
  var month= d.format("yyyy-MM"); 
  data+="&user_id="+user_id+"&time="+month; 
        $.post(self.attr("action"), data, function(data,textStatus){
        	 bootbox.alert(data.info,null);        
             if(data.status){ 
                     calendar.fullCalendar('refetchEvents');
                } 
        }, "json");
        return false;
});



			jQuery(function($) {
 $("#menu_7").addClass("active");
 $("#menu_59").addClass("active open");  



$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) { 
  	$('.calendar_c').fullCalendar('render');
})


	function getCountDays(date) { 
        /* 获取当前月份 */
        var curDate=new Date();
        var curMonth = date.getMonth();
       /*  生成实际的月份: 由于curMonth会比实际月份小1, 故需加1 */
       curDate.setMonth(curMonth + 1);
       /* 将日期设置为0, 这里为什么要这样设置, 我不知道原因, 这是从网上学来的 */
       curDate.setDate(0);
       /* 返回当月的天数 */
       return curDate.getDate();
	}

	$("#user_id").change(function(){
	    $('.calendar_c').fullCalendar('refetchEvents');
	}); 

	/* initialize the calendar
	-----------------------------------------------------------------*/

	var date = new Date(); 
	var m = date.getMonth();
	date.setMonth(m + 1);
	var d = date.getDate();
	var m = date.getMonth(); 
	var y = date.getFullYear();
   
  
	  $('#calendar').fullCalendar({
		 titleFormat: {month:'yyyy年M月'}, 
		 year:y,
		 month:m,
		 buttonText: {
			prev: '<i class="icon-chevron-left"></i>',
			next: '<i class="icon-chevron-right"></i>',
			'today':"本月"
		},
		firstDay:1,
		weekMode:'liquid' , 
		monthNamesShort:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
		dayNames:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],
		dayNamesShort:["周日","周一","周二","周三","周四","周五","周六"],
		dayNamesMin:["日","一","二","三","四","五","六"],
		monthNames:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
		header: {
			left: 'prev,next today',
			center: 'title', 
			right:"xxx",
			// right: 'month,agendaWeek,agendaDay'
			right: ''
		}, 
		events: {
				url:'<?php echo U("Mcmanager/Plannew/getnewjson");?>',
				data: function() {
				 return {
                	user_id: $("#user_id").val()
            	};
            }
			}, 
		loading:function( isLoading, view )
		{
			if(isLoading) 
			 loadTotalPlan(0);
		},
		editable: false,
		droppable: false, // this allows things to be dropped onto the calendar !!! 
		selectable: false,
		selectHelper: true,
		
		eventClick: function(calEvent, jsEvent, view) {
			var title=calEvent.title;
			title=title.split(":");
			var lbl=title[0];
			var value=title[1];
			var date=calEvent.start;
			var days = getCountDays(date);
			if(days == calEvent.start.getDate())
			{
				return; 
			} 
			if(calEvent.start.getTime() < new Date().getTime())
			{
				return;
			}

			var form = $("<form  action=\"<?php echo U('Mcmanager/Plannew/setdaynew');?>\" class='form-inline'><label>"+lbl+" &nbsp;</label></form>");
			form.append("<input name='type' type=hidden value='" + calEvent.start + "' /> ");
			form.append("<input id='processway' name='processway' type=hidden value='0' /> ");

			form.append("<input name='value' class='spinner middle' autocomplete=off type=text value='" + value + "' /> ");  
			form.append("<button type='submit' class='btn btn-sm btn-success' onClick=\"javascript:$('#processway').val(0);\"><i class='icon-ok'></i> 保存</button>");
			form.append("<button type='submit' class='btn btn-sm btn-danger' onClick=\"javascript:$('#processway').val(1);\"><i class='icon-ok'></i> 修改</button>");

			form.append('<h6 class="green"> <i class="icon-hand-right icon-animated-hand-pointer blue"></i>分配，进行分配后，会把总计划剩余的值平均分配到第二天到最后一天	</h6>');
			form.append('<h6 class="red"> <i class="icon-hand-right icon-animated-hand-pointer red"></i>修改，本月其他时间的计划均不变，总计划值会根据修改的值变化！	</h6>');
			var div = bootbox.dialog({
				message: form,
			
				buttons: { 
					"close" : {
						"label" : "<i class='icon-remove'></i> 关闭",
						"className" : "btn-sm"
					} 
				}

			});
			spinner_init();
			form.on('submit', function(){ 

				 var data = form.serialize();
				  var user_id=$("#user_id").val(); 
				  data+="&user_id="+user_id; 
				  $.post(form.attr("action"), data, function(data,textStatus){ 
				             if(data.status){ 
				                     $('#calendar').fullCalendar('refetchEvents');
				                } 
				                else
				                {
				                	 bootbox.alert(data.info,null);   
				                }
				        }, "json"); 
				div.modal("hide");
				return false;
				
			}); 

		}
		
	}); 






$('#calendar_old').fullCalendar({
		 titleFormat: {month:'yyyy年M月'}, 
		 year:y,
		 month:m,
		 buttonText: {
			prev: '<i class="icon-chevron-left"></i>',
			next: '<i class="icon-chevron-right"></i>',
			'today':"本月"
		},
		firstDay:1,
		weekMode:'liquid' , 
		monthNamesShort:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
		dayNames:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],
		dayNamesShort:["周日","周一","周二","周三","周四","周五","周六"],
		dayNamesMin:["日","一","二","三","四","五","六"],
		monthNames:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
		header: {
			left: 'prev,next today',
			center: 'title',  
			right: ''
		}, 
		events: {
				url:'<?php echo U("Mcmanager/Plannew/getoldjson");?>',
				data: function() {
				 return {
                	user_id: $("#user_id").val()
            	};
            }
			}, 
		loading:function( isLoading, view )
		{
			if(isLoading) 
			 loadTotalPlan(1);
		},
		editable: false,
		droppable: false, // this allows things to be dropped onto the calendar !!! 
		selectable: false,
		selectHelper: true,
		
		eventClick: function(calEvent, jsEvent, view) {
			var title=calEvent.title;
			title=title.split(":");
			var lbl=title[0];
			var value=title[1];
			var date=calEvent.start;
			var days = getCountDays(date);
			if(days == calEvent.start.getDate())
			{
				return; 
			} 
			if(calEvent.start.getTime() < new Date().getTime())
			{
				return;
			}

			var form = $("<form  action=\"<?php echo U('Mcmanager/Plannew/setdayold');?>\" class='form-inline'><label>"+lbl+" &nbsp;</label></form>");
			form.append("<input name='type' type=hidden value='" + calEvent.start + "' /> ");
			form.append("<input id='processway' name='processway' type=hidden value='0' /> ");

			form.append("<input name='value' class='spinner middle' autocomplete=off type=text value='" + value + "' /> ");  
			form.append("<button type='submit' class='btn btn-sm btn-success' onClick=\"javascript:$('#processway').val(0);\"><i class='icon-ok'></i> 保存</button>");
			form.append("<button type='submit' class='btn btn-sm btn-danger' onClick=\"javascript:$('#processway').val(1);\"><i class='icon-ok'></i> 修改</button>");

			form.append('<h6 class="green"> <i class="icon-hand-right icon-animated-hand-pointer blue"></i>分配，进行分配后，会把总计划剩余的值平均分配到第二天到最后一天	</h6>');
			form.append('<h6 class="red"> <i class="icon-hand-right icon-animated-hand-pointer red"></i>修改，本月其他时间的计划均不变，总计划值会根据修改的值变化！	</h6>');
			var div = bootbox.dialog({
				message: form,
			
				buttons: { 
					"close" : {
						"label" : "<i class='icon-remove'></i> 关闭",
						"className" : "btn-sm"
					} 
				}

			});
			spinner_init();
			form.on('submit', function(){ 

				 var data = form.serialize();
				  var user_id=$("#user_id").val(); 
				  data+="&user_id="+user_id; 
				  $.post(form.attr("action"), data, function(data,textStatus){ 
				             if(data.status){ 
				                     $('#calendar_old').fullCalendar('refetchEvents');
				                } 
				                else
				                {
				                	 bootbox.alert(data.info,null);   
				                }
				        }, "json"); 
				div.modal("hide");
				return false;
				
			}); 

		}
		
	}); 




$('#calendar_member').fullCalendar({
		 titleFormat: {month:'yyyy年M月'}, 
		 year:y,
		 month:m,
		 buttonText: {
			prev: '<i class="icon-chevron-left"></i>',
			next: '<i class="icon-chevron-right"></i>',
			'today':"本月"
		},
		firstDay:1,
		weekMode:'liquid' , 
		monthNamesShort:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
		dayNames:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],
		dayNamesShort:["周日","周一","周二","周三","周四","周五","周六"],
		dayNamesMin:["日","一","二","三","四","五","六"],
		monthNames:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
		header: {
			left: 'prev,next today',
			center: 'title', 
			right: '' 
		}, 
		events: {
				url:'<?php echo U("Mcmanager/Plannew/getmemberjson");?>',
				data: function() {
				 return {
                	user_id: $("#user_id").val()
            	};
            }
			}, 
		loading:function( isLoading, view )
		{
			if(isLoading) 
			 loadTotalPlan(2);
		},
		editable: false,
		droppable: false, // this allows things to be dropped onto the calendar !!! 
		selectable: false,
		selectHelper: true,
		
		eventClick: function(calEvent, jsEvent, view) {
			var title=calEvent.title;
			title=title.split(":");
			var lbl=title[0];
			var value=title[1];
			var date=calEvent.start;
			var days = getCountDays(date);
			if(days == calEvent.start.getDate())
			{
				return; 
			} 
			if(calEvent.start.getTime() < new Date().getTime())
			{
				return;
			}

			var form = $("<form  action=\"<?php echo U('Mcmanager/Plannew/setdaymember');?>\" class='form-inline'><label>"+lbl+" &nbsp;</label></form>");
			form.append("<input name='type' type=hidden value='" + calEvent.start + "' /> ");
			form.append("<input id='processway' name='processway' type=hidden value='0' /> ");

			form.append("<input name='value' class='spinner middle' autocomplete=off type=text value='" + value + "' /> ");  
			form.append("<button type='submit' class='btn btn-sm btn-success' onClick=\"javascript:$('#processway').val(0);\"><i class='icon-ok'></i> 保存</button>");
			form.append("<button type='submit' class='btn btn-sm btn-danger' onClick=\"javascript:$('#processway').val(1);\"><i class='icon-ok'></i> 修改</button>");

			form.append('<h6 class="green"> <i class="icon-hand-right icon-animated-hand-pointer blue"></i>分配，进行分配后，会把总计划剩余的值平均分配到第二天到最后一天	</h6>');
			form.append('<h6 class="red"> <i class="icon-hand-right icon-animated-hand-pointer red"></i>修改，本月其他时间的计划均不变，总计划值会根据修改的值变化！	</h6>');

			 

			var div = bootbox.dialog({
				message: form,
			
				buttons: { 
					"close" : {
						"label" : "<i class='icon-remove'></i> 关闭",
						"className" : "btn-sm"
					} 
				}

			});
			spinner_init();

			form.on('submit', function(){ 

				 var data = form.serialize();
				  var user_id=$("#user_id").val(); 
				  data+="&user_id="+user_id; 
				  $.post(form.attr("action"), data, function(data,textStatus){ 
				             if(data.status){ 
				                     $('#calendar_member').fullCalendar('refetchEvents');
				                } 
				                else
				                {
				                	 bootbox.alert(data.info,null);   
				                }
				        }, "json"); 
				div.modal("hide");
				return false;
				
			}); 

		}
		
	}); 





})

		</script>


</body>
</html>