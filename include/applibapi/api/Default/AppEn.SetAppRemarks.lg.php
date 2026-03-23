<?php


/***********************接口介绍说明******************************************
 * SetAppRemarks.lg
 * 用户漫游配置
 * *****************************************************************************
 */

#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

$daihao = PLUG_DAIHAO();
$uid = Plug_Get_Session_Value('USER_UID');


$remarks = Plug_Set_Data('remarks');  #保存用户数据 -1为读取


//登陆状态
$log = Plug_User_Is_Login_Seesion();
if ($log == 1047) {


   //$remarks
   if ($remarks == '-1') {

      $arr = Plug_Get_App_User_Info($uid, $daihao);
      Plug_Echo_Info($arr['L_links_info'],200);
   }



   $sql = "UPDATE`bs_php_pattern_login`SET `L_links_info` = '$remarks' WHERE `L_User_uid`='$uid';";
   $tmp = Plug_Query($sql);
   if ($tmp) {
      Plug_Echo_Info('10001',10001);
   } else {
      Plug_Echo_Info('10002',10002);
   }
}

Plug_Echo_Info($user_str_log[$log]);
