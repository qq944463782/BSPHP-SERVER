<?php
/*
<api>
  <name>timeout.ic</name>
  <title>超时更新</title>
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
  </params>
</api>
*/



/***********************接口介绍说明******************************************
 * timeout.ic
 * 超时更新
 * *****************************************************************************
 */

$daihao = PLUG_DAIHAO();
$car_id = Plug_Get_Session_Value('ic_carid');   #获取SESSION保存登录卡密
$car_pwd = Plug_Get_Session_Value('ic_pwd');    #获取SESSION保存登录卡密
$BSphpSeSsL = Plug_Set_Data('BSphpSeSsL');



//获取验证信息 COOKIE内之了
$log = Plug_App_Is_Login($car_id, $car_pwd, $daihao);
if ((int)$log !== 1080) {
    Plug_Echo_Info((string)$log, $log);
}

$arr = Plug_Get_Card_Info($car_id, $car_pwd, $daihao);

if ($arr['L_IsLock'] == 1) {
    Plug_Echo_Info('5033', 5033);  #被冻结
}

if ($arr['L_vip_unix'] > PLUG_UNIX()) {
    //没有到期
    // Plug_Echo_Info('5029');

} else {

    //到期
    Plug_Echo_Info('5030', 5030);
}


//一切正常
Plug_Echo_Info('5031', 5031);
