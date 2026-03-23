<?php



/***********************接口介绍说明******************************************
 * getdata.ic
 * 取验证数据
 * *****************************************************************************
 */
#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

$car_id = Plug_Get_Session_Value('ic_carid');
$car_pwd = Plug_Get_Session_Value('ic_pwd');
$daihao = PLUG_DAIHAO();

$key = Plug_Set_Data('key');   #验证key



//获取验证信息 COOKIE内之了
$log = Plug_App_Is_Login($car_id, $car_pwd, $daihao);

if ($log == 1080) {
  //查询信息
  $arr_log = Plug_Get_Card_Info($car_id, $car_pwd, $daihao);


  if ($arr_log['L_key_info'] == $key or Plug_App_DaTa('app_set') == 0) {
    Plug_Echo_Info(Plug_App_DaTa('app_logininfo'));
  } else {
    Plug_Echo_Info(Plug_Lang('5033'),5033);
  }
} else {
  Plug_Echo_Info($user_str_log[$log],$log);
}
