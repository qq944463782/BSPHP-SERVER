<?php
/*
<api>
  <name>SetAppRemarks.ic</name>
  <title>用户漫游配置</title>
    <intro>接口参数说明</intro>
  <common_params type="1">
    <param name="api" type="1" required="true" dtype="string" desc="API接口名称"></param>
    <param name="BSphpSeSsL" type="1" required="true" dtype="string" desc="BSphpSeSsL连接Cookies"></param>
    <param name="date" type="1" required="false" dtype="string" desc="服务器时间超时验证；可空，后台设置超时0即关闭"></param>
    <param name="mutualkey" type="1" required="true" dtype="string" desc="通信认证Key，用作软件数据包交换数据验证串"></param>
    <param name="appsafecode" type="1" required="false" dtype="string" desc="封包劫持检测；可空，客户端提交参数给服务器时原样返回"></param>
    <param name="md5" type="1" required="false" dtype="string" desc="程序MD5；可空，后台MD5内容要为空"></param>
  </common_params>

  <params>
    <param name="icid" required="false" type="string" desc="直接使用卡号密码验证"></param>
    <param name="icpwd" required="false" type="string" desc="直接使用卡号密码验证"></param>
    <param name="remarks" required="false" type="string" desc="参数说明"></param>
  </params>
</api>
*/



/***********************接口介绍说明******************************************
 * SetAppRemarks.ic
 * 用户漫游配置
 * *****************************************************************************
 */

#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');


$daihao = PLUG_DAIHAO();

if (Plug_Set_Data('icid') != '') {
    $car_id = Plug_Set_Data('icid');       #直接使用卡号密码验证
    $car_pwd = Plug_Set_Data('icpwd');     #直接使用卡号密码验证
} else {
    $car_id = Plug_Get_Session_Value('ic_carid');    #获取已登登录保存卡号密码
    $car_pwd = Plug_Get_Session_Value('ic_pwd');     #获取已登登录保存卡号密码
}

$remarks =  Plug_Set_Data('remarks');



//获取验证信息 COOKIE内之了
$log = Plug_App_Is_Login($car_id, $car_pwd, $daihao);
if ($log == 1080) {

    if ($remarks == '-1') {
        $arr = Plug_Get_App_User_Info($car_id, $daihao);
        Plug_Echo_Info($arr['L_links_info']);
    }

    $sql = "UPDATE`bs_php_pattern_login`SET `L_links_info` = '$remarks' WHERE `L_User_uid`='$car_id';";
    $tmp = Plug_Query($sql);
    if ($tmp) {
        Plug_Echo_Info('10001');
    } else {
        Plug_Echo_Info('10002');
    }
} else {
    Plug_Echo_Info($user_str_log[$log], $log);
}
