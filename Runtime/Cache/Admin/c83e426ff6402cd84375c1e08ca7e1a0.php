<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Yoga 后台管理系统</title>

  <!-- Bootstrap -->
  <link href="/Public/css//bootstrap.min.css" rel="stylesheet">

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="/Public/js//jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="/Public/js//bootstrap.min.js"></script>
  <script src="/Public/js//cms.js"></script>
  <link href="/Public/css//cms.css" rel="stylesheet">
  
	<script>
	$(function(){$(".navbar-nav>li:eq(3)").addClass("active").siblings().removeClass("active");});
</script>


  <!-- inline styles related to this page -->

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

  <!--[if lt IE 9]>
  <script src="/Public/js//html5shiv.js"></script>
  <script src="/Public/js//respond.min.js"></script>
  <![endif]-->

</head>
<body>
	<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Yoga Cms</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
       <li class="dropdown">
          <a href="<?php echo U('system/index');?>" class="dropdown-toggle" data-toggle="dropdown">系统设置 <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">    
            <li><a href="<?php echo U('system/index');?>">默认角色</a></li>           
          </ul>
        </li>

        <li class="dropdown">
          <a href="<?php echo U('system/index');?>" class="dropdown-toggle" data-toggle="dropdown">调查问卷 <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">    
            <li><a href="<?php echo U('Quiz/quiz');?>">调查问卷</a></li>           
          </ul>
        </li>


       <li class="dropdown">
          <a href="<?php echo U('Admin/Brand/index');?>" class="dropdown-toggle" data-toggle="dropdown">品牌管理 <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#"  data-toggle="modal" data-target="#editbrand">添加品牌</a></li>
            <li><a href="<?php echo U('Admin/Brand/index');?>">品牌查询</a></li>           
          </ul>
        </li>



        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">用户管理 <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#"  data-toggle="modal" data-target="#edituser" >添加帐号</a></li>
            <li><a href="<?php echo U('Admin/User/index');?>">用户查询</a></li>           
          </ul>
        </li>



        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Super <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo U('Admin/Super/export');?>" >导出会员资料</a></li> 
          </ul>
        </li>

      </ul>
     
      <ul class="nav navbar-nav navbar-right">      
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">你好,<?php echo ($user); ?> <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo U('Admin/User/editpw');?>">修改密码</a></li>
            <li><a href="<?php echo U('Admin/User/logout');?>">退出</a></li>            
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="container">
	
	<div class="head" >	
	 	
   </div>
        
	 <table class="table">		 
		<thead>
			<th>序号</th>
			<th>调查主题</th>
			<th>封面</th> 
			<th>创建时间</th> 
			<th>操作</th>
		</thead>
		<tbody>
			<?php if(is_array($quizs)): $i = 0; $__LIST__ = $quizs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$quiz): $mod = ($i % 2 );++$i;?><tr>
			  <td>
			  	<?php echo ($quiz["id"]); ?>
			  </td>			   
			   <td>
			  	<?php echo ($quiz["title"]); ?>
			  </td>	
			   <td>
			  	<?php echo ($quiz["conver_url"]); ?>
			  </td>			  
			   <td >
			  	<?php echo ($quiz["create_time"]); ?>
			  </td> 
			   <td>			  	
			  	 <a href="javascript:void(0)" onclick="if(confirm('确定要删除吗？'))deluser(<?php echo ($user["id"]); ?>,this)">删除</a>
			  </td>
			  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
     </table>
   <ul class="pagination">
   <?php if(0 == $current_page): ?><li class="disabled"><a href="#">&laquo;</a></li>
   <?php else: ?>
    <li><a href="<?php echo U('Admin/User/index?page='.($current_page-1));?>">&laquo;</a></li><?php endif; ?>
   <?php $__FOR_START_444220722__=0;$__FOR_END_444220722__=$pages;for($i=$__FOR_START_444220722__;$i < $__FOR_END_444220722__;$i+=1){ if($i == $current_page): ?><li class="active"><a href="<?php echo U('Admin/User/index?page='.$i);?>"><?php echo ($i+1); ?><span class="sr-only">(current)</span></a></li>
		<?php else: ?> <li><a href="<?php echo U('Admin/User/index?page='.$i);?>"><?php echo ($i+1); ?></a></li><?php endif; } ?> 
    <?php if($pages == $current_page+1): ?><li class="disabled"><a href="#">&raquo;</a></li>
   <?php else: ?>
    <li><a href="<?php echo U('Admin/User/index?page='.($current_page+1));?>">&raquo;</a></li><?php endif; ?>	 	
	</ul>

