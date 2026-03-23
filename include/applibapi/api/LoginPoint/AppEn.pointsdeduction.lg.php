<?php


/***********************接口介绍说明******************************************
 * pointsdeduction.lg
 * 扣点 点模式下
 * *****************************************************************************
 */

#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');


$daihao = PLUG_DAIHAO();
$uid = Plug_Get_Session_Value('USER_UID');

$BSphpSeSsL = Plug_Set_data('BSphpSeSsL');
$onetime = Plug_Set_data('onetime');
$point = Plug_Set_data('balance'); //扣除点数
if (Plug_App_data('app_MoShi') !== 'LoginPoint') {

    Plug_Echo_Info(Plug_Lang('[90014]本接口是登录扣点模式下使用,当前软件模式不对应'), 90014); //不对应的模式
}

$log = Plug_User_Is_Login_Seesion();
if ($log == 1047) {


    if ($point <= 0) {
        Plug_Echo_Info('90011', 90011); //点数不能少或者等于0
    }

    if ($point > 1000) {
        Plug_Echo_Info('90016', 90016); //点数不能少或者等于0
    }

    $arr = Plug_Get_App_User_Info($uid, $daihao);

    if ($arr['L_vip_unix'] > 0) {
        $ConsumptionPoint_time = Plug_Get_Session_Value('ConsumptionPoint_time');
        $time_int = PLUG_UNIX() - $ConsumptionPoint_time;
        if ($time_int < $onetime) {
            Plug_Echo_Info('90013', 90013); //一分钟只能扣除一次
        }


        $sql = "UPDATE `bs_php_pattern_login`SET`L_vip_unix`=`L_vip_unix`-'$point' WHERE `L_id`='{$arr['L_id']}' LIMIT 1;";
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
} else {
    Plug_Echo_Info($user_str_log[$log], $log);
}
