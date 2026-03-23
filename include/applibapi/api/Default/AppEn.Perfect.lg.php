<?php


/***********************接口介绍说明******************************************
 * Perfect.lg
 * 完善用户资料 
 * *****************************************************************************
 */
#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');


$daihao = PLUG_DAIHAO();
$uid = Plug_Get_Session_Value('USER_UID');


$qq = Plug_Set_Data('qq');
$mail = Plug_Set_Data('mail');
$Mobile = Plug_Set_Data('mobile');


//登陆状态
$log = Plug_User_Is_Login_Seesion();
if ($log == 1047) {


  /**
   * 完善资料
   */
  if (empty($qq))
    Plug_Echo_Info($user_str_log[1014], 1014);
    
  if (empty($mail))

    Plug_Echo_Info($user_str_log[1015], 1015);
  if (empty($Mobile))
    Plug_Echo_Info($user_str_log[1016], 1016);


  $sql = "UPDATE`bs_php_user`SET`user_email`='{$mail}',`user_qq`='{$qq}',`user_Mobile`='{$Mobile}'WHERE`bs_php_user`.`user_uid`='{$uid}';";
  $param_tmp = Plug_Query($sql);
  if ($param_tmp) {

    Plug_Echo_Info($user_str_log[1017], 1017);
  } else {

    Plug_Echo_Info($user_str_log[1018], 1018);
  }
}
