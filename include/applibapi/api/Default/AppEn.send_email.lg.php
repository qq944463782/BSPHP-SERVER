<?php
/*
<api>
  <name>send_email.lg</name>
  <title>send_email.in</title>
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
    <param name="BSphpSeSsL" required="false" type="string" desc="会话标识"></param>
    <param name="coode" required="false" type="string" desc="图形验证码"></param>
    <param name="scene" required="false" type="string" desc="参数说明"></param>
    <param name="email" required="false" type="string" desc="邮箱地址"></param>
  </params>
</api>
*/

/***********************接口介绍说明******************************************
 * send_email.in
 * 发送邮箱验证码（带图像验证码）
 *
 * 请求参数：
 *   scene   = 场景：login|register|reset
 *   email   = 邮箱地址
 *   coode   = 图像验证码（必填）
 *   BSphpSeSsL = 会话标识（必填，用于存储验证码）
 *
 * 返回说明：
 *   成功：Plug_Echo_Info(消息, 200)
 *   失败：Plug_Echo_Info(错误信息, 错误码)
 *
 * 调用示例：
 *   &api=send_email.in&scene=register&email=user@example.com&coode=xxxx&BSphpSeSsL=xxx
 *****************************************************************************
 */

$BSphpSeSsL = Plug_Set_Data('BSphpSeSsL');
if ($BSphpSeSsL == '') {
    Plug_Echo_Info(Plug_Lang('BSphpSeSsL必须传入'), -1);
    exit;
}

$coode = Plug_Set_Data('coode');
if ($coode == '') {
    Plug_Echo_Info(Plug_Lang('请输入图片验证码.'), -1);
    exit;
}
$log = Plug_Push_Cood_Imges($coode);
if ((int)$log !== 1037) {
    Plug_Echo_Info(Plug_Lang('图片验证码错误'), -11111);
    exit;
}

$scene = Plug_Set_Data('scene');
if (!in_array($scene, array('login', 'register', 'reset'), true)) {
    $scene = 'login';
}
$email = trim(Plug_Set_Data('email'));
if ($email == '') {
    Plug_Echo_Info(Plug_Lang('请填写邮箱.'), -1);
    exit;
}
if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
    Plug_Echo_Info(Plug_Lang('邮箱格式不正确.'), -1);
    exit;
}

$email_safe = strtolower(trim(addslashes($email)));
if ($scene === 'login') {
    $sql = "SELECT 1 FROM `bs_php_user` WHERE `user_email` = '{$email_safe}' LIMIT 1";
    $row = Plug_Query_Assoc($sql);
    if (!$row) {
        Plug_Echo_Info(Plug_Lang('该邮箱未绑定任何账号.'), -1);
        exit;
    }
} elseif ($scene === 'register') {
    $sql = "SELECT 1 FROM `bs_php_user` WHERE `user_email` = '{$email_safe}' LIMIT 1";
    $row = Plug_Query_Assoc($sql);
    if ($row) {
        Plug_Echo_Info(Plug_Lang('当前邮箱已经注册过，可直接用邮箱登录。'), -1);
        exit;
    }
}

$code = '';
for ($i = 0; $i < 6; $i++) {
    $code .= mt_rand(0, 9);
}
Plug_Otp_Set_Email($scene, $email, $code);

$site_name = Plug_Get_Configs_Value('sys', 'name');
$subject   = $site_name . ' - ' . Plug_Lang('验证码');
$body      = Plug_Lang('您的验证码是：') . $code . '，300秒内有效，请勿泄露。';
$ret       = Plug_Send_tomail($email, $subject, $body);

// 系统日志记录：发邮件
$scene_log  = (string)$scene;
$email_log  = (string)$email;
$email_local = preg_replace('/@.*$/', '', (string)$email);
$log_user   = substr((string)$email_local, 0, 20);

if ($ret == 1 || $ret === true) {
    $code_log = (string)$code;
    $log_content = 'scene=' . $scene_log . '|email=' . $email_log . '|code=' . $code_log . '|result=success';
    Plug_Add_AppenLog('email_log', $log_content, $log_user);
    Plug_Echo_Info(Plug_Lang('验证码已发送，请查收邮件'), 200);
} else {
    $ret_str = is_string($ret) ? $ret : json_encode($ret, JSON_UNESCAPED_UNICODE);
    $ret_str = (string)$ret_str;
    $code_log = (string)$code;
    $log_content = 'scene=' . $scene_log . '|email=' . $email_log . '|code=' . $code_log . '|result=fail:' . $ret_str;
    Plug_Add_AppenLog('email_log', $log_content, $log_user);
    Plug_Echo_Info(Plug_Lang('发送失败') . (is_string($ret) ? ': ' . $ret : ''), -1);
}
