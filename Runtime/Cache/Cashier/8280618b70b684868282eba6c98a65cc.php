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
        <li class="active">升级</li>
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
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">会员信息</h3>
                </div>
                <div class="panel-body"> 
                    <input type="hidden" id="user_id" value="<?php echo ($member["id"]); ?>">
                    <div class="row">
                        <div class="form-group col-xs-4">姓名:<?php echo ($member["name"]); ?></div>
                        <div class="form-group col-xs-4">电话:<?php echo ($member["phone"]); ?></div>
                        <div class="form-group col-xs-4">
                            性别:
                            <?php if(female == $member['sex']): ?>女
                                <?php else: ?>
                                男<?php endif; ?>
                        </div>
                    </div>

                    <!-- <div class="row">
                    <div class="form-group col-xs-4">卡号:<?php echo ($card["card_number"]); ?></div>
                    <div class="form-group col-xs-4">
                        卡状态:
                        <?php switch($card["status"]): case "0": ?>正常<?php break;?>
                            <?php case "1": ?>挂失<?php break;?>
                            <?php case "1": ?>新办<?php break;?>
                            <?php case "1": ?>请假中<?php break;?>
                            <?php case "1": ?>已销毁<?php break;?>
                            <?php default: ?>
                            正常<?php endswitch;?>

                    </div>
                    <div class="form-group col-xs-4">
                        是否激活：
                        <?php if(1 == $card['is_active']): ?>激活
                            <?php else: ?>
                            未激活<?php endif; ?>
                    </div>
                </div>
                -->
            </div></div>

            <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">当前合同信息</h3>
            </div>
            <div class="panel-body">
                <input type="hidden" id="contract_id" value="<?php echo ($contract["id"]); ?>">
                <div class="form-group col-xs-4">合同编号:<?php echo ($contract["contract_number"]); ?></div>
                <div class="form-group col-xs-4">卡种:<?php echo ($contract["card_type"]["name"]); ?></div>
                <div class="form-group col-xs-4">
                    次数:
                    <?php if(1 == $contract['card_type']['type']): ?>不限次数
                        <?php else: ?>
                        <?php echo ($contract["used_num"]); ?>/<?php echo ($contract["total_num"]); endif; ?>
                </div>
                <div class="form-group col-xs-4">应收价格:<?php echo ($contract["price"]); ?></div>
                <div class="form-group col-xs-4">已付:<?php echo ($contract["payed"]); ?></div>
                <div class="form-group col-xs-4">欠款:<?php echo ($contract['price']-$contract['payed']); ?></div>
                <div class="form-group col-xs-4">
                    开卡方式:
                    <?php switch($contract["active_type"]): case "0": ?>买卡当天开卡<?php break;?>
                        <?php case "1": ?>指定日期开卡<?php break;?>
                        <?php case "2": ?>第一次到开卡<?php break;?>
                        <?php default: ?>
                        买卡当天开卡<?php endswitch;?>

                </div>
                <div class="form-group col-xs-4">
                    有效期限:
                    <?php if(2 == $contract['active_type']): echo ($contract['card_type']['valid_time']); ?>月 + <?php echo ($contract["present_day"]); ?>天
                        <?php else: ?>
                        <?php echo ($contract["start_time"]); ?>--<?php echo ($contract["end_time"]); endif; ?>

                </div>
            </div>

        </div>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">可升级卡种信息</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal ajaxForm" id="validation-form" method="post" action="<?php echo U('Cashier/Contract/doUpgrade');?>">
                     <input type="hidden" name="current_contract_id" value="<?php echo ($contract["id"]); ?>">
                    <input type="hidden" name="current_member_id" value="<?php echo ($contract["member_id"]); ?>">
                        <div class="col-xs-12 col-sm-7">
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for></label>

                                <div class="col-xs-12 col-sm-9">
                                    <label class="radio-inline">
                                        <input type="radio" name="type" value="0" checked="checked">普通合同</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="type" value="1">团卡合同</label>

                                </div>
                            </div>

                            <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="join_mc_id">会籍顾问:</label>
                                        <div class="col-xs-12 col-sm-9">
                                         <select name="join_mc_id" id="join_mc_id" class="col-xs-12 col-sm-6">
                                          <option value="0" >无MC</option>
                                                <?php if(is_array($mcs)): $i = 0; $__LIST__ = $mcs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mc): $mod = ($i % 2 );++$i;?><option value="<?php echo ($mc["id"]); ?>"   <?php if($mc['id'] == $contract['mc_id']): ?>selected="1"<?php endif; ?>><?php echo ($mc["name_cn"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select> 
                                        </div>
                                        </div> 

                                        
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="card_type_id">选择卡种:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <select name="card_type_id" id="card_type_id" class="col-xs-12 col-sm-6">
                                            <option value="0">请选择卡种</option>
                                            <?php if(is_array($cardtypes)): $i = 0; $__LIST__ = $cardtypes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?><option value="<?php echo ($type["id"]); ?>"><?php echo ($type["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group hide" id="detail">

                                <label class="control-label col-xs-6 col-sm-3 no-padding-right" for="cardtype"></label>
                                <label >卡种类型:</label>
                                <label  id="cardtype" ></label>
                                <label >价格:</label>
                                <label  id="card_price" ></label>

                                <label >&nbsp;&nbsp;&nbsp;有效时间:</label>
                                <label  id="valid_time" ></label>

                                <label >&nbsp;&nbsp;&nbsp;有效次数:</label>
                                <label  id="valid_number"></label>
                            </div>
                            <div class="form-group">
                                <label  id="lbl_day" class="control-label col-xs-12 col-sm-3 no-padding-right" for="present_day">升级赠送天数:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" class="col-xs-12 col-sm-6" name="present_day" id="present_day" value="0">
                                        <label   class="col-xs-12 col-sm-2" name="day_tip" id="day_tip" ></label>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label  id="lbl_num" class="control-label col-xs-12 col-sm-3 no-padding-right" for="present_num">升级赠送次数:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" class="col-xs-12 col-sm-6" name="present_num" id="present_num" value="0">
                                        <label   class="col-xs-12 col-sm-2" id="num_tip" ></label>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="start_time">开始日期:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <input type="text" class="col-xs-12 col-sm-6" name="start_time" id="start_time" disabled value="<?php echo ($contract["start_time"]); ?>"></div>

                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="end_time" >结束日期:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <input type="text" class=" col-xs-12 col-sm-6 " name="end_time" id="end_time" readonly = "readonly"></div>

                            </div>

                              <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="free_trans" >免费转会籍一次:</label>

                            <div class="col-sm-9"> 
                                            <span class="help-inline col-xs-12 col-sm-7">
                                                <label class="middle">
                                                    <input class="ace" type="checkbox" name="free_trans" id="free_trans"      <?php if(1 == $contract['free_trans']): ?>checked="checked"<?php endif; ?>      /> 
                                                        <span class="lbl"> &nbsp</span>
                                                </label>
                                            </span>
                                        </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="free_rest" >免费停卡次数:</label> 
                             <div class="col-xs-12 col-sm-9"> 
                                                <input type="text" class="col-xs-12 col-sm-6 " name="free_rest" id="free_rest" value="<?php echo ($contract['free_rest'] - $contract['rest_count']); ?>"></div>
                        </div>


                            <div class="form-group red">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="extra" >手续费:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <input type="text" class=" col-xs-12 col-sm-6 red"  id="extra" readonly = "readonly" value="￥<?php echo ($extra); ?>（需单独付款）"></div>

                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="should_pay" >需补差额:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <input type="text" class=" col-xs-12 col-sm-6 " name="should_pay" id="should_pay"  ></div>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="form-group">
                                <label for="cash" class="control-label col-xs-12 col-sm-3 no-padding-right">现金</label>
                                <div class="col-xs-12 col-sm-9">
                                    <input class="form-control col-xs-12 col-sm-6" type="text" name="cash" id="cash" value="0"></div>
                            </div>
                            <div class="form-group">
                                <label for="pos" class="control-label col-xs-12 col-sm-3 no-padding-right">刷卡</label>
                                <div class="col-xs-12 col-sm-9">
                                    <input value="0" class="form-control col-xs-12 col-sm-6" type="text" name="pos" id="pos"></div>
                            </div>
                            <div class="form-group">
                                <label for="check" class="control-label col-xs-12 col-sm-3 no-padding-right">支票</label>
                                <div class="col-xs-12 col-sm-9">
                                    <input value="0" class="form-control col-xs-12 col-sm-6" type="text" name="check" id="check"></div>
                            </div>
                            <div class="form-group">
                                <label for="check_num" class="control-label col-xs-12 col-sm-3 no-padding-right">支票号</label>
                                <div class="col-xs-12 col-sm-9">
                                    <input class="form-control col-xs-12 col-sm-6" type="text" name="check_num" id="check_num"></div>
                            </div>

                        <div class="form-group">
                            <label for="network" class="control-label col-xs-12 col-sm-3 no-padding-right">网络支付</label>
                            <div class="col-xs-12 col-sm-9">
                                <input value="0" class="form-control col-xs-12 col-sm-6" type="text" name="network" id="network"></div>
                        </div>
                        <div class="form-group">
                            <label for="netbank" class="control-label col-xs-12 col-sm-3 no-padding-right">网银分期</label>
                            <div class="col-xs-12 col-sm-9">
                                <input value="0"  class="form-control col-xs-12 col-sm-6" type="text" name="netbank" id="netbank"></div>
                        </div>
                            <div class="form-group">
                                <label for="description" class="control-label col-xs-12 col-sm-3 no-padding-right">备注</label>
                                <div class="col-xs-12 col-sm-9">
                                    <textarea class="form-control col-xs-12 col-sm-6"  name="description" id="description" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
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
    function calEndTime()
        {
            if(current_card_type==null) return;
            var start_time=$("#start_time").val();
            var params=start_time.split("-");
            var year=parseInt(params[0]);
            var month=parseInt(params[1]);
            var day = parseInt(params[2]); 
            month += parseInt(current_card_type.valid_time);
            year += Math.floor(month/12);
            month=month%12; 
            var date = new Date() ; 
            date.setFullYear(year,month-1,day); 
             if(!isNaN(parseInt(parseInt($("#present_day").val()))))
            date.setDate(date.getDate()+parseInt($("#present_day").val())); 
            $("#end_time").val(date.format("yyyy-MM-dd"));
        };
  $("#present_day").on('input',function(e){  
                calEndTime();
        });  
      

        var saletypes = eval("(" + '<?php echo ($typesarr); ?>' + ")");
        var current_contract = '<?php echo ($current_contract); ?>';
        current_contract=current_contract.replaceAll("\r\n", "<br/>") ;
        var current_contract=eval("(" + current_contract + ")");
        var extra = '<?php echo ($extra); ?>';
$(function(){ 
            $("#card_type_id").change(function(){
              
                $("#end_time").val("");
                var card_type_id = $(this).val();
                if(card_type_id==0)
                {
                    $("#detail").addClass("hide"); 
                     $("#should_pay").val("");
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
                        $("#card_price").text(saletypes[i].price);
                        var vn=saletypes[i].type==1?"不限次数":saletypes[i].valid_number+" 次"                   
                        $("#valid_number").text(vn);
                        $("#detail").removeClass("hide");
                        $("#day_tip").text("<"+saletypes[i].max_present_day);
                        $("#num_tip").text("<"+saletypes[i].max_present_num);
                        $("#present_value").val(saletypes[i].max_present_value);
                        str = current_contract.start_time.replace(/-/g,"/");                        
                        var date = new Date(str);
                        // var now = new Date();
                        var year = date.getFullYear();
                        var month = date.getMonth()+1;
                        var day = date.getDate();  
                        month += parseInt(saletypes[i].valid_time);
                        year += Math.floor(month/12);
                        month=month%12;  
                        $("#end_time").val(year+"-"+padLeft(month,2)+"-"+padLeft(day,2)); 
                        $("#should_pay").val(saletypes[i].price - current_contract.price +parseInt(extra));
                        current_card_type=saletypes[i];
                        return;
                    }
                    $("#detail").addClass("hide");
                }
            }); 
});
        </script>
</body>
</html>