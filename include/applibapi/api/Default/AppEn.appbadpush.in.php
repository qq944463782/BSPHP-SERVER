<?php

/*
<api>
  <name>appbadpush.in</name>
  <title>上报异常提交日志</title>
  <intro>接口参数说明</intro>
  <common_params type="1">
    <param name="api" type="1" required="true" dtype="string" desc="API接口名称"></param>
    <param name="BSphpSeSsL" type="1" required="false" dtype="string" desc="BSphpSeSsL连接Cookies"></param>
    <param name="date" type="1" required="false" dtype="string" desc="服务器时间超时验证；可空，后台设置超时0即关闭"></param>
    <param name="mutualkey" type="1" required="true" dtype="string" desc="通信认证Key，用作软件数据包交换数据验证串"></param>
    <param name="appsafecode" type="1" required="false" dtype="string" desc="封包劫持检测；可空，客户端提交参数给服务器时原样返回"></param>
    <param name="md5" type="1" required="false" dtype="string" desc="程序MD5；可空，后台MD5内容要为空"></param>
  </common_params>
  <params>
    <param name="table" required="false" type="string" desc="日志内容（文本）"></param>
  </params>
</api>
*/

/***********************接口介绍说明******************************************
 * appbadpush.in
 * 上报异常提交日志（用于记录客户端异常/破解后提交信息）
 *
 * 请求参数：
 *   table = 日志内容文本
 *
 * 返回说明：
 *   成功：Plug_Echo_Info(1, 200)
 *   失败：按系统通用错误码返回
 *
 * 调用示例：
 *   &api=appbadpush.in&table=xxxxx
 *****************************************************************************
 */


$daihao = PLUG_DAIHAO();
$teble = Plug_Set_Data('table');                #日志内容
$uid = Plug_Get_Session_Value('USER_UID');


Plug_Add_AppenLog('od_po_log', $teble,$uid);

Plug_Echo_Info(1,200);