<?php


/***********************接口介绍说明******************************************
 * getuserinfo.lg
 * 取用户信息
 * *****************************************************************************
 */

#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

$uid = Plug_Get_Session_Value('USER_UID');
$daihao = PLUG_DAIHAO();
$info = Plug_Set_data('info');
if ($info == NULL) Plug_Echo_Info('请输入要获取数据类型如:激活时间=UserReDate,激活时Ip=UserReIp,用户状态=UserIsLock,登录时间=UserLogInDate');

//登录连接数功能集代码
//登陆状态
$log = Plug_User_Is_Login_Seesion();
if ($log == 1047) {



   //获取软件用户信息
   $arr = Plug_Get_App_User_Info($uid, $daihao);

   //获取用户信息
   $sql = "SELECT * FROM`bs_php_user` WHERE `user_uid`='$uid' LIMIT 1;";

   $user_array = Plug_Query_Assoc($sql);

   //获取类型

   /**
            信息字段： 
            激活时间=UserReDate   
            激活时Ip=UserReIp   
            用户状态=UserIsLock   
            登录时间=UserLogInDate   
            登录Ip=UserLogInIp    
            到期时=UserVipDate   
            绑定特征=UserKey
            用户分组名称=Class_Nane
            用户分组别名=Class_Mark
            
            UserQQ=用户QQ
            UserMAIL=用户邮箱
            UserPayZhe=购卡折扣
            UserTreasury=是否代理 代理=1
            UserMobile=电话
            UserRMB=帐号金额
            UserPoint=帐号积分
            Usermibao_wenti=密保问题
            
            UserVipDate=VIP到期时间
            UserVipWhether=vip是否到期 没有到期返回1 到期返回2
    */

   $info = str_replace('UserName', $user_array['user_user'], $info);
   $info = str_replace('UserUID', $user_array['user_uid'], $info);
   $info = str_replace('UserReDate', $user_array['user_re_date'], $info);
   $info = str_replace('UserReIp', $user_array['user_re_ip'], $info);
   $info = str_replace('UserIsLock', $user_array['user_IsLock'], $info);
   $info = str_replace('UserLogInDate', $user_array['user_Login_date'], $info);
   $info = str_replace('UserLogInIp', $user_array['user_Login_ip'], $info);

   $info = str_replace('UserQQ', $user_array['user_qq'], $info);
   $info = str_replace('UserMAIL', $user_array['user_email'], $info);
   $info = str_replace('UserPayZhe', $user_array['user_Zhe'], $info);
   $info = str_replace('UserTreasury', $user_array['user_daili'], $info);
   $info = str_replace('UserMobile', $user_array['user_Mobile'], $info);
   $info = str_replace('UserRMB', $user_array['user_rmb'], $info);
   $info = str_replace('UserPoint', $user_array['user_jifen'], $info);
   $info = str_replace('Usermibao_wenti', $user_array['user_mibao_wenti'], $info);



   $info = str_replace('UserVipDate', $arr['L_vip_unix'], $info);
   if ($arr['L_vip_unix'] > 1) {
      $info = str_replace('UserVipWhether', '1', $info);
   } else {
      $info = str_replace('UserVipWhether', '2', $info);
   }




   $info = str_replace('UserKey', $arr['L_key_info'], $info);

   if ($arr['L_class'] == 0) {
      $class_array['class_name'] = Plug_Lang("未分组");
      $class_array['calss_mark'] = "null";
   } else {
      $class_array = Plug_Query_One('bs_php_userclass', 'class_id', $arr['L_class'], ' * ');
   }

   $info = str_replace('Class_Nane', $class_array['class_name'], $info);
   $info = str_replace('Class_Mark', $class_array['calss_mark'], $info);





   Plug_Echo_Info($info, 200);
}
Plug_Echo_Info($user_str_log[$log], $log);
