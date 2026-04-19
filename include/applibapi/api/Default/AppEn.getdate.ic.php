<?php
/*
<api>
  <name>getdate.ic</name>
  <title>取卡模式到期时间</title>
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
 * getdate.ic
 * 取卡模式到期时间
 * *****************************************************************************
 */

#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');



$car_id = Plug_Get_Session_Value('ic_carid');   #获取登录卡号
$car_pwd = Plug_Get_Session_Value('ic_pwd');    #获取登录的卡密码
$daihao = PLUG_DAIHAO();

$arr_log = Plug_Get_Card_Info($car_id, $car_pwd, $daihao);

if ($arr_log == 1083 || $arr_log == 1084) {

  Plug_Echo_Info($user_str_log[$arr_log], $arr_log);
} else {




  Plug_Echo_Info(date('Y-m-d H:i:s', $arr_log['L_vip_unix']), 200);
}
