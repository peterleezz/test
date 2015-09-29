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
      <a href="<?php echo U('Home/Main/main');?>">店长</a>
    </li>
    <li class="active">课程安排</li>

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
   <div class="col-sm-2 col-sm-offset-10"> 
    </div>

    <div class="col-sm-12" style="margin-top:10px">

      <div id="calendar" class="col-xs-12 calendar_c"></div>

    </div>
    
   <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;margin:auto">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">设置课程信息</h4>
      </div>
      <div class="modal-body">


        <form class="form-horizontal" role="form" id="modalform" action="<?php echo U('Shopkeeper/Class/edit');?>">
      <input type="hidden" id="id" value="0">
      <input type="hidden" id="class_id" value="0">
<!-- 
      <div class="form-group">
        <label for="room" class="col-sm-3 control-label">开始时间：</label>
        <div class="col-sm-9">
              <input type="text" class="date_ymd" name="start_time"  id="start_time"></div>
        </div>
      </div>
 -->

    <div class="form-group">
        <label for="room" class="col-sm-3 control-label">开始时间：</label>
        <div class="col-sm-4">
             <input type="text" class="date_ymdhi col-sm-12"   name="start_time"  id="start_time"  > 
        </div>
         <div class="col-sm-5"></div>
      </div>


      <div class="form-group">
        <label for="room" class="col-sm-3 control-label">选择教室：</label>
        <div class="col-sm-4">
           <select name="room" id="room" class="form-control">
        	<?php if(is_array($rooms)): $i = 0; $__LIST__ = $rooms;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$room): $mod = ($i % 2 );++$i;?><option value="<?php echo ($room["id"]); ?>"><?php echo ($room["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        </div>
         <div class="col-sm-5"></div>
      </div>

      <div class="form-group">
        <label for="class_name" class="col-sm-3 control-label">选择课程：</label>
        <div class="col-sm-4">
          <input type="text" class="col-sm-12"   name="name"  id="name" oper="cn" > 
        </div>
        <div class="col-sm-5"> <button type="button"  id="s_class_query_btn" class="btn  btn-info btn-sm" > <i class="icon-search"></i>
          查询
        </button></div>
      </div>
 		

      <div class="form-group">
        <label for="room" class="col-sm-3 control-label">选择老师：</label>
        <div class="col-sm-4">
           <select name="teacher" id="teacher" class="form-control">
          <?php if(is_array($teachers)): $i = 0; $__LIST__ = $teachers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$teacher): $mod = ($i % 2 );++$i;?><option value="<?php echo ($teacher["id"]); ?>"><?php echo ($teacher["name_cn"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        </div>
         <div class="col-sm-5"></div>
      </div>



 		<div class="pull-center col-sm-12" >
 			 
            <table id="grid"></table> 
             <div id="pager"></div> 
        </div> 

      </form>
<h4 class="green"> <i class="icon-hand-right icon-animated-hand-pointer blue"></i>请单击选中课程！	</h4> 
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-warning" onclick=" if(confirm('您确定要删除吗？')) deleteClass()">删除此课程</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-primary" onclick="editClass()">确认</button>
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
 
 	  function getCountDays(date) {  
        var curDate=new Date();
        var curMonth = date.getMonth(); 
       curDate.setMonth(curMonth + 1); 
       curDate.setDate(0); 
       return curDate.getDate();
  }

var index=9999999;start_time
var start;var end;var allDay;var interval;
var calendar;
var view; 
    var rsp_start = new Date();
    var rsp_end = new Date();
rsp_start.setDate(1);
rsp_start.setHours(1);
rsp_end.setDate(DayNumOfMonth(rsp_end.getFullYear(),rsp_end.getMonth()));
rsp_end.setHours(23);

function DayNumOfMonth(Year,Month)
{
    return 32-new Date(Year,Month,32).getDate();
}

//modify all schedule every dayofweek!
function editClass()
{ 

  var str_start_ime = $("#start_time").val();
  str_start_ime = str_start_ime.replace(/-/g,"/");
  start = new Date(str_start_ime );

	end.setTime(start.getTime()+interval*60*1000); 
	if($("#room  option:selected").val()=='')
	{
		bootbox.alert("请选择教室！");
		return;
	}
	if($("#name").val()=='')
	{
		bootbox.alert("请选择课程！");
		return;
	}
	// deleteClass();

var title = $("#name").val()+"--"+$("#room  option:selected").text();

var id = $("#id").val();
  if(id==0)//如果是添加
  {

     for(var i=0;i<5;i++)
     {
        var s_start = new Date();
        s_start.setTime(start.getTime()+7*24*60*60*1000*i);
        var s_end=new Date();
        s_end.setTime(end.getTime()+7*24*60*60*1000*i);
        if(s_start.getMonth()!=start.getMonth())break; 
        $.ajax({
            type:"post", 
            url:"<?php echo U('Shopkeeper/Class/editone');?>",
            dataType:"json",
            data:{room_id:$("#room").val(),class_id:$("#class_id").val(),start:s_start.format('yyyy-MM-dd hh:mm:ss'),end:s_end.format('yyyy-MM-dd hh:mm:ss'),pt_id:$("#teacher").val()},
            success:function(data,textStatus){ 
                          // bootbox.alert(data.info);  
                           $(".modal").modal("hide");
                            calendar.fullCalendar( 'refetchEvents' );
            },
            error: function (jqXHR, textStatus, errorThrown) {
                 bootbox.alert("Error...",null);             
            }
          }); 
     }
    

  }
  else //如果是修改
  {
      
      var thisevent  =  calendar.fullCalendar('clientEvents',id);
       thisevent = thisevent[0];
      var this_start = thisevent.start;
      var diff = start.getTime()-this_start.getTime();

      var s_start = new Date();
      var s_end = new Date();
      var allevent =   calendar.fullCalendar('clientEvents');
      allevent.forEach(function(e){
        if(e.start.getDate() >= thisevent.start.getDate() && e.start.getHours()==thisevent.start.getHours() && e.start.getMinutes()==thisevent.start.getMinutes() && e.room_id==thisevent.room_id && e.class_id==thisevent.class_id)
         {
              s_start.setTime(diff + e.start.getTime());
              s_end.setTime(diff + e.end.getTime());
               $.ajax({
              type:"post", 
              url:"<?php echo U('Shopkeeper/Class/editone');?>",
              dataType:"json",
              data:{id:e.id,room_id:$("#room").val(),class_id:$("#class_id").val(),start:s_start.format('yyyy-MM-dd hh:mm:ss'),end:s_end.format('yyyy-MM-dd hh:mm:ss'),pt_id:$("#teacher").val()},
              success:function(data,textStatus){ 
                            $(".modal").modal("hide");
                            calendar.fullCalendar( 'refetchEvents' );
              },
              error: function (jqXHR, textStatus, errorThrown) {
                   bootbox.alert("Error...",null);             
              }
            }); 
          }

      });
       
  } 

 
	 
}

function Schedule(class_id,room_id,start,end)
{
	this.class_id=class_id;
	this.room_id=room_id;
	this.start=start;
	this.end=end;
	return this;
}
function save()
{
	var data =   calendar.fullCalendar('clientEvents');  
	var arr=new Array();
	data.forEach(function(e){
		var schedule = new Schedule(e.class_id,e.room_id,e.start,e.end);
		arr.push(schedule);
	});
 var b = JSON.stringify(arr); 
 
	 $.ajax({
    type:"post", 
    url:"<?php echo U('Shopkeeper/Class/edit');?>",
    dataType:"json",
    data:{data:b,start:rsp_start,end:rsp_end},
    success:function(data,textStatus){ 
                  bootbox.alert(data.info);  
    },
    error: function (jqXHR, textStatus, errorThrown) {
         bootbox.alert("Error...",null);             
    }
});

}
function deleteClass()
{
	var id = $("#id").val();
	if(id==0) return;

	var thisevent  =  calendar.fullCalendar('clientEvents',id);
	thisevent = thisevent[0];
	var allevent =   calendar.fullCalendar('clientEvents');
	allevent.forEach(function(e){
		if(e.start.getMonth()== thisevent.start.getMonth()&& e.start.getDate() >= thisevent.start.getDate() && e.start.getHours()==thisevent.start.getHours() && e.start.getMinutes()==thisevent.start.getMinutes() && e.room_id==thisevent.room_id && e.class_id==thisevent.class_id)
		delid(e.id);
	});
	delid(id);
	$(".modal").modal("hide");
}
function delid(id)
{
	 $.ajax({
    type:"post",
    url:"<?php echo U('Shopkeeper/Class/del');?>",
    dataType:"json",
    data:{id:id},
    success:function(data,textStatus){
    		 $(".modal").modal("hide");
                            calendar.fullCalendar( 'refetchEvents' );
	},
    error: function (jqXHR, textStatus, errorThrown) {
         bootbox.alert("Error...",null);
    }
});
}

	$(document).ready(function() { 
		var  grid_selector = "#grid";
            var  pager_selector = "#pager";     

                jQuery(grid_selector).jqGrid({
                    url:"/Shopkeeper/Class/query",                 
                    datatype: "json", 
                    height:"100%",
                    width:"500px",
                    mtype:"POST",
                    colNames:['ID','教师', 'pt_id','名称','名称(En)','课时长(分钟)','语言','难度等级'],
                    colModel:[      
                        {name:'id',index:'id',sortable:true,editable: false ,width:70,align:'center',sorttype:'integer',hidden:true},
                         {name:'teacher',index:'teacher',width:100},
                          {name:'pt_id',index:'pt_id',hidden:true},
                        {name:'name',index:'name',width:100,editoptions:{size:"20",maxlength:"30"},editrules:{required:true},align:'center',search:true},
                          {name:'name_en',index:'name_en',width:100,editoptions:{size:"20",maxlength:"30"},editrules:{required:true},align:'center',search:true},
                        {name:'time',index:'time',width:50,editoptions:{size:"20",maxlength:"30"},editrules:{required:true},align:'center',search:true},
                           
                       {name:'lang',index:'lang', width:50, editable: true,edittype:"select",editoptions:{value:"中文:zh-chs;English:en-us"},formatter : function(value, options, rData){
                            // return value=='zh-chs'?"中文":"English";
                            return value;
            }}, 
                       {name:'level',index:'level', width:50, editable: true,edittype:"select",editoptions:{value:"一级:1;二级:2;三级:3;四级:4"},formatter : function(value, options, rData){
                         var a=new Array("","一级","二级","三级","四级");
                           return getValue(a,value); 
            }},      
                        

                    ],      
                    pager : pager_selector,
                    altRows: true,                   
                    multiselect: true,
                    multiboxonly: true,
                    pgbuttons:true,
                    pginput : false,
                    cmTemplate: {sortable:false,editable: true,search:false},
                    sortorder: "desc",
                    editurl: "/Pt/Class/setPtclass",          
                    autowidth: true,
                    shrinkToFit:true,  
              
                    // hidegrid:false,
                     rowNum: 10,
                    rowList: [10, 20, 30],
                    viewrecords: true,
                    gridview: true,
                    jsonReader:{userdata:"userdata"},    
                    onSelectRow: function (rowid, status) {
                      var data = jQuery("#grid").jqGrid("getRowData",rowid);
                      $("#class_id").val(rowid);
                      $("#name").val(data.name);
                      $("#teacher").val(data.pt_id); 
                      interval = data.time;
                	},               
                    loadComplete : function() {  
                        var table = this;
                        setTimeout(function(){ 
                            updatePagerIcons(table);
                            enableTooltips(table);
                        }, 0);
                      
                    },
                 
            
                }); 
 
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
                    } 
                );






		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
	 calendar = $('#calendar').fullCalendar({
			titleFormat: {month:'yyyy年M月'}, 
		     year:y,
		     month:m,
		     buttonText: {
		      prev: '<i class="icon-chevron-left"></i>',
		      next: '<i class="icon-chevron-right"></i>',
		      'today':"本月",
		      today: '今天',
		      month: '月',
		      week: '周',
		      day: '天'
		    }, 
         minTime:7,
            maxTime:21,
               allDaySlot:false,
            allDayText:'今天的课程',
		    firstDay:1,
		    weekMode:'liquid' , 
		    monthNamesShort:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
		    dayNames:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],
		    dayNamesShort:["周日","周一","周二","周三","周四","周五","周六"],
		    dayNamesMin:["日","一","二","三","四","五","六"],
		    monthNames:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
		    header: {
		      left: 'prev,next, today',
		      center: 'title',  
		      right: 'month,agendaWeek,agendaDay' 
		    },  
			selectable: true,
			selectHelper: true,
			defaultView:"agendaDay",
			select: function(s, e, a) {
         $("#id").val(0);
				 	if(view.name=='month') return;
				start=s;  
        
        $("#start_time").val(start.format('yyyy-MM-dd hh:mm:ss'));
				   end=e;
				   allDay=a; 
			      if(Date.parse(date) > Date.parse(start)) 
			      	{
			      		bootbox.alert("只能编辑当前时间之后的课程信息！");
			      		return; 
			      	}
				  $('#myModal').modal("show"); 
				   $("#grid").jqGrid('setGridWidth',550); 
				 
				calendar.fullCalendar('unselect');
			},
			eventClick: function(calEvent, jsEvent, view) { 
			      var title=calEvent.title;
			      title=title.split("--");
			      start=calEvent.start;
			     if(Date.parse(date) > Date.parse(start)) {
			      	//	bootbox.alert("只能编辑当前时间之后的课程信息！");
			      	//	return; 
			      	}
			      end=calEvent.end;
			      allDay=calEvent.allDay;
              $("#start_time").val(start.format('yyyy-MM-dd hh:mm:ss'));
			       $("#class_id").val(calEvent.class_id);
             $("#teacher").val(calEvent.pt_id);
			       $("#room option[value='"+calEvent.room_id+"']").attr("selected", "selected");
			       $("#id").val(calEvent.id);
			       $("#name").val(calEvent.name);
			       $('#myModal').modal("show"); 
			        $("#grid").jqGrid('setGridWidth',550); 

			 },
			 viewRender:function(v,element)
			 {
			 	view=v;
			 	if(rsp_start==null)rsp_start=view.start;
			 	else if(Date.parse(rsp_start) > Date.parse(view.start))rsp_start=view.start;
			 	if(rsp_end==null)rsp_end=view.end;
			 	else if(Date.parse(rsp_end) < Date.parse(view.end))rsp_end=view.end;  
			 },

			editable: true,
				events: {
				url:'<?php echo U("Shopkeeper/Class/getjson");?>',
				data: function() {
				 return {
                	user_id: $("#user_id").val()
            	};
            }
			}
		});
		
	});

    </script>


</body>
</html>