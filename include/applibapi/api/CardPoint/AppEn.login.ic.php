<?php

/***********************接口介绍说明******************************************
 * login.ic
 * 卡扣点模式卡登录验证
 * *****************************************************************************
 */

$icid = Plug_Set_data('icid');
$icpwd = Plug_Set_data('icpwd');
$key = Plug_Set_data('key');
$maxoror = Plug_Set_data('maxoror');
$daihao = PLUG_DAIHAO();

#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');


if (Plug_App_data('app_MoShi') !== 'CardPoint') {

    Plug_Echo_Info($appen_str_log[5058], 5058);
}


if ($icid == '') {
    Plug_Echo_Info(Plug_Lang('请输入激活码'), -1);
}

//登陆前绑定-------------------------------------------------------------------------
//读取用户数据
$Get_DaTa = Plug_Get_Card_Info($icid, $icpwd, $daihao);
if (is_array($Get_DaTa)) {
    //判断是否已经解除绑定

    if ($Get_DaTa['L_key_info'] == '' and $key !== '') {
        //添加绑定
        $sql = "UPDATE`bs_php_pattern_login`SET `L_key_info`='{$key}' WHERE  `L_id`='{$Get_DaTa['L_id']}';";
        $tmp = Plug_Query($sql);
    }
}
//END
//-----------------------------------------





$log = Plug_Car_Login_point($icid, $icpwd, $key, $daihao);
if ($log == 1069) $log = Plug_Car_Login_point($icid, $icpwd, $key, $daihao);
if ($log == 1081) {



    //建立登录限制
    $log = Plug_Login_Multi_Control($icid, $daihao, $maxoror, $icid, $icid);
    if ($log != 5047) Plug_Echo_Info($appen_str_log[$log],$log);

    /**
     * 查询用户信息
     */
    $carinfo = Plug_Get_Card_Info($icid, $icpwd, $daihao);
    if ($carinfo == 1083 || $carinfo == 1084) Plug_Echo_Info($user_str_log[$arr_log]);
    if ($carinfo['L_IsLock'] > 0) {
        Plug_Echo_Info('当前激活码已经被冻结禁止登录当前软件.');
    }

    if (Plug_App_data('app_set') == 1) {
        if ((string)$carinfo['L_key_info'] != (string)$key) {

            //注销登录
            Plug_Set_Session_Value('ic_carid', ''); //登陆UID
            Plug_Set_Session_Value('ic_pwd', ''); //登陆MD7加密
            Plug_Set_Session_Value('USER_UID', '');
            Plug_Echo_Info('[5035]' . $appen_str_log[5035]);
            Plug_Echo_Info('[5035]' . $appen_str_log[5035]);
        }
    }




    //---------------------------------------


    //链接数验证


    //$login_ssl = MD5($BSphpSeSsL);
    Plug_Links_Add_Info('-1', $icid, $key, $daihao, $maxoror);


    //-----------------------------------------
    //记录登录时间用做扣点




    $ic_vipdate =  $carinfo['L_vip_unix'];

    $ic_key = $carinfo['L_key_info'];

    $login_info = NULL;
    if ($key == $ic_key & $ic_key != '') $login_info = Plug_App_data('app_logininfo');




    /**
     * 返回说明
     * 1.= 成功返回1
     * 2.= 登陆成功代号
     * 3.= 用户绑定key
     * 4.= 用户登陆成功返回特定数据
     * 5.= VIP到期时间
     */
    Plug_Echo_Info("01|1081|$ic_key|$login_info|$ic_vipdate|||||", 1081);
} else {

    Plug_Echo_Info($user_str_log[$log],$log);
}
