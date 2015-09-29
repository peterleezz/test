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

  
  <style>
    .ui-jqgrid tr.jqgrow td
{           
    word-wrap: break-word; /* IE 5.5+ and CSS3 */
    white-space: pre-wrap; /* CSS3 */
    white-space: -pre-wrap; /* Opera 4-6 */
    white-space: -o-pre-wrap; /* Opera 7 */
    white-space: normal !important;
    height: auto;
    vertical-align: text-top;
    padding-top: 2px;
    padding-bottom: 3px;
}
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
    <li class="active">会籍合同管理</li>
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

      <form class="form-inline" role="form" action="<?php echo U('Brand/Review/queryNew');?>" method="post" id="cashier_contract_form" style="margin-bottom:10px">

        <!--  <div class="form-group">
        <label class="sr-only" for="card_type_id">卡种分类</label>
        <select name="card_type_id" id="card_type_id" class="form-control" oper="eq">
          <option value="0">请选择卡种分类</option>
          <?php if(is_array($cardtypes)): $i = 0; $__LIST__ = $cardtypes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cardtype): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cardtype["id"]); ?>"><?php echo ($cardtype["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
      </div>
      -->
      <div class="form-group ">
        <label  for="contract_number">合同号:</label>
        <input type="text" class="form-control" name="contract_number"  id="contract_number" oper="eq"></div>

      <div class="form-group">
        <label  for="card_number">卡号:</label>
        <input type="text" class="form-control" name="card_number"  id="card_number" oper="eq"></div>
      <div class="form-group">
        <label  for="name">会员姓名:</label>
        <input type="text" class="form-control" name="name"  id="name" oper="eq"></div>
      <div class="form-group">
        <label  for="phone">手机号码:</label>
        <input type="text" class="form-control" name="phone"  id="phone" oper="eq"></div>

      <button type="submit" class="btn  btn-info btn-sm" onclick="clean()"> <i class="icon-search"></i>
        查询
      </button>
    </form>

    <table id="cashier_contract_grid"></table>
    <div id="cashier_contract_pager"></div>
    <div align="left" id="show_detail">
       
    </div>
  
  <div class="clearfix form-actions operation">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="btn btn-info" onclick="pass()"> <i class="icon-ok bigger-110"></i>
                                审核通过
                            </button>
                            &nbsp; &nbsp; &nbsp;
                            <button class="btn" >
                                <i class="icon-remove bigger-110"></i>
                                不通过
                            </button>
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
            var grid_selector = "#cashier_contract_grid";
            var pager_selector = "#cashier_contract_pager";     
            function clean()
            {
                  $("#show_detail").text("");
            }

