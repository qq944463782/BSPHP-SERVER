<?php
/*
<api>
  <name>BackMailPwd.lg</name>
  <title>通过邮箱找回密码</title>
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
    <param name="user" required="false" type="string" desc="找回用户账号"></param>
    <param name="mail" required="false" type="string" desc="密保邮箱，输入-1不验证账号和邮箱是否符合直接发邮件"></param>
  </params>
</api>
*/



/**
 * **********************接口介绍说明******************************************
 * BackMailPwd.lg
 * 通过邮箱找回密码
 * *****************************************************************************
 */
$daihao = PLUG_DAIHAO();
$user = Plug_Set_Data('user'); #找回用户账号
$mail = Plug_Set_Data('mail'); #密保邮箱，输入-1不验证账号和邮箱是否符合直接发邮件


$Bs_api_sql = "SELECT`user_uid`,`user_user`,`user_pwd`,`user_IsLock`,`user_LoGinNum`,`user_Login_ip`,`user_Login_date`,`user_daili`,`user_email`FROM`bs_php_user`WHERE `user_user` = '$user' ";
$Bs_api_arr = Plug_Query_Assoc($Bs_api_sql);




if (Plug_Get_Configs_Value('mail', 'set') == 0) {
    Plug_Echo_Info(Plug_Lang('系统没有开启邮件功能.'), -1);
}




if (!$Bs_api_arr) {
    Plug_Echo_Info(Plug_Lang('账号不存在.'), -1);
}


if ($Bs_api_arr['user_email'] == '') {
    Plug_Echo_Info(Plug_Lang('账号没有设置邮箱信息.'), -1);
}


if ($Bs_api_arr['user_email'] != $mail and $mail != -1) {
    Plug_Echo_Info(Plug_Lang('输入邮箱跟已设置邮箱不符合.'), -1);
}


$sql = "SELECT * FROM`bs_php_user`WHERE `user_user` = '$user' ";
$arr = Plug_Query_Assoc($sql);
if (!$arr) Plug_Echo_Info(Plug_Lang('找回账号不存在.'), -1);


$name = Plug_Get_Configs_Value("" . 'sys', 'name');
$cookie_pre = Plug_Get_Configs_Value("" . 'sys', 'cookie_pre');
$HOST_UNIX = PLUG_UNIX();
$md5 = md5($arr['user_LoGinNum'] . $arr['user_pwd'] . $arr['user_uid'] . $arr['user_uid'] . $cookie_pre . date('Ymd', $HOST_UNIX));

$sgin = md5($md5 . $arr['user_uid'] . $cookie_pre . 'bsphp' . $HOST_UNIX);
$url = Plug_Get_Configs_Value("" . 'sys', 'url') . 'Plug/mail/pwd.php?md5=' . $md5 . "&uid={$arr['user_uid']}&sgin={$sgin}&unix={$HOST_UNIX}";
if ($arr['user_email'] == '') {

    Plug_Echo_Info(Plug_Lang('该账号没有设置邮箱发件失败.'), -1);
}

$bool = Plug_Send_tomail($arr['user_email'], $name . Plug_Lang(' - 账号找回密码'), "{$name}-账号找回密码 <BR/> 尊敬用户:{$arr['user_user']} <BR/>点击下面链接系统将会进行随机重置密码,如果不需要重置密码忽略本邮件<BR/> $url  <BR/>链接10分钟有效 <BR/>邮件为系统发出请勿回复");


if ($bool) {
    Plug_Echo_Info(Plug_Lang('邮件已经发出，请注意查收,可能在垃圾邮箱里.'), 200);
} else {
    Plug_Echo_Info(Plug_Lang('系统邮件失败，请确认邮件发送开启等配置，联系管理员.error:').$bool, -1);
}
