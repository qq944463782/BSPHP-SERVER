<?php

/***********************接口介绍说明******************************************
 * GetMyData.in
 * 获取远程配置
 * *****************************************************************************
 */

$keys = Plug_Set_Data('keys'); #获取配置键值



//演示需要登录操作
// $uid = Plug_Get_Session_Value('USER_UID'); //获取当前登录UID
// if ($uid <= 0) {
//     Plug_Echo_Info('请登录在操作');
// }


$tmp = plug_get_mydata($keys);
//读取成功
Plug_Echo_Info('ok|' . $tmp, 200);
