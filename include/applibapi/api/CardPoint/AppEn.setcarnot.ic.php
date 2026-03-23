<?php


/***********************接口介绍说明******************************************
 * setcarnot.ic
 * 解除绑定
 * *****************************************************************************
 */


#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');


$daihao = PLUG_DAIHAO();

$car_id = Plug_Set_Data('icid');      #直接传递卡号
$car_pwd = Plug_Set_Data('icpwd');    #卡密码


#判断是否传递卡号密码进行直接解除绑定=’‘，获取登录状态的卡密码验证
if (Plug_Set_Data('icid') == '') {
    $car_id = Plug_Get_Session_Value('ic_carid');
    $car_pwd = Plug_Get_Session_Value('ic_pwd');
}

//获取验证信息 COOKIE内之了
$log = Plug_App_Is_Login($car_id, $car_pwd, $daihao);
if ($log == 1080) {

    //读取用户数据
    $Get_DaTa = Plug_Get_Card_Info($car_id, $car_pwd, $daihao);
    if (is_array($Get_DaTa)) {
        //判断是否已经解除绑定
        if ($Get_DaTa['L_key_info'] == '')
            Plug_Echo_Info($appen_str_log[5022], 5022);

        //判断用户是否到期
        if ($Get_DaTa['L_vip_unix'] <= 0)
            Plug_Echo_Info($appen_str_log[5018], 5018);

        //判断解除绑定是否会到期
        $Usb_date = Plug_App_data('app_zhuang_date');

        //$Usb_date=$Usb_date*3600;
        $uesr_date = $Get_DaTa['L_vip_unix'];
        $uesr_date = $uesr_date - $Usb_date;
        if ($uesr_date <= 0)
            Plug_Echo_Info($appen_str_log[5019], 5019);


        //解除绑定
        $sql = "UPDATE`bs_php_pattern_login`SET`L_key_info`='',`L_vip_unix`='$uesr_date' WHERE`L_id` ='{$Get_DaTa['L_id']}'";
        $tmp = Plug_Query($sql);

        if ($tmp) {
            Plug_Echo_Info(Plug_Lang('解除绑定成功!,剩余点:') . $uesr_date, 2000);
        } else {
            Plug_Echo_Info(Plug_Lang('解除绑定失败,请重试!'), -200);
        }
    } else {
        Plug_Echo_Info($user_str_log[$Get_DaTa], $log);
    }
} else {
    Plug_Echo_Info($user_str_log[$log], $log);
}
