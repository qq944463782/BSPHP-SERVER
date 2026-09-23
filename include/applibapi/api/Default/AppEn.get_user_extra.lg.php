<?php
/*
<api>
  <name>get_user_extra.lg</name>
  <title>获取用户拓展字段</title>
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
    <param name="api" required="true" type="string" desc="固定为 get_user_extra.lg"></param>
  </params>
</api>
*/

/**
 * **********************接口介绍说明******************************************
 * get_user_extra.lg
 * 获取当前登录用户 user_extra（JSON字符串）
 * 返回示例：{"姓名":"张三","学校":"xx中学"}
 * *****************************************************************************
 */

$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');

$uid = (int) Plug_Get_Session_Value('USER_UID');
$log = Plug_User_Is_Login_Seesion();
if ($log != 1047 || $uid <= 0) {
    Plug_Echo_Info($user_str_log[$log], $log);
}

$user_extra = Plug_Query_One('bs_php_user', 'user_uid', $uid, 'user_extra');
if (!is_string($user_extra) || $user_extra === '') {
    $user_extra = '{}';
}

$decoded = json_decode($user_extra, true);
if (!is_array($decoded)) {
    $decoded2 = json_decode(stripslashes((string)$user_extra), true);
    if (is_array($decoded2)) {
        $decoded = $decoded2;
    } else {
        $decoded = [];
    }
}

$result_json = json_encode($decoded, JSON_UNESCAPED_UNICODE);
Plug_Echo_Info($result_json, 200);
