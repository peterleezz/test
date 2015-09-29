 $(function(){ 


$("#teacherregist").validate({
    rules:{
      email:{
        required:true,
        email:true
      },
    password:{
                        required:true,
                        rangelength:[6,12]
                    },
    confirm_password:{
                        equalTo:"#password"
                    }  ,
     username:{
        required:true,
        rangelength:[4,12]
     }
    },
    
     submitHandler:function(form){ 
       teacher_regist(form);   //提交表单   
        }    
  });

  function teacher_regist(form)
  {
    ajaxSubmitHandler(form,null);
  }

  $("#login_form").validate({
    rules:{
      username:"required",
    },
    messages:{
      username:"Please Input username",
    }

  });

  $("#forget_form").validate({
    rules:{
      email:"required",
    },
    messages:{
      email:"Please Input email",
    }

  });


  var verifyimg = $(".verifyimg").attr("src");
  $(".reloadverify").click(function(){
                if( verifyimg.indexOf('?')>0){
                    $(".verifyimg").attr("src", verifyimg+'&random='+Math.random());
                }else{
                    $(".verifyimg").attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
                }
            });
      if($.cookie('username')!=null)
        {
          $("#rememberpw").attr("checked","true");
          $("form").find("[name=username]").val($.cookie('username'));
        }else $("form").find("[name=username]").val('');
      if($.cookie('password')!=null)$("form").find("[name=password]").val($.cookie('password'));else $("form").find("[name=password]").val('');
       
       $("#login_form").submit(function(){ 
         var self = $(this);
        if($("#rememberpw").prop("checked")==true)
        {
            $.cookie('username', $(this).find("[name=username]").val());
            $.cookie('password', $(this).find("[name=password]").val());
        }       
        $.post(self.attr("action"), self.serialize(), function(data,textStatus){
             if(data.status){
                    window.location.href = data.url;
                } else {
                    alert(data.info);
                    $(".reloadverify").click();
                }
        }, "json");
        return false;

     });
}
);


function forget_password()
{
  var self =$("#forget_form");
    $.post(self.attr("action"), self.serialize(), function(data,textStatus){
              alert(data.info);
        }, "json");

}


function ajaxSubmitHandler(form,callback)
 {  
     var self = $(form); 
         $.ajax({
                  type:"post", 
                  url:self.attr("action"),
                  dataType:"json",
                  data:self.serialize(),
                  success:function(data,textStatus){   
                      if(data.status){
                                if(data.info!=null && data.info!='')
                                {
                                   $(".modal").modal("hide");
                                   bootbox.alert(data.info,function(){ 
                                    if(data.url!=null && data.url!='')
                                      window.location.href = data.url;
                                     if(callback!=null) callback();
                                   });   
                                   
                                } 
                                else
                                {
                                   if(data.url!=null && data.url!='')
                                      window.location.href = data.url;
                                     $(".modal").modal("hide");
                                      if(callback!=null) callback();
                                } 
                                         
                              } else {
                                  bootbox.alert(data.info,null);             
                              }
                  },
                  error: function (jqXHR, textStatus, errorThrown) {
                       bootbox.alert("Error...",null);             
                  }
              });
return false; 
 }