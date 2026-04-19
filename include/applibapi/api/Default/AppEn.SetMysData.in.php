<?php
/*
<api>
  <name>SetMysData.in</name>
  <title>远程配置设置</title>
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
    <param name="keys" required="false" type="string" desc="键值"></param>
    <param name="datas" required="false" type="string" desc="存储参数，如果特殊内容建议base64编码或者utl编码等编码测试"></param>
  </params>
</api>
*/


/***********************接口介绍说明******************************************
 * SetMysData.in
 * 远程配置设置
 * *****************************************************************************
 */

$keys = Plug_Set_Data('keys');   #键值
$datas = Plug_Set_Data('datas'); #存储参数，如果特殊内容建议base64编码或者utl编码等编码测试


$tmp = Plug_Set_mydata($keys, $datas);
if ($tmp) {
	//保存成功
	Plug_Echo_Info('ok', 200);
} else {
	//保存失败
	Plug_Echo_Info('no', 200);
}
