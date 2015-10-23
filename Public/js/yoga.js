
//check task every 1 second

// if(isReception);
//  task();

$(document).ajaxStart(function(){
    $("#wait_gif").show();
     var hidebg=document.getElementById("hidebg");
   hidebg.style.display="block";  //显示隐藏层
   hidebg.style.height=window.screen.height+"px";  //设置隐藏层的高度为当前页面高度
 
}).ajaxStop(function(){
 $("#wait_gif").hide();
  document.getElementById("hidebg").style.display="none";
});



var timer=null; 

 String.prototype.replaceAll = function(s1,s2){ 
  return this.replace(new RegExp(s1,"gm"),s2); 
} 
 function choosept()
{
  var pt_id = $("#pts").val();
  var task_id = $("#ptchoose_id").val();
  $.ajax({
                type:"post",
                async:false,
                url:"/Home/Task/setpt",
                data:{pt_id:pt_id,id:task_id},
                success:function(data,textStatus){    
                  if(data.status)
                  { 
                       $('#chooseptModel').modal("hide"); 
                  }
                  bootbox.alert(data.info);  
                }

              });
}

 function printpt(id)
{ 
  $.ajax({
                type:"post",
                async:false,
                url:"/Home/Task/printpt",
                data:{id:id},
                success:function(data,textStatus){    
                  if(!data.status)
                  { 
                       bootbox.alert(data.info);  
                  } 
                }

              });
}


function task()
{ 
  $.getJSON("/Home/Task/checkTask", function(data) {  
        if(data.cmd!=null)
        {
          clearTimeout(timer);
          if(data.cmd=='choosept')
          {
            var pts=getPts();
            var selOpt = $("#pts option");   
             selOpt.remove();  
             for(var i=0;i<pts.length;i++)
             {
                var pt = pts[i];
                 $("#pts").append("<option value='"+pt.id+"'>"+pt.name_cn+"</option>");  
             }
             if(data.member==null || data.class==null) return;
            $('#ptchoose_name').val(data.member.name);
            $('#ptchoose_gender').val(data.member.sex=='female'?"女":"男" );
            $('#ptchoose_card').val(data.class.card_number);
            $('#ptchoose_avatar').val(data.member.avatar);
            $("#ptchoose_id").val(data.class.id);
             $('#chooseptModel').modal("show");
             $('#chooseptModel').on('hidden.bs.modal', function (e) {
                  timer=setTimeout(task,1000); 
             })
          }
          else if(data.cmd=='printpt')
          {
            clearTimeout(timer);
             bootbox.confirm("打印会员 "+data.member.name+" 消课小票?",function(result) {
              printpt(data.task.id)
                if(result)
                {
                    window.open("/Reception/Pt/consumeprint/id/"+data.class.contract_id,'newwindow');
                }
                timer=setTimeout(task,1000); 
             } )
           }




         }
    });  
 timer=setTimeout(task,1000); 
}
 

function getGroups()
{
  var groups=new Array();;
  if(groups.length>0) return pts; 
  $.ajax({
    type:"post",
    async:false,
    url:"/Api/index/getGroups",
    success:function(data,textStatus){   
                      
               if(data.status && data.data!=null){              
                  var obj=data.data;               
                 for(var i=0;i<obj.length;i++)
                  { 
                     groups.push(obj[i]);
                  }       
                }            
    }

  });

return groups;   
}




var pts=new Array();;
function getPts()
{
  if(pts.length>0) return pts; 
  $.ajax({
    type:"post",
    async:false,
    url:"/Api/index/getPts",
    success:function(data,textStatus){   
                      
               if(data.status){              
                  var obj=data.data;               
                 for(var i=0;i<obj.length;i++)
                  { 
                     pts.push(obj[i]);
                  }       
                }            
    }

  });

return pts;   
}


function addCellAttr(rowId, val, rawObject, cm, rdata) { 
  try{
   if(val && val.indexOf("[")>0 && val.indexOf("]")>0)
        return "style='color:red'";
  }
  catch(error)
  {
    // return "style='color:blue'";
  }
}



var lasdetailtid="";

function getRandColorValue(){
    var str = Math.ceil(Math.random()*16777215).toString(16);
    while(str.length < 6){
         str = '0' + str;
    }
    return str;
}
var recharge_value=0;
function changerecharge(recharge)
{ 
  recharge_value=recharge;
  $("#recharge").text("余额（￥"+recharge+"）");
}


Date.prototype.format = function(format){ 
    var o = { 
    "M+" : this.getMonth()+1, //month 
    "d+" : this.getDate(), //day 
    "h+" : this.getHours(), //hour 
    "m+" : this.getMinutes(), //minute 
    "s+" : this.getSeconds(), //second 
    "q+" : Math.floor((this.getMonth()+3)/3), //quarter 
    "S" : this.getMilliseconds() //millisecond 
    } 

    if(/(y+)/.test(format)) { 
    format = format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length)); 
    } 

    for(var k in o) { 
    if(new RegExp("("+ k +")").test(format)) { 
    format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length)); 
    } 
    } 
    return format; 
} 
 

function isNumber(str)
{
    return (typeof obj=='number')&&obj.constructor==Number; 
}

function isString(str)
{
    return (typeof str=='string')&&str.constructor==String; 
}

function isArray(obj){ 
    return (typeof obj=='object')&&obj.constructor==Array; 
} 

function padLeft(str, lenght) {
    str=str.toString();
            if (str.length >= lenght)
                return str;
            else
                return padLeft("0" + str, lenght);
        }


function getValue(arr,str)
{
    for(var i=0;i<arr.length;i++)
    {
        if(arr[i]==str) return str;
    }
 return arr[str];    
}

var searchclubs="";
function getSearchClubs()
{
  if(searchclubs!="") return searchclubs; 
  $.ajax({
    type:"post",
    async:false,
    url:"/Api/index/getClubs",
    success:function(data,textStatus){   
                      
               if(data.status){              
                  var obj=data.data;
                  if(obj!=null)               
                 for(var i=0;i<obj.length;i++)
                  {
                      if(i!=0)
                      {
                          searchclubs+=";";
                      }
                      searchclubs+=obj[i]['id']+":"+obj[i]['club_name'];
                  }       
                }            
    }

  });

return searchclubs;   
}


var channels="";
function getChannel()
{
  if(channels!="") return channels; 
  $.ajax({
    type:"post",
    async:false,
    url:"/Api/index/getChannel",
    success:function(data,textStatus){   
                      
               if(data.status){              
                  var obj=data.data;   
                   if(obj!=null)                   
                 for(var i=0;i<obj.length;i++)
                  {
                      if(i!=0)
                      {
                          channels+=";";
                      }
                      channels+=obj[i]['id']+":"+obj[i]['name'];
                  }       
                }            
    }

  });

return channels;   
}


var userchannels="";
var userchannelsobj=null;
function getUserChannelObj()
{
  if(userchannelsobj!=null) return userchannelsobj;
  getUserChannel();
  return userchannelsobj;
}
function getUserChannel()
{
  if(userchannels!="") return userchannels; 
  $.ajax({
    type:"post",
    async:false,
    url:"/Api/index/getUserChannel",
    success:function(data,textStatus){   
                      
               if(data.status){              
                  var obj=data.data;    
                  userchannelsobj=obj;           
                 for(var i=0;i<obj.length;i++)
                  {
                      if(i!=0)
                      {
                          userchannels+=";";
                      }
                      userchannels+=obj[i]['id']+":"+obj[i]['name'];
                  }       
                }            
    }

  });

return userchannels;   
}




