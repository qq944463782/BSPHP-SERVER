<?php


/***********************接口介绍说明******************************************
 * timeout.lg
 * 超时更新
 * *****************************************************************************
 */

$daihao = PLUG_DAIHAO();
$uid = Plug_Get_Session_Value('USER_UID');
$BSphpSeSsL = Plug_Set_Data('BSphpSeSsL');

//判断是否登录
$log = Plug_User_Is_Login_Seesion();
if ((int)$log !== 1047)
    Plug_Echo_Info((string)$log, $log);

//获取用户信息
$arr = Plug_Get_App_User_Info($uid, PLUG_DAIHAO());

//---------------------------------------
//获取用户信息判断是否到期
if ($arr['L_IsLock'] == 1) {
    Plug_Echo_Info('5033', 5033);
}

if ($arr['L_vip_unix'] > 0) {
} else {

    //到期
    Plug_Echo_Info('5030', 5030);
}
//---------------------------------------




//一切正常
Plug_Echo_Info('5031', 5031);
