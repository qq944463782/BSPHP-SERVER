<?php
/*
<api>
  <name>GetPleaseregister.lg</name>
  <title>检测账号是否存在</title>
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
    <param name="user" required="false" type="string" desc="需要检测的账号"></param>
  </params>
</api>
*/




/***********************接口介绍说明******************************************
 * GetPleaseregister.lg
 * 检测账号是否存在
 * *****************************************************************************
 */
#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');
$daihao = PLUG_DAIHAO();
$user = Plug_Set_Data('user');   #需要检测的账号

//获取用户信息
$sql = "SELECT*FROM`bs_php_user`WHERE`user_user`='$user';";
$user_array = Plug_Query_Assoc($sql);
if (!$user_array) {
  Plug_Echo_Info(Plug_Lang('[1001],账号不存在'), '1001');
}
Plug_Echo_Info(Plug_Lang('账号已经存在'), -1);
