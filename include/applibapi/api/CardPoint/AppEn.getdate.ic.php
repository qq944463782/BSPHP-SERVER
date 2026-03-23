<?php



/***********************接口介绍说明******************************************
 * getdate.ic
 * 取卡模式剩余点
 * *****************************************************************************
 */

#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

$car_id = Plug_Get_Session_Value("".'ic_carid');
$car_pwd = Plug_Get_Session_Value("".'ic_pwd');
$daihao = PLUG_DAIHAO();

$arr_log = Plug_Get_Card_Info($car_id, $car_pwd, $daihao);

if ($arr_log == 1083 || $arr_log == 1084) {

  Plug_Echo_Info($user_str_log[$arr_log], $arr_log);
} else {

  Plug_Echo_Info($arr_log['L_vip_unix'], 200);
}
