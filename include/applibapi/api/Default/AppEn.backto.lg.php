<?php
/*
<api>
  <name>backto.lg</name>
  <title>密保找回密码</title>
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
    <param name="user" required="false" type="string" desc="账号"></param>
    <param name="pwd" required="false" type="string" desc="新密码"></param>
    <param name="pwdb" required="false" type="string" desc="再次输入新密码"></param>
    <param name="mibao" required="false" type="string" desc="密保问题"></param>
    <param name="wenti" required="false" type="string" desc="参数说明"></param>
    <param name="daan" required="false" type="string" desc="密保答案"></param>
    <param name="img" required="false" type="string" desc="开验证码，接验证码"></param>
  </params>
</api>
*/




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
