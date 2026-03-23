<?php


/***********************接口介绍说明******************************************
 * timeoutupdate.ic
 * 超时更新
 * *****************************************************************************
 */

$daihao = PLUG_DAIHAO();
$car_id = Plug_Get_Session_Value("".'ic_carid');
$car_pwd = Plug_Get_Session_Value("".'ic_pwd');
$BSphpSeSsL = Plug_Set_data('BSphpSeSsL');



//获取验证信息 COOKIE内之了
$log = Plug_App_Is_Login($car_id, $car_pwd, $daihao);
if ($log != 1080)
    Plug_Echo_Info((string)$log);


$arr = Plug_Get_Card_Info($car_id, $car_pwd, $daihao);
if ($arr['L_IsLock'] == 1) {
    Plug_Echo_Info('5033', 5033);
}

if ($arr['L_vip_unix'] > 0) {
    //没有到期
    //Plug_Echo_Info('5029');

} else {

    //到期
    Plug_Echo_Info('5030', 5030);
}


//一切正常
Plug_Echo_Info('5031', 5031);
