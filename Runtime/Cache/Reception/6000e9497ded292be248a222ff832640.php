<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>

    <style type="text/css">

        body {
        margin: 0;
        padding: 0;
        background-color: #FFFFFF; 
         font-family:  "Microsoft Yahei"; 
    }
        .xiaopiao{width:5.75cm; background-color:White; margin:0 auto;padding:2px;font-size:14px;line-height: 24px;}
        .name,.num,.total,.name_r,.num_r,.total_r{float:left; text-align:center;}
        .name,.num,.total{font-weight:bold}
        .content{width:100%;padding:0px;margin:0px;}
        .name,.name_r{width:30%;}
        .num,.num_r{width:30%;}
        .total,.total_r{width:40%;}
        .title{width:100%;text-align:center;font-size:16px;}
        .detail{width:100%;padding:0px;}
        .lab{width:35%;font-weight:bold;padding:0px;margin:0px;float:left;text-align:right;}
        .cnt{width:65%;padding:0px;margin:0px;text-align:left;float:left;}
        .tail{margin-top:32px;}

         @media print {
            .xiaopiao{border:0px;width:7.6cm; background-color:White; margin:0 auto;padding:4px;font-size:14px;line-height: 24px;}
         }
    </style>

    <script type="text/javascript">
        window.print(); 
    </script>
</head>
<body>
    <div class="xiaopiao">
        <div class="title"><?php echo ($club["club_name"]); ?></div>
        <div class="title"><?php echo ($head); ?></div>
        <br>
        <div class="content">

            <div class="head1">
                <div class="name">品名</div>
                <div class="num">数量</div>
                <div class="total">实收</div>

                <div class="name_r"><?php echo ($title); ?></div>
                <div class="num_r"><?php echo ($num); ?></div>
                <div class="total_r" >￥<?php echo ($history['cash']+$history['pos']+$history['check']+$history['network']+$history['netbank']); ?>.00</div>
            </div>

            <div class="detail">
                <div class="title">明细</div>
    
                 <div class="lab">合同编号：</div>
                <div class="cnt"><?php echo ($bill["serial_number"]); ?></div>

                 <div class="lab">店名：</div>
                <div class="cnt"><?php echo ($club["club_name"]); ?></div>
                  <div class="lab">会员名：</div>
                <div class="cnt" ><?php echo ($member["name"]); ?></div>


                <?php if(is_array($items)): $i = 0; $__LIST__ = $items;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="lab"><?php echo ($item["key"]); ?>：</div>
                <div class="cnt"><?php echo ($item["value"]); ?>&nbsp</div><?php endforeach; endif; else: echo "" ;endif; ?> 
 
            
                 <?php if(0 != $history['create_time']): ?><div class="lab">付款日期：</div>
                <div class="cnt" ><?php echo ($history["create_time"]); ?></div><?php endif; ?>

                <?php if(0 != $history['cash']): ?><div class="lab">现金：</div>
                    <div class="cnt">￥<?php echo ($history["cash"]); ?>.00</div><?php endif; ?>
                <?php if(0 != $history['pos']): ?><div class="lab">刷卡：</div>
                    <div class="cnt">￥<?php echo ($history["pos"]); ?>.00</div><?php endif; ?>
                <?php if(0 != $history['check']): ?><div class="lab">支票：</div>
                    <div class="cnt">￥<?php echo ($history["check"]); ?>.00</div><?php endif; ?>
                <?php if(0 != $history['recharge']): ?><div class="lab">储值卡：</div>
                    <div class="cnt">￥<?php echo ($history["recharge"]); ?>.00</div><?php endif; ?>
                 <?php if(0 != $history['network']): ?><div class="lab">网络支付：</div>
                    <div class="cnt">￥<?php echo ($history["network"]); ?>.00</div><?php endif; ?>
                 <?php if(0 != $history['netbank']): ?><div class="lab">网银分期：</div>
                    <div class="cnt">￥<?php echo ($history["netbank"]); ?>.00</div><?php endif; ?>
                <div class="lab">总计收款：</div>
                <div class="cnt">￥<?php echo ($history['cash']+$history['pos']+$history['check']+$history['network']+$history['netbank']); ?>.00</div>
                <div class="lab">收款人：</div>
                <div class="cnt"><?php echo ($cashier); ?></div>
                <div class="lab">打印日期：</div>
                <div class="cnt"><?php echo ($print_time); ?></div>

                <div class="lab">备注：</div>
                <div class="cnt"><div style="width:4cm"> <?php echo ($history["description"]); ?> &nbsp</div></div> 
            
                <div class="lab tail">会员签名:</div>
                <div class="cnt tail">________________</div>
            </div>
        </div>
    </div>
</body>
</html>