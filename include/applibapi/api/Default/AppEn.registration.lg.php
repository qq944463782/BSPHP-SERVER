<?php
/*
<api>
  <name>registration.lg</name>
  <title>注册账号</title>
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
    <param name="user" required="false" type="string" desc="注册账号"></param>
    <param name="pwd" required="false" type="string" desc="注册登录密码"></param>
    <param name="pwdb" required="false" type="string" desc="再次输入密码"></param>
    <param name="qq" required="false" type="string" desc="联系qq"></param>
    <param name="mail" required="false" type="string" desc="联系邮箱"></param>
    <param name="key" required="false" type="string" desc="绑定特征/机器码"></param>
    <param name="img" required="false" type="string" desc="开启验证码接到的验证码"></param>
    <param name="mobile" required="false" type="string" desc="联系电话"></param>
    <param name="mibao_wenti" required="false" type="string" desc="密保问题"></param>
    <param name="mibao_daan" required="false" type="string" desc="密保答案"></param>
    <param name="extension" required="false" type="string" desc="邀请人UID"></param>
    <param name="user_extra" required="false" type="string" desc="全局用户拓展字段(JSON文本字符串)"></param>
    <param name="app_user_extra" required="false" type="string" desc="软件用户拓展字段(JSON文本字符串)"></param>
  </params>
</api>
*/



/***********************接口介绍说明******************************************
 * registration.lg
 * 注册账号
 *
 * 请求参数补充：
 *   user_extra = 用户拓展字段(JSON文本字符串)
 *   示例：&user_extra={"key1":"","key2":"","key3":""}
 * *****************************************************************************
 */
#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

$daihao = PLUG_DAIHAO();


$user = Plug_Set_Data('user');       #注册账号
$pwd = Plug_Set_Data('pwd');         #注册登录密码
$pwdb = Plug_Set_Data('pwdb');       #再次输入密码
$qq = Plug_Set_Data('qq');           #联系qq
$mail = strtolower(trim((string)Plug_Set_Data('mail')));       #联系邮箱（统一小写）

$key = Plug_Set_Data('key');          #绑定特征/机器码
$img = Plug_Set_Data('img');          #开启验证码接到的验证码





$Mobile = Plug_Set_Data('mobile');    #联系电话
$user_mibao_wenti = Plug_Set_Data('mibao_wenti');    #密保问题
$user_mibao_daan = Plug_Set_Data('mibao_daan');      #密保答案

$extension = Plug_Set_Data('extension');    #邀请人UID
$user_extra = Plug_Set_Data('user_extra');  #全局用户拓展字段(JSON文本字符串)
$app_user_extra = Plug_Set_Data('app_user_extra');  #软件用户拓展字段(JSON文本字符串)


/**
 * 判断检测账号重复
 */

$sql = "SELECT*FROM`bs_php_pattern_login`WHERE`L_daihao`='$daihao'AND`L_key_info`LIKE '$key';";
$tmp = Plug_Query_Assoc($sql);

if (Plug_App_DaTa('app_key_zhong') == 1 & is_array($tmp)) {

    
    Plug_Echo_Info(Plug_Lang('[5010],当前账号已经注册过,无法在同一环境注册多个账号'), 5010);
}


/**
 * 判断邀请注册IUD是否存在
 */
if ($extension > 0) {
    $uid_extension = Plug_Query_One('bs_php_user', 'user_uid', $extension, '`user_uid`');
    if (!$uid_extension)
        Plug_Echo_Info(Plug_Lang('推荐人错误,没有请不要填写！'), -2);
}

/**
 * 用户注册
 */
$log = Plug_User_Re_Add($user, $pwd, $pwdb, $qq, $mail, $extension, $Mobile, $user_mibao_wenti, $user_mibao_daan, $user_extra);
if ($log == 1005) {


    $gift_value = (int)Plug_App_DaTa('app_re_date'); // 获取赠送值：限时模式=秒，扣点模式=点数
    $app_moshi  = (string)Plug_App_DaTa('app_MoShi');
    $is_point_mode = ($app_moshi === 'LoginPoint' || $app_moshi === 'CardPoint');
    $date = $is_point_mode ? $gift_value : (PLUG_UNIX() + $gift_value);

    /*查询是否重复绑定*/
    $uid = Plug_Query_One('bs_php_user', 'user_user', $user, '`user_uid`');




    Plug_App_Login_Add_Key($uid, $daihao, $date, $key, $user, $user, '0', 0, 0, $app_user_extra); //添加特征



    if ($gift_value == 0) {

        Plug_Echo_Info(Plug_Lang('注册成功'), 1005);
    } elseif ($is_point_mode) {
        Plug_Echo_Info(Plug_Lang('注册成功,恭喜你获得了') . $gift_value . Plug_Lang('点数'), 1005);
    } else {
        $s = $gift_value / 3600;
        Plug_Echo_Info(Plug_Lang('注册成功,恭喜你获得了') . round($s, 1) . Plug_Lang('小时的使期限'), 1005);
    }
}
Plug_Echo_Info($user_str_log[$log], $log);
