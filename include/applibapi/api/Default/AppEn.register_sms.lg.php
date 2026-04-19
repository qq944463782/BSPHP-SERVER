<?php
/*
<api>
  <name>register_sms.lg</name>
  <title>手机短信验证码注册</title>
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
    <param name="user" required="false" type="string" desc="用户名"></param>
    <param name="mobile" required="false" type="string" desc="手机号"></param>
    <param name="area" required="false" type="string" desc="国际区号"></param>
    <param name="sms_code" required="false" type="string" desc="短信验证码"></param>
    <param name="pwd" required="false" type="string" desc="密码"></param>
    <param name="pwdb" required="false" type="string" desc="确认密码"></param>
    <param name="key" required="false" type="string" desc="绑定特征/机器码"></param>
    <param name="user_extra" required="false" type="string" desc="用户拓展字段(JSON文本字符串)"></param>
    <param name="coode" required="false" type="string" desc="图形验证码"></param>
  </params>
</api>
*/

/***********************接口介绍说明******************************************
 * register_sms.lg
 * 手机短信验证码注册
 *
 * 请求参数：
 *   user     = 用户名
 *   mobile   = 手机号
 *   area     = 区号，默认86
 *   sms_code = 短信验证码
 *   pwd      = 密码
 *   pwdb     = 确认密码
 *   key      = 绑定特征/机器码
 *   user_extra = 用户拓展字段(JSON文本字符串)
 *   coode    = 图像验证码（若软件配置开启）
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
$mobile   = Plug_Set_Data('mobile');
$area     = trim(Plug_Set_Data('area'));
if ($area == '') $area = '86';
$sms_code = Plug_Set_Data('sms_code');
$pwd      = Plug_Set_Data('pwd');
$pwdb     = Plug_Set_Data('pwdb');
$key      = Plug_Set_Data('key');
$user_extra = Plug_Set_Data('user_extra');
$coode    = Plug_Set_Data('coode');

if ($user == '' ) {
    Plug_Echo_Info(Plug_Lang('请填写用户名.'), -1);
    exit;
}
if ($mobile == '' ) {
    Plug_Echo_Info(Plug_Lang('请填写手机号.'), -1);
    exit;
}
if ($sms_code == '' ) {
    Plug_Echo_Info(Plug_Lang('请填写短信验证码.'), -1);
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

// if (stristr(Plug_App_DaTa('app_coode'), 'register_sms.lg')) {
//     $log_img = Plug_Push_Cood_Imges($coode);
//     if ((int)$log_img !== 1037) {
//         Plug_Echo_Info(Plug_Lang('验证码错误'), -11111);
//         exit;
//     }
// }

if (!Plug_Otp_Verify_Sms('register', $area, $mobile, $sms_code)) {
    Plug_Echo_Info(Plug_Lang('手机短信验证码错误或已过期.'), -1);
    exit;
}

$mobile_clean = preg_replace('/[^0-9]/', '', $mobile);
$log          = Plug_User_Re_Add($user, $pwd, $pwdb, '', '', '', $mobile_clean, '', '', $user_extra);

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
