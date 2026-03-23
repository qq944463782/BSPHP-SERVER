<?php


/***********************接口介绍说明******************************************
 * remotecancellation.ic
 * 远程注销登录状态
 * *****************************************************************************
 */

#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

$BSphpSeSsL = Plug_Set_Data('BSphpSeSsL');
$icid = Plug_Set_Data('icid');       #注销的卡号
$icpwd = Plug_Set_Data('icpwd');     #注销卡密码


$type = (int)Plug_Set_Data('type');  #=0 注销全部  非0=注销最早登录的/注销最早登录设备全部账号
$biaoji = Plug_Set_Data('biaoji');   #设备机器码全球唯一的，不限制设备使用量时候不填写


$daihao = PLUG_DAIHAO();
if ($icid == '') {
    Plug_Echo_Info($user_str_log[1115]);
}




$arr_log = Plug_Get_Card_Info($icid, $icpwd, $daihao);


if ($arr_log == 1083 or $arr_log == 1084) {

    Plug_Echo_Info($user_str_log[$arr_log], $arr_log);
}



if ($type == 0) {



    //查询是否注册使用过，存在就注销退出
    $tmp = Plug_Links_Delete_All_Name($daihao, $icid);

    if ($tmp == 1) {
        //登录COOKIES设置
        Plug_Set_Session_Value('ic_carid', 'NOT');
        Plug_Set_Session_Value('ic_pwd', 'NOT');
        Plug_Echo_Info($user_str_log[1116], 1116);
    } else {

        Plug_Echo_Info($user_str_log[1117], 1117);
    }
} else {


    #自动执行注销最早的
    $log  = Plug_Login_Multi_Control($icid, $daihao, $biaoji, $icid, 1);
    Plug_Echo_Info($this->appen_str_log[$log], $log);
}
