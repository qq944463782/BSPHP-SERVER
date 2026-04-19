<?php
/*
<api>
  <name>remotecancellation.ic</name>
  <title>远程注销登录状态</title>
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
    <param name="BSphpSeSsL" required="false" type="string" desc="会话标识"></param>
    <param name="icid" required="false" type="string" desc="注销的卡号"></param>
    <param name="icpwd" required="false" type="string" desc="注销卡密码"></param>
    <param name="type" required="false" type="string" desc="=0 注销全部  非0=注销最早登录的/注销最早登录设备全部账号"></param>
    <param name="biaoji" required="false" type="string" desc="设备机器码全球唯一的，不限制设备使用量时候不填写"></param>
  </params>
</api>
*/



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
