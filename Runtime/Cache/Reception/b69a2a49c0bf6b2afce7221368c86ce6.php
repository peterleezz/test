<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone=no">
	<title>美妙瑜伽之旅</title>

	<!-- 新 Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="/Public/css/bootstrap.min.css">

	<!-- 可选的Bootstrap主题文件（一般不用引入） -->
	<link rel="stylesheet" href="/Public/css/bootstrap-theme.min.css">
	 <link href="/Public/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	 
	

	<style type="text/css"> 
		.container-fluid{padding-left: 0px;padding-right: 0px}
		#head {width:100%; padding-left: 0px;padding-right: 0px;margin-left: 0px;margin-right: 0px} 
		#head img{width:100%;}
		.appoint:link{color:red;}
	.appoint:visited{color:red;}
	.appoint:hover{color:red;}
	.appoint:active{color:red;}

	</style>
</head>
<body>
	  
			<div class="jumbotron" style="100%">
				<h2 align="center" style="margin-bottom:40px">Hello! 欢迎使用瑜伽约课系统</h2>
			</div> 


			<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo ($member['name']); ?>---<?php echo ($member['phone']); ?></h3>
			</div>
			<div class="panel-body">
				<div role="tabpanel"> 
					<ul id="myTab" class="nav nav-tabs nav-justified">  
					<?php if(empty($classes)): ?>今日没有课程<?php else: ?>  
								  <!-- Nav tabs -->
								  <ul class="nav nav-tabs" id="myTabs" role="tablist">
								  <?php if(is_array($classes)): $k = 0; $__LIST__ = $classes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$class): $mod = ($k % 2 );++$k;?><li role="presentation"  ><a href="#c<?php echo ($key); ?>" aria-controls="c<?php echo ($key); ?>" role="tab" data-toggle="tab"><?php echo ($key); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?> 
								  </ul><?php endif; ?>
					  <!-- Tab panes -->
					  <div class="tab-content">
							<?php if(is_array($classes)): $i = 0; $__LIST__ = $classes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$class): $mod = ($i % 2 );++$i;?><div role="tabpanel" class="tab-pane " id="c<?php echo ($key); ?>">
							  		 	
							  		 	<ul class="list-unstyled">
							  		 		<li>
							  		 				<table class="table table-condensed table-hover" border="0" cellspacing="0" cellpadding="0" >
							  		 				 <tr>
												 		<th   >时间</th>
												 		<th   >课程名</th> 
												 		<th  >教室</th>
												 		<th  >时长</th>
												 		<th >学分</th> 
												 		<th >老师</th> 
												 		<th >语言</th> 
												 		<th >难度</th> 
												 		<th >预约</th> 
										 		      </tr>


							  		 		<?php if(is_array($class)): $i = 0; $__LIST__ = $class;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><tr> 
													 			<td  ><?php echo (substr($c["start"],10,6)); ?></td>
													 			<td  class="classname_cn"><?php echo ($c["class"]["name"]); ?></td>  
													 			<td  ><?php echo ($c["room"]["name"]); ?></td>
													 			<td  ><?php echo ($c["class"]["time"]); ?>min</td>
													 			<td ><?php echo ($c["class"]["level"]); ?></td>

													 				<td ><?php echo ($c["class"]["teacher_name"]); ?></td>
													 					<td ><?php if($c['class']['lang'] == 'zh-chs'): ?>中文<?php else: ?>英文<?php endif; ?> </td>
													 						<td ><?php switch($c['class']['level']): case "1": ?>入门<?php break;?>
																	    <?php case "2": ?>容易<?php break;?>
																	     <?php case "3": ?>一般<?php break;?>
																	      <?php case "4": ?>困难<?php break;?>
																	    <?php default: ?>入门<?php endswitch;?></td>

			 													<td> <a href="#" onclick="appoint(<?php echo ($c["id"]); ?>)" ><?php if($c["is_appointed"] == 1): ?>取消预约     <?php else: ?> 预约<?php endif; ?>  </a></td>
												 		 
												 			</tr><?php endforeach; endif; else: echo "" ;endif; ?>



							  		 				</table>
							  		 		</li>

							  		 		
							  		 		<hr> 
							  		 	</ul>　

							  		 </div><?php endforeach; endif; else: echo "" ;endif; ?>  
					    
					    </div> 
				</div>
			</div>
	 

	<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
	<script src="/Public/js/jquery.min.js"></script>  
	<script src="/Public/js/bootbox.min.js"></script>
	<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
	<script src="/Public/js/bootstrap.min.js"></script>
	 
	 <script type="text/javascript"> 

	    var member_id = "<?php echo ($member_id); ?>";
			 function appoint(id)
			 {
			 	 bootbox.setDefaults("locale","zh_CN");  
			 	 bootbox.confirm("预约此课程?",function(result) {　
			         if(result)
			            {
			            	 
			            			window.location.href= "/index.php/Reception/Appoint/choosepos/member_id/"+member_id+  "/schedule_id/"+id;
			            	 
			            }　
			    })
			 }

			 $(function(){
			 	 $('#myTabs a:first').tab('show') ;

			 // 	 currentLang = navigator.language;  
				// if(!currentLang)  
			 //    currentLang = navigator.browserLanguage;  
				// currentLang=currentLang.toLowerCase();
				// if(currentLang=='zh-cn')
				// {
				// 	$(".classname_en").hide();
				// }
				// else
				// {
				// 	$(".classname_cn").hide();
				// }
			 });
 	</script>
 
</body>
</html>