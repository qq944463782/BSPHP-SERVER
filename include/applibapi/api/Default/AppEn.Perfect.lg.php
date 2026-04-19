<?php
/*
<api>
  <name>Perfect.lg</name>
  <title>完善用户资料</title>
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
    <param name="qq" required="false" type="string" desc="联系QQ"></param>
    <param name="mail" required="false" type="string" desc="联系邮箱"></param>
    <param name="mobile" required="false" type="string" desc="手机号"></param>
  </params>
</api>
*/



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