</div>

  <div class="modal fade" id="editbrand" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">添加品牌</h4>
      </div>
      <div class="modal-body">
      <form class="form-horizontal" role="form" action="<?php echo U('brand/edit');?>">
        <input type="hidden" name="id" value="0" id="brand_id"/>
        <div class="form-group">
              <label for="brand_name" class="col-sm-2 control-label">品牌名称:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="brand_name" name="brand_name"></div>
            </div>

         <div class="form-group">
              <label for="username" class="col-sm-2 control-label">登录帐号:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="username" name="username" ></div>
            </div>

            <div class="form-group">
              <label for="password" class="col-sm-2 control-label">密 　 码:</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" ></div>
            </div>

             <div class="form-group">
              <label for="contact_name" class="col-sm-2 control-label">联 系 人:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="contact_name" name="contact_name"></div>
            </div>
             <div class="form-group">
              <label for="email" class="col-sm-2 control-label">Email:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="email" name="email" ></div>
            </div>
             <div class="form-group">
              <label for="phone" class="col-sm-2 control-label">电 　 话:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="phone" name="phone"></div>
            </div>

            <div class="form-group">
            <label for="roles" class="col-sm-3 control-label">
                <select class="form-control" id="chooserole" name="chooserole">
                  <option value="default">默认权限</option>
                  <option value="set">设置</option>                  
              </select>
            </label>
            <div class="col-sm-9" id="roles" style="display:none">
                <label class="checkbox-inline">
                  <input type="checkbox" id="default_role" value="shopkeeper" name="roles[]" <?php if(!empty($shopkeeper)): ?>checked<?php endif; ?>> 店长
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="default_role" value="finance" name="roles[]" <?php if(!empty($finance)): ?>checked<?php endif; ?>> 财务
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="default_role" value="reception" name="roles[]" <?php if(!empty($reception)): ?>checked<?php endif; ?>> 前台
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="default_role" value="bar" name="roles[]" <?php if(!empty($bar)): ?>checked<?php endif; ?>> 水吧
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="default_role" value="cashier" name="roles[]" <?php if(!empty($cashier)): ?>checked<?php endif; ?>> 收银员
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="default_role" value="mcmanager" name="roles[]" <?php if(!empty($mcmanager)): ?>checked<?php endif; ?>> MC经理
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="default_role" value="mc" name="roles[]" <?php if(!empty($mc)): ?>checked<?php endif; ?>> MC
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="default_role" value="ptmanager" name="roles[]" <?php if(!empty($ptmanager)): ?>checked<?php endif; ?>> PT经理
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="default_role" value="pt" name="roles[]" <?php if(!empty($pt)): ?>checked<?php endif; ?>> PT
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="default_role" value="channelmanager" name="roles[]" <?php if(!empty($channelmanager)): ?>checked<?php endif; ?>> 渠道经理
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="default_role" value="channel" name="roles[]" <?php if(!empty($channel)): ?>checked<?php endif; ?>> 渠道销售
                </label>
            </div>
            <span class="help-block" style="margin-left:20px"></span>
            </div>
             <div class="form-group">
              <label for="desc" class="col-sm-2 control-label">备 　 注:</label>
             <div class="col-sm-10">
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
               </div>
            </div>         
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary" id="add_brand">添加</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="modal fade" id="edituser" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">添加用户</h4>
      </div>
      <div class="modal-body">
      <form class="form-horizontal" role="form" action="<?php echo U('user/edit');?>">         
        <div class="form-group">
              <label for="brand_name" class="col-sm-2 control-label">用户名:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="username"></div>
            </div> 
            <div class="form-group">
              <label for="password" class="col-sm-2 control-label">密 　 码:</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="password" ></div>
            </div>      
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary" id="add_user">添加</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>