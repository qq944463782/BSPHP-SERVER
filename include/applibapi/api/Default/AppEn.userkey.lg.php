<?php


/***********************接口介绍说明******************************************
 * userkey.lg
 * 取用户绑定key
 * *****************************************************************************
 */
#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');


$daihao = PLUG_DAIHAO();
$uid = Plug_Get_Session_Value('USER_UID');

//登录连接数功能集代码
$log = Plug_User_Is_Login_Seesion();
if ($log == 1047) {


  /**
   * 查询用户绑定key
   */
  $user_arr = Plug_Get_App_User_Info($uid, $daihao);
  if ($user_arr['L_key_info'] == "") Plug_Echo_Info("9981",9981);

  Plug_Echo_Info($user_arr['L_key_info'],200);
}
Plug_Echo_Info($user_str_log[$log], $log);
