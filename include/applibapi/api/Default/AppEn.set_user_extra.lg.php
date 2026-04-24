<?php
/*
<api>
  <name>set_user_extra.lg</name>
  <title>修改用户拓展字段</title>
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
    <param name="user_extra" required="true" type="string" desc="用户拓展字段(JSON字符串)，按键合并到现有 user_extra"></param>
  </params>
</api>
*/

/**
 * **********************接口介绍说明******************************************
 * set_user_extra.lg
 * 修改当前登录用户 user_extra（JSON合并更新）
 * 规则：新传入JSON按键覆盖旧值；未传入键保留原值
 * 请求示例：user_extra={"班级":"高三1班","姓名":"李四"}
 * 返回示例：{"姓名":"李四","学校":"xx中学","班级":"高三1班"}
 * *****************************************************************************
 */

$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');

$uid = (int) Plug_Get_Session_Value('USER_UID');
$log = Plug_User_Is_Login_Seesion();
if ($log != 1047 || $uid <= 0) {
    Plug_Echo_Info($user_str_log[$log], $log);
}

$incoming_raw = Plug_Set_Data('user_extra');
if (!is_string($incoming_raw) || trim($incoming_raw) === '') {
    Plug_Echo_Info('user_extra json empty', -1);
}

$incoming = json_decode($incoming_raw, true);
if (!is_array($incoming)) {
    Plug_Echo_Info('user_extra json invalid', -1);
}

$old_raw = Plug_Query_One('bs_php_user', 'user_uid', $uid, 'user_extra');
if (!is_string($old_raw) || $old_raw === '') {
    $old_raw = '{}';
}
$old = json_decode($old_raw, true);
if (!is_array($old)) {
    $old2 = json_decode(stripslashes((string)$old_raw), true);
    $old = is_array($old2) ? $old2 : [];
}

$old_safe = [];
foreach ($old as $k => $v) {
    $old_safe[(string)$k] = is_scalar($v) ? (string)$v : '';
}

$new_safe = [];
foreach ($incoming as $k => $v) {
    $new_safe[(string)$k] = is_scalar($v) ? (string)$v : '';
}

$merged = array_merge($old_safe, $new_safe);
$merged_json = json_encode($merged, JSON_UNESCAPED_UNICODE);
$merged_sql = addslashes($merged_json);

$sql = "UPDATE`bs_php_user`SET`user_extra`='{$merged_sql}' WHERE `user_uid`='{$uid}';";
$tmp = Plug_Query($sql);
if (!$tmp) {
    Plug_Echo_Info('set user_extra fail', -2);
}

Plug_Echo_Info($merged_json, 200);
