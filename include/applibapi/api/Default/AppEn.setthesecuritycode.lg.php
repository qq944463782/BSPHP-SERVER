<?php
/*
<api>
  <name>setthesecuritycode.lg</name>
  <title>设置登录用户密保问题与答案</title>
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
    <param name="problem" required="false" type="string" desc="密保问题（长度建议>=3）"></param>
    <param name="answer" required="false" type="string" desc="密保答案（长度建议>=3）"></param>
  </params>
</api>
*/



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
