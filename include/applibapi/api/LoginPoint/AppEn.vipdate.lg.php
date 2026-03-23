<?php



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
