<?php


/***********************接口介绍说明******************************************
 * setcaron.ic
 * 绑定新特征
 * *****************************************************************************
 */

#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');


$key = Plug_Set_Data('key');  #绑定新特征/机器码


$daihao = PLUG_DAIHAO();

$car_id = Plug_Set_Data('icid');      #直接传递卡号
$car_pwd = Plug_Set_Data('icpwd');    #卡密码


#判断是否传递卡号密码进行直接解除绑定=’‘，获取登录状态的卡密码验证
if (Plug_Set_Data('icid') == '') {
    $car_id = Plug_Get_Session_Value('ic_carid');
    $car_pwd = Plug_Get_Session_Value('ic_pwd');
}



$daihao = PLUG_DAIHAO();


//获取验证信息 COOKIE内之了
$log = Plug_App_Is_Login($car_id, $car_pwd, $daihao);
if ($log == 1080) {

    //读取用户数据
    $Get_DaTa = Plug_Get_Card_Info($car_id, $car_pwd, $daihao);
    if (is_array($Get_DaTa)) {
        //判断是否已经解除绑定
        if ($key == '')
            Plug_Echo_Info($appen_str_log[5023], 5023);
        if ($Get_DaTa['L_key_info'] != '')
            Plug_Echo_Info($appen_str_log[5025], 5025);


        //添加绑定
        $sql = "UPDATE`bs_php_pattern_login`SET`L_key_info`='{$key}'WHERE  `L_id`='{$Get_DaTa['L_id']}';";
        $tmp = Plug_Query($sql);

        if ($tmp) {
          
            Plug_Echo_Info(Plug_Lang('[5013]绑定成功'), 5013); //
        } else {
            PrLog(5014); //绑定失败,请重试!
        }
    } else {
        Plug_Echo_Info($user_str_log[$Get_DaTa], $Get_DaTa);
    }
} else {
    Plug_Echo_Info($user_str_log[$log], $log);
}
