<?php if (!defined('THINK_PATH')) exit();?> 
	<div class="profile-user-info profile-user-info-striped">
		<div class="profile-info-row">
			<div class="profile-info-name">姓名：</div>
			<div class="profile-info-value">
				<span >&nbsp<?php echo ($member["name"]); ?></span>
			</div>
		</div>

		<div class="profile-info-row">
			<div class="profile-info-name">手机号码</div>
			<div class="profile-info-value">
				<span >
				 &nbsp<?php echo ($member["phone"]); ?>
				</span>
			</div>
		</div>


		<div class="profile-info-row">
			<div class="profile-info-name">性别</div>
			<div class="profile-info-value">
				<span >
					<?php switch($member["sex"]): case "female": ?>女<?php break;?>
					    <?php case "male": ?>男<?php break;?>
					    <?php default: ?>女<?php endswitch;?>
				</span>
			</div>
		</div>

		<div class="profile-info-row">
			<div class="profile-info-name">购买合同</div>
			<div class="profile-info-value">
				<span >&nbsp
				   <?php if(is_array($contracts)): $i = 0; $__LIST__ = $contracts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$contract): $mod = ($i % 2 );++$i; echo ($contract["card_type"]["name"]); ?>(<?php echo ($contract["start_time"]); ?>---<?php echo ($contract["end_time"]); ?>|<?php echo ($contract["used_num"]); ?>/<?php echo ($contract["total_num"]); ?>) &nbsp&nbsp<?php endforeach; endif; else: echo "" ;endif; ?>
				</span>
			</div>
		</div>
		<div class="profile-info-row">
			<div class="profile-info-name">购买私教</div>
			<div class="profile-info-value">
				<span >&nbsp
				  <?php if(is_array($ptcontracts)): $i = 0; $__LIST__ = $ptcontracts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$contract): $mod = ($i % 2 );++$i; echo ($contract["ptclass"]["name"]); ?>(<?php echo ($contract["used_num"]); ?>/<?php echo ($contract["total_num"]); ?>)  &nbsp&nbsp<?php endforeach; endif; else: echo "" ;endif; ?>
				</span>
			</div>
		</div>


		<div class="profile-info-row">
			<div class="profile-info-name">来自渠道</div>

			<div class="profile-info-value"> 
				<span >&nbsp<?php if($member["channel_id"] == 0): ?>朋友推荐<?php else: echo ($member["channel"]["name"]); endif; ?></span>
			</div>
		</div>

		<div class="profile-info-row">
			<div class="profile-info-name">推荐人</div>

			<div class="profile-info-value"> 
				<span >&nbsp<?php echo ($member["recommend_name"]); ?></span>
			</div>
		</div>

		<div class="profile-info-row">
			<div class="profile-info-name">推荐人手机号码</div>

			<div class="profile-info-value"> 
				<span >&nbsp<?php echo ($member["recommend_phone"]); ?></span>
			</div>
		</div>

	<div class="profile-info-row">
			<div class="profile-info-name">分类</div>
			<div class="profile-info-value">
				<span >
					<?php switch($member["type"]): case "4": ?>A类<?php break;?>
					    <?php case "3": ?>B类<?php break;?>
					    <?php case "2": ?>C类<?php break;?>
					    <?php case "1": ?>D类<?php break;?>
					    <?php default: ?>D类<?php endswitch;?>
				</span>
			</div>
		</div> 

		<div class="profile-info-row">
			<div class="profile-info-name">邮件</div>
			<div class="profile-info-value">
				<span >&nbsp<?php echo ($member["email"]); ?></span>
			</div>
		</div>
		<div class="profile-info-row">
			<div class="profile-info-name">生日</div>
			<div class="profile-info-value">
				<span >&nbsp<?php echo ($member["birthday"]); ?></span>
			</div>
		</div>
		<div class="profile-info-row">
			<div class="profile-info-name">家庭座机</div>
			<div class="profile-info-value">
				<span >&nbsp<?php echo ($member["home_phone"]); ?></span>
			</div>
		</div>
		<div class="profile-info-row">
			<div class="profile-info-name">家庭地址</div>
			<div class="profile-info-value">
				<span >&nbsp<?php echo ($member["home_addr"]); ?></span>
			</div>
		</div>
		<div class="profile-info-row">
			<div class="profile-info-name">国籍</div>
			<div class="profile-info-value">
				<span >&nbsp<?php echo ($member["country"]); ?></span>
			</div>

		</div>

			<div class="profile-info-row">
			<div class="profile-info-name">民族</div>
			<div class="profile-info-value">
				<span >&nbsp<?php echo ($member["nation"]); ?></span>
			</div>
		</div>
			<div class="profile-info-row">
			<div class="profile-info-name">职业</div>
			<div class="profile-info-value">
				<span >&nbsp<?php echo ($member["job"]); ?></span>
			</div>
		</div>

<div class="profile-info-row">
			<div class="profile-info-name">公司名</div>
			<div class="profile-info-value">
				<span >&nbsp<?php echo ($member["office_name"]); ?></span>
			</div>
		</div>
		<div class="profile-info-row">
			<div class="profile-info-name">公司地址</div>
			<div class="profile-info-value">
				<span >&nbsp<?php echo ($member["office_addr"]); ?></span>
			</div>
		</div>
	<div class="profile-info-row">
			<div class="profile-info-name">公司电话</div>
			<div class="profile-info-value">
				<span >&nbsp<?php echo ($member["office_phone"]); ?></span>
			</div>
		</div>
