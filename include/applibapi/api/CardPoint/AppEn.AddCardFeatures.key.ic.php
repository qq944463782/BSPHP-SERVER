<?php


/***********************接口介绍说明******************************************
 * login.ic
 * 卡模式扣点用户登录验证
 * *****************************************************************************
 */

#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');


$key_carid = Plug_Set_Data('carid');  #需要登录特征，没有就会注册
$key = Plug_Set_Data('key');          #绑定特征
$maxoror = Plug_Set_Data('maxoror');  #多开控制唯一特征码
$daihao = PLUG_DAIHAO();

if ($key == '') Plug_Echo_Info(Plug_Lang('KEY不能空'));
$log = Plug_Car_Login_point($key_carid, '', $key, $daihao);

if (Plug_App_data('app_MoShi') !== 'CardPoint') {

    Plug_Echo_Info($user_str_log[1119]);
}


//1073不存在
if ($log == 1073) {

    $date = (int)Plug_App_data('app_re_date'); //获取赠送时间
    Plug_App_Login_Add_Key($key_carid, $daihao, $date, $key);

    //再次登录验证
    $log = Plug_Car_Login_point($key_carid, '', $maxoror, $daihao);
}


if ($log == 1081) {


    //建立登录限制
    $log = Plug_Login_Multi_Control($key_carid, $daihao, $maxoror, $key);
    if ($log != 5047)
        Plug_Echo_Info($appen_str_log[$log], $log);

    /**
     * 查询用户信息
     */
    $carinfo = Plug_Get_Card_Info($key_carid, '', $daihao);
    if ($carinfo == 1083 || $carinfo == 1084)
        Plug_Echo_Info($user_str_log[$arr_log], $arr_log);


    if (Plug_App_data('app_set') == 1) {
        if ((string)$carinfo['L_key_info'] != (string)$key) {

            //注销登录
            Plug_Set_Session_Value('ic_carid', ''); //登陆UID
            Plug_Set_Session_Value('ic_pwd', ''); //登陆MD7加密
            Plug_Set_Session_Value('USER_UID', '');

            Plug_Echo_Info(Plug_Lang('[5035]非绑定机器，到绑定机器登录'), 5035);
        }
    }


    //---------------------------------------


    //链接数验证


    //$login_ssl = MD5($BSphpSeSsL);
    Plug_Links_Add_Info('-1', $key_carid, $key, $daihao, $maxoror);


    //-----------------------------------------
    //记录登录时间用做扣点


    $ic_vipdate =  $carinfo['L_vip_unix'];

    $ic_key = $carinfo['L_key_info'];

    $login_info = null;

    $login_info = Plug_App_data('app_logininfo');


    /**
     * 返回数据说明
     */
    if ($carinfo['L_vip_unix'] > 0) {
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
        Plug_Echo_Info(Plug_Lang('9908'));
    }
} else {

    Plug_Echo_Info($user_str_log[$log], $log);
}
