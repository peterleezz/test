<?php
namespace Common\Model;
use Think\Model;
class BrandConfigModel extends Model {
    protected $_validate = array( 
        array('member_trans_price','/^\d*(\.\d+)?$/','请输入正确的会籍转让手续费！!',self::MUST_VALIDATE),
        array('member_upgrade_price','/^\d*(\.\d+)?$/','请输入正确的会籍升级手续费！!',self::MUST_VALIDATE),
        array('member_fillcard_price','/^\d*(\.\d+)?$/','请输入正确的续会手续费!',self::MUST_VALIDATE),
        array('member_payment_deadline','/^\d*$/','请输入正确的欠款补齐天数！!',self::MUST_VALIDATE),
  );
 
   protected $_auto = array(
       array('update_time','getDbTime',self::MODEL_BOTH,'function'),
       array('brand_id','get_brand_id',self::MODEL_BOTH,'function'),  
    ); 

}