<?php
/*
<api>
  <name>password.lg</name>
  <title>修改密码</title>
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
    <param name="daihao" required="false" type="string" desc="软件代号"></param>
    <param name="user" required="false" type="string" desc="用户名"></param>
    <param name="pwd" required="false" type="string" desc="密码"></param>
    <param name="pwda" required="false" type="string" desc="参数说明"></param>
    <param name="pwdb" required="false" type="string" desc="确认密码"></param>
    <param name="img" required="false" type="string" desc="图形验证码"></param>
  </params>
</api>
*/




/***********************接口介绍说明******************************************
 * password.lg
 * 修改密码
 * *****************************************************************************
 */
#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

$daihao = Plug_Set_Data('daihao');
$user = Plug_Set_Data('user');

$pwd = Plug_Set_Data('pwd');
$pwda = Plug_Set_Data('pwda');
$pwdb = Plug_Set_Data('pwdb');
$uid = Plug_Get_Session_Value('USER_UID');
$img = Plug_Set_Data('img');


//检测登录状态
if ($user != "" and $pwd != "") {



  //转换真实user信息,顺序账户,邮箱,手机 uid+密码
  $user = Plug_UserTageToUser($user, $pwd);


  $log = Plug_Is_User_Account($user, $pwd);
  //读取用户配置
  $User_Info = Plug_Query_One('bs_php_user', 'user_user', $user, '`user_uid`,`user_daili`,`user_user`');
  $uid = $User_Info['user_uid'];
} else {


  $log =  Plug_User_Is_Login_Seesion();
}




if ($log == 1047 or $log == 1011) {

  $log = Plug_User_Modify_PassWord($uid, $pwd, $pwda, $pwdb);
  Plug_Echo_Info($user_str_log[$log], $log);
}
Plug_Echo_Info($user_str_log[$log], $log);
