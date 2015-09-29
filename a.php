<?php

$a=array (
  'member_id' => '99939585',
  'type' => '0',
  'card_type_id' => '945',
  'active_type' => '0',
  'present_day' => '0',
  'present_num' => '1',
  'start_time' => '2015-08-31',
  'end_time' => '2015-11-31',
  'price' => '800',
  'cash' => '800',
  'card_number' => '',
  'pos' => '0',
  'free_trans' => 'false',
  'check' => '0',
  'check_num' => '',
  'description' => '',
  'free_rest' => '0',
  'network' => '0',
  'netbank' => '0',
  'join_mc_id' => '1813',
);

function trans($a)
{
	$s="";
	foreach ($a as $key => $value) {
		if(empty($value))$value=' ';
		$s.="{$key}/{$value}/";
	}
	return $s;
}
echo preg_replace("/\/$/", "", trans($a));