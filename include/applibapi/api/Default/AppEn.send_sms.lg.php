<?php
/***********************接口介绍说明******************************************
 * send_sms.in
 * 发送手机短信验证码（带图像验证码）
 *
 * 请求参数：
 *   scene   = 场景：login|register|reset
 *   mobile  = 手机号
 *   area    = 区号，默认86
 *   coode   = 图像验证码（必填）
 *   BSphpSeSsL = 会话标识（必填，用于存储验证码）
 *
 * 返回说明：
 *   成功：Plug_Echo_Info(消息, 200)
 *   失败：Plug_Echo_Info(错误信息, 错误码)
 *
 * 调用示例：
 *   &api=send_sms.in&scene=register&mobile=13800138000&area=86&coode=xxxx&BSphpSeSsL=xxx
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
$mobile = Plug_Set_Data('mobile');
$area   = trim(Plug_Set_Data('area'));
if ($area == '') $area = '86';

if ($mobile == '') {
    Plug_Echo_Info(Plug_Lang('请填写手机号.'), -1);
    exit;
}

$mobile_safe = addslashes(preg_replace('/[^0-9]/', '', $mobile));
if ($mobile_safe === '') {
    Plug_Echo_Info(Plug_Lang('手机号格式不正确.'), -1);
    exit;
}
if ($scene === 'login') {
    $sql = "SELECT 1 FROM `bs_php_user` WHERE `user_Mobile` = '{$mobile_safe}' LIMIT 1";
    $user = Plug_Query_Assoc($sql);
    if (!$user) {
        Plug_Echo_Info(Plug_Lang('手机号未绑定任何账号.'), -1);
        exit;
    }
} elseif ($scene === 'register') {
    $sql = "SELECT 1 FROM `bs_php_user` WHERE `user_Mobile` = '{$mobile_safe}' LIMIT 1";
    $user = Plug_Query_Assoc($sql);
    if ($user) {
        Plug_Echo_Info(Plug_Lang('当前手机号已经注册过，可直接用手机登录'), -1);
        exit;
    }
}

$code = '';
for ($i = 0; $i < 4; $i++) {
    $code .= mt_rand(0, 9);
}
Plug_Otp_Set_Sms($scene, $area, $mobile, $code);

$ret = Plug_Send_Sms_Code($area, $mobile, $code);

// 系统日志记录：发短信
$scene_log  = (string)$scene;
$area_log   = (string)$area;
$mobile_log = (string)$mobile_safe;
$log_user   = substr((string)$mobile_safe, 0, 20);

if (isset($ret['code']) && (int)$ret['code'] === 0) {
    $code_log = (string)$code;
    $log_content = 'scene=' . $scene_log . '|area=' . $area_log . '|mobile=' . $mobile_log . '|code=' . $code_log . '|result=success';
    Plug_Add_AppenLog('sms_log', $log_content, $log_user);
    Plug_Echo_Info(Plug_Lang('验证码已发送，请查收手机'), 200);
} else {
    $msg = isset($ret['msg']) ? $ret['msg'] : Plug_Lang('发送失败');
    $msg_str = is_string($msg) ? $msg : json_encode($msg, JSON_UNESCAPED_UNICODE);
    $msg_str = (string)$msg_str;

    $code_log = (string)$code;
    $log_content = 'scene=' . $scene_log . '|area=' . $area_log . '|mobile=' . $mobile_log . '|code=' . $code_log . '|result=fail:' . $msg_str;
    Plug_Add_AppenLog('sms_log', $log_content, $log_user);

    Plug_Echo_Info($msg, -1);
}
