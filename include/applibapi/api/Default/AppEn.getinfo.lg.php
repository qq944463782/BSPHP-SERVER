<?php



/***********************接口介绍说明******************************************
 * getinfo.lg
 * 取用户到期时间
 * *****************************************************************************
 */
#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');



$uid = Plug_Get_Session_Value('USER_UID');
$daihao = PLUG_DAIHAO();
$info = Plug_Set_Data('info');            #需要获取信息字段
$user = Plug_Set_Data('user');            #通过账号密码方式直接验证
$userpwd = Plug_Set_Data('pwd');          #通过账号密码方式直接验证

//转换真实user信息,顺序账户,邮箱,手机 uid+密码
$user = Plug_UserTageToUser($user, $userpwd);

if ($user != '' and $userpwd != '') {
  $log = Plug_Is_User_Account($user, $userpwd);
  if ($log != 1011) Plug_Echo_Info($user_str_log[$log], $log);


  //获取用户信息
  $sql = "SELECT*FROM`bs_php_user`WHERE`user_user`='$user';";
  $user_array = Plug_Query_Assoc($sql);

  //获取软件用户信息
  $arr = Plug_Get_App_User_Info($user_array['user_uid'], $daihao);
  if (!$arr) {
    Plug_Echo_Info(Plug_Lang('未读取到用户信息,请确认是否软件使用登录使用过'), -12);
  }
} else {


  //登陆状态
  $log = Plug_User_Is_Login_Seesion();
  if ($log != 1047) Plug_Echo_Info($log, $log);


  //获取软件用户信息
  $arr = Plug_Get_App_User_Info($uid, $daihao);
  if (!$arr) {
    Plug_Echo_Info(Plug_Lang('未读取到用户信息,请确认是否软件使用登录使用过'), -12);
  }

  //获取用户信息
  $sql = "SELECT*FROM`bs_php_user`WHERE`user_uid`='$uid';";
  $user_array = Plug_Query_Assoc($sql);
}





/**
            信息字段： 
            激活时间=ReDate   
            激活时Ip=ReIp   
            用户状态=IsLock   
            登录时间=LogInDate   
            登录Ip=LogInIp    
            到期时=VipDate   
            绑定特征=Key
            用户分组名称=Class_Nane
            用户分组别名=Class_Mark
            
            QQ=用户QQ
            MAIL=用户邮箱
            PayZhe=购卡折扣
            Treasury=是否代理 代理=1
            Mobile=电话
            RMB=帐号金额
            Point=帐号积分
            mibao_wenti=密保问题
            
            VipDate=VIP到期时间
            VipWhether=vip是否到期 没有到期返回1 到期返回2
 */


$info = str_replace('ReDate', $user_array['user_re_date'], $info);
$info = str_replace('ReIp', $user_array['user_re_ip'], $info);
$info = str_replace('IsLock', $user_array['user_IsLock'], $info);
$info = str_replace('LogInDate', $user_array['user_Login_date'], $info);
$info = str_replace('LogInIp', $user_array['user_Login_ip'], $info);

$info = str_replace('QQ', $user_array['user_qq'], $info);
$info = str_replace('MAIL', $user_array['user_Login_ip'], $info);
$info = str_replace('PayZhe', $user_array['user_Zhe'], $info);
$info = str_replace('Treasury', $user_array['user_daili'], $info);
$info = str_replace('Mobile', $user_array['user_Mobile'], $info);
$info = str_replace('RMB', $user_array['user_rmb'], $info);
$info = str_replace('Point', $user_array['user_jifen'], $info);
$info = str_replace('mibao_wenti', $user_array['user_mibao_wenti'], $info);

$info = str_replace('VipDate', date('Y-m-d H:i:s', $arr['L_vip_unix']), $info);



if ($arr['L_vip_unix'] > PLUG_UNIX()) {
  $info = str_replace('VipWhether', '1', $info);
} else {
  $info = str_replace('VipWhether', '2', $info);
}

$info = str_replace('Key', $arr['L_key_info'], $info);



if ($arr['L_class'] == 0) {
  $class_array['class_name'] = Plug_Lang("未分组");
  $class_array['calss_mark'] = "null";
} else {

  //获取类型
  $class_array = Plug_Query_One('bs_php_userclass', 'class_id', $arr['L_class'], ' * ');
}

$info = str_replace('Class_Nane', $class_array['class_name'], $info);
$info = str_replace('Class_Mark', $class_array['calss_mark'], $info);

Plug_Echo_Info($info, 200);
