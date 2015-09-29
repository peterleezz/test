$(function()
{
	$("#add_brand").click(function()
		{
			  var self = $('#editbrand form');
	        $.post(self.attr("action"), self.serialize(), function(data,textStatus){
	             if(data.status){	                    
	                    $('#editbrand').modal('hide');
	                    alert("添加成功！");
	                } else {
	                    alert(data.info);	                    
	                }
	        }, "json");
			
		});

		$("#add_user").click(function()
		{
			  var self = $('#edituser form');
	        $.post(self.attr("action"), self.serialize(), function(data,textStatus){
	             if(data.status){	                    
	                    $('#edituser').modal('hide');
	                    alert("添加成功！");
	                } else {
	                    alert(data.info);	                    
	                }
	        }, "json");
			
		}); 

		  $('#chooserole').change(function(){
		        if($(this).children('option:selected').val()=='default')$("#roles").hide();
		        else $("#roles").show();
		    });


	$(".navbar-nav>li").click(function(){
		$(this).addClass("active").siblings().removeClass("active");
	});

	   $('#editbrand').on('hidden.bs.modal', function (e) {
	   $('#editbrand .modal-title').text("添加品牌");
	   $('#add_brand').text("添加");
	   $('#editbrand [type=text]').val("");
	   $('#editbrand [type=password]').val("");
	   $('#brand_id').val(0);	
	   $('#username').attr("disabled",false);
	});
});

function delbrand(id,obj)
{
	$.post("/index.php/Admin/Brand/delbrand", {id:id}, function(data,textStatus){
	             if(data.status){          
	                    alert("删除成功！");
	                    $(obj).parents("tr").remove(); 
	                } else {
	                    alert(data.info);	                    
	                }
	        }, "json");
}

function deluser(id,obj)
{
	$.post("/index.php/Admin/User/del", {id:id}, function(data,textStatus){
	             if(data.status){          
	                    alert("删除成功！");
	                    $(obj).parents("tr").remove(); 
	                } else {
	                    alert(data.info);	                    
	                }
	        }, "json");
}


function editbrand(brand_id,obj)
{
	$('#editbrand .modal-title').text("修改品牌");
	$('#add_brand').text("保存");
	$('#brand_id').val(brand_id);	
	$('#brand_name').val($(obj).parents("tr").find("td:eq(1)").text().trim());
	$('#username').attr("disabled","disabled");
	$('#username').val($(obj).parents("tr").find("td:eq(2)").text().trim());
	$('#contact_name').val($(obj).parents("tr").find("td:eq(3)").text().trim());
	$('#email').val($(obj).parents("tr").find("td:eq(4)").text().trim());
	$('#phone').val($(obj).parents("tr").find("td:eq(5)").text().trim());
	$('#desc').val($(obj).parents("tr").find("td:eq(8)").text().trim());
	$('#editbrand').modal('show');	
}
