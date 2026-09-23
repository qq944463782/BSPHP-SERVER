<?php
/*
<api>
  <name>CallRemote.in</name>
  <title>网关侨接数据</title>
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
    <param name="datas" required="false" type="string" desc="中转地址"></param>
  </params>
</api>
*/


/***********************接口介绍说明******************************************
 * CallRemote.in
 * 网关侨接数据
 * *****************************************************************************
 */


$datas = Plug_Set_Data('datas');   #中转地址
$url = Plug_Get_Configs_Value("" . 'sys', 'admin_mail');
if (strpos($url, ":") > 0) {
} else {
   $url = "127.0.0.1:3365";
}

$data = @file_get_contents("http://$url/?bsphp=1&data=$datas&endtime=" . time());
Plug_Echo_Info($data, 200);