<div class="profile-info-row">
			<div class="profile-info-name">兴趣爱好</div>
			<div class="profile-info-value">
				<span >&nbsp<?php echo ($member["hobby"]); ?></span>
			</div>
		</div>



		<div class="profile-info-row">
			<div class="profile-info-name">最近会馆</div>
			<div class="profile-info-value">
				<span >&nbsp<?php echo ($member["near_club_info"]["club_name"]); ?></span>
			</div>
		</div>

		<div class="profile-info-row">
			<div class="profile-info-name">目的</div>
			<div class="profile-info-value">
				<span ><?php switch($member["purpose"]): case "1": ?>减肥<?php break;?>
					    <?php case "2": ?>增肌<?php break;?>
					    <?php case "3": ?>保持健康<?php break;?>
					    <?php case "4": ?>时尚<?php break;?>
					    <?php case "5": ?>习惯<?php break;?>
					    <?php case "6": ?>其他<?php break;?>
					    <?php default: ?>其他<?php endswitch;?></span>
			</div>
		</div>

<div class="profile-info-row">
			<div class="profile-info-name">证件类型</div>
			<div class="profile-info-value">
				<span ><?php switch($member["certificate_type"]): case "1": ?>身份证<?php break;?>
					    <?php case "2": ?>护照<?php break;?>
					    <?php case "3": ?>其他<?php break;?>
					  
					    <?php default: ?>身份证<?php endswitch;?></span>
			</div>
		</div>

		<div class="profile-info-row">
			<div class="profile-info-name">证件号码</div>
			<div class="profile-info-value">
				<span > &nbsp<?php echo ($member["certificate_number"]); ?></span>
			</div>
		</div>


<div class="profile-info-row">
			<div class="profile-info-name">获取咨询习惯</div>
			<div class="profile-info-value">
				<span ><?php switch($member["certificate_type"]): case "1": ?>网络<?php break;?>
					    <?php case "2": ?>杂志<?php break;?>
					    <?php case "3": ?>报纸<?php break;?>
					    <?php case "4": ?>电视<?php break;?>
					    <?php case "5": ?>广播<?php break;?>
					    <?php case "6": ?>短信<?php break;?>
						 <?php case "7": ?>其他<?php break;?>
					  
					    <?php default: ?>其他<?php endswitch;?></span>
			</div>
		</div>

<div class="profile-info-row">
			<div class="profile-info-name">婚姻状况</div>
			<div class="profile-info-value">
				<span >&nbsp<?php switch($member["marriage"]): case "0": ?>未婚<?php break;?>
					    <?php case "1": ?>已婚<?php break;?>
					   
					    <?php default: ?>未婚<?php endswitch;?></span>
			</div>
		</div>

		<div class="profile-info-row">
			<div class="profile-info-name">子女状况</div>
			<div class="profile-info-value">
				<span >&nbsp<?php switch($member["has_child"]): case "0": ?>无子女<?php break;?>
					    <?php case "1": ?>有子女<?php break;?>
					   
					    <?php default: ?>无子女<?php endswitch;?></span>
			</div>
		</div>

<div class="profile-info-row">
			<div class="profile-info-name">紧急联系人</div>
			<div class="profile-info-value">
				<span > &nbsp<?php echo ($member["emergency_name"]); ?></span>
			</div>
		</div>
		<div class="profile-info-row">
			<div class="profile-info-name">联系人电话</div>
			<div class="profile-info-value">
				<span >&nbsp <?php echo ($member["emergency_phone"]); ?></span>
			</div>
		</div>
		<div class="profile-info-row">
			<div class="profile-info-name">参加过其他品牌</div>
			<div class="profile-info-value">
				<span > &nbsp<?php echo ($member["other_clubs"]); ?></span>
			</div>
		</div>

<div class="profile-info-row">
			<div class="profile-info-name">照片</div>
			<div class="profile-info-value">
				<img src="/Public/uploads/mmb_avatar/<?php echo ($member["avatar"]); ?>" alt="" style="width:100px;height:100px">
			</div>
		</div>
<div class="profile-info-row">
			<div class="profile-info-name">备注</div>
			<div class="profile-info-value">
				<span >&nbsp<?php echo ($member["desc"]); ?></span>
			</div>
		</div> 
 
		<div class="profile-info-row">
			<div class="profile-info-name">录入人</div>
			<div class="profile-info-value">
				<span >&nbsp<?php if($member["record_user"] == null): ?>品牌帐号录入<?php else: echo ($member["record_user"]["name_cn"]); endif; ?></span>
			</div>
		</div>


		<div class="profile-info-row">
			<div class="profile-info-name">创建时间</div>
			<div class="profile-info-value">
				<span >&nbsp<?php echo ($member["create_time"]); ?></span>
			</div>
		</div>

		<div class="profile-info-row">
			<div class="profile-info-name">更新时间</div>
			<div class="profile-info-value">
				<span >&nbsp<?php echo ($member["update_time"]); ?></span>
			</div>
		</div>
		
	</div>