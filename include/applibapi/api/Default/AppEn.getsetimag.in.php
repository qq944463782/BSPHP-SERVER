<?php
/*
<api>
  <name>getsetimag.in</name>
  <title>获取验证码是否开启</title>
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
    <param name="type" required="false" type="string" desc="传递INGES_LOGIN INGES_RE INGES_MACK INGES_SAY，checked被替换就是开启了"></param>
  </params>
</api>
*/



/***********************接口介绍说明******************************************
 * getsetimag.in
 * 获取验证码是否开启
 * 通过软件后台配置列表比对
 * *****************************************************************************
 */

$type = Plug_Set_Data('type');//传递INGES_LOGIN INGES_RE INGES_MACK INGES_SAY，checked被替换就是开启了


if (stristr($type, 'INGES_LOGIN')) {
    if (stristr(Plug_App_DaTa('app_coode'), 'login.lg')) {
        $type = str_replace('INGES_LOGIN', 'checked', $type);
    }
}
if (stristr($type, 'INGES_RE')) {


    if (stristr(Plug_App_DaTa('app_coode'), 'registration.lg')) {
        $type = str_replace('INGES_RE', 'checked', $type);
    }
}
if (stristr($type, 'INGES_MACK')) {


    if (stristr(Plug_App_DaTa('app_coode'), 'backto.lg')) {
        $type = str_replace('INGES_MACK', 'checked', $type);
    }
}
if (stristr($type, 'INGES_SAY')) {


    if (stristr(Plug_App_DaTa('app_coode'), 'liuyan.in')) {
        $type = str_replace('INGES_SAY', 'checked', $type);
    }
}


Plug_Echo_Info($type,200);
