<?php


/***********************接口介绍说明******************************************
 * setcode.lg
 * 检测密保信息是否填写
 * *****************************************************************************
 */

#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');


$uid = Plug_Get_Session_Value('USER_UID');



//登陆状态
$log = Plug_User_Is_Login_Seesion();
if ($log == 1047) {


  /**
   * 密保信息
   */

  $sql = "SELECT`user_mibao_wenti`,`user_mibao_daan`FROM`bs_php_user`WHERE`user_uid`='{$uid}'";
  $arr = Plug_Query_Assoc($sql);
  if (!$arr)

    Plug_Echo_Info($user_str_log[1022], 1022);
  if (empty($arr['user_mibao_wenti']) and empty($arr['user_mibao_daan'])) {

    Plug_Echo_Info($user_str_log[1051], 1051);
  } else
    Plug_Echo_Info($user_str_log[1023], 1023);
}
