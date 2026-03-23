<?php



/***********************接口介绍说明******************************************
 * bang.lg
 * 绑定特征
 * *****************************************************************************
 */

$daihao = PLUG_DAIHAO();

$uid = Plug_Get_Session_Value('USER_UID');

$user = Plug_Set_Data('user');  #账号密码方式验证
$pwd = Plug_Set_Data('pwd');    #账号密码方式验证
$key = Plug_Set_Data('key');    #新绑定key

#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

//检测登录状态，直接通过账号密码
if ($user != "" and $pwd != "") {

  //转换真实user信息,顺序账户,邮箱,手机 uid+密码
  $user = Plug_UserTageToUser($user, $pwd);

  $log = Plug_Is_User_Account($user, $pwd);


  //读取用户配置
  $User_Info = Plug_Query_One('bs_php_user', 'user_user', $user, '`user_uid`,`user_daili`,`user_user`');
  $uid = $User_Info['user_uid'];
  $user = $User_Info['user_user'];

} else {
  //登录连接数功能集代码

  $User_Info = Plug_Query_One('bs_php_user', 'user_uid', $uid, '`user_uid`,`user_daili`,`user_user`');
  $uid = $User_Info['user_uid'];
  $user = $User_Info['user_user'];

  $log = Plug_User_Is_Login_Seesion();
}



if ($log == 1047 or $log == 1011) {



  if ($key == '') Plug_Echo_Info(Plug_Lang('[5013]绑定特征不能为空'), 5015); // PrLog(5015);//绑定特征不能为空
  //判断是否已经过期

  /*查询是否重复绑定*/

  if (Plug_App_DaTa('app_key_zhong') == 1) {

    //查询该key是否已经在数据库
    $sql = "SELECT*FROM`bs_php_pattern_login`WHERE`L_daihao`='{$daihao}'AND`L_key_info`= '{$key}' LIMIT 1;";
    $zhong_arr = Plug_Query_Assoc($sql);
    if ($zhong_arr) {
      Plug_Echo_Info(Plug_Lang('[5012]当前特征已经有人绑定,无法在绑定'), 5012);
    }
  }




  $arr = Plug_Get_App_User_Info($uid, $daihao);


  //判断是否已经绑定过了
  if ($arr['L_key_info'] != '') PrLog(5016); //已经绑定了,不需要在绑定




  //添加绑定
  $sql = "UPDATE`bs_php_pattern_login`SET`L_key_info`='{$key}'WHERE  `L_id`='{$arr['L_id']}';";
  $tmp = Plug_Query($sql);

  if ($tmp) {

    Plug_Add_AppenLog('user_login_log', Plug_Lang('操作新特征绑定成功 KEY:') . $key, $user);
    Plug_Echo_Info(Plug_Lang('[5013]绑定成功'), 5013);
  } else {
    Plug_Echo_Info(Plug_Lang('[5014]绑定失败,请重试'), 5014); //绑定失败,请重试!
  }
}
Plug_Echo_Info($user_str_log[$log], $log);
