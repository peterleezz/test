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
      <a href="<?php echo U('Home/Main/main');?>">财务</a>
    </li>
    <li class="active">财务报表</li>

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
      <form class="form-inline" role="form" action="<?php echo U('Finance/Report/queryReport');?>" method="post" id="finance_query_report" >

        <div class="form-group col-xs-12">
          <label for="cc">选择会所：</label>
          <label class="checkbox-inline">
            <input type="checkbox"  id="allclub" onchange="chooseall()">所有会所</label>
          <?php if(is_array($clubs)): $i = 0; $__LIST__ = $clubs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$club): $mod = ($i % 2 );++$i;?><label class="checkbox-inline">
              <input type="checkbox" name="club_ids[]" id="club_ids" class="club_ids" value="<?php echo ($club["id"]); ?>"  checked='checked'><?php echo ($club["club_name"]); ?></label><?php endforeach; endif; else: echo "" ;endif; ?> 
        </div>

        <div class="form-group">
          <label  for="type">报表类型：</label>
          <select name="type" id="type" class="form-control" oper="eq">
            <option value="1">日报表</option>
            <option value="2">月报表</option>
            <option value="3">年报表</option>
            <option value="4">时间段报表</option>
          </select>
        </div>

        <div class="form-group">
          <label  for="name">开始时间:</label>
          <input type="text" class="date_ymd" name="start_time"  id="start_time" oper="eq"></div>
        <div class="form-group hide" id="end">
          <label  for="name">结束时间:</label>
          <input type="text" class="date_ymd" name="end_time"  id="end_time" oper="eq"></div>
        <button type="submit" class="btn  btn-info btn-sm"> <i class="icon-search"></i>
          查询
        </button>
      </form>
    </div>

    <div class="col-xs-12">
      <table id="finance_report_grid"></table>
      <div id="finance_report_grid_pager"></div>
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
  
  function chooseall()
  {
      var all=$("#allclub").prop("checked");
      if(all)
      {
        $(".club_ids").prop("checked", true);  
      }
      else
      {
        $(".club_ids").prop("checked", false);  
      }
  }

