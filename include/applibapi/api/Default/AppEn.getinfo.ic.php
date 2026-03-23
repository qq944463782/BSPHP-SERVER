<?php



/***********************接口介绍说明******************************************
 * getinfo.ic
 * 取卡串用户信息
 * *****************************************************************************
 */
#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');


$car_id = Plug_Get_Session_Value('ic_carid');   #获取登录SESSON卡号
$car_pwd = Plug_Get_Session_Value('ic_pwd');    #获取登录SESSON卡密码

if ($car_id == '' and $car_pwd == '') {
   $car_id = Plug_Set_Data('ic_carid');   #通过登录卡号获取验证
   $car_pwd = Plug_Set_Data('ic_pwd');    #卡密码
}


$daihao = PLUG_DAIHAO();
$info = Plug_Set_Data('info');   #需要获取信息字段
$type = Plug_Set_Data('type');   #type=1 直接返回数组

/**
            信息字段： 
            卡名称=CarName
            激活时间=ReDate   
            激活时Ip=ReIp   
            用户状态=IsLock    
            登录时间=LogInDate   
            登录Ip=LogInIp    
            到期时=VipDate   
            绑定特征=Key
            用户分组名称=Class_Nane
            用户分组别名=Class_Mark
 */


#验证登录状态
$log = Plug_App_Is_Login($car_id, $car_pwd, $daihao);

if ($log != 1080) {
   Plug_Echo_Info($user_str_log[$log], $log);
}

$arr_log = Plug_Get_Card_Info($car_id, $car_pwd, $daihao);


if ($arr_log == 1083 || $arr_log == 1084) {

   Plug_Echo_Info($user_str_log[$arr_log], $arr_log);
} else {


   if ($type == 1) {
      Plug_Echo_Info(json_encode($arr_log), 200);
   }

   $info = str_replace('CarName', $arr_log['L_User_uid'], $info);
   $info = str_replace('UserName', $arr_log['L_User_uid'], $info);
   $info = str_replace('ReDate', $arr_log['L_re_date'], $info);
   $info = str_replace('ReIp', $arr_log['L_re_ip'], $info);
   $info = str_replace('IsLock', $arr_log['L_IsLock'], $info);
   $info = str_replace('LogInDate', $arr_log['L_login_time'], $info);
   $info = str_replace('LogInIp', $arr_log['L_login_ip'], $info);

   if ($arr_log['L_key_info'] == '') $arr_log['L_key_info'] = '9981';

   $info = str_replace('Key', $arr_log['L_key_info'], $info);



   if ($arr_log['L_class'] == 0) {
      $class_array['class_name'] = Plug_Lang("未分组");
      $class_array['calss_mark'] = "null";
   } else {

      //获取类型
      $class_array = Plug_Query_One('bs_php_userclass', 'class_id', $arr_log['L_class'], ' * ');
   }


   

   $info = str_replace('Class_Nane', $class_array['class_name'], $info);
   $info = str_replace('Class_Mark', $class_array['calss_mark'], $info);


   //计算剩余倒计时用全球化显示
   $endTime = new DateTime(date('Y-m-d H:i:s', $arr_log['L_vip_unix']));
   $startTime = new DateTime(PLUG_DATE());
   $interval = $endTime->diff($startTime);
   $info = str_replace('UserVipDateSurplus_DAY', $interval->days, $info);
   $info = str_replace('UserVipDateSurplus_H', $interval->h, $info);
   $info = str_replace('UserVipDateSurplus_I', $interval->i, $info);
   $info = str_replace('UserVipDateSurplus_S', $interval->s, $info);

   

   $info = str_replace('VipDate', date('Y-m-d H:i:s', $arr_log['L_vip_unix']), $info);


   if ($arr_log['L_vip_unix'] > PLUG_UNIX()) {
      $info = str_replace('VipWhether', '1', $info);
   } else {
      $info = str_replace('VipWhether', '2', $info);
   }




   Plug_Echo_Info($info, 200);
}
