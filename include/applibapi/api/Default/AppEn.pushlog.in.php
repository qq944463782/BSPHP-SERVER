<?php
/*
<api>
  <name>pushlog.in</name>
  <title>反破解冻结账号/卡号</title>
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
    <param name="user" required="false" type="string" desc="用户名或者激活码"></param>
    <param name="log" required="false" type="string" desc="参数说明"></param>
  </params>
</api>
*/


/***********************接口介绍说明******************************************
 * pushlog.in
 * 反破解冻结账号/卡号
 * *****************************************************************************
 */
$user = Plug_Set_Data('user'); //用户名或者激活码
$log = Plug_Set_Data('log');



$sql = "UPDATE `bs_php_user` SET  `user_IsLock` =  '1' WHERE  `bs_php_user`.`user_user` ='$user';";
if (Plug_Query($sql)) {
}

$sql = "UPDATE `bs_php_pattern_login` SET  `L_IsLock` =  '1' WHERE  `bs_php_pattern_login`.`L_User_uid` ='$user';";
if (Plug_Query($sql)) {
}

if ($user != '') {
  Plug_Add_AppenLog('od_po_log', Plug_Lang("冻结")."：$user", 'pushlog');
}
//日志记录
if ($log != '') {
  Plug_Add_AppenLog('od_po_log', "$log", 'pushlog');
}


Plug_Echo_Info(1, 200);