function pass()
{
  if(lasdetailtid==null)
  {
    bootbox.alert("请先选中相应合同!");
  }
   $.post("/Brand/Review/passnew", {id:lasdetailtid}, function(data,textStatus){
        if(data.status){
              $("#cashier_contract_grid").jqGrid('setRowData',lasdetailtid,{is_review:"1"});
                    bootbox.alert(data.info,null); 
                } else {
                     bootbox.alert(data.info,null);                   
                }                    
    }, "json");
}
function showdetail(id)
{
  if(lasdetailtid==id && $("#show_detail").text()!='')return;
  lasdetailtid=id;
    $.post("/Brand/Review/show", {id:id}, function(data,textStatus){
                                $("#show_detail").text("");
                                $("#show_detail").append(data);
    }, "json");
 
}
  
    $(function(){ 
$("#menu_1").addClass("active open");
     $("#menu_18").addClass("active open");
    $("#menu_25").addClass("active");

            var grid_selector = "#cashier_contract_grid";
            var pager_selector = "#cashier_contract_pager";                 
                jQuery(grid_selector).jqGrid({
                    url:"<?php echo U('Brand/Review/queryNew');?>",                 
                    datatype: "local",
                    height: "100%",    
                    width:($('#fcontainer').width()-20),
                    mtype:"POST",
                    colNames:['ID','状态', 'contract_id','合同编号','合同类型','对应卡号','合同状态','普通/团卡','姓名','性别', '手机号码','卡种','次数','赠送时间(天)','赠送次数(次)','应收价格','卡种价格','已付','欠款','生效时间','结束时间','开卡方式','MC姓名', '录入人','签约日期',"备注"],
                    colModel:[   
                         {name:'id',index:'id',width:150,hidden:true},
                            {name:'is_review',index:'is_review',width:100,formatter : function(value, options, rData){
                           var a=new Array("未审核","已审核");
                           return getValue(a,value); 
                   }}, 
                          {name:'contract_id',index:'contract_id',hidden:true},
                        {name:'contract_number',index:'contract_number',width:150,},      

                      {name:'type',index:'type',width:100,formatter : function(value, options, rData){
                           var a=new Array("新增合同","","","转让","续费","升级");
                           return getValue(a,value); 
                   }}, 
                        {name:'card_number',index:'card_number',width:150,editable: true,},

                        {name:'invalid',index:'invalid',width:70,formatter : function(value, options, rData){
                                             var a=new Array("无效","有效");
                                               return getValue(a,value); 
                                }},
                        {name:'btype',index:'btype',width:70,formatter : function(value, options, rData){
                                           var a=new Array("普通合同","团卡合同");
                                           return getValue(a,value); 
                                   },editable: true,edittype: 'select',editoptions:{sopt:['eq'],value:"0:普通合同;1:团卡合同"}},
                         {name:'name',index:'name',width:100},
                                                {name:'sex',index:'sex',width:50,formatter : function(value, options, rData){
                                                  return value=='male'|| value=='男'?"男":"女";
                                           }},
                        {name:'phone',index:'phone',hidden:true,width:150,},
                        {name:'card_type_id',index:'card_type_id',width:150,editable: true,edittype: 'select',editoptions:{sopt:['eq'],value:getCardTyps()},formatter : function(value, options, rData){
                                          return rData.card_name;
                                           }},  
                        {name:'times',index:'times',width:100,formatter : function(value, options, rData){
                                                    if(rData.card_type==1) return "时间卡"
                                                          return rData.used_num+"/"+rData.total_num;
                                           }},  
                        {name:'present_day',index:'present_day',width:100,editable: true},      
                         {name:'present_num',index:'present_num',width:100,editable: true},      
                                                              
                      {name:'price',index:'price',width:80,editable: true},
                      {name:'card_type_price',index:'card_type_price',width:80},
                        {name:'paid',index:'paid',width:80,editable: false},
                        {name:'',index:'',width:80,formatter : function(value, options, rData){                            
                           return rData.price-rData.paid; 
                   }},
                    {name:'start_time',index:'start_time',width:150,editable: true,edittype:'text',editrules:{required:true},editoptions: {size:10,maxlengh:10,dataInit:function(element){$(element).datetimepicker({ format: 'yyyy-mm-dd',      minView:'2',          language:'zh-CN',      autoclose:true,})}}} ,
                    {name:'end_time',index:'end_time',width:150,editable: true,edittype:'text',editrules:{required:true},editoptions: {size:10,maxlengh:10,dataInit:function(element){$(element).datetimepicker({ format: 'yyyy-mm-dd',      minView:'2',          language:'zh-CN',      autoclose:true,})}}} ,

                         {name:'active_type',index:'active_type',width:100,formatter : function(value, options, rData){
                           var a=new Array("买卡当天开卡","指定日期开卡","第一次到开卡");
                           return getValue(a,value); 
                   },editable: true,edittype: 'select',editoptions:{sopt:['eq'],value:"0:买卡当天开卡;1:指定日期开卡;2:第一次到开卡"}},     
                       {name:'mc_name',index:'mc_name',width:80}, 
                        {name:'recorder_name',index:'recorder_name',width:80},                          
                        {name:'create_time',index:'create_time',width:150},   
                          {name:'desc',index:'desc',width:150},                                          
                    ],      
                    pager : pager_selector,
                    altRows: true,                   
                    multiselect: true,
                    multiboxonly: true,
                    pgbuttons:true,
                    pginput : false,
                    cmTemplate: {sortable:false,editable: false,search:false,align:"left"},
                    sortorder: "desc",
                    editurl: "<?php echo U('Brand/Review/editcontract');?>",         
                    autowidth: false,
                    shrinkToFit:false,  
                    autoScroll: true,
                    caption: "会员卡信息" ,
                    // loadonce: true,
                     rowNum: 10,
                    rowList: [10, 20, 30],
                    viewrecords: true,
                    onSelectRow: function (rowid, status) {
                      var ret = jQuery(grid_selector).jqGrid('getRowData',rowid); 
                      if(ret.is_review=='已审核')
                      {
                        $(".operation").hide();
                      }
                      else
                      {
                        $(".operation").show();
                      }
                             showdetail(rowid);
                             return;
                        
                     }, 
                     beforeSelectRow: function(rowid, e)
                      {
                          jQuery(grid_selector).jqGrid('resetSelection');
                          return(true);
                      },


                    gridview: true, 

                    jsonReader:{userdata:"userdata"},                   
                    loadComplete : function() {  
                      // jQuery("#contract_grid").jqGrid('setGridParam',{datatype:'local'});
                        var table = this;
                        // $("#show_detail").addClass("hide");
                        userData=jQuery(grid_selector).jqGrid('getGridParam', 'userData');
                        setTimeout(function(){ 
                            updatePagerIcons(table);
                            enableTooltips(table);
                        }, 0); 
                    },
 
   
                }); 

                jQuery(grid_selector).jqGrid('navGrid',pager_selector,
                    {   //navbar options
                        edit: true,
                        editicon : 'icon-pencil blue',
                        edittext:"编辑",
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
                            return [res.status==1,res.info,res.new_id];
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
                             return [res.status==1,res.info,res.new_id];
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
 
 
          
})
    </script>

</body>
</html>