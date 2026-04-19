<?php
/*
<api>
  <name>vipdate.lg</name>
  <title>取用户到期时间</title>
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
    <param name="" required="false" type="string" desc="参数说明"></param>
  </params>
</api>
*/




/***********************接口介绍说明******************************************
 * vipdate.lg
 * 取用户到期时间
 * *****************************************************************************
 */



#预设好文本字符串数组
$user_str_log = Plug_Load_Langs_Array("" . 'user', "" . 'user_str_log');
$appen_str_log = Plug_Load_Langs_Array('applib', 'appen_str_log');
$uid = Plug_Get_Session_Value('USER_UID');
$daihao = PLUG_DAIHAO();



//登录连接数功能集代码
//links_chaoshi_login();
//登陆状态
$log = Plug_User_Is_Login_Seesion();
if ($log != 1047) Plug_Echo_Info($user_str_log[$log], $log);

//获取用户信息
$arr = Plug_Get_App_User_Info($uid, $daihao);

Plug_Echo_Info($arr['L_vip_unix'], 200);
