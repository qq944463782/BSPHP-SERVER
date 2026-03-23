<?php


/***********************接口介绍说明******************************************
 * lginfo.lg
 * 验证是否登录
 * *****************************************************************************
 */
#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

$log = Plug_User_Is_Login_Seesion();
if ($log == 1047) Plug_Echo_Info('1', 200);
Plug_Echo_Info($user_str_log[$log], $log);
