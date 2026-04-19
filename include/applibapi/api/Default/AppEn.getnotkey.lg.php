<?php
/*
<api>
  <name>getnotkey.lg</name>
  <title>查询绑定key是否存在</title>
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
    <param name="key" required="false" type="string" desc="需要查询特征码"></param>
  </params>
</api>
*/



/***********************接口介绍说明******************************************
 * getnotkey.lg
 * 查询绑定key是否存在
 * *****************************************************************************
 */


$daihao = PLUG_DAIHAO();
$key = Plug_Set_Data('key');   #需要查询特征码
//查询该key是否已经在数据库
$sql = "SELECT*FROM`bs_php_pattern_login`WHERE`L_daihao`='{$daihao}'AND`L_key_info`= '{$key}' LIMIT 1;";
$zhong_arr = Plug_Query_Assoc($sql);
if ($zhong_arr) {
  //重覆返回
  Plug_Echo_Info('10089', 10089);
} else {
  //没有重覆返回
  Plug_Echo_Info('10809', 10809);
}
