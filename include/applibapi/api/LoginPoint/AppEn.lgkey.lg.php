<?php
/*
<api>
  <name>lgkey.lg</name>
  <title>取得登陆成功返回数据包</title>
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
 * lgkey.lg
 * 取得登陆成功返回数据包
 * *****************************************************************************
 */


$daihao = PLUG_DAIHAO();
$key = Plug_Set_data('key');
$uid = Plug_Get_Session_Value('USER_UID');

#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

//登录连接数功能集代码

$log = Plug_User_Is_Login_Seesion();
if ($log == 1047) {

  //    /**
  //     * 查询用户绑定key
  //     */
  if (Plug_App_data('app_set') == 1) {
    $user_arr = Plug_Get_App_User_Info($uid, $daihao);

    if ($key !== $user_arr['L_key_info']) Plug_Echo_Info('5034',5034);
  }



  //判断是否已经过期
  $arr = Plug_Get_App_User_Info($uid, $daihao);
  if (Plug_App_data('app_set') == 1 or $arr['L_vip_unix'] > 0) {
    Plug_Echo_Info(Plug_App_data('app_logininfo'));
  } else {
    Plug_Echo_Info(Plug_Lang('5033'), 5033);
  }
}
Plug_Echo_Info($user_str_log[$log], $log);
