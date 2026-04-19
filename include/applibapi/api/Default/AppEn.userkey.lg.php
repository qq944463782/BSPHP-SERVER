<?php
/*
<api>
  <name>userkey.lg</name>
  <title>取用户绑定key</title>
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
    <param name="" required="false" type="string" desc="参数说明"></param>
  </params>
</api>
*/



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
