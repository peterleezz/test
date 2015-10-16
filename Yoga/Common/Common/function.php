<?php

use Service\CMailService;
function dd()
{
    echo "x";die();
}

function getautocardnumber()
{
        $max_card = M("Card")->where(array("sale_club"=>get_club_id(),"is_auto_create"=>1))->order("card_number desc")->find();
                            if(empty($max_card))
                                $card_number=get_club_id()."000001";
                            else
                                $card_number=$max_card['card_number']+1; 
                            $card_number = preg_replace("/4/", "5", $card_number);
                            $cardModel = D("Card");
                            while(true)
                            {
                                    if($cardModel->isExist($card_number,get_brand_id()))
                                    {
                                            $card_number+=1;
                                            $card_number = preg_replace("/4/", "5", $card_number);
                                    }
                                    else
                                    {
                                            break;
                                    }
                            }
                            return $card_number;

}
function protential_d_asc($a,$b)
{
    return sortallgroup($a,$b,"protential_d")==0;
}
function protential_d_desc($a,$b)
{
    return sortallgroup($a,$b,"protential_d");
}
function potential_all_asc($a,$b)
{
    return sortallgroup($a,$b,"potential_all")==0;
}
function potential_all_desc($a,$b)
{
    return sortallgroup($a,$b,"potential_all");
}
function cardsale_d_asc($a,$b)
{
    return sortallgroup($a,$b,"cardsale_d")==0;
}
function cardsale_d_desc($a,$b)
{
    return sortallgroup($a,$b,"cardsale_d");
}
function cardsale_all_asc($a,$b)
{
    return sortallgroup($a,$b,"cardsale_all")==0;
}
function cardsale_all_desc($a,$b)
{
    return sortallgroup($a,$b,"cardsale_all");
}


function f2_protential_d_asc($a,$b)
{
    return sortonegroup($a,$b,"protential_d")==0;
}
function f2_protential_d_desc($a,$b)
{
    return sortonegroup($a,$b,"protential_d");
}
function f2_potential_all_asc($a,$b)
{
    return sortonegroup($a,$b,"potential_all")==0;
}
function f2_potential_all_desc($a,$b)
{
    return sortonegroup($a,$b,"potential_all");
}
function f2_cardsale_d_asc($a,$b)
{
    return sortonegroup($a,$b,"cardsale_d")==0;
}
function f2_cardsale_d_desc($a,$b)
{
    return sortonegroup($a,$b,"cardsale_d");
}
function f2_cardsale_all_asc($a,$b)
{
    return sortonegroup($a,$b,"cardsale_all")==0;
}
function f2_cardsale_all_desc($a,$b)
{
    return sortonegroup($a,$b,"cardsale_all");
}
 function sortonegroup($a,$b,$key)
     { 
        return $a[$key]<$b[$key];
     }


 function sortallgroup($a,$b,$k)
     {
        $price_a=$price_b=0;
        foreach ($a as $key => $value) {
            $price_a+=$value[$k];
        }
        foreach ($b as $key => $value) {
            $price_b+=$value[$k];
        }
        return $price_a<$price_b;
     }

function array_unique_2d($array2D){
    $temp = $res = array();
    foreach ($array2D as $v){
        $v = json_encode($v);  //降维,将一维数组转换字符串      

            $temp[] = $v;
        }
        $temp = array_unique($temp);    //去掉重复的字符串,也就是重复的一维数组
    foreach ($temp as $item){

        $res[] = json_decode($item,true);   //再将拆开的数组重新组装
    }
    return $res;
}

 function sendMail($to,$message,$subject)
 {
        $smtpserver = "smtp.163.com";//SMTP服务器 
        $smtpserverport = 25;//SMTP服务器端口 
        $smtpusermail = "peterlibo020@163.com";//SMTP服务器的用户邮箱 
        $smtpemailto = $to;//发送给谁 
        $smtpuser = "peterlibo020";//SMTP服务器的用户帐号 
        $smtppass = "000000a";//SMTP服务器的用户密码 
        $mailsubject = $subject;//邮件主题 
        $mailbody = $message;//邮件内容 
        $mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件 
        ########################################## 
        $smtp = new CMailService($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证. 
        $smtp->debug = true;//是否显示发送的调试信息 
        $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
 }
 function generateSessionToken($userId) {
        $content = "userid=$userId;ts=" . time();
        $iv_size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_CFB);
        $iv = str_repeat("\0", $iv_size);
        return base64_encode(mcrypt_encrypt(MCRYPT_3DES, C('encryptKey'), $content, MCRYPT_MODE_CFB, $iv));
}


function getInfoFromSessionToken($token) {
        if (trim($token) == '') {
            return false;
        }
        $iv_size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_CFB);
        $iv = str_repeat("\0", $iv_size);
        $content = mcrypt_decrypt(MCRYPT_3DES, C('encryptKey'), base64_decode($token), MCRYPT_MODE_CFB, $iv);
        $ret = false;
        if (strpos($content, 'userid') === 0) {
            $content = explode(";", $content);
            if (count($content) > 1) {
                $tempRet = array();
                $isFailed = false;
                foreach ($content as $v) {
                    $vs = explode("=", $v);
                    if (count($vs) !== 2) {
                        $isFailed = true;
                        break;
                    } else {
                        $tempRet[$vs[0]] = $vs[1];
                    }
                }

                if (!$isFailed) {
                    $ret = $tempRet;
                }
            }
        }  
        if ($ret) {
            if (!(isset($ret['userid'])) || !(isset($ret['ts']))) {
                $ret = false;
            }
        }
        return $ret['userid'];
    }


