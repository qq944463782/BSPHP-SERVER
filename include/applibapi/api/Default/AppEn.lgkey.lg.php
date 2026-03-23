<?php


/***********************接口介绍说明******************************************
 * lgkey.lg
 * 取得登陆成功返回数据包
 * *****************************************************************************
 */

#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');
$daihao = PLUG_DAIHAO();
$key = Plug_Set_Data('key');
$uid = Plug_Get_Session_Value('USER_UID');




$log = Plug_User_Is_Login_Seesion();
if ($log == 1047) {


  //    /**
  //     * 查询用户绑定key
  //     */
  if (Plug_App_DaTa('app_set') == 1) {
    $user_arr = Plug_Get_App_User_Info($uid, $daihao);
    if ($key !== $user_arr['L_key_info']) Plug_Echo_Info('5034', 5034);
  }



  //判断是否已经过期
  $arr = Plug_Get_App_User_Info($uid, $daihao);
  if (Plug_App_DaTa('app_set') == 1 or $arr['L_vip_unix'] > PLUG_UNIX()) {
    Plug_Echo_Info(Plug_App_DaTa('app_logininfo'));
  } else {
    Plug_Echo_Info('5033');
  }
}
Plug_Echo_Info($user_str_log[$log], $log);
