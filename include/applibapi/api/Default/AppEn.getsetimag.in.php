<?php


/***********************接口介绍说明******************************************
 * getsetimag.in
 * 获取验证码是否开启
 * 通过软件后台配置列表比对
 * *****************************************************************************
 */

$type = Plug_Set_Data('type');//传递INGES_LOGIN INGES_RE INGES_MACK INGES_SAY，checked被替换就是开启了


if (stristr($type, 'INGES_LOGIN')) {
    if (stristr(Plug_App_DaTa('app_coode'), 'login.lg')) {
        $type = str_replace('INGES_LOGIN', 'checked', $type);
    }
}
if (stristr($type, 'INGES_RE')) {


    if (stristr(Plug_App_DaTa('app_coode'), 'registration.lg')) {
        $type = str_replace('INGES_RE', 'checked', $type);
    }
}
if (stristr($type, 'INGES_MACK')) {


    if (stristr(Plug_App_DaTa('app_coode'), 'backto.lg')) {
        $type = str_replace('INGES_MACK', 'checked', $type);
    }
}
if (stristr($type, 'INGES_SAY')) {


    if (stristr(Plug_App_DaTa('app_coode'), 'liuyan.in')) {
        $type = str_replace('INGES_SAY', 'checked', $type);
    }
}


Plug_Echo_Info($type,200);