$("#type").change(function(){
     $('#start_time,#end_time').val("");
    if($(this).val()==1)
    {
        $('#start_time').datetimepicker('remove');
         $("#start_time").datetimepicker({
          format: 'yyyy-mm-dd',
          minView:'2',
          startView:'2',
          language:'zh-CN',
          autoclose:true,
        });
         $("#end").addClass("hide");
    }
    else if($(this).val()==2)
    {
        $('#start_time').datetimepicker('remove');
         $("#start_time").datetimepicker({
          format: 'yyyy-mm',
          minView:'3',
          startView:'3',
          language:'zh-CN',
          autoclose:true,
        });
         $("#end").addClass("hide");
    }
    else if($(this).val()==3)
    {
       $('#start_time').datetimepicker('remove');
         $("#start_time").datetimepicker({
          format: 'yyyy',
          minView:'4',
          startView:'4',
          language:'zh-CN',
          autoclose:true,
        });
         $("#end").addClass("hide");
    }
    else
    {
      $('#start_time').datetimepicker('remove');
       $("#start_time").datetimepicker({
          format: 'yyyy-mm-dd',
          minView:'2',
          startView:'2',
          language:'zh-CN',
          autoclose:true,
        });
         $("#end").removeClass("hide");
    }

}); 
$(function(){ 
var clubs,start_time,end_time,type,clubsstring="";
$("#finance_query_report").submit(function(){   
         var self = $(this);  
          clubs=$('input[name="club_ids[]"]:checked'); 
         if(clubs.length==0)
         {
             bootbox.alert("请选中需要统计的会所！");
            return false;
         }  
         clubsstring="";
         clubs.each(function(){  
            clubsstring+=$(this).val()+",";
          })  
         clubsstring=clubsstring.substring(0,clubsstring.length-1); 
          start_time=$("#start_time").val();
         if(start_time=='')
         {
            bootbox.alert("请输入查询时间！");
            return false;
         }
        end_time=$("#end_time").val();
          type=$("#type").val();
         if(type==4 && end_time=='')
         {
            bootbox.alert("请输入查询结束时间！");
            return false;
         }

         jQuery("#finance_report_grid").jqGrid('setGridParam',{postData:self.serialize(),url:self.attr("action"),page:1,datatype:'json'}).trigger("reloadGrid"); 
         return false;
     });



    $("#menu_3").addClass("active open");
    $("#menu_64").addClass("active"); 
    var grid_selector = "#finance_report_grid";
    var pager_selector = "#finance_report_grid_pager";

    
                jQuery(grid_selector).jqGrid({
                    url:"/Finance/Report/queryReport",                 
                   mtype:"POST",        
                  datatype: "local",
                  height: 'auto', 
                  width:"auto",
                    colNames:['项目','收款笔数','合同单数','应缴收入','实际收入','欠款','现金','支票','POS','储值卡','网络支付','网银分期','classify'],
                    colModel:[ 
                      
                        {name:'name',index:'name',formatter : function(value, options, rData){ 
                            if(end_time=="")end_time="0";
                                            return "<a target='_blank' href='/Finance/Report/detail?clubs="+clubsstring+ "&type="+rData.type+"&subtype="+rData.subtype+"&start_time="+start_time+"&end_time="+end_time+"&reporttype="+type+"'>"+value+"</a>"
                         }}, 
                          {name:'pay_number',index:'pay_number'},  
                       {name:'number',index:'number'},  
                       {name:'price',index:'price',summaryType:'sum',summaryTpl:'<b>总收入: ￥{0}</b>'},  
                       {name:'paid',index:'paid',summaryType:'sum',summaryTpl:'<b>实际总收入: ￥{0}</b>',formatter : function(value, options, rData){
                          if(isNaN(value)) return "未知";
                          return value;
                       }},
                       {name:'own',index:'own',summaryType:'sum',summaryTpl:'<b>总欠款: ￥{0}</b>',formatter : function(value, options, rData){
                          if(isNaN(value)) return "未知";
                          return value;
                       }},
                       {name:'cash',index:'cash',summaryType:'sum',summaryTpl:'<b>总现金: ￥{0}</b>',formatter : function(value, options, rData){
                          if(isNaN(value)) return "未知";
                          return value;
                       }},
                       {name:'check',index:'check',summaryType:'sum',summaryTpl:'<b>总支票: ￥{0}</b>',formatter : function(value, options, rData){
                          if(isNaN(value)) return "未知";
                          return value;
                       }},
                       {name:'pos',index:'pos',summaryType:'sum',summaryTpl:'<b>总POS: ￥{0}</b>',formatter : function(value, options, rData){
                          if(isNaN(value)) return "未知";
                          return value;
                       }},
                       {name:'recharge',index:'recharge',summaryType:'sum',summaryTpl:'<b>总储值卡: ￥{0}</b>',formatter : function(value, options, rData){
                          if(isNaN(value)) return "未知";
                          return value;
                       }},
                        {name:'network',index:'network',summaryType:'sum',summaryTpl:'<b>总网络支付: ￥{0}</b>',formatter : function(value, options, rData){
                          if(isNaN(value)) return "未知";
                          return value;
                       }},
                        {name:'netbank',index:'netbank',summaryType:'sum',summaryTpl:'<b>总网银分期: ￥{0}</b>',formatter : function(value, options, rData){
                          if(isNaN(value)) return "未知";
                          return value;
                       }},
                       {name:'classify',index:'classify',hidden:true},
                    ],       
                   
                    pager : pager_selector,
                     viewrecords: true,
    sortname: 'classify',
    rowList:[],
    grouping:true,
    autowidth: true,
    shrinkToFit:false,  
    rowNum: 99999,
    pginput:false,
  pgbuttons: false,
   gridview: false,
    caption: "财务报表" ,
    groupingView : {
      groupField : ['classify'],
      groupSummary : [true],
      groupColumnShow : [false],
      groupText : ['<b>{0} - {1} 项</b>'],
      groupCollapse : false,
      scroll:false,
    groupOrder: ['desc']      
    },

    footerrow: true,
    userDataOnFooter: true

                });   
})
</script>

</body>
</html>