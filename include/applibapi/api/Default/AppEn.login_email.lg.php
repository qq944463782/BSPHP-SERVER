<?php
/***********************接口介绍说明******************************************
 * login_email.lg
 * 邮箱验证码登陆
 *
 * 请求参数：
 *   email     = 邮箱地址
 *   email_code= 邮箱验证码
 *   key       = 绑定特征/机器码
 *   maxoror   = 控制多开机器数量
 *   coode     = 图像验证码（若软件配置开启）
 *   BSphpSeSsL = 会话标识
 *
 * 返回说明：
 *   成功：与 login.lg 相同格式 01|1011|key|logininfo|vipdate
 *   失败：Plug_Echo_Info(错误信息, 错误码)
 *****************************************************************************
 */

$user_str_log = plug_load_langs_array('user', 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');
$daihao = PLUG_DAIHAO();

if (Plug_App_DaTa('app_MoShi') !== 'LoginTerm') {
    Plug_Echo_Info($appen_str_log[5057], 5057);
    exit;
}

$email      = trim(Plug_Set_Data('email'));
$email_code = Plug_Set_Data('email_code');
$key        = Plug_Set_Data('key');
$maxoror    = Plug_Set_Data('maxoror');
$coode      = Plug_Set_Data('coode');

if ($email == '') {
    Plug_Echo_Info(Plug_Lang('请填写邮箱.'), -1);
    exit;
}
if ($email_code == '') {
    Plug_Echo_Info(Plug_Lang('请输入邮箱验证码.'), -1);
    exit;
}



if (!Plug_Otp_Verify_Email('login', $email, $email_code)) {
    Plug_Echo_Info(Plug_Lang('邮箱验证码错误或已过期.'), -1);
    exit;
}

$email_safe = addslashes($email);
$sql = "SELECT `user_uid`,`user_user`,`user_pwd`,`user_IsLock` FROM `bs_php_user` WHERE `user_email` = '{$email_safe}' LIMIT 1";
$row = Plug_Query_Assoc($sql);
if (!$row) {
    Plug_Echo_Info(Plug_Lang('该邮箱未绑定任何账号.'), -1);
    exit;
}
if ((int)$row['user_IsLock'] !== 0) {
    Plug_Echo_Info(Plug_Lang('账号已被锁定或未激活.'), 1021);
    exit;
}

$uid  = (int)$row['user_uid'];
$user = $row['user_user'];
$pwd_hash = $row['user_pwd'];
$param_date = PLUG_DATE();
$param_ip   = Plug_Get_IP();
$param_UNIX = PLUG_UNIX();

$update_sql = "UPDATE `bs_php_user` SET `user_DenJi_tmp`='{$param_UNIX}',`user_Login_ip`='{$param_ip}',`user_Login_date`='{$param_date}',`user_CaoShi`='{$param_UNIX}',`user_LoGinNum`=`user_LoGinNum`+1 WHERE `user_uid`='{$uid}'";
Plug_Query($update_sql);

$param_cookies_pwd  = Plug_Cookies_Md7($pwd_hash);
$param_LoGinNumFlag = 'ALL';
$param_cookies_md7  = Plug_Cookies_Md7($uid . $param_cookies_pwd . $param_date . $param_ip . $param_LoGinNumFlag);

plug_set_session_value('USER_UID', $uid);
plug_set_session_value('USER_YSE', $param_cookies_pwd);
plug_set_session_value('USER_DATE', $param_date);
plug_set_session_value('USER_IP', $param_ip);
plug_set_session_value('USER_MD7', $param_cookies_md7);

$arr = Plug_Get_App_User_Info($uid, $daihao);
if (!$arr) {
    $date = (int)Plug_App_DaTa('app_re_date');
    $date = PLUG_UNIX() + $date;
    $sql = "SELECT*FROM`bs_php_pattern_login`WHERE`L_daihao`='{$daihao}'AND`L_key_info`= '{$key}' LIMIT 1;";
    $zhong_arr = Plug_Query_Assoc($sql);
    if ($zhong_arr && Plug_App_DaTa('app_key_zhong') == 1) {
        Plug_Echo_Info(Plug_Lang('[5009]绑定特征码,已经有人绑定过了,不能重复绑定,不能登陆'), 5009);
        exit;
    }
    if (Plug_App_Login_Add_Key($uid, $daihao, $date, $key, $user, $user)) {
        $arr = Plug_Get_App_User_Info($uid, $daihao);
    } else {
        Plug_Echo_Info(Plug_Lang('注册新用户失败,请联系管理员！'), -200);
        exit;
    }
}

if ($arr['L_IsLock'] > 0) {
    Plug_Echo_Info(Plug_Lang('当前账号已经被冻结禁止登录当前软件.'), -200);
    exit;
}

$date = PLUG_DATE();
$sql = "UPDATE`bs_php_pattern_login`SET`L_login_time`='$date'WHERE`bs_php_pattern_login`.`L_User_uid`='$uid'AND`bs_php_pattern_login`.`L_daihao`='$daihao';";
Plug_Query($sql);

$log = Plug_Login_Multi_Control($user, $daihao, $maxoror, $uid);
if ($log != 5047) {
    Plug_Echo_Info($appen_str_log[$log], $log);
    exit;
}

Plug_Add_AppenLog('user_login_log', Plug_Lang('软件登录 机器码:') . $key, $user);

$uesr_key = $arr['L_key_info'];
$uesr_vipdate = $arr['L_vip_unix'];
$login_info = null;
if (($key == $uesr_key && $uesr_key != '') || Plug_App_DaTa('app_set') == 0) {
    $login_info = Plug_App_DaTa('app_logininfo');
}

Plug_Links_Add_Info($uid, $user, $key, $daihao, $maxoror);

if ($arr['L_vip_unix'] > PLUG_UNIX()) {
    if (Plug_App_DaTa('app_set') == 1 && $arr['L_key_info'] !== $key) {
        if ($arr['L_key_info'] == '') {
            Plug_Echo_Info(Plug_Lang("还没有绑定,请绑定在登录"), -3);
            exit;
        }
        Plug_Echo_Info('[5035]' . $appen_str_log[5035], 5035);
        exit;
    }
    $UNIX = PLUG_UNIX();
    $sql = "UPDATE`bs_php_pattern_login`SET`L_timing`='$UNIX'WHERE`bs_php_pattern_login`.`L_User_uid`='$uid'AND`bs_php_pattern_login`.`L_daihao`='$daihao';";
    Plug_Query($sql);
    $uesr_vipdate = date('Y-m-d H:i:s', $uesr_vipdate);
    Plug_Echo_Info("01|1011|$uesr_key|$login_info|$uesr_vipdate|||||", 1011);
} else {
    Plug_Echo_Info(Plug_Lang('[9908]使用已经到期.'), 9908);
}