function getNotEmptyField()
{
    $params = I("post.");
    $var=array();
    foreach ($params as $key => $value) {
        if(!empty($value))
            $var[]=$key;
    }
   return $var;
}

function getRequestParams()
{
            $page = I("page");
            $page = empty($page )?1:$page ;
            $sidx = I("sidx");
            $sidx = empty($sidx )?"id":$sidx ;
            $limit = I("rows");
            $limit = empty($limit )?10000:$limit ;
            $sord = I("sord");
            $sord = empty($sord )?"desc":$sord ;   
            $totalrows = I("totalrows");  
            if(!empty($totalrows)) {
                $limit = $totalrows;
            }
              $start = $limit*$page - $limit; 
            return array($page,$sidx,$limit,$sord,$start);
}
function getLoginAdminUid()
{
    $user = session('sys_user_auth');
    return $user['uid']; 
}

function userLoginSession($user)
{
        $auth = array(
            'uid'             => $user['id'],
            'username'        => $user['username'],
            'last_login_time' => $user['last_login_time'],
            'brand_id'  =>$user['brand_id'],
            'is_brand'=>$user['is_brand'],
            'club_id'=>$user['club_id'],
        );
        // session('user_auth', $auth);
        // session('user_auth_sign', data_auth_sign($auth));

        $sid=generateSessionToken($user["id"]);
        cookie("sid",$sid);
}

 $loginuser; 
function is_user_login()
{ 
    $sid=cookie("sid");
    if(empty($sid))
    {
        $sid = I("sid");
    }if(empty($sid)) return null; 
    return getInfoFromSessionToken($sid);
    // $user = session('user_auth');
    // if (empty($user)) {
    //     return 0;
    // } else {
    //     return session('user_auth_sign') == data_auth_sign($user) ? $user['uid'] : 0;
    // }

}

function getLoginUser()
{
     global  $loginuser; 
    if(!empty($loginuser))
        return $loginuser;
    $x=is_user_login();
    if(empty($x)) return null;
    return D("User")->relation(true)->find($x);
}


function get_club_id()
{
     // $user = session('user_auth');
     // return $user['club_id'];
        $loginuser=getLoginUser();  
     return $loginuser['club_id'];
}
function get_brand_id()
{
     // $user = session('user_auth');   
     // return $user['brand_id'];
      $loginuser=getLoginUser();  
     return $loginuser['brand_id'];
}
function is_user_brand()
{
 //    $user = session('user_auth');
 // return $user['is_brand']!=0;
    $loginuser=getLoginUser(); 
     return $loginuser['is_brand']!=0;
}

function loginSession($user)
	{
		  $auth = array(
            'uid'             => $user['id'],
            'username'        => $user['username'],
            'last_login_time' => $user['last_login_time'],
        );
        // session('sys_user_auth', $auth);
        // session('sys_user_auth_sign', data_auth_sign($auth));
        $sid=generateSessionToken($user["id"]);
        cookie("sid",$sid);
	}

function is_admin_login()
{
	// $user = session('sys_user_auth');

	// if (empty($user)) {
 //        return 0;
 //    } else {
 //        return session('sys_user_auth_sign') == data_auth_sign($user) ? $user['uid'] : 0;
 //    }
 //    
    $sid=cookie("sid");
    if(empty($sid))
    {
        $sid = I("sid");
    }
    return getInfoFromSessionToken($sid);

}

function ucenter_md5($str, $key = 'yoga_peter!@#'){
	return '' === $str ? '' : md5(sha1($str) . $key);
}


function check_verify($code, $id = 1){
	$verify = new \Think\Verify();
	return $verify->check($code, $id);
}

function getDbTime($time=null)
{
	$value=empty($time)?time():$time;
	return date('Y-m-d H:i:s',$value);
}

function data_auth_sign($data) {
    //数据类型检测
    if(!is_array($data)){
        $data = (array)$data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}

function getQiubai()
{
    $HTTP_Server = "www.qiushibaike.com/8hr";
    $HTTP_URL = "/";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://" . $HTTP_Server . $HTTP_URL);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)");

            // curl_setopt($ch,CURLOPT_COOKIE,$HTTP_SESSION);

    $content = curl_exec($ch);
    curl_close($ch);
    if($content){
        preg_match_all('/<div class="content" title="(.*?)">\s*(.*?)\s*<\/div>/is', $content, $match);
        unset($match[0]);
        $lists = array_map(function($a, $b) {
         return array('time' => $a, 'content' => $b);
        }, $match[1], $match[2]);


       return $lists[rand(0,count($lists))];
    }
}

function getOPerationMysql($op)
{
    switch ($op) {
        case 'eq':
            return "=";
            break;
         case 'egt':
            return ">=";
            break;    
        case 'elt':
            return "<=";
            break;     
        
        default:
            # code...
            break;
    }
}
function getOneSearchParams()
{
    $field = I("searchField");
    $string = I("searchString");
    $searchOper=I("searchOper");
    $arr = array();
    switch ($searchOper) {
        case 'cn':
           $arr[$field]=array("like","%{$string}%");
            break;
        case 'eq':
           $arr[$field]=$string ;
            break;
        default:
            # code...
            break;
    }
    return $arr;
}

function validPassword($password)
{
    if (!preg_match ("/^[A-Za-z0-9_]{6,30}$/", $password))  {
        return false;
    } 
    return true;
}
 
