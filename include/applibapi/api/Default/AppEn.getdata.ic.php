<?php
/*
<api>
  <name>getdata.ic</name>
  <title>取验证数据</title>
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
    <param name="key" required="false" type="string" desc="验证key"></param>
  </params>
</api>
*/




/***********************接口介绍说明******************************************
 * getdata.ic
 * 取验证数据
 * *****************************************************************************
 */
#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

$car_id = Plug_Get_Session_Value('ic_carid');
$car_pwd = Plug_Get_Session_Value('ic_pwd');
$daihao = PLUG_DAIHAO();

$key = Plug_Set_Data('key');   #验证key



//获取验证信息 COOKIE内之了
$log = Plug_App_Is_Login($car_id, $car_pwd, $daihao);

if ($log == 1080) {
  //查询信息
  $arr_log = Plug_Get_Card_Info($car_id, $car_pwd, $daihao);


  if ($arr_log['L_key_info'] == $key or Plug_App_DaTa('app_set') == 0) {
    Plug_Echo_Info(Plug_App_DaTa('app_logininfo'));
  } else {
    Plug_Echo_Info(Plug_Lang('5033'),5033);
  }
} else {
  Plug_Echo_Info($user_str_log[$log],$log);
}