var card_types="";
function getCardTyps()
{
  if(card_types!="") return card_types; 
  $.ajax({
    type:"post",
    async:false,
    url:"/Api/index/getCardType",
    success:function(data,textStatus){   
                      
               if(data.status){              
                  var obj=data.data;      
                  if(obj==null) return "";         
                 for(var i=0;i<obj.length;i++)
                  {
                      if(i!=0)
                      {
                          card_types+=";";
                      }
                      card_types+=obj[i]['id']+":"+obj[i]['name'];
                  }       
                }            
    }

  });
return card_types;   
}

var mcs="";
function getMcs()
{
  if(mcs!="") return mcs; 
  $.ajax({
    type:"post",
    async:false,
    url:"/Api/index/getMcs",
    success:function(data,textStatus){   
                      
               if(data.status){              
                  var obj=data.data;      
                  if(obj==null) return "";         
                 for(var i=0;i<obj.length;i++)
                  {
                      if(i!=0)
                      {
                          mcs+=";";
                      }
                      mcs+=obj[i]['id']+":"+obj[i]['name_cn'];
                  }       
                }            
    }

  });
return mcs;   
}





var channel_users="";
function getChannelUsers()
{
  if(channel_users!="") return channel_users; 
  $.ajax({
    type:"post",
    async:false,
    url:"/Api/index/getChannelUsers",
    success:function(data,textStatus){   
                      
               if(data.status){              
                  var obj=data.data;    
                  if(obj==null) return "";           
                 for(var i=0;i<obj.length;i++)
                  {
                      if(i!=0)
                      {
                          channel_users+=";";
                      }
                      channel_users+=obj[i]['id']+":"+obj[i]['name_cn'];
                  }       
                }            
    }

  });
return channel_users;   
}

function review_pass(ids,result,note)
{ 
   $.post('/Brand/Review/pass',{ids:ids,result:result,note:note}, function(data,textStatus){
             if(data.status){
              if(isString(ids))
                var id=ids.split(",");
              else
                var id=new Array(ids+"");
              for(var i=0;i<id.length;i++)
              {
                 $("#conract_review_grid").jqGrid('setRowData',id[i],{status:result});
                $("#conract_review_grid").jqGrid('setRowData',id[i],{note:note});
              }  
                } else {
                     bootbox.alert(data.info,null);              
                }
    }, "json");
}

function change_password()
{
   var self = $("#change_password_form");
  $.post(self.attr("action"), self.serialize(), function(data,textStatus){
             if(data.status){
              $("#chpasswdModel").modal("hide");
                    bootbox.alert(data.info,null);  
                     window.location.href =data.url;
                } else {
                     bootbox.alert(data.info,null);               
                }
        }, "json");
}

function review_unpass_all()
{ 
   var selectedIds = $("#conract_review_grid").jqGrid("getGridParam", "selarrrow");
   var ids="";
   for(var i=0;i<selectedIds.length;i++)
   {
      if(i!=0) ids=ids+",";
        ids+=selectedIds[i];
   }
   review_pass(ids,2,$("#note").val());
}

function review_pass_all()
{ 
   var selectedIds = $("#conract_review_grid").jqGrid("getGridParam", "selarrrow");
   var ids="";
   for(var i=0;i<selectedIds.length;i++)
   {
      if(i!=0) ids=ids+",";
        ids+=selectedIds[i];
   }
   review_pass(ids,1,$("#note").val());
}

function lost(id)
{ 
   $.post('/Reception/Cardmanage/lost',{id:id}, function(data,textStatus){
             if(data.status){
              $("#reception_card_grid").jqGrid('setRowData',id,{status:"1"});
                    bootbox.alert(data.info,null); 
                } else {
                     bootbox.alert(data.info,null);              
                }
    }, "json");
}
function unlost(id)
{
    $.post('/Reception/Cardmanage/unlost',{id:id}, function(data,textStatus){
             if(data.status){
              $("#reception_card_grid").jqGrid('setRowData',id,{status:"0"});
                    bootbox.alert(data.info,null); 
                } else {
                     bootbox.alert(data.info,null);                   
                }
    }, "json");
}

function getnew()
{
   var id=$("#reception_card_grid").jqGrid('getGridParam','selrow');
  var rowData = jQuery(grid_selector).jqGrid("getRowData",id); 
   $.post('/Reception/Cardmanage/getnew',{id:rowData.cid,"card_number":$("#new_card_number").val()}, function(data,textStatus){
             if(data.status){
               $("#reception_card_grid").jqGrid('setRowData',id,{card_number:data.new_card_number});
                  $('#newCardModal').modal('hide');    
                    bootbox.alert(data.info,function(){
                    //    $("body").append('<a id="open" target="_blank" href="'+data.url+'" > </a>');
                    // document.getElementById("open").click();
                    }); 
                   
                   // window.open(data.url,"newwindow");
                } else {
                     bootbox.alert(data.info,null);                   
                }
    }, "json");
}

 
function rest()
{ 
  var id=$("#reception_card_grid").jqGrid('getGridParam','selrow');
  $.post('/Reception/Cardmanage/rest',{id:id,start_date:$("#rest_start_time").val(),end_date:$("#rest_end_time").val()}, function(data,textStatus){
             if(data.status){
                     
                     if(new Date().format('yyyy-MM-dd') >= $("#rest_start_time").val()) 
                          $("#reception_card_grid").jqGrid('setRowData',id,{status:"3"}); 
                     $('#restModel').modal('hide');    
                      bootbox.alert(data.info,function(){
                        if(data.url!=null)
                      {
                        window.location.href =data.url;
                      }
                      }); 

                } else {
                    bootbox.alert(data.info,null);                
                }
    }, "json");
}

function unrest(id)
{
  $.post('/Reception/Cardmanage/unrest',{id:id}, function(data,textStatus){
             if(data.status){
                   $("#reception_card_grid").jqGrid('setRowData',id,{status:"0"});
                      
                      bootbox.alert(data.info,null); 
                } else {
                    bootbox.alert(data.info,null);               
                }
    }, "json");
}

function pay_back(id)
{
  $.post('/Cashier/Contract/applyPayback',{id:id}, function(data,textStatus){
             if(data.status){
               // $("#cashier_contract_grid").jqGrid('setRowData',id,{status:"4"});
                    bootbox.alert(data.info,null); 
                } else {
                    bootbox.alert(data.info,null);            
                }
    }, "json");
}

function destroy(id)
{
  $.post('/Reception/Cardmanage/destroy',{id:id}, function(data,textStatus){
             if(data.status){
               $("#reception_card_grid").jqGrid('setRowData',id,{status:"4"});
                    bootbox.alert("退会成功!",null); 
                } else {
                    bootbox.alert(data.info,null);            
                }
    }, "json");
}

function destroy_card(id)
{
   bootbox.prompt("退卡金额?", function(result) {   
    if(result)
  $.post('/Reception/Cardmanage/destroycard',{id:id,should_pay:result}, function(data,textStatus){
             if(data.status){
               $("#reception_card_grid").jqGrid('setRowData',id,{status:"4"});
                   window.location.href =data.url;
                } else {
                    bootbox.alert(data.info,null);            
                }
    }, "json");
   });

  
}

function editpeak()
{
    //cal time
    var times = [];
     $(".peaktime").each(function(){
        var week=($(this).find(".week").val());
        var start_time=($(this).find(".start_time").val());
        var end_time=($(this).find(".end_time").val());
        var arr = {"week":week,"start_time":start_time,"end_time":end_time};
        times.push(arr);
    });
    $.post($("#editPeakForm").attr("action"), {id:$("#peakid").val(),times:times,peak_name:$("#form-field-1").val(),club_id:$("#form-field-2").val()}, function(data,textStatus){                         
                      
               if(data.status){
                    window.location.href = data.url;
                } else {
                    bootbox.alert(data.info,null);               
                }            
    }, "json");
}

