<?php
/***********************接口介绍说明******************************************
 * resetpwd_sms.lg
 * 手机短信验证码找回密码
 *
 * 请求参数：
 *   mobile   = 手机号
 *   area     = 区号，默认86
 *   sms_code = 短信验证码
 *   pwd      = 新密码
 *   pwdb     = 确认新密码
 *   coode    = 图像验证码（若软件配置开启）
 *   BSphpSeSsL = 会话标识
 *
 * 返回说明：
 *   成功：Plug_Echo_Info(消息, 1033)
 *   失败：Plug_Echo_Info(错误信息, 错误码)
 *****************************************************************************
 */

$mobile   = Plug_Set_Data('mobile');
$area     = trim(Plug_Set_Data('area'));
if ($area == '') $area = '86';
$sms_code = Plug_Set_Data('sms_code');
$pwd      = Plug_Set_Data('pwd');
$pwdb     = Plug_Set_Data('pwdb');
$coode    = Plug_Set_Data('coode');

if ($mobile == '' || $sms_code == '' || $pwd == '' || $pwdb == '') {
    Plug_Echo_Info(Plug_Lang('请填写手机号、验证码和新密码.'), -1);
    exit;
}
if ($pwd !== $pwdb) {
    Plug_Echo_Info(Plug_Lang('两次密码不一致.'), -1);
    exit;
}

if (stristr(Plug_App_DaTa('app_coode'), 'resetpwd_sms.lg')) {
    $log_img = Plug_Push_Cood_Imges($coode);
    if ((int)$log_img !== 1037) {
        Plug_Echo_Info(Plug_Lang('验证码错误'), -11111);
        exit;
    }
}

if (!Plug_Otp_Verify_Sms('reset', $area, $mobile, $sms_code)) {
    Plug_Echo_Info(Plug_Lang('验证码错误或已过期.'), -1);
    exit;
}

$mobile_safe = addslashes(preg_replace('/[^0-9]/', '', $mobile));
$row = Plug_Query_Assoc("SELECT `user_uid` FROM `bs_php_user` WHERE `user_Mobile`='{$mobile_safe}' LIMIT 1");
if (!$row) {
    Plug_Echo_Info(Plug_Lang('手机号未绑定任何账号.'), -1);
    exit;
}

$uid    = (int)$row['user_uid'];
$pwd_md = Plug_Password_Md6($pwd);
Plug_Query("UPDATE `bs_php_user` SET `user_pwd`='{$pwd_md}' WHERE `user_uid`='{$uid}' LIMIT 1");

Plug_Echo_Info(Plug_Lang('密码已重置'), 1033);
