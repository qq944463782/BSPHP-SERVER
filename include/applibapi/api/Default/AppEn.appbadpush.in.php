<?php


/**
 * **********************接口介绍说明******************************************
 * appbadpush.in
 * 破解后太提交日志
 * *****************************************************************************
 */


$daihao = PLUG_DAIHAO();
$teble = Plug_Set_Data('table');                #日志内容
$uid = Plug_Get_Session_Value('USER_UID');


Plug_Add_AppenLog('od_po_log', $teble,$uid);

Plug_Echo_Info(1,200);