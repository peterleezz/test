<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title></title>
 
<link rel="stylesheet" type="text/css" media="screen" href="/Public/jqgrid/css/jquery-ui-1.11.2.custom/jquery-ui.theme.css" />
  <link rel="stylesheet" href="/Public/css/ui.jqgrid.css" />
 
<script src="/Public/js/jquery.min.js"></script>
<script src="/Public/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="/Public/js/jqGrid/jquery.jqGrid.min.js"></script>
 <script src="/Public/js/jquery.browser.min.js"></script> 
 <script src="/Public/js/jquery.printElement.js"></script>

  <style>
.ui-jqgrid tr.jqgrow td {
  white-space: normal !important;
  height:auto;
  vertical-align:text-top;
  padding-top:2px;
 }
</style>

</head>
<body>
 <table id="grid"></table>
<div id="pager"></div>
</body> 
<script> 
 
  var get = {};
    var url = window.document.location.href.toString();
    var u = url.split("?");
    if(typeof(u[1]) == "string"){
        u = u[1].split("&"); 
        for(var i in u){
            var j = u[i].split("=");
            get[j[0]] = j[1];
        } 
    }   
 
var type = '{type}';
jQuery("#grid").jqGrid({ 
  datatype: "json",
  height: 'auto',
  rowNum: 30,
  postData:get,
  url:"/Finance/Report/getdetail",
  mtype:"POST",        
  rowList: [30,60,100],
    colNames:['编号','付费类型', '项目名', '数量', '总金额','折扣(%)', '现金','POS','支票','储值卡','会员','操作者','销售','时间','备注'],
    colModel:[
      {name:'id',index:'id', width:60},
      {name:'project',index:'project'},
       {name:'sub_project',index:'sub_project'},
      {name:'number',index:'number'},
      {name:'paid',index:'paid'},
       {name:'discount',index:'discount'},
      {name:'cash',index:'cash'},
      {name:'pos',index:'pos'},
      {name:'check',index:'check'},
      {name:'recharge',index:'recharge'},   
      {name:'member',index:'member',formatter : function(value, options, rData){ 
                          return value.name;
                       }},
      {name:'recorder',index:'recorder',formatter : function(value, options, rData){ 
                          return value.name_cn;
                       }}, 
       {name:'mc',index:'mc',formatter : function(value, options, rData){ 
          if(value!=null)
            return value.name_cn;
          return "未指定MC!";
        }}, 
      {name:'create_time',index:'create_time'},     
      {name:'description',index:'description', width:150, sortable:false}   
    ],
    cmTemplate: {sortable:false,editable: false,search:false},
    pager: "#pager",
     autowidth: true,
    shrinkToFit:true,  
    viewrecords: true,
    sortname: 'id', 
    sortorder: "desc",
    caption: "报表详情"
}); 
jQuery("#grid").navGrid('#pager',{edit:false,add:false,del:false,search:false})  .navButtonAdd('#pager',{  
   caption:"全部导出",   
   buttonicon:"ui-icon-add",   
   onClickButton: function(){   
    var u = url.split("?");
     if(typeof(u[1]) == "string")
     {
         window.location.href="/Finance/Report/printdetail?"+u[1];
     }
     else
     {
        alert("Error!");
     }
    
   },   
   position:"last"   
});    
  
  jQuery("#grid").navGrid('#pager',{edit:false,add:false,del:false,search:false})  .navButtonAdd('#pager',{  
   caption:"导出/打印当前页",   
   buttonicon:"ui-icon-add",   
   onClickButton: function(){   
     $('#grid').printElement();
    
   },   
   position:"last"   
});    

</script>

</html>