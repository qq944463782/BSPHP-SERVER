<?php



/***********************接口介绍说明******************************************
 * getlkinfo.ic
 * 验证登录状态
 * *****************************************************************************
 */


#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');


$car_id = Plug_Get_Session_Value('ic_carid');   #获取登录SESSON卡号
$car_pwd = Plug_Get_Session_Value('ic_pwd');    #获取登录SESSON卡密码

$daihao = PLUG_DAIHAO();




//获取验证信息 COOKIE内之了
$log = Plug_App_Is_Login($car_id, $car_pwd, $daihao);

if ($log == 1080) {
    Plug_Echo_Info("1080", 1080);
} else {
    Plug_Echo_Info($user_str_log[$log], 1080);
}
