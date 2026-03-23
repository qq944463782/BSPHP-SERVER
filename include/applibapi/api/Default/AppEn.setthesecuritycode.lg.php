<?php


/***********************接口介绍说明******************************************
 * setthesecuritycode.lg
 * 设置密保信息

 * *****************************************************************************
 */
#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

$uid = Plug_Get_Session_Value('USER_UID');
$WenTi = Plug_Set_Data('problem');    #密保问题
$DaAn = Plug_Set_Data('answer');      #密保答案



//登陆状态
$log = Plug_User_Is_Login_Seesion();
if ($log == 1047) {

  /**
   * 完善资料
   */
  if (strlen($WenTi) < 3 or strlen($DaAn) < 3)

    Plug_Echo_Info($user_str_log[1050], 1050);
 



  if ($WenTi == '' or $DaAn == '')

    Plug_Echo_Info($user_str_log[1020], 1020);
  $sql = "SELECT`user_mibao_wenti`,`user_mibao_daan`FROM`bs_php_user`WHERE`user_uid`={$uid}";
  $arr = Plug_Query_Assoc($sql);
  if (!$arr)

    Plug_Echo_Info($user_str_log[1022], 1022);
  if (empty($arr['user_mibao_wenti']) and empty($arr['user_mibao_daan'])) {
    $sql = "UPDATE`bs_php_user`SET`user_mibao_wenti`='{$WenTi}',`user_mibao_daan`='{$DaAn}'WHERE`bs_php_user`.`user_uid`='{$uid}';";
    $tmp = Plug_Query($sql);
    if ($tmp)

      Plug_Echo_Info($user_str_log[1024], 1024);
    else

      Plug_Echo_Info($user_str_log[1025], 1025);
  } else

    Plug_Echo_Info($user_str_log[1023], 1023);
}
Plug_Echo_Info($user_str_log[$log], $log);
