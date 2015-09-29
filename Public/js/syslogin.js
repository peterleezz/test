$(function(){
	//verify code click event
	var verifyimg = $(".verifyimg").attr("src");
	$(".reloadverify").click(function(){
                if( verifyimg.indexOf('?')>0){
                    $(".verifyimg").attr("src", verifyimg+'&random='+Math.random());
                }else{
                    $(".verifyimg").attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
                }
            });
	//ajax login
    $("#loginbtn").click(function(){
        $(this).hide();
        $("#refreshbtn").show();
        $.post('/Admin/login', self.serialize(), success, "json");

     });
	

       $("form").submit(function(){
         var self = $(this);
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