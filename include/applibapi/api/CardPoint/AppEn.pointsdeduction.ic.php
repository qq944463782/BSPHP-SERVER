<?php


/***********************接口介绍说明******************************************
 * pointsdeduction.ic
 * 扣点 点模式下
 * *****************************************************************************
 */

$daihao = PLUG_DAIHAO();
$car_id = Plug_Set_data('icid');
$car_pwd = Plug_Set_data('icpwd');
$onetime = Plug_Set_data('onetime');   #扣点间隔
$point = Plug_Set_data('balance');     #扣除点数


if ($car_id == '' and $car_pwd == '') {

    $car_id = Plug_Get_Session_Value("".'ic_carid');
    $car_pwd = Plug_Get_Session_Value("".'ic_pwd');
}



$BSphpSeSsL = Plug_Set_data('BSphpSeSsL');



//获取验证信息 COOKIE内之了
$log = Plug_App_Is_Login($car_id, $car_pwd, $daihao);
if ($log != 1080)
    Plug_Echo_Info((string)$log);


if (Plug_App_data('app_MoShi') !== 'CardPoint') {


    Plug_Echo_Info('90014', 90014); //不对应的模式


}

if ($point <= 0) {
    Plug_Echo_Info('90011', 90011); //点数不能少或者等于0
}
if ($point > 1000) {
    Plug_Echo_Info('90016', 90016); //点数不能少或者等于0
}


//获取验证信息 COOKIE内之了
$log = Plug_App_Is_Login($car_id, $car_pwd, $daihao);
if ($log != 1080)
    Plug_Echo_Info((string)$log);


$arr = Plug_Get_Card_Info($car_id, $car_pwd, $daihao);


if ($arr['L_vip_unix'] > 0) {

    $ConsumptionPoint_time = Plug_Get_Session_Value("".'ConsumptionPoint_time');
    $time_int = PLUG_UNIX() - $ConsumptionPoint_time;
    if ($time_int < $onetime) {
        Plug_Echo_Info('90013', 90013); //一分钟只能扣除一次
    }


    $sql = "UPDATE `bs_php_pattern_login`SET`L_vip_unix`=`L_vip_unix`-'{$point}' WHERE `L_id`='{$arr['L_id']}' LIMIT 1;";
    $tmp = Plug_Query($sql);
    if ($tmp) {
        Plug_Set_Session_Value('ConsumptionPoint_time', PLUG_UNIX());

        //扣点完成
        Plug_Echo_Info('90010', 90010);
    } else {


        //扣点失败
        Plug_Echo_Info('90012', 90012);
    }
} else {

    //到期
    Plug_Echo_Info('90015', 90015);
}
