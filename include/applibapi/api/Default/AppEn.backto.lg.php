<?php



/***********************接口介绍说明******************************************
 * backto.lg
 * 密保找回密码
 * *****************************************************************************
 */;
$daihao = PLUG_DAIHAO();
$user = Plug_Set_Data('user');     #账号
$pwd = Plug_Set_Data('pwd');       #新密码
$pwdb = Plug_Set_Data('pwdb');     #再次输入新密码
$mibao = Plug_Set_Data('mibao');   #密保问题
if($mibao == ''){
  $mibao = Plug_Set_Data('wenti');
}


$wenti = Plug_Set_Data('daan');    #密保答案
$img = Plug_Set_Data('img');       #开验证码，接验证码

#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

if ($user == '') {
  Plug_Echo_Info('请输入账号.', -1);
}

if ($pwd == '') {
  Plug_Echo_Info('请输入密码.', -1);
}

if ($pwdb == '') {
  Plug_Echo_Info('请再次输入密码.', -1);
}

if ($mibao == '') {
  Plug_Echo_Info('请输入密保.', -1);
}


if ($wenti == '') {
  Plug_Echo_Info('请输入答案.', -1);
}


//转换真实user信息,顺序账户,邮箱,手机 uid+密码
$user = Plug_UserTageToUser($user, $pwdb);

$log = Plug_User_MiBao_Pwd($user, $pwd, $pwdb, $mibao, $wenti);
Plug_Echo_Info($user_str_log[$log], $log);