function editroom()
{
    //cal time
    var name=$("#name").val();
    if(name==""){ bootbox.alert("请输入教室名");return false;}
    var arr = [];  
    var rows=0;
    var num=0;
     $(".addroom").each(function(){
       rows++;
        var roomrownum=($(this).find(".roomrownum").val());  
        if(roomrownum=='' || isNaN(roomrownum) )
        {
            bootbox.alert("第"+rows+"行的"+roomrownum+"不是一个整数");return false;
        }
        arr.push(parseInt(roomrownum));
        num+=parseInt(roomrownum);
    });
     var b = JSON.stringify(arr); 
    $.post($("#editRoomForm").attr("action"), {id:$("#id").val(),rows:rows,name:$("#name").val(),num:num,extension:b}, function(data,textStatus){  
               if(data.status){
                    window.location.href = data.url;
                } else {
                    bootbox.alert(data.info,null);               
                }            
    }, "json");
}


function initdatatable(){
    var table= {
                    "bLengthChange":false,
                    "bStateSave":true,//save status ,even refresh!
                     "oLanguage": {
                    "sProcessing": "正在加载中......",
                    "sLengthMenu": "每页显示 _MENU_ 条记录",
                    "sZeroRecords": "对不起，查询不到相关数据！",
                    "sEmptyTable": "表中无数据存在！",
                    "sInfo": "当前显示 _START_ 到 _END_ 条，共 _TOTAL_ 条记录",
                    "sInfoFiltered": "数据表中共为 _MAX_ 条记录",
                    "sSearch": "搜索",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "上一页",
                        "sNext": "下一页",
                        "sLast": "末页"
                    }
                }};
                return table;
}
$(document).on("click", ".addpeaktime", function() {
      var html = '<div class="form-group peaktime">'+$(".peaktime").html()+'</div>' ;      
      $(".peaktime:last").after(html);
      $(".peaklabel:gt(0)").text("");
      $(".delpeaktime:gt(0)").show();
});



$(document).on("click", ".addroombtn", function() {
      var html = '<div class="form-group addroom">'+$(".addroom").html()+'</div>' ;     
      var count = $(".addroom").size();
       count++; 
      $(".addroom:last").after(html); 
      $(".addroomlabel:gt(0)").text("");
      $(".delroombtn:gt(0)").show();

      var $roomslabel = $(".rowlabel");
      for(var i=0,len=$roomslabel.length;i<len;i++)
      {
        $($roomslabel[i]).text('第'+(i+1)+'排'); 
      } 
});
$(document).on("click", ".delroombtn", function(event) {
      $(this).parents(".addroom").remove();
        var $roomslabel = $(".rowlabel");
      for(var i=0,len=$roomslabel.length;i<len;i++)
      {
        $($roomslabel[i]).text('第'+(i+1)+'排'); 
      }
});



$(document).on("dblclick", "#member_info tbody tr td", function() { 
     $(this).parent().find(":radio").trigger("click");

});

$(document).on("dblclick", "#member_info_goods tbody tr td", function() { 
     $(this).parent().find(":radio").trigger("click");

});

 
function transform()
{
  var ele=$("#member_info tbody :radio:checked");           
  if(ele.length==0) 
   {
      bootbox.alert("请先选中需要转入的会员",null);
      return;
   }  
   bootbox.confirm("确定需要转入吗？",function(result) {
          if(result)
          {
             var id = (ele.val());
             var contract_id=$("#contract_id").val();
             var owner_id=$("#user_id").val();  
             var cash=$("#cash").val();  
             var pos=$("#pos").val();  
             var check=$("#check").val();  
             var check_num=$("#check_num").val();  
             var network=$("#network").val();  
             var netbank=$("#netbank").val();  
             var description=$("#description").val();  

             var should_pay=$("#should_pay").val();  
             var contract_number=$("#contract_number").val();  
             if(owner_id==id)
             {
                bootbox.alert("转出会员与转入会员是同一个！请重新选择!");
                return ;
             }
             var new_card_number=ele.parent().parent().find("td").eq(5).html();
             if( new_card_number== '无会员卡')
             {
                    bootbox.prompt("该转出客户无可用会员卡，请分配一个会员卡号，否则系统会自动生成！", function(result) {                
                    if (result === null) {                                             
                        new_card_number="";                        
                    } else {
                      new_card_number=result;                          
                    }
                     $.post("/Cashier/Contract/doTransform", {should_pay:should_pay,contract_number:contract_number, network:network,netbank:netbank,cash:cash,pos:pos,check:check,check_num:check_num,description:description,owner_id:owner_id,contract_id:contract_id,new_id:id,new_card_number:new_card_number}, function(data,textStatus){                         
                            bootbox.alert(data.info);
                             if(data.status){
                                window.location.href = data.url;
                            } 
                                   
                    }, "json");
                  });
             }
             else
             {
                $.post("/Cashier/Contract/doTransform", {should_pay:should_pay,contract_number:contract_number,network:network,netbank:netbank,cash:cash,pos:pos,check:check,check_num:check_num,description:description,owner_id:owner_id,contract_id:contract_id,new_id:id,new_card_number:new_card_number}, function(data,textStatus){                         
                            bootbox.alert(data.info);
                             if(data.status){
                                window.location.href = data.url;
                            } 
                                   
                    }, "json");
             }

            
          }
    }); 
}

function pt_transform()
{
  var ele=$("#member_info tbody :radio:checked");           
  if(ele.length==0) 
   {
      bootbox.alert("请先选中需要转入的会员",null);
      return;
   }  
   bootbox.confirm("确定需要转入吗？",function(result) {
          if(result)
          {
             var id = (ele.val());
             var contract_id=$("#contract_id").val();
             var owner_id=$("#user_id").val(); 
             if(owner_id==id)
             {
                bootbox.alert("转出会员与转入会员是同一个！请重新选择!");
                return ;
             }
              
                $.post("/Cashier/Ptcontract/doTransform", {contract_id:contract_id,new_id:id}, function(data,textStatus){                         
                            bootbox.alert(data.info);
                             if(data.status){
                                window.location.href = data.url;
                            } 
                                   
                    }, "json");
            
            
          }
    }); 
}


$(document).on("click", ".delpeaktime", function(event) {
      $(this).parents(".peaktime").remove();
});

function getClubs()
{
    var options="";
     if(clubs!=null)       
    for(var i=0;i<clubs.length;i++)
    {
        if(i!=0)
        {
            options+=";";
        }
        options+=clubs[i]['id']+":"+clubs[i]['club_name'];
    }
    return options;
}


var peaktime="";
function getPeaktime()
{
  if(peaktime!="") return peaktime; 
  $.ajax({
    type:"post",
    async:false,
    url:"/Api/index/getPeaktime",
    success:function(data,textStatus){   
                      
               if(data.status){              
                  var obj=data.data;               
                 for(var i=0;i<obj.length;i++)
                  {
                      if(i!=0)
                      {
                          peaktime+=";";
                      }
                      peaktime+=obj[i]['id']+":"+obj[i]['peak_name'];
                  }       
                }            
    }

  });

return peaktime;   
}

function getClub(id)
{ 
    if(clubs!=null)
    for(var i=0;i<clubs.length;i++)
    {
         if(clubs[i]['id']==id)return clubs[i]['club_name'];
    }
    return id;
}

