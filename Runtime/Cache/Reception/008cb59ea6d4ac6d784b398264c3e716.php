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
	  <link href="/Public/css/jquery.seat-charts.css" rel="stylesheet">
	

	<style type="text/css"> 
		.container-fluid{padding-left: 0px;padding-right: 0px}
		#head {width:100%; padding-left: 0px;padding-right: 0px;margin-left: 0px;margin-right: 0px} 
		#head img{width:100%;}
		 
	.seat-myorder{color:red;}
	.seat-appoint{color:grey;}
	.seat-empty{color:green;}

	</style>
</head>
<body>
	  
			<div class="jumbotron" style="100%">
				<h2 align="center" style="margin-bottom:40px">Hello! 欢迎使用瑜伽约课系统</h2>
			</div> 
 <div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">选择座位</h3>
			</div>
			<div class="panel-body">
				<div id="seat-map">
					 
					
				</div>
				<div class="pull-right">
						<button type="button" class="btn btn-primary" onclick="back()">返回</button>
			    <button type="button" class="btn btn-success" onclick="appoint()">确认预约</button>
			    <button type="button" class="btn btn-warning" onclick="candelappoint()">取消预约</button>
				</div>
			 	

				<input type="hidden" id="schedule_id" value="<?php echo ($schedule_id); ?>"/> 
				<input type="hidden" id="member_id" value="<?php echo ($member_id); ?>"/> 
				<input type="hidden" id="openid" value="<?php echo ($openid); ?>"/> 
			</div>
 </div>

	 

	<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
	<script src="/Public/js/jquery.min.js"></script>  
	<script src="/Public/js/bootbox.min.js"></script>
	<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
	<script src="/Public/js/bootstrap.min.js"></script>
	 <script src="/Public/js/jquery.seat-charts.js"></script>  
	 <script type="text/javascript"> 

	   function back()
	  {
	  	 history.go(-1);
	  }

	  var arr = '<?php echo ($arr); ?>';
	  var sc;
	  function appoint()
	  {
	  		var myorder = sc.find('selected');
	  		if(myorder.length==0)
	  		{
	  			bootbox.alert("请选选中位置！");
	  		}
	  		else
	  		{
	  			var x ;
	  			sc.find('selected').each(function(seatId) {
  					 x=this.settings.label; 　
				}); 
　				var schedule_id = $("#schedule_id").val(); 
				var member_id = $("#member_id").val(); 
				var openid = $("#openid").val(); 
				 $.ajax({
                  type:"post", 
                  url:"<?php echo U('Appoint/doappoint');?>",
                  dataType:"json",
                  data:{pos:x,schedule_id:schedule_id,member_id:member_id,open_id:openid},
                  success:function(data,textStatus){   
                      if(data.status){
                                 
                                   bootbox.alert(data.data );   
                                   
                              } else {
                                  bootbox.alert(data.data);             
                              }
                  },
                  error: function (jqXHR, textStatus, errorThrown) {
                       bootbox.alert("Error...",null);             
                  }
             	 });


	  		}
	  }


	   function candelappoint()
	  {
	  		　
　				var schedule_id = $("#schedule_id").val(); 
				var member_id = $("#member_id").val(); 
				var openid = $("#openid").val(); 
				 $.ajax({
                  type:"post", 
                  url:"<?php echo U('Appoint/cancelappoint');?>",
                  dataType:"json",
                  data:{schedule_id:schedule_id,member_id:member_id,open_id:openid},
                  success:function(data,textStatus){   
                      if(data.status){ 
                                   bootbox.alert(data.data );   
                                   
                              } else {
                                  bootbox.alert(data.info );             
                              }
                  },
                  error: function (jqXHR, textStatus, errorThrown) {
                       bootbox.alert("Error...",null);             
                  }
             	 });　
	  }


		 $(document).ready(function() {


		 		var firstSeatLabel = 1;
				 var pos =  $.parseJSON(arr);
				 sc = $('#seat-map').seatCharts({
			        map: pos,
			        seats: {
			            a: { 
			                classes : 'seat-myorder' //your custom CSS class
			            },

			             b: { 
			                classes : 'seat-appoint' //your custom CSS class
			            },
			 	 		 c: { 
			                classes : 'seat-empty' //your custom CSS class
			            }
			        },
			        naming : {
						top : false,
						getLabel : function (character, row, column) {
							return firstSeatLabel++;
						},
					},
			        click: function () {
			            if (this.status() == 'available') {
			                //do some stuff, i.e. add to the cart
			                sc.find('a.selected').status('available');
			                sc.find('b.selected').status('available');
			                return 'selected';
			            } else if (this.status() == 'selected') {
			                //seat has been vacated 
			                return 'available';
			            } else if (this.status() == 'unavailable') {
			                //seat has been already booked
			                return 'unavailable';
			            } else {
			                return this.style();
			            }
			        }
			    });

				sc.find('b').status('selected');
			    sc.find('c').status('unavailable');

			    $(".seatCharts-cell.seatCharts-space").each(function(){
			    	 $(this).text($(this).text()+"排");
			    });

     });
 	</script>
 
</body>
</html>