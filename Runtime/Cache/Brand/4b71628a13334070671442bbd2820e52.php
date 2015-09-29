<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Contract</title>

    <style type="text/css">
     body {
        margin: 0;
        padding: 0;
        background-color: #000000; 
    }
    .contract *{
        box-sizing: border-box;
        -moz-box-sizing: border-box;
         font: 0.52655cm "Microsoft Yahei"; 
    }

       .contract{
         background: white; 
         width: 21cm;
            min-height: 29.7cm; 
            margin: 0cm auto;
//            border: 1px #D3D3D3 solid;
            border-radius: 5px; 
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            position:relative;
       }

       img{
         width:100%;
         height:100%;
       }
       .content{
        position: absolute;
        left:0px;
        top:-7px; 
        white-space:nowrap;
       }

       .content span{
            position: absolute;
       }
       .char
       {
            font: 0.567cm "Helvetica"; 
       }
        @media screen { 
        span:nth-child(1){left:3.5cm;top:5.58cm}
        span:nth-child(2){left:12.15cm;top:5.58cm}
        span:nth-child(3){left:3.75cm;top:6.35cm}
        span:nth-child(4){left:14.72cm;top:6.4cm}
        span:nth-child(5){left:3.75cm;top:7.09cm}
        span:nth-child(6){left:12.41cm;top:7.14cm}

        span:nth-child(7){left:4.77cm;top:9.1cm;}
        span:nth-child(8){left:3.4cm;top:9.85cm}
        span:nth-child(9){left:13cm;top:9.9cm;}
        span:nth-child(10){left:4.66cm;top:10.63cm;}
        span:nth-child(11){left:13.7cm;top:10.6cm;}
        span:nth-child(12){left:4.42cm;top:11.42cm;}
        span:nth-child(13){left:13.8cm;top:11.42cm;}
        span:nth-child(14){left:3.84cm;top:12.18cm;}
        span:nth-child(15){left:4.38cm;top:14.2cm;}
        span:nth-child(16){left:5.66cm;top:15.06cm;}
        span:nth-child(17){left:13.21cm;top:15.06cm;}
        span:nth-child(18){left:5cm;top:15.84cm;}
        span:nth-child(19){left:12.9cm;top:15.8cm;}
        span:nth-child(20){left:4.4cm;top:17.74cm;}
        span:nth-child(21){left:10.5cm;top:17.74cm;}
        span:nth-child(22){left:16.7cm;top:17.7cm;}
        span:nth-child(23){left:4.54cm;top:18.44cm;}
        span:nth-child(24){left:10.63cm;top:18.44cm;}
        span:nth-child(25){left:17.65cm;top:18.44cm;}
        span:nth-child(26){left:3.76cm;top:20.22cm;}
        span:nth-child(27){left:12cm;top:22cm;} 
        } 
    </style>
    <script type="text/javascript">
       
    </script>
</head>
<body>
    <div class="contract">
        <img src="/Public/images/contract_background.jpg" alt="">
        <div class="content">
            <span style=""><?php echo ($member["name"]); ?></span>
            <span style="">
                <?php if(female == $member['sex']): ?>女
                    <?php else: ?>
                    男<?php endif; ?>
            </span>
            <span style=""><?php echo ($member["country"]); ?></span>
            <span style="" class="char"><?php echo ($member["certificate_number"]); ?></span>
            <span style=""><?php echo ($member["home_addr"]); ?></span>
            <span style="" class="char"><?php echo ($member["phone"]); ?></span>

            <span style="" class="char"><?php echo ($contract["contract_number"]); ?></span>
            <span style="">
                <?php if(0 == $contract['type']): ?>普通合同
                    <?php else: ?>
                    团卡合同<?php endif; ?>
            </span>
            <span style="" class="char"><?php echo ($card["card_number"]); ?></span>

            <span style=""><?php echo ($contract["card_type"]["name"]); ?></span>
            <span style="">
                <?php if(1 == $contract['card_type']['type']): ?>时间卡
                    <?php else: ?>
                    次数卡<?php endif; ?>
            </span>
            <span style=""  class="char"><?php echo ($contract["start_time"]); ?> 至  <?php echo ($contract["end_time"]); ?></span>
            <span style=""  class="char"><?php echo ($contract["create_time"]); ?></span>
            <span style=""><?php echo ($contract["description"]); ?></span>

            <span style=""><?php echo ($via); ?></span>
            <span style=""  class="char">￥<?php echo ($bill["paid"]); ?>.00</span>
            <span style=""  class="char">￥0.00</span>
            <span style=""  class="char"><?php echo ($bill["update_time"]); ?></span>
            <span style="">
                <?php if(1 == $historycount): ?>初办收费
                    <?php else: ?>
                    收款<?php endif; ?>
            </span>
            <span style="" class="char"><?php echo ($print_time); ?></span>
            <span style="" class="char"><?php echo ($contract["print_count"]); ?></span>
            <span style=""><?php echo ($club["club_name"]); ?></span>
            <span style=""><?php echo ($mc_name); ?></span>
            <span style=""><?php echo ($cashier_name); ?></span>
            <span style=""><?php echo ($shopkeeper_name); ?></span>
            <span style=""><?php echo ($user); ?></span>
            <span style="" class="char"><?php echo (substr($print_time,0,10)); ?></span>

        </div>
    </div>
</body>
</html>