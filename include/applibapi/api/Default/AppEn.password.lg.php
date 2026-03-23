<?php



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
