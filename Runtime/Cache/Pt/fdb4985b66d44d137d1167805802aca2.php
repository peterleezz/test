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
        <li class="active">客户管理</li>

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
            <form class="form-inline" role="form" action="<?php echo U('Pt/Sale/getMembers');?>" method="post" id="pt_query_notmember" >

                <input type="hidden" value="1" name="is_member" oper="eq">

                <div class="input-group form-group">
                    <input type="text" class="form-control" id="day"> 
                    <input type='text' style='display:none'/>
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-sm" type="button" disabled="">日内</button>
                    </span>
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                            <span  id="action">统计类型</span>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">

                            <li>
                                <a href="javascript:void(0)" onclick="$('#action').text('新录入');$('.detail_query').addClass('hide');st_query(2)">新录入</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" onclick="$('#action').text('无跟进');$('.detail_query').addClass('hide');st_query(8)">无跟进</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" onclick="$('#action').text('新分配');$('.detail_query').addClass('hide');st_query(9)">新分配</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" onclick="$('#action').text('预约体验');$('.detail_query').addClass('hide');st_query(10)">预约</a>
                            </li>
                            

                            <li class="divider"></li>
                            <li>
                                <a href="javascript:void(0)" onclick="$('#action').text('精确查询');$('.detail_query').removeClass('hide')">精确查询</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </form>
        </div>
        <hr/>
        <div class="col-xs-12 detail_query hide"  >
            <form class="form-inline" role="form" action="<?php echo U('Pt/Sale/getMembers');?>" method="post" id="pt_query_member" >

                <input type="hidden" value="1" name="is_member" oper="eq">
                <!-- <div class="form-group">
                <label class="sr-only" for="channel_id">选择渠道</label>
                <select name="channel_id" id="channel_id" class="form-control">
                    <option value="0">所有渠道</option>
                    <?php if(is_array($channels)): $i = 0; $__LIST__ = $channels;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$channel): $mod = ($i % 2 );++$i;?><option value="<?php echo ($channel["id"]); ?>"><?php echo ($channel["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
            -->
            <div class="form-group">
                <label class="sr-only" for="type">客户分类</label>
                <select name="type" id="type" class="form-control" oper="eq">
                    <option value="0">所有客户</option>
                    <option value="4">A类</option>
                    <option value="3">B类</option>
                    <option value="2">C类</option>
                    <option value="1">D类</option>
                </select>
            </div>

            <div class="form-group">
                <label  for="name">姓名:</label>
                <input type="text" class="form-control" name="name"  id="name" oper="eq"></div>

            <div class="form-group">
                <label  for="phone">手机号:</label>
                <input type="text" class="form-control" name="phone"  id="phone" oper="eq"></div>

            <button type="submit" class="btn  btn-info btn-sm"> <i class="icon-search"></i>
                查询
            </button>

        </form>
    </div>
    <div class="col-xs-12">
        <table id="pt_member_grid"></table>
        <div id="pt_member_grid_pager"></div>
    </div>

</div>
<div id="show_detail"></div>

<div class="modal fade " id="followupModal" tabindex="-1" role="dialog" aria-labelledby="followupmodallabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="row">
                    <div class="col-xs-12">
                        <form class="form-horizontal ajaxForm" role="form" id="followupform" action="<?php echo U('Pt/Sale/addfollowup');?>">
                            <input type="hidden" name="member_id" id="follow_id"  oper="eq">
                            <div class="form-group">

                                <label class="col-sm-4  control-label no-padding-right" for="f_name">
                                    姓名:
                                    <span id="f_name" ></span>
                                </label>
                                <label class="col-sm-4  control-label no-padding-left" for="f_phone">
                                    电话:
                                    <a id="f_phone"></a>
                                </label>

                            </div>
                            <div class="form-group">

                                <label class="col-sm-2  control-label no-padding-right" for="name">结果:</label>
                                <div class="col-sm-4">
                                    <select name="ret" id="ret" class=" form-control">
                                        <option value="0">跟进失败</option>
                                        <option value="1">邀约体验</option>    
                                         <option value="2">决定购买课程</option>                         
                                    </select>
                                </div>

                                <label class="failed col-sm-2  control-label no-padding-right" for="failed_reason">失败反馈:</label>
                                <div class="col-sm-4 failed">
                                    <select name="failed_reason" id="failed_reason" class=" form-control">
                                        <option value="未接通">未接通</option>
                                        <option value="问候电话">问候电话</option>
                                        <option value="最近没有时间">最近没有时间</option>
                                        <option value="不感兴趣">不感兴趣</option>
                                        <option value="对俱乐部硬件有意见">对俱乐部硬件有意见</option>
                                        <option value="对服务有意见">对服务有意见</option>
                                        <option value="对团操课有意见">对团操课有意见</option>
                                        <option value="对教练有意见">对教练有意见</option>
                                        <option value="价格">价格</option>
                                        <option value="没有效果">没有效果</option>
                                        <option value="其他">其他</option>
                                    </select>
                                </div>

                                <label class="successed hide col-sm-2  control-label no-padding-right" for="appoint_time">预约时间:</label>
                                <div class="successed  hide col-sm-4">
                                    <input type="text" name="appoint_time" id="appoint_time" class="date_ymd form-control"></div>

                            </div>
                            
                             <div class="form-group successed hide"> 
                                <label class="col-sm-2  control-label no-padding-right" for="pt_class_id">Pt课程:</label>
                                <div class="col-sm-10">
                                    <select name="pt_class_id" id="pt_class_id" class="col-xs-12">
                                        <?php if(is_array($classes)): $i = 0; $__LIST__ = $classes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$class): $mod = ($i % 2 );++$i;?><option value="<?php echo ($class["id"]); ?>"><?php echo ($class["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">

                                <label class="col-xs-2  control-label no-padding-right" for="desc">备注:</label>
                                <div class="col-xs-10">
                                    <textarea type="text" id="desc"  rows="3" class="form-control col-xs-12" name="desc" ></textarea>
                                </div>
                            </div>

                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="submit" class="btn btn-primary" >保存</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade " id="followlistModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">跟进历史记录</h4>
            </div>
            <div class="modal-body">

                <table class="table table-condensed followlist" >
                    <thead>
                        <tr>
                            <th>姓名</th>
                            <th>通话日期</th>
                            <th>结果</th>
                            <th>相关</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">已阅</button>
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
  


function show_follow_up(self)
{ 
    $("#followupModal").modal("show");
    $(self).removeClass("btn-danger").addClass("btn-default");
}


function st_query(type)
{
    var day = $("#day").val();
    if(parseInt(day)>0)
    {
         var rules="";
        rules = '{"field":"st_type","op":"eq","data":{"type":"' + type + '","day":"'+day+'","is_member":-1}}'; 

        var filtersStr = '{"groupOp":"AND","rules":[' + rules + ']}';  
         var postData = $("#pt_member_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#pt_member_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
    }
    
}

function showdetail(id)
{
    if(lasdetailtid==id && $("#show_detail").text()!='')return; lasdetailtid=id;
    $.post("/Pt/Sale/show", {id:id}, function(data,textStatus){
                              $("#show_detail").text("");
                              $("#show_detail").append(data);
                        }, "json");
}
$(function(){ 

    $("#menu_10").addClass("active open");
    $("#menu_62").addClass("active");

$("#ret").change(function(){
    if($(this).val()==0)
    {
        $(".successed").addClass("hide");
         $(".failed").removeClass("hide");
    }
    else  if($(this).val()==1)
    {
         $(".successed").removeClass("hide");
         $(".failed").addClass("hide");
    }else  if($(this).val()==2)
    {
         $(".successed").removeClass("hide");
         $(".failed").addClass("hide");
    }
});

    var grid_selector = "#pt_member_grid";
    var pager_selector = "#pt_member_grid_pager";

    
                jQuery(grid_selector).jqGrid({
                    url:"/Pt/Sale/getMembers",                 
                    datatype: "json",
                    height: "100%",  
                    width:"100%",          
                    mtype:"POST",
                     postData:{is_member:-1},
                    colNames:['ID','姓名','手机号码','性别','入会','访客状态','跟进'],
                    colModel:[ 
                        {name:'id',index:'id',hidden:true,sortable:true,editable: false ,width:100,formatter : function(value, options, rData){
                            return value;
                            // return "<a href='javascript:void(0)' onclick=showdetail("+value+")>"+value+"</a>";
            },sorttype:'integer', searchoptions:{sopt:['eq','ne','le','lt','gt','ge']}},
                        {name:'name',index:'name',width:80,editoptions:{size:"20",maxlength:"30"},formatter : function(value, options, rData){
                            return value;
                            //   var v=rData.id;
                            // return "<a href='javascript:void(0)' onclick=showdetail("+v+")>"+value+"</a>";
            }},
                        {name:'phone',index:'phone',hidden:true,width:150,editoptions:{size:"20",maxlength:"30"},search:true},
                       {name:'sex',index:'sex', width:60,editoptions:{size:"20",maxlength:"30"},edittype:"select",editoptions:{value:"male:男;female:女"},formatter : function(value, options, rData){
                           return value=='male'|| value=='男'?"男":"女";
            },},
                        {name:'type',index:'type', width:60,editoptions:{size:"20",maxlength:"30"},edittype:"select",formatter : function(value, options, rData){
                         var a=new Array("潜客","会员");
                           return getValue(a,value); 
            }}, 
             {name:'is_member',index:'is_member',hidden:true, width:100,editoptions:{size:"20",maxlength:"30"},formatter : function(value, options, rData){
                            var a=new Array("潜在客户","正式会员");
                           return getValue(a,value);
            },},
 
                        {name:'id',index:'id',editable: false , width:100,formatter : function(value, options, rData){
                          return '<button class="btn btn-danger btn-sm followup" onclick="show_follow_up(this)"><i class="icon-reply icon-only"></i>跟进</button>';
            }},  
                    ],       
                   
                    pager : pager_selector,
                    altRows: true,                   
                    multiselect: true,
                    multiboxonly: true,
                    pgbuttons:true,
                    pginput : false,
                    cmTemplate: {sortable:false,editable: false,search:false},
                    sortorder: "desc",
                    editurl: "",    
                     autowidth: true,
                     shrinkToFit:true,  
                    caption: "客户信息" ,
                    // hidegrid:false,
                     rowNum: 10,
                    rowList: [10, 20, 30],
                    viewrecords: true,
                    gridview: true,
                    jsonReader:{userdata:"userdata"},
                     onSelectRow: function (rowid, status) { 
                       
                        var id = jQuery("#pt_member_grid").jqGrid('getGridParam','selrow');
                        var rowData = $("#pt_member_grid").jqGrid("getRowData",id);
                        var name=rowData.name;
                        var phone=rowData.phone;
                          $("#f_name").text(name); 
                        $("#f_phone").text(phone);
                        $("#f_phone").attr("href","tel:"+phone);
                        $("#follow_id").val(id);
                         if(status==true)
                         {
                             showdetail(rowid);
                             return;
                         } 
                         else
                         {
                            $("#show_detail").text("");
                         }
                     }, 

                    loadComplete : function() { 
                        var table = this;
                        setTimeout(function(){ 
                            updatePagerIcons(table);
                            enableTooltips(table);
                        }, 0); 
                    }, 
                });  
 
    jQuery(grid_selector).jqGrid('inlineNav',pager_selector);
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
                    } 
                );

jQuery(grid_selector).jqGrid('navButtonAdd',pager_selector,{position: "first",buttonicon : 'icon-calendar blue',caption:"",title:"",
    onClickButton:function(){ 
        var id = jQuery(grid_selector).jqGrid('getGridParam','selrow');
    if (id) {
          var ret = jQuery(grid_selector).jqGrid('getRowData',id);
        $.post("/Pt/Sale/followlist", {id:id}, function(data,textStatus){
                             if(data.status)
                             {
                                var data=data.data;
                                if(data==null)
                                {
                                    bootbox.alert('无跟进记录',null);
                                    return;
                                }
                                $(".followlist tr:not(:first)").remove();
                                for(var i=0;i<data.length;i++)
                                {
                                    var record=data[i];
                                    var html='<tr><td>'+ret.name+'</td>';
                                    var rslt;var info;
                                    if(record.ret==0)
                                    {
                                        rslt="跟进失败";
                                        info=record.failed_reason;
                                    }
                                    else if(record.ret==1)
                                    {
                                        rslt="邀约"+record.ptclass.name;
                                        info=record.appoint_time+"来店"
                                    }  else if(record.ret==2)
                                    {
                                        rslt="决定购买"+record.ptclass.name;
                                        info=record.appoint_time+"来店"
                                    }
                                     html+="<td>"+record.create_time+"</td>";
                                     html+="<td>"+rslt+"</td>";
                                      html+="<td>"+info+"</td></tr>"; 

                                    $(".followlist").append(html); 
                                }
                                  
                                 $("#followlistModel").modal("show");
                             }
                             else
                             {
                                bootbox.alert(data.info,null);
                             }
                        }, "json");       
    } else { alert("请先选中要修改的行！");}
         
    } 
}); 



})
</script>

</body>
</html>