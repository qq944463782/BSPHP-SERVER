<?php



/***********************接口介绍说明******************************************
 * liuyan.in
 * 用户留言
 * *****************************************************************************
 */


$daihao = PLUG_DAIHAO();
$table = Plug_Set_Data('table');        #标题
$leix = Plug_Set_Data('leix');          #类型
$qq = Plug_Set_Data('qq');              #联系方式
$txt = Plug_Set_Data('txt');            #留言内容
$img = Plug_Set_Data('img');            #验证码，开启时候需要
$uid = Plug_Get_Session_Value('USER_UID');

$user = Plug_Set_Data('user'); //填写-1 无需登录直接提交留言
$pwd = Plug_Set_Data('pwd');

#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');






if ($user == -1) {

  /**
   * 提交留言无需登录
   */

  $ic_carid = Plug_Get_Session_Value('ic_carid');

  if ($uid == 0 and $ic_carid != '') {
    $uid = $ic_carid;
  }


  $log = Plug_UserAddLiuYan($leix, $table, $qq, $uid, $daihao, $txt);
  Plug_Echo_Info($user_str_log[$log], $log);
}



#卡模式判断
if (Plug_App_data('app_MoShi') == 'CardPoint' or Plug_App_DaTa('app_MoShi') == 'CardTerm') {



  $ic_carid = Plug_Get_Session_Value('ic_carid');   #获取SESSION保存登录卡密
  $ic_pwd = Plug_Get_Session_Value('ic_pwd');   #获取SESSION保存登录卡密
  if ($user == '' and $ic_carid != '') {
    $user = $ic_carid;
    $pwd = $ic_pwd;
  }



  //卡模式获取验证信息 COOKIE内之了
  $log = Plug_App_Is_Login($user, $pwd, $daihao);
  if ($log == 1080) {

    $log = Plug_UserAddLiuYan($leix, $table, $qq, $user, $daihao, $txt);
    Plug_Echo_Info($user_str_log[$log], $log);
  } else {
    Plug_Echo_Info($user_str_log[$log], $log);
  }
}



//检测登录状态
if ($user != "") {


  //转换真实user信息,顺序账户,邮箱,手机 uid+密码
  $user = Plug_UserTageToUser($user, $pwd);


  $log = Plug_Is_User_Account($user, $pwd);

  if ($log == 1011) {
    //读取用户配置
    $User_Info = Plug_Query_One('bs_php_user', 'user_user', $user, '`user_uid`,`user_daili`,`user_user`');
    $uid = $User_Info['user_uid'];
  } else {
    Plug_Echo_Info($user_str_log[$log], $log);
  }


  //直接进行session验证
} else {
  $log = Plug_User_Is_Login_Seesion();
}



if ($log == 1047 or $log == 1011) {

  /**
   * 提交留言
   */
  $log = Plug_UserAddLiuYan($leix, $table, $qq, $uid, $daihao, $txt);
  Plug_Echo_Info($user_str_log[$log], $log);
}

Plug_Echo_Info($user_str_log[$log], $log);
