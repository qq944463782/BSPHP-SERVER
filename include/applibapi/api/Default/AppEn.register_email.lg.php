<?php
/***********************接口介绍说明******************************************
 * register_email.lg
 * 邮箱验证码注册
 *
 * 请求参数：
 *   user      = 用户名
 *   email     = 邮箱地址
 *   email_code= 邮箱验证码
 *   pwd       = 密码
 *   pwdb      = 确认密码
 *   key       = 绑定特征/机器码
 *   coode     = 图像验证码（若软件配置开启）
 *   BSphpSeSsL = 会话标识
 *
 * 返回说明：
 *   成功：Plug_Echo_Info(消息, 1005)
 *   失败：Plug_Echo_Info(错误信息, 错误码)
 *****************************************************************************
 */

$user_str_log = plug_load_langs_array('user', 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');
$daihao = PLUG_DAIHAO();

if ((int)Plug_Get_Configs_Value('user', 'user_re_set') !== 1) {
    Plug_Echo_Info(Plug_Lang('当前系统已关闭注册功能'), -1);
    exit;
}

$user      = trim(Plug_Set_Data('user'));
$email      = strtolower(trim(Plug_Set_Data('email')));
$email_code = Plug_Set_Data('email_code');
$pwd        = Plug_Set_Data('pwd');
$pwdb       = Plug_Set_Data('pwdb');
$key        = Plug_Set_Data('key');
$coode      = Plug_Set_Data('coode');


if ($user == '' ) {
    Plug_Echo_Info(Plug_Lang('请填写用户名.'), -1);
    exit;
}

if ($email == '' ) {
    Plug_Echo_Info(Plug_Lang('请填写邮箱.'), -1);
    exit;
}
if ($email_code == '' ) {
    Plug_Echo_Info(Plug_Lang('请填写邮箱验证码.'), -1);
    exit;
}
if ($pwd == '' ) {
    Plug_Echo_Info(Plug_Lang('请填写密码.'), -1);
    exit;
}
if ($pwdb == '' ) {
    Plug_Echo_Info(Plug_Lang('请填写确认密码.'), -1);
    exit;
}


if ($pwd !== $pwdb) {
    Plug_Echo_Info(Plug_Lang('两次密码不一致.'), -1);
    exit;
}
if (!PiPei($email, 3)) {
    Plug_Echo_Info(Plug_Lang('邮箱格式不正确.'), -1);
    exit;
}

if (stristr(Plug_App_DaTa('app_coode'), 'register_email.lg')) {
    $log_img = Plug_Push_Cood_Imges($coode);
    if ((int)$log_img !== 1037) {
        Plug_Echo_Info(Plug_Lang('验证码错误'), -11111);
        exit;
    }
}

if (!Plug_Otp_Verify_Email('register', $email, $email_code)) {
    Plug_Echo_Info(Plug_Lang('验证码错误或已过期.'), -1);
    exit;
}



$log = Plug_User_Re_Add($user, $pwd, $pwdb, '', $email, '', '', '', '');

if ($log == 1005) {
    $gift_value = (int)Plug_App_DaTa('app_re_date');
    $app_moshi  = (string)Plug_App_DaTa('app_MoShi');
    $is_point_mode = ($app_moshi === 'LoginPoint' || $app_moshi === 'CardPoint');
    $date = $is_point_mode ? $gift_value : (PLUG_UNIX() + $gift_value);
    $uid  = Plug_Query_One('bs_php_user', 'user_user', $user, '`user_uid`');
    Plug_App_Login_Add_Key($uid, $daihao, $date, $key, $user, $user);

    if ($gift_value == 0) {
        Plug_Echo_Info(Plug_Lang('注册成功'), 1005);
    } elseif ($is_point_mode) {
        Plug_Echo_Info(Plug_Lang('注册成功,恭喜你获得了') . $gift_value . Plug_Lang('点数'), 1005);
    } else {
        $s = $gift_value / 3600;
        Plug_Echo_Info(Plug_Lang('注册成功,恭喜你获得了') . round($s, 1) . Plug_Lang('小时的使期限'), 1005);
    }
} else {
    Plug_Echo_Info(isset($user_str_log[$log]) ? $user_str_log[$log] : Plug_Lang('注册失败'), $log);
}