function add_mc_plan()
{
  var self = $("#addmcplanform");
  $.post(self.attr("action"), self.serialize(), function(data,textStatus){
             if(data.status){
               bootbox.alert(data.info,null); 
                    $(".addMcPlan").modal("hide");
                } else {
                     bootbox.alert(data.info,null);               
                }
        }, "json");

}

function add_mc_plan_one()
{
  var self = $("#addonemcpanform");
  $.post(self.attr("action"), self.serialize(), function(data,textStatus){
             if(data.status){
                    bootbox.alert(data.info,null); 
                    $(".addMcPlan").modal("hide");
                } else {
                     bootbox.alert(data.info,null);                 
                }
        }, "json");
}

function add_channel_plan()
{
  var self = $("#addplanform");
  $.post(self.attr("action"), self.serialize(), function(data,textStatus){
             if(data.status){
                    bootbox.alert(data.info,null); 
                    $(".addChannelPlan").modal("hide");
                } else {
                     bootbox.alert(data.info,null);                 
                }
        }, "json");

}


function add_channel_plan_one()
{
  var self = $("#addplanformone");
  $.post(self.attr("action"), self.serialize(), function(data,textStatus){
             if(data.status){
                    bootbox.alert(data.info,null); 
                    $(".addChannelPlan").modal("hide");
                } else {
                    bootbox.alert(data.info,null);                 
                }
        }, "json");

}

