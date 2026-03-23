<?php



/***********************接口介绍说明******************************************
 * getinfo.ic
 * 取卡模式扣点获取信息
 * *****************************************************************************
 */

$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');

$car_id = Plug_Get_Session_Value("".'ic_carid');
$car_pwd = Plug_Get_Session_Value("".'ic_pwd');


if ($car_id == '' and $car_pwd == '') {
   $car_id = Plug_Set_data('ic_carid');
   $car_pwd = Plug_Set_data('ic_pwd');
}


$daihao = PLUG_DAIHAO();
$info = Plug_Set_data('info');
$type = Plug_Set_data('type');


$arr_log = Plug_Get_Card_Info($car_id, $car_pwd, $daihao);

if ($arr_log == 1083 || $arr_log == 1084) {

   Plug_Echo_Info($user_str_log[$arr_log], $arr_log);
} else {



   if ($type == 1) {
      Plug_Echo_Info(json_encode($arr_log), 200);
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
    */


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





   $info = str_replace('VipDate', $arr_log['L_vip_unix'], $info);


   if ($arr_log['L_vip_unix'] > 0) {
      $info = str_replace('VipWhether', '1', $info);
   } else {
      $info = str_replace('VipWhether', '2', $info);
   }




   Plug_Echo_Info($info, 200);
}
