<?php

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