function buildAjaxQuery(form)
{

         var rules="";
        form.find(":input").each(function(i){
            var searchField=$(this).attr("name");
            var searchOper=$(this).attr("oper");
            var searchString=$(this).val();
            if(searchField && searchOper && searchString) {  
                rules += ',{"field":"' + searchField + '","op":"' + searchOper + '","data":"' + searchString + '"}';  
            }  
         }); 
         if(rules) {  
            rules = rules.substring(1);  
         }  
         var filtersStr = '{"groupOp":"AND","rules":[' + rules + ']}';  
         return filtersStr;
}
$(function(){   


$("#addPtClassPublicForm").validate({
    rules:{ 
     name:{
        required:true,
        rangelength:[2,12]
     },
     time:{
         required:true,
          number:true,  
          min:10,
     }
    },
    
     submitHandler:function(form){   
        var html=ue.getContent(); 
      
        $("#desc").val(html); 
        form.submit();
      }    
  });


 

$("#shopkeeper_room").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#shopkeeper_room_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#shopkeeper_room_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });


 $("#pt_class_public").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#pt_class_public_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#pt_class_public_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });


 

 $("#query_check_consume_form").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#consume_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#consume_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });

  $("#query_review_contract_form").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#conract_review_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#conract_review_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });


 $("#query_salelist_form").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#sale_list_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#sale_list_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });

  $("#mcmanager_query_followup").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#mcmanager_followup_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#mcmanager_followup_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });


  $("#mcmanager_query_servicelist").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#mcmanager_servicelist_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#mcmanager_servicelist_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });
 

 $("#query_recharge_form").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#recharge_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#recharge_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });

$("#cashier_ptcontract_form").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#cashier_ptcontract_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#cashier_ptcontract_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });

$("#pt_ptcontract_form").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#cashier_ptcontract_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#cashier_ptcontract_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });
$("#reception_ptcontract_form").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#reception_ptcontract_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#reception_ptcontract_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });





  $("#cashier_contract_form").submit(function(){   
         var self = $(this);     
         var rules="";
         $(this).find(":input").each(function(i){
            var searchField=$(this).attr("name");
            var searchOper=$(this).attr("oper");
            var searchString=$(this).val();
            if(searchField && searchOper && searchString) {  
                rules += ',{"field":"' + searchField + '","op":"' + searchOper + '","data":"' + searchString + '"}';  
            }  
         }); 
         if(rules) {  
            rules = rules.substring(1);  
         }  
         var filtersStr = '{"groupOp":"AND","rules":[' + rules + ']}';  
         var postData = $("#cashier_contract_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#cashier_contract_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });


  $("#reception_card_manage_form").submit(function(){   
         var self = $(this);    
         //contact the query string
         var rules="";
         $(this).find(":input").each(function(i){
            var searchField=$(this).attr("name");
            var searchOper=$(this).attr("oper");
            var searchString=$(this).val();
            if(searchField && searchOper && searchString) { //(5)如果三者皆有值且长度大于0，则将查询条件加入rules字符串  
                rules += ',{"field":"' + searchField + '","op":"' + searchOper + '","data":"' + searchString + '"}';  
            }  
         }); 
         if(rules) { //(6)如果rules不为空，且长度大于0，则去掉开头的逗号  
            rules = rules.substring(1);  
         }  
         var filtersStr = '{"groupOp":"AND","rules":[' + rules + ']}';  
         var postData = $("#reception_card_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  

        $("#reception_card_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    //(9)将jqGrid的search选项设为true  
          }).trigger("reloadGrid", [{page:1}]);   //(10)重新载入Grid表格  
      
         // jQuery("#reception_card_grid").jqGrid('setGridParam',{datatype:'json',postData:self.serialize(),url:self.attr("action"),page:2}).trigger("reloadGrid");
       
        return false;

     });


    // var oTable1 = $('#clubs_table').dataTable( {
    //             "aoColumns": [
    //               { "bSortable": false },
    //               null, null,null, null, null,null,
    //               { "bSortable": false }
    //             ] } );
    $(':file').ace_file_input({
          style:'well',
          btn_choose:'选择照片',
          btn_change:null,
          no_icon:'icon-picture',
          thumbnail:'large',
          // droppable:true,
          before_change: function(files, dropped) {
            var file = files[0];
            if(typeof file === "string") {
              if(! (/\.(jpe?g|png|gif)$/i).test(file) )
              {
                alert("请选择jpg|png|gif 格式的图片!");
                return false;
              } 
            }
            else {
              var type = $.trim(file.type);
              if( ( type.length > 0 && ! (/^image\/(jpe?g|png|gif)$/i).test(type) )
                  || ( type.length == 0 && ! (/\.(jpe?g|png|gif)$/i).test(file.name) ) 
                  ) 
                {
                    alert("请选择jpg|png|gif 格式的图片!");
                    return false;
                }
      
              if( file.size > 10240000 ) { 
                alert("照片大小请小于10M！");
                return false;
              }
            }
      
            return true;
          }
        });

      datePick = function(elem)
                {
                    jQuery(elem).datetimepicker({
                    format: 'yyyy-mm-dd',
                    minView:'2',
                    startView:'32',
                    language:'zh-CN',
                    autoclose:true,
                  });
                }


 $(".date_y").datetimepicker({
      format: 'yyyy',
      minView:'4',
      // startView:'3',
      language:'zh-CN',
      autoclose:true,
    });



 $(".date_ym").datetimepicker({
      format: 'yyyy-mm',
      minView:'3',
      startView:'3',
      language:'zh-CN',
      autoclose:true,
    });

 $(".date_ymd").datetimepicker({
      format: 'yyyy-mm-dd',
      minView:'2',
      startView:'2',
      language:'zh-CN',
      autoclose:true,
    });
$(".date_ymdhis").datetimepicker({     
      format: 'yyyy-mm-dd HH:ii:ss',  
      language:'zh-CN',
      autoclose:true,
    });


$(".date_ymdhi").datetimepicker({     
      format: 'yyyy-mm-dd HH:ii',  
      language:'zh-CN',
      autoclose:true,
    });




$( ".datepicker" ).datepicker({
                 format: 'yyyy-mm-dd',
                 language: 'zh-CN'
                });

  $('.datetimepicker_ymd').datetimepicker({
      language: 'zh-CN',
      format: 'yyyy-MM-dd', autoclose:true,
      pick12HourFormat: false,
      //  maskInput: true,           // disables the text input mask
      // pickDate: true,            // disables the date picker
      pickTime: false,            // disables de time picker
      // pick12HourFormat: false,   // enables the 12-hour format time picker
      // pickSeconds: true,         // disables seconds in the time picker
      // startDate: -Infinity,      // set a minimum date
      // endDate: Infinity          // set a maximum date

    });



$(".delpeaktime:eq(0)").hide();
$(".delroombtn:eq(0)").hide();
$('#peak_table').dataTable(new initdatatable());
$("#peak_table_wrapper .row:first .col-sm-6:first").append("<a href='/Brand/Shop/showEditPeak' class='btn btn-info btn-sm' 'role='button'><i class='icon-plus-sign'></i>增加时段</a>");
$('#clubs_table').dataTable( new initdatatable());
$("#clubs_table_wrapper .row:first .col-sm-6:first").append("<a href='/Brand/Shop/showAdd' class='btn btn-info btn-sm' 'role='button'><i class='icon-plus-sign'></i>增加会所</a>");
var dt_style=new initdatatable();
dt_style.bLengthChange=true;
 $('#delay_table').dataTable(dt_style);    

$("#form_add_delay").submit(function(){   
  var self = $(this); 
        $.post(self.attr("action"), self.serialize(), function(data,textStatus){
             if(data.status){
                    var delay=data.data;
                    var html='<tr><td>'+delay.club.club_name+'</td>  <td>'+delay.delay_day+'</td>    <td>'+delay.reason+'</td>   <td>'+delay.create_time+'</td>   </tr>';

                    $("#delay_table tbody tr:first").before(html);
                      
                } else {
                    bootbox.alert(data.info,null);            
                }
        }, "json");
        return false;
});
 
 $("#query_mc_plan_new").submit(function(){   
         var self = $(this); 
        $.post(self.attr("action"), self.serialize(), function(data,textStatus){
             if(data.status){
                     $(".newtable tr:not(:first)").remove();
                     var sts=data.statistics;
                     if(sts==null) 
                      {
                        bootbox.alert("无此时间段的计划，请先添加计划！",null);
                        return;
                      } 
                      if(sts.newplan==null)
                        html= '<tr class="warning"><td>本月计划</td><td colspan="10">无</td></tr>';
                      else
                      html = '<tr class="warning"><td>本月计划</td><td>'+sts.newplan.protential+'</td><td>'+sts.newplan.invit+'</td><td>'+sts.newplan.invit_success+'</td><td>'+sts.newplan.invit_come+'</td><td>'+sts.newplan.a_member+'</td><td>'+sts.newplan.b_member+'</td><td>'+sts.newplan.pre_sale+'</td><td>'+sts.newplan.sale+'</td><td>'+sts.newplan.deal_num+'</td><td>'+sts.newplan.transform+'</td></tr>';
                       $(".newtable").append(html);

                       html = '<tr class="success"><td>实际完成</td><td>'+sts.newstat.protential+'</td><td>'+sts.newstat.invit+'</td><td>'+sts.newstat.invit_success+'</td><td>'+sts.newstat.invit_come+'</td><td>'+sts.newstat.a_member+'</td><td>'+sts.newstat.b_member+'</td><td>'+sts.newstat.pre_sale+'</td><td>'+sts.newstat.sale+'</td><td>'+sts.newstat.deal_num+'</td><td>'+sts.newstat.transform+'</td></tr>';
                     
                      $(".newtable").append(html);
                       if(sts.newplan!=null)
                       {
                         html = '<tr class="danger"><td>完成率</td><td>'+(sts.newstat.protential*100/sts.newplan.protential).toFixed(2)+'%</td><td>'+(sts.newstat.invit*100/sts.newplan.invit).toFixed(2)+'%</td><td>'+(sts.newstat.invit_success*100/sts.newplan.invit_success).toFixed(2)+'%</td><td>'+(sts.newstat.invit_come*100/sts.newplan.invit_come).toFixed(2)+'%</td><td>'+(sts.newstat.a_member*100/sts.newplan.a_member).toFixed(2)+'%</td><td>'+(sts.newstat.b_member*100/sts.newplan.b_member).toFixed(2)+'%</td><td>'+(sts.newstat.pre_sale*100/sts.newplan.pre_sale).toFixed(2)+'%</td><td>'+(sts.newstat.sale*100/sts.newplan.sale).toFixed(2)+'%</td><td>'+(sts.newstat.deal_num*100/sts.newplan.deal_num).toFixed(2)+'%</td><td>'+(sts.newstat.transform*100/sts.newplan.transform).toFixed(2)+'%</td></tr>';
                       
                        $(".newtable").append(html);
                      }

                     $(".oldtable tr:not(:first)").remove(); 
                      if(sts.oldplan==null)
                        html= '<tr class="warning"><td>本月计划</td><td colspan="9">无</td></tr>';
                      else
                      html = '<tr class="warning"><td>本月计划</td><td>'+sts.oldplan.invit+'</td><td>'+sts.oldplan.invit_success+'</td><td>'+sts.oldplan.invit_come+'</td><td>'+sts.oldplan.a_member+'</td><td>'+sts.oldplan.b_member+'</td><td>'+sts.oldplan.pre_sale+'</td><td>'+sts.oldplan.sale+'</td><td>'+sts.oldplan.deal_num+'</td><td>'+sts.oldplan.transform+'</td></tr>';
                       $(".oldtable").append(html);
                       html = '<tr class="success"><td>实际完成</td><td>'+sts.oldstat.invit+'</td><td>'+sts.oldstat.invit_success+'</td><td>'+sts.oldstat.invit_come+'</td><td>'+sts.oldstat.a_member+'</td><td>'+sts.oldstat.b_member+'</td><td>'+sts.oldstat.pre_sale+'</td><td>'+sts.oldstat.sale+'</td><td>'+sts.oldstat.deal_num+'</td><td>'+sts.oldstat.transform+'</td></tr>';
                     
                      $(".oldtable").append(html);
                       if(sts.oldplan!=null){
                         html = '<tr class="danger"><td>完成率</td><td>'+(sts.oldstat.invit*100/sts.oldplan.invit).toFixed(2)+'%</td><td>'+(sts.oldstat.invit_success*100/sts.oldplan.invit_success).toFixed(2)+'%</td><td>'+(sts.oldstat.invit_come*100/sts.oldplan.invit_come).toFixed(2)+'%</td><td>'+(sts.oldstat.a_member*100/sts.oldplan.a_member).toFixed(2)+'%</td><td>'+(sts.oldstat.b_member*100/sts.oldplan.b_member).toFixed(2)+'%</td><td>'+(sts.oldstat.pre_sale*100/sts.oldplan.pre_sale).toFixed(2)+'%</td><td>'+(sts.oldstat.sale*100/sts.oldplan.sale).toFixed(2)+'%</td><td>'+(sts.oldstat.deal_num*100/sts.oldplan.deal_num).toFixed(2)+'%</td><td>'+(sts.oldstat.transform*100/sts.oldplan.transform).toFixed(2)+'%</td></tr>';
                         $(".oldtable").append(html);
                    }
                        

                         $(".membertable tr:not(:first)").remove(); 
                      if(sts.oldplan==null)
                        html= '<tr class="warning"><td>本月计划</td><td colspan="8">无</td></tr>';
                      else
                      html = '<tr class="warning"><td>本月计划</td><td>'+sts.memberplan.a_member+'</td><td>'+sts.memberplan.b_member+'</td><td>'+sts.memberplan.pre_sale+'</td><td>'+sts.memberplan.sale+'</td><td>'+sts.memberplan.deal_num+'</td></tr>';
                       $(".membertable").append(html);
                       html = '<tr class="success"><td>实际完成</td><td>'+sts.memberstat.a_member+'</td><td>'+sts.memberstat.b_member+'</td><td>'+sts.memberstat.pre_sale+'</td><td>'+sts.memberstat.sale+'</td><td>'+sts.memberstat.deal_num+'</td></tr>';
                     
                      $(".membertable").append(html);
                       if(sts.oldplan!=null){
                         html = '<tr class="danger"><td>完成率</td><td>'+(sts.memberstat.a_member*100/sts.memberplan.a_member).toFixed(2)+'%</td><td>'+(sts.memberstat.b_member*100/sts.memberplan.b_member).toFixed(2)+'%</td><td>'+(sts.memberstat.pre_sale*100/sts.memberplan.pre_sale).toFixed(2)+'%</td><td>'+(sts.memberstat.sale*100/sts.memberplan.sale).toFixed(2)+'%</td><td>'+(sts.memberstat.deal_num*100/sts.memberplan.deal_num).toFixed(2)+'%</td></tr>';
                         $(".membertable").append(html);
                    }


                     
                } else {
                     bootbox.alert(data.info,null);          
                }
        }, "json");
        return false;

     });


$("#query_mc_plan").submit(function(){   
         var self = $(this); 
        $.post(self.attr("action"), self.serialize(), function(data,textStatus){
             if(data.status){
                     $(".table tr:not(:first)").remove();
                     var sts=data.statistics;
                     if(sts==null) 
                      {
                        bootbox.alert("无此时间段的计划，请先添加计划！",null);
                        return;
                      }
                     for(var i=0;i<sts.length;i++)
                     {
                        var time = sts[i].time;
                        var html='<tr  class="info" ><td colspan="6" align="center">'+time+'</td></tr>';
                        $(".table").append(html);
                        html = '<tr class="warning"><td>本月计划</td><td>'+sts[i].protential_plan+'</td><td>'+sts[i].transform_plan+'</td><td>'+sts[i].transform_plan*100/sts[i].protential_plan +'%</td><td>'+sts[i].cardsale_plan+'</td><td>'+sts[i].br_plan+'</td></tr>';
                        $(".table").append(html);
                        html = '<tr class="danger"><td>本月实际</td><td>'+sts[i].protential_value+'</td><td>'+sts[i].transform_value+'</td><td>'+sts[i].transform_value*100/sts[i].protential_value +'%</td><td>'+sts[i].cardsale_value+'</td><td>'+sts[i].br_value+'</td></tr>';
                        $(".table").append(html);
                        html = '<tr class="err"><td>本月累计</td><td>'+sts[i].protential_total+'</td><td>'+sts[i].transform_total+'</td><td>'+sts[i].transform_total*100/sts[i].protential_total +'%</td><td>'+sts[i].cardsale_total+'</td><td>'+sts[i].br_total+'</td></tr>';
                        $(".table").append(html);
                     }
                     
                } else {
                     bootbox.alert(data.info,null);          
                }
        }, "json");
        return false;

     });

   $("#query_channel_plan").submit(function(){   
         var self = $(this); 
        $.post(self.attr("action"), self.serialize(), function(data,textStatus){
             if(data.status){
                     $(".table tr:not(:first)").remove();
                     var sts=data.statistics;
                     if(sts==null) 
                      {
                        bootbox.alert("无此时间段的计划，请先添加计划！",null);
                        return;
                      }
                     for(var i=0;i<sts.length;i++)
                     {
                        var time = sts[i].time;
                        var html='<tr  class="info" ><td colspan="5" align="center">'+time+'</td></tr>';
                        $(".table").append(html);
                        html = '<tr class="warning"><td>本月计划</td><td>'+sts[i].protential_plan+'</td><td>'+sts[i].channel_plan+'</td> <td>'+sts[i].transform_plan+'</td><td>'+sts[i].transform_plan*100/sts[i].protential_plan +'%</td></tr>';
                        $(".table").append(html);
                         html = '<tr class="danger"><td>本月实际</td><td>'+sts[i].protential_value+'</td><td>'+sts[i].channel_value+'</td> <td>'+sts[i].transform_value+'</td><td>'+sts[i].transform_value*100/sts[i].protential_value +'%</td></tr>';
                        $(".table").append(html);
                          html = '<tr class="default"><td>本月累计</td><td>'+sts[i].protential_total+'</td><td>'+sts[i].channel_total+'</td> <td>'+sts[i].transform_total+'</td><td>'+sts[i].transform_total*100/sts[i].protential_total +'%</td></tr>';
                        $(".table").append(html);
                     }
                     
                } else {
                     bootbox.alert(data.info,null);          
                }
        }, "json");
        return false;

     });


   $("#query_channel_statistics,#query_channel_statistics_self").submit(function(){   
         var self = $(this); 
        $.post(self.attr("action"), self.serialize(), function(data,textStatus){
             if(data.status){
                     $(".table tr:not(:first)").remove();
                     var sts=data.statistics;
                     for(var i=0;i<sts.length;i++)
                     {  
                        var st = sts[i];

                        var persent = st.protential==0?0:st.mcount*100/st.protential;
                         var persent_total = st.protential_total==0?0:st.mcount_total*100/st.protential_total;

                       var html='<tr class="warning"><td>'+(i+1)+'</td> <td>'+st.name+'</td> <td>'+st.level+'</td> <td>'+st.protential+'</td><td>'+st.mcount+'</td><td>'+persent+'%</td><td>'+st.protential_total+'</td><td>'+st.mcount_total+'</td><td>'+persent_total+'%</td></tr>';
                       
                       $(".table").append(html);
                     }
                     
                } else {
                    bootbox.alert(data.info,null);            
                }
        }, "json");
        return false;

     });
 

$(document).on("change", "#member_info :radio", function() { 
     $.post("/Cashier/Member/show", {id:$(this).val()}, function(data,textStatus){
                          $("#show_detail").text("");
                          $("#show_detail").append(data);
                    }, "json");
     if(join_query_members!=null)
     for(var i=0;i<join_query_members.length;i++)
     {
        var member = join_query_members[i];
        if(member.id==$(this).val())
        {
           $("#card_type_id").val(member.maybuy);
           $("#card_type_id").trigger("change");
           $("#book_price").val(member.contract_book_price);
            $("#pt_book_price").val(member.pt_book_price);
            $("#join_mc_id").val(member.mc_id);
              $("#pt_id").val(member.pt_id);
          break;
        }
     }

});

$(document).on("change", "#member_info_goods :radio", function() { 
     var ele=$("#member_info_goods tbody :radio:checked");        
     var recharge=ele.parent().parent().find("td:eq(5)");
     var recharge=recharge.text();
     recharge_value=recharge;
     tip();
     $("#recharge").text("（￥"+recharge+"）");
});

 

var join_query_members;
   $("#join_form_query").submit(function(){  
        var name =$("#join_form_query [name=name]").val();
        if($.trim(name)=="") return false;
         var self = $(this); 
        $.post(self.attr("action"), self.serialize(), function(data,textStatus){
             if(data.status){
             join_query_members=members=data.data;
              $(".table tr:not(:first)").remove();
                     for(var i=0;i<members.length;i++)
                     {
                        var member = members[i];
                        var sex = member.sex=="female"?"女":"男";
                        var membertype=member.is_member=="1"?"正式会员":"潜在会员";
                        var card_number=member.card_number==null?"无会员卡":member.card_number;
                       var html='<tr><td><input type="radio" name="rd1" value="'+member.id+'"></td>';
                       html+="<td>"+member.name+"</td>";
                         html+="<td>"+member.phone+"</td>";
                          html+="<td>"+sex+"</td>";
                           html+="<td>"+membertype+"</td>";
                            
                           html+="<td>"+card_number+"</td>";
                           
                           if(member.is_member!="1")
                             html+="<td class='can_modify'><a href='/Reception/Visit/index/id/"+member.id+"'>修改</a></td></tr>";

                        $("#member_info tbody").append(html); 
                     }
                      $("#member_info").removeClass("hide");
                } else {
                  $("#member_info").addClass("hide");
                  $("#show_detail").text("");
                    bootbox.alert("此用户信息不存在，请先到前台进行录入！",null);           
                }
        }, "json");
        return false;

     });
 
 $("#pt_transform_form_query").submit(function(){  
        var name =$("#pt_transform_form_query [name=name]").val();
        if($.trim(name)=="") return false;
         var self = $(this); 
        $.post(self.attr("action"), self.serialize(), function(data,textStatus){
           $("#member_info tr:not(:first)").remove();
             if(data.status){
              var members=data.data;  join_query_members=members;
              if(members==null)return;
                     for(var i=0;i<members.length;i++)
                     {
                        var member = members[i];
                        var sex = member.sex=="female"?"女":"男"; 
                       var html='<tr><td><input type="radio" name="member_id" value="'+member.id+'"></td>';
                       html+="<td>"+member.name+"</td>";
                         html+="<td>"+member.phone+"</td>";
                         html+="<td>"+sex+"</td></tr>"; 
                        $("#member_info tbody").append(html);   
                     }
                      
                } else { 
                  bootbox.alert(data.info,null);
                }
        }, "json");
        return false;

     });

$("#pt_form_query").submit(function(){  
        var name =$("#pt_form_query [name=name]").val();
        if($.trim(name)=="") return false;
         var self = $(this); 
        $.post(self.attr("action"), self.serialize(), function(data,textStatus){
           $("#member_info tr:not(:first)").remove();
             if(data.status){
              var members=data.data; join_query_members=members;
              if(members==null)return;
                     for(var i=0;i<members.length;i++)
                     {

                      var member = members[i];
                        var sex = member.sex=="female"?"女":"男";
                        var membertype=member.is_member=="1"?"正式会员":"潜在会员";
                        var card_number=member.card_number==null?"无会员卡":member.card_number;
                         var recharge=member.recharge;
                       var html='<tr><td><input type="radio" name="member_id" value="'+member.id+'" onclick="changerecharge('+recharge+');"></td>';
                       html+="<td>"+member.name+"</td>";
                         html+="<td>"+member.phone+"</td>";
                          html+="<td>"+sex+"</td>";
                           html+="<td>"+membertype+"</td>";
                            
                           html+="<td>"+card_number+"</td>";
                           
                           if(member.is_member!="1")
                             html+="<td class='can_modify'><a href='/Reception/Visit/index/id/"+member.id+"'>修改</a></td></tr>"; 
                        $("#member_info tbody").append(html); 
                     }
                      
                } else { 
                  bootbox.alert(data.info,null);
                }
        }, "json");
        return false;

     });


$("#book_form_query").submit(function(){  
        var name =$("#book_form_query [name=name]").val();
        if($.trim(name)=="") return false;
         var self = $(this); 
        $.post(self.attr("action"), self.serialize(), function(data,textStatus){
           $("#member_info tr:not(:first)").remove();
             if(data.status){
              var members=data.data; 
              if(members==null)return;
                     for(var i=0;i<members.length;i++)
                     {
                        var member = members[i];
                        var sex = member.sex=="female"?"女":"男";
                        var recharge=member.recharge;
                        var is_member = member.is_member=="1"?"正式会员":"潜在会员";
                       var html='<tr><td><input type="radio" name="member_id" value="'+member.id+'" onclick="changerecharge('+recharge+');"></td>';
                       html+="<td>"+member.name+"</td>";
                         html+="<td>"+member.phone+"</td>";
                         html+="<td>"+sex+"</td>"; 
                          html+="<td>"+is_member+"</td></tr>"; 
                        $("#member_info tbody").append(html); 
                     }
                      
                } else { 
                  bootbox.alert(data.info,null);
                }
        }, "json");
        return false;

     });

$("#goods_form_query").submit(function(){  
        var name =$("#goods_form_query [name=name]").val();
        if($.trim(name)=="") return false;
         var self = $(this); 
        $.post(self.attr("action"), self.serialize(), function(data,textStatus){
           $("#member_info_goods tr:not(:first)").remove();
             if(data.status){
              var members=data.data; 
              if(members==null)
                {
                  bootbox.alert("此会员不存在，请先添加潜在会员!");
                  return;
                }
                     for(var i=0;i<members.length;i++)
                     {
                        var member = members[i];
                        var sex = member.sex=="female"?"女":"男";
                         var is_member = member.is_member==0?"潜在会员":"正式会员";
                        var recharge=member.recharge;
                        
                       var html='<tr><td><input type="radio" name="member_id" value="'+member.id+'"></td>';
                       html+="<td>"+member.name+"</td>";
                         html+="<td>"+member.phone+"</td>";
                          html+="<td>"+sex+"</td>";
                           html+="<td>"+is_member+"</td>";
                           html+="<td>"+recharge+"</td></tr>";
                            
                        $("#member_info_goods tbody").append(html); 
                     }
                      
                } else { 
                  bootbox.alert(data.info,null);
                }
        }, "json");
        return false;

     });


   $("#addClubForm").submit(function(){   
         var self = $(this);
         locate();
         promptinfo(); 
        $.post(self.attr("action"), self.serialize(), function(data,textStatus){
             if(data.status){
                    window.location.href = data.url;
                } else {
                    bootbox.alert(data.info,null);                 
                }
        }, "json");
        return false;

     });


 $("#query_contract_form").submit(function(){   
         var self = $(this);     
         var rules="";
         $(this).find(":input").each(function(i){
            var searchField=$(this).attr("name");
            var searchOper=$(this).attr("oper");
            var searchString=$(this).val();
            if(searchField && searchOper && searchString) {  
                rules += ',{"field":"' + searchField + '","op":"' + searchOper + '","data":"' + searchString + '"}';  
            }  
         }); 
         if(rules) {  
            rules = rules.substring(1);  
         }  
         var filtersStr = '{"groupOp":"AND","rules":[' + rules + ']}';  
         var postData = $("#contract_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#contract_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });

 

 $("#mc_query_appoint").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#mc_appoint_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#mc_appoint_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });

 

  $("#pt_query_member").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#pt_member_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#pt_member_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });

  $("#mc_query_member").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#mc_member_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#mc_member_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });

  $("#mc_query_smember").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#mc_smember_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#mc_smember_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });




 $("#ptmanager_query_member").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#ptmanager_member_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#ptmanager_member_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });

 $("#mcmanager_query_member").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#mcmanager_member_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#mcmanager_member_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });

  $("#reception_query_member").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#reception_member_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#reception_member_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });

 
     
 $(".query_member").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#member_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#member_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });

   $("#channel_query_member").submit(function(){   
         var self = $(this);     
         jQuery("#channel_member_grid").jqGrid('setGridParam',{datatype:'json',postData:self.serialize(),url:self.attr("action")}).trigger("reloadGrid");
 
        return false;

     }); 

    $("#query_employee").submit(function(){   
         var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#employee_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#employee_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });

    

   // $("#query_employee").submit(function(){   
   //       var self = $(this);     
   //       jQuery("#employee_grid").jqGrid('setGridParam',{postData:self.serialize(),url:self.attr("action"),page:1}).trigger("reloadGrid");
 
   //      return false;

   //   });

   $("#query_goods").submit(function(){   
         var self = $(this);     
         jQuery("#goods_grid").jqGrid('setGridParam',{postData:self.serialize(),url:"/Brand/Goods/query",page:1}).trigger("reloadGrid");
 
        return false;

     });


$("#m_group_query").click(function(){ 
            var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#goods_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#goods_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });


$("#s_class_query_btn").click(function(){ 
         var self = $("#modalform"); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;

     });



   $("#query_ptclass").submit(function(){   
         var self = $(this);     
         jQuery("#pt_class_grid").jqGrid('setGridParam',{postData:self.serialize(),url:self.attr("action"),page:1}).trigger("reloadGrid");
 
        return false;

     });

     $("#cashier_query_cardtype").submit(function(){   
         var self = $(this);     
         jQuery("#card_type_grid").jqGrid('setGridParam',{postData:self.serialize(),url:self.attr("action"),page:1}).trigger("reloadGrid");
 
        return false;

     });



    $("#query_cardtype").submit(function(){   

        var self = $(this); 
         var filtersStr=buildAjaxQuery(self);
         var postData = $("#card_type_grid").jqGrid("getGridParam", "postData"); 
         $.extend(postData, {filters: filtersStr});  
        $("#card_type_grid").jqGrid("setGridParam", {  
          datatype:'json',
              search: true    
          }).trigger("reloadGrid", [{page:1}]);   
       
        return false;
        

     });


$("#dopayback").submit(function(){   
  var self = $(this);
  $.ajax({
    type:"post", 
    url:self.attr("action"),
    dataType:"json",
    data:self.serialize(),
    success:function(data,textStatus){   
        if(data.status){
           bootbox.alert(data.info,function(){
             window.opener=null;
                window.open('','_self');
                window.close();  
           });             
                        
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
);



   $(".ajaxForm").submit(function(){   
         var self = $(this);

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
                     });   
                     
                  } 
                  else
                  {
                    if(data.url!=null && data.url!='')
                        window.location.href = data.url;
                       $(".modal").modal("hide");
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


        // $.post(self.attr("action"), self.serialize(), function(data,textStatus){
        //      if(data.status){
        //           if(data.info!=null && data.info!='')
        //           {
        //              $(".modal").modal("hide");
        //              bootbox.alert(data.info,function(){ 
        //               if(data.url!=null && data.url!='')
        //                 window.location.href = data.url;
        //              });   
                     
        //           } 
        //           else
        //           {
        //             if(data.url!=null && data.url!='')
        //                 window.location.href = data.url;
        //                $(".modal").modal("hide");
        //           }

                           
        //         } else {
        //             bootbox.alert(data.info,null);             
        //         }
        // }, "json");
        // return false;

     });



}
);





                function style_edit_form(form) {
                    //enable datepicker on "sdate" field and switches for "stock" field
                    form.find('input[name=sdate]').datepicker({format:'yyyy-mm-dd' , autoclose:true})
                        .end().find('input[name=stock]')
                              .addClass('ace ace-switch ace-switch-5').wrap('<label class="inline" />').after('<span class="lbl"></span>');
            
                    //update buttons classes
                    var buttons = form.next().find('.EditButton .fm-button');
                    buttons.addClass('btn btn-sm').find('[class*="-icon"]').remove();//ui-icon, s-icon
                    buttons.eq(0).addClass('btn-primary').prepend('<i class="icon-ok"></i>');
                    buttons.eq(1).prepend('<i class="icon-remove"></i>')
                    
                    buttons = form.next().find('.navButton a');
                    buttons.find('.ui-icon').remove();
                    buttons.eq(0).append('<i class="icon-chevron-left"></i>');
                    buttons.eq(1).append('<i class="icon-chevron-right"></i>');     
                }
            
                function style_delete_form(form) {
                    var buttons = form.next().find('.EditButton .fm-button');
                    buttons.addClass('btn btn-sm').find('[class*="-icon"]').remove();//ui-icon, s-icon
                    buttons.eq(0).addClass('btn-danger').prepend('<i class="icon-trash"></i>');
                    buttons.eq(1).prepend('<i class="icon-remove"></i>')
                }
                
                function style_search_filters(form) {
                    form.find('.delete-rule').val('X');
                    form.find('.add-rule').addClass('btn btn-xs btn-primary');
                    form.find('.add-group').addClass('btn btn-xs btn-success');
                    form.find('.delete-group').addClass('btn btn-xs btn-danger');
                }
                function style_search_form(form) {
                    var dialog = form.closest('.ui-jqdialog');
                    var buttons = dialog.find('.EditTable')
                    buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'icon-retweet');
                    buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'icon-comment-alt');
                    buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'icon-search');
                }
                
                function beforeDeleteCallback(e) {
                    var form = $(e[0]);
                    if(form.data('styled')) return false;
                    
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                    style_delete_form(form);
                    
                    form.data('styled', true);
                }
                
                function beforeEditCallback(e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                    style_edit_form(form);
                }
            
                
                //replace icons with FontAwesome icons like above
                function updatePagerIcons(table) {
                    var replacement = 
                    {
                        'ui-icon-seek-first' : 'icon-double-angle-left bigger-140',
                        'ui-icon-seek-prev' : 'icon-angle-left bigger-140',
                        'ui-icon-seek-next' : 'icon-angle-right bigger-140',
                        'ui-icon-seek-end' : 'icon-double-angle-right bigger-140'
                    };
                    $('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function(){
                        var icon = $(this);
                        var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
                        
                        if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
                    })
                }
            
                function enableTooltips(table) {
                    $('.navtable .ui-pg-button').tooltip({container:'body'});
                    $(table).find('.ui-pg-div').tooltip({container:'body'});
                }


function delClub(id,obj)
{
  bootbox.confirm("确认删除？", function(result) {
          if(result)
          {
            $.post("/index.php/Brand/Shop/del", {id:id}, function(data,textStatus){
                         if(data.status){          
                                // bootbox.alert("删除成功！",null);
                                // $(obj).parents("tr").remove(); 
                                
                                start = $("#clubs_table").dataTable().fnSettings()._iDisplayStart;  
                                total = $("#clubs_table").dataTable().fnSettings().fnRecordsDisplay();  
                                window.location.reload();  
                                if((total-start)==1){  
                                    if (start > 0) {  
                                        $("#clubs_table").dataTable().fnPageChange( 'previous', true );  
                                    }  
                                }  
                            } else {
                                 bootbox.alert(data.info,null);                   
                            }
                    }, "json");
          }
    });
}


function delPeak(id,obj)
{
  bootbox.confirm("确认删除？", function(result) {
          if(result)
          {
            $.post("/index.php/Brand/Shop/delPeak", {id:id}, function(data,textStatus){
                         if(data.status){                               
                                start = $("#peak_table").dataTable().fnSettings()._iDisplayStart;  
                                total = $("#peak_table").dataTable().fnSettings().fnRecordsDisplay();  
                                window.location.reload();  
                                if((total-start)==1){  
                                    if (start > 0) {  
                                        $("#peak_table").dataTable().fnPageChange( 'previous', true );  
                                    }  
                                }  
                            } else {
                                 bootbox.alert(data.info,null);                     
                            }
                    }, "json");
          }
    });
}
