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
        <li class="active">会员卡管理</li>

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
        <div class="col-xs-12" id="fcontainer">

            <form class="form-inline" role="form" action="<?php echo U('Reception/Cardmanage/queryNew');?>" method="post" id="reception_card_manage_form" style="margin-bottom:10px">

                <div class="form-group">
                    <label  for="card_id">会员卡号:</label>
                    <input type="text" class="form-control" name="card_id"  id="card_id" oper="eq"></div>
                <div class="form-group">
                    <label  for="name">会员姓名:</label>
                    <input type="text" class="form-control" name="name"  id="name" oper="eq"></div>
                <div class="form-group">
                    <label  for="phone">手机号码:</label>
                    <input type="text" class="form-control" name="phone"  id="phone" oper="eq"></div>

                <button type="submit" class="btn  btn-info btn-sm"> <i class="icon-search"></i>
                    查询
                </button>

            </form>

            <table id="reception_card_grid"></table>
            <div id="reception_card_pager"></div>
            <div align="center">
              <button class="btn  btn-danger btn-sm" onclick="yueke()"> <i class="icon-lock">约课</i></button>

                <button class="btn  btn-default btn-sm" onclick="guashi()"> <i class="icon-lock">挂失</i></button>
                 <button class="btn  btn-primary btn-sm" onclick="quxiaoguashi()"> <i class="icon-unlock">取消挂失</i></button>
                  <button class="btn  btn-success btn-sm" onclick="buka()"> <i class="icon-cog">补卡</i></button>
                   <button class="btn  btn-info btn-sm" onclick="qingjia()"> <i class="icon-umbrella">请假</i></button>
                    <button class="btn  btn-warning btn-sm" onclick="xiaojia()"> <i class="icon-off">销假</i></button>
                     <button class="btn  btn-danger btn-sm" onclick="tuihui()"> <i class="icon-remove-circle">退会</i></button>
                      <button class="btn  btn-primary btn-sm" onclick="xiaoka()"> <i class="icon-remove-circle">消卡</i></button>
            </div>
        </div>
    </div>

    <div class="modal fade " id="restModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">选择请假时间</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" id="addplanform" action="<?php echo U('Channelmanager/Plan/edit');?>">
                        <div class="form-group">
                            <label for="rest_start_time" class="col-sm-4 control-label">选择起始时间</label>
                            <div class="col-sm-8">
                                <input type="text" class="date_ymd form-control" name="rest_start_time" id="rest_start_time" ></div>
                        </div>

                        <div class="form-group">
                            <label for="rest_end_time" class="col-sm-4 control-label">选择结束时间</label>
                            <div class="col-sm-8">
                                <input type="text" class="date_ymd form-control" name="rest_end_time" id="rest_end_time" ></div>
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" onclick="rest()">保存</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="newCardModal" tabindex="-1" role="dialog" aria-labelledby="newcardmodallabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="newcardmodallabel">请输入新的卡号,否则系统会自动生成新的卡号!</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" id="newcardform">
                        <div class="form-group">
                            <label for="new_card_number" class="col-sm-2 control-label">卡号:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="new_card_number" id="new_card_number" ></div>
                        </div>
                         
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" onclick="getnew()">保存</button>
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
       
  var grid_selector = "#reception_card_grid";
            var pager_selector = "#reception_card_pager";    
    function guashi()
    {
          var id = jQuery(grid_selector).jqGrid('getGridParam','selrow');
                if (id) {
                    lost(id);
                } else { alert("请先选中！");}
                     
                
    }

    function yueke()
    {
          var id = jQuery(grid_selector).jqGrid('getGridParam','selrow');
                if (id) { 
                     var rowData = jQuery(grid_selector).jqGrid("getRowData",id); 
                            var member_id = (rowData.memberid);
                     window.open("/Reception/Appoint/index/id/"+member_id);

                } else { alert("请先选中！");}
                     
                
    }
    function quxiaoguashi()
    {
          var id = jQuery(grid_selector).jqGrid('getGridParam','selrow');
                if (id) {
                    unlost(id);
                } else { alert("请先选中！");}
    }
    function buka()
    {
       var id = jQuery(grid_selector).jqGrid('getGridParam','selrow');
                if (id) {
                   $('#newCardModal').modal('show');              
                } else { alert("请先选中！");} 
    }
    function qingjia()
    {
           var id = jQuery(grid_selector).jqGrid('getGridParam','selrow');
                if (id) {
                    $('#restModel').modal('show');                   
                } else { alert("请先选中！");}
    }
    function xiaojia()
    {
         var id = jQuery(grid_selector).jqGrid('getGridParam','selrow');
                if (id) {
                   unrest(id);
                } else { alert("请先选中！");}
    }
    function tuihui()
    {
          var id = jQuery(grid_selector).jqGrid('getGridParam','selrow');
                if (id) {
                   destroy(id);
                } else { alert("请先选中！");}
    }
    function xiaoka()
    {
         var id = jQuery(grid_selector).jqGrid('getGridParam','selrow');
                if (id) {
                   destroy_card(id);
                } else { alert("请先选中！");}
    }



    $(function(){
    $("#menu_4").addClass("active open");
    $("#menu_44").addClass("active");

                       
                jQuery(grid_selector).jqGrid({
                    url:"<?php echo U('Reception/Cardmanage/queryNew');?>",                 
                    datatype: "json",
                    height: "100%",    
                    width:($('#fcontainer').width()-10),
                    mtype:"POST",
                    colNames:['ID','member_id','会员姓名', '卡号','办理会所','卡种名称','卡状态','签订日期', '手机号码','有效期起','有效期止','免费请假次数', '操作'],
                    colModel:[   
                       {name:'id',index:'id',width:1,align:'center',hidden:true},
                         {name:'memberid',index:'memberid',width:1,align:'center',hidden:true},
                           {name:'member_name',index:'member_name',width:150,align:'center',formatter : function(value, options, rData){  
                           var html='<a  target="blank" href="/Reception/Visit/index/id/'+rData.memberid+'" >'+value+'</a>'; 
                           return html;
                        }},
                       {name:'card_number',index:'card_number',width:150,align:'center'},
                        {name:'club_name',index:'club_name',width:150,align:'center'},
                        {name:'card_type_name',index:'card_type_name',width:200,align:'center',formatter : function(value, options, rData){  
                                return rData.card_type_extension.name;
                         }},
                         {name:'status',index:'status',width:150,align:'center',formatter : function(value, options, rData){  
                                 var a=new Array("正常","已挂失","已被补卡","请假中","申请退会","消卡收回");
                                return getValue(a,value); 
                         }},
                        {name:'create_time',index:'create_time',width:150,align:'center',formatter : function(value, options, rData){  
                               return value.substring(0,10);
                         }},
                      
                          {name:'phone',index:'phone',hidden:true,hidden:true,width:150,align:'center'},
                        {name:'start_time',index:'start_time',width:150,align:'center'},
                        {name:'end_time',index:'end_time',width:150,align:'center'},
                         {name:'cfree_rest',index:'cfree_rest',width:150,align:'center',formatter : function(value, options, rData){  
                          return rData.crest_count+"/"+rData.cfree_rest;
                        }},
                       {name:'op',index:'op',hidden:true,width:450,align:'center',formatter : function(value, options, rData){  
                            var id=rData.id; 
                           var html='<a class="btn  btn-default btn-xs"  href="javascript:void(0)" onclick="lost('+id+')"><i class="icon-lock bigger-130"></i>挂失</a>&nbsp&nbsp&nbsp';
                            html+='<a class="btn  btn-primary btn-xs " href="javascript:void(0)" onclick="unlost('+id+')"><i class="icon-unlock bigger-130"></i>取消挂失</a>&nbsp&nbsp&nbsp';
                            html+='<a class="btn  btn-success btn-xs" href="javascript:void(0)" data-toggle="modal" data-target="#newCardModal"></i>补卡</a>&nbsp&nbsp&nbsp';
                             html+='<a class="btn  btn-info btn-xs" href="javascript:void(0)"  data-toggle="modal" data-target="#restModel" ><i class="icon-umbrella bigger-130"></i>请假</a>&nbsp&nbsp&nbsp';
                              html+='<a class="btn  btn-warning btn-xs" href="javascript:void(0)"onclick="unrest('+id+')"><i class="icon-off bigger-130"></i>销假</a>&nbsp&nbsp&nbsp';
                              html+='<a class="btn  btn-danger btn-xs" href="javascript:void(0)" onclick="destroy('+id+')"><i class="icon-remove-circle bigger-130"></i>退会消卡</a>';
                              return html;
                         }},
                    ],   
                    // pagerpos:"right",   
                    pager : pager_selector,
                    altRows: true,                   
                    multiselect: true,
                    multiboxonly: true,
                    pgbuttons:true,
                    pginput : false,
                    cmTemplate: {sortable:false,editable: true,search:false},
                    sortorder: "desc",
                    editurl: "/Brand/Cardtype/setCardType",          
                    autowidth: true,
                    shrinkToFit:true,  
                    autoScroll: true,
                    caption: "会员卡信息" ,
                    // loadonce: true,
                     rowNum: 10,
                    rowList: [10, 20, 30],
                    viewrecords: true,
                    gridview: true,

                     subGrid : true,
                   subGridRowExpanded: function(subgrid_id, row_id) {
                        var subgrid_table_id, pager_id; subgrid_table_id = subgrid_id+"_t";
                        pager_id = "p_"+subgrid_table_id;
                        $("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id+"' class='scroll'></div>");
                        $("#"+subgrid_table_id).jqGrid({
                            datatype: "json",
                            url:"/Reception/Cardmanage/querycardophistory?id="+row_id,
                            colNames: ['ID', '时间','操作','操作人','细节'],
                            colModel: [
                            {
                                    name:"id",index:"id",width:100,align:"left"}, 
                                  {name:"create_time",index:"create_time",width:200,align:"left"},  
                                        {name:"card_status",index:"card_status",width:100,align:"left",formatter : function(value, options, rData){
                                              if(value!=0)
                                            {
                                                 var a=new Array("正常","挂失","补卡","请假","申请退会","消卡收回");
                                                return getValue(a,value); 
                                            }
                                            else
                                            {
                                                 var a=new Array("正常","取消挂失","补卡","取消请假","取消申请退会","取消消卡收回");
                                                 return getValue(a,rData.status_before); 
                                            }
                                          }}, 
                                        {name:"recorder",index:"recorder",width:100,align:"left",formatter : function(value, options, rData){
                                            if(value!=null)
                                            return value.name_cn;
                                            return "系统";
                                          }}, 
                                           {name:"extension",index:"extension",width:200,align:"left",formatter : function(value, options, rData){
                                                if(value!=null && value!="")
                                                {
                                                    var json=JSON.parse(value);
                                                    return "从"+json.start_time+" 到"+json.end_time;
                                                }
                                                if(rData.recorder==null)
                                                return "请假时间到，自动销假!";
                                                else
                                                return "到馆销假!"
                                          }}, 

                                        ], 
                            rowNum:100,
                            // pager: pager_id,
                            sortname: 'id',
                            loadonce:true,
                            autowidth: false,
                            shrinkToFit:false,  
                            autoScroll: true,
                            sortorder: "desc", height: '100%' });
                    },


                    subGridOptions: {
                        "plusicon": "icon-plus",
                        "minusicon": "icon-minus",
                        "openicon": "icon-list",
                        "reloadOnExpand": false,
                        "selectOnExpand": true
                    },






                    jsonReader:{userdata:"userdata"},                   
                    loadComplete : function() {
                     
                        var table = this;
                        setTimeout(function(){ 
                            updatePagerIcons(table);
                            enableTooltips(table);
                        }, 0); 
                    },
                    
            
                });  

                //navButtons
                jQuery(grid_selector).jqGrid('navGrid',pager_selector,
                    {   //navbar options
                        edit: false,
                        editicon : 'icon-pencil blue',
                        add: false,
                        addicon : 'icon-plus-sign purple',
                        del: false,
                        delicon : 'icon-trash red',
                        search: false,
                        searchicon : 'icon-search orange',
                        refresh: false,
                        refreshicon : 'icon-refresh green',
                        view: false,
                        viewicon : 'icon-zoom-in grey',
                    },
                    {
                        //edit record form
 
                         closeAfterEdit:true,
                        recreateForm: true,
                        beforeShowForm : function(e) {
                            var form = $(e[0]);
                            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                            style_edit_form(form);
                        },
                         afterSubmit : function(response, postdata)
                        {
                         var res = $.parseJSON(response.responseText);
                            return [res.success,res.message,res.new_id];
                        }
                    },
                    {
                        //new record form
                        closeAfterAdd: true,
                        recreateForm: true,
                        viewPagerButtons: false,
                        beforeShowForm : function(e) {
                            var form = $(e[0]);
                            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                            style_edit_form(form);
                        },
                        afterSubmit : function(response, postdata)
                        {
                           var res = $.parseJSON(response.responseText);
                             // jQuery(grid_selector).setGridParam({datatype:'json', page:1}).trigger("reloadGrid");
                            return [res.success,res.message,res.new_id];
                        }
                    },
                    {
                        //delete record form
                        recreateForm: true,
                        beforeShowForm : function(e) {
                            var form = $(e[0]);
                            if(form.data('styled')) return false;
                            
                            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                            style_delete_form(form);
                            
                            form.data('styled', true);
                        }, 
                        onClick : function(e) {
                            alert(1);
                        }
                    },
                    {
                        //search form
                        recreateForm: true,
                        afterShowSearch: function(e){
                            var form = $(e[0]);
                            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                            style_search_form(form);
                        },
                        afterRedraw: function(){
                            style_search_filters($(this));
                        }
                        ,
                        multipleSearch: true,
                        /**
                        multipleGroup:true,
                        showQuery: true
                        */
                    },
                    {
                        //view record form
                        recreateForm: true,
                        beforeShowForm: function(e){
                            var form = $(e[0]);
                            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                        }
                    }
                ); 


  
            // jQuery(grid_selector).jqGrid('navButtonAdd',pager_selector,{position: "first",buttonicon : 'icon-remove-circle red',caption:"消卡",title:"消卡",
            //     onClickButton:function(){ 
            //         var id = jQuery(grid_selector).jqGrid('getGridParam','selrow');
            //     if (id) {
            //        destroy_card(id);
            //     } else { alert("请先选中！");}
                     
            //     } 
            // });


            
            // jQuery(grid_selector).jqGrid('navButtonAdd',pager_selector,{position: "first",buttonicon : 'icon-remove-circle red',caption:"退会",title:"退会",
            //     onClickButton:function(){ 
            //         var id = jQuery(grid_selector).jqGrid('getGridParam','selrow');
            //     if (id) {
            //        destroy(id);
            //     } else { alert("请先选中！");}
                     
            //     } 
            // });

            // jQuery(grid_selector).jqGrid('navButtonAdd',pager_selector,{position: "first",buttonicon : 'icon-off yellow',caption:"销假",title:"销假",
            //     onClickButton:function(){ 
            //         var id = jQuery(grid_selector).jqGrid('getGridParam','selrow');
            //     if (id) {
            //        unrest(id);
            //     } else { alert("请先选中！");}
                     
            //     } 
            // });
            // jQuery(grid_selector).jqGrid('navButtonAdd',pager_selector,{position: "first",buttonicon : 'icon-umbrella blue',caption:"请假",title:"请假",
            //     onClickButton:function(){ 
            //         var id = jQuery(grid_selector).jqGrid('getGridParam','selrow');
            //     if (id) {
            //         $('#restModel').modal('show');                   
            //     } else { alert("请先选中！");}
                     
            //     } 
            // });
            // jQuery(grid_selector).jqGrid('navButtonAdd',pager_selector,{position: "first",buttonicon : 'icon-cog green',caption:"补卡",title:"补卡",
            //     onClickButton:function(){ 
            //         var id = jQuery(grid_selector).jqGrid('getGridParam','selrow');
            //     if (id) {
            //        $('#newCardModal').modal('show');              
            //     } else { alert("请先选中！");}
                     
            //     } 
            // });
            //  jQuery(grid_selector).jqGrid('navButtonAdd',pager_selector,{position: "first",buttonicon : 'icon-unlock blue',caption:"取消挂失",title:"取消挂失",
            //     onClickButton:function(){ 
            //         var id = jQuery(grid_selector).jqGrid('getGridParam','selrow');
            //     if (id) {
            //         unlost(id);
            //     } else { alert("请先选中！");}
                     
            //     } 
            // });


            //   // jQuery(grid_selector).jqGrid('navSeparatorAdd',pager_selector,{sepclass:"ui-separator",sepcontent:''});

            //  jQuery(grid_selector).jqGrid('navButtonAdd',pager_selector,{position: "first",buttonicon : 'icon-lock grey',caption:"挂失",title:"挂失",
            //     onClickButton:function(){ 
            //         var id = jQuery(grid_selector).jqGrid('getGridParam','selrow');
            //     if (id) {
            //         lost(id);
            //     } else { alert("请先选中！");}
                     
            //     } 
            // });


})
</script>

</body>
</html>