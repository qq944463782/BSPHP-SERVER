<?php
/*
<api>
  <name>chong.lg</name>
  <title>软件使用期充值</title>
    <intro>接口参数说明</intro>
  <common_params type="1">
    <param name="api" type="1" required="true" dtype="string" desc="API接口名称"></param>
    <param name="BSphpSeSsL" type="1" required="true" dtype="string" desc="BSphpSeSsL连接Cookies"></param>
    <param name="date" type="1" required="false" dtype="string" desc="服务器时间超时验证；可空，后台设置超时0即关闭"></param>
    <param name="mutualkey" type="1" required="true" dtype="string" desc="通信认证Key，用作软件数据包交换数据验证串"></param>
    <param name="appsafecode" type="1" required="false" dtype="string" desc="封包劫持检测；可空，客户端提交参数给服务器时原样返回"></param>
    <param name="md5" type="1" required="false" dtype="string" desc="程序MD5；可空，后台MD5内容要为空"></param>
  </common_params>

  <params>
    <param name="user" required="false" type="string" desc="充值用户"></param>
    <param name="userpwd" required="false" type="string" desc="充值密码"></param>
    <param name="userset" required="false" type="string" desc="是否需要验证密码=1需要验证密码"></param>
    <param name="ka" required="false" type="string" desc="充值卡号"></param>
    <param name="pwd" required="false" type="string" desc="充值卡密码"></param>
  </params>
</api>
*/




/***********************接口介绍说明******************************************
 * chong.lg
 * 软件使用期充值 
 * *****************************************************************************
 */


$daihao = PLUG_DAIHAO();
$user = Plug_Set_Data('user');          #充值用户
$userpwd = Plug_Set_Data('userpwd');    #充值密码
$userset = Plug_Set_Data('userset');    #是否需要验证密码=1需要验证密码
$ka = Plug_Set_Data('ka');              #充值卡号
$pwd = Plug_Set_Data('pwd');            #充值卡密码


#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');


 //转换真实user信息,顺序账户,邮箱,手机 uid+密码
 $user = Plug_UserTageToUser($user, $userpwd);


if ($userset == '1') {
  $log = Plug_Is_User_Account($user, $userpwd);
  if ($log != 1011) Plug_Echo_Info($user_str_log[$log],$log);
}

if($ka==''){
  Plug_Echo_Info(Plug_Lang('请输入充值卡号'),-1);
}

$sql = "SELECT *  FROM `bs_php_cardseries` WHERE `car_name` = '{$ka}'  ";
$arrcar = Plug_Query_Assoc($sql);
if (!$arrcar) {
  Plug_Echo_Info($user_str_log[1138],1138);
}


 $sql = "SELECT `app_daihao`,`app_MoShi`,`car_DaiHao`,`app_name`  FROM `bs_php_cardseries`,`bs_php_appinfo` WHERE `car_name` LIKE '{$ka}' AND `app_daihao`= `car_DaiHao` ";
$arr = Plug_Query_Assoc($sql);



if (!$arr) {
  Plug_Echo_Info($user_str_log[1135], 1135);
}



#验证是否当前软件，很多用户拿A软件卡到B软件充值说B软件没时间，时间到对应卡软件上！
if ($arr["" . 'app_daihao'] == $daihao) {

  if ($arr["" . 'app_MoShi'] == 'LoginPoint' or $arr["" . 'app_MoShi'] == 'LoginTerm') {

    $log = Plug_User_Chong($user, $ka, $pwd);
    Plug_Echo_Info($user_str_log[$log],$log);
  } else {

    Plug_Echo_Info($user_str_log[1139], 1139);
  }
} else {
  $a  =   str_replace("[软件]", $arr["" . 'app_name'], $user_str_log[1137]);
  Plug_Echo_Info($a, 1137);
}
