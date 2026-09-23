<?php
/*
<api>
  <name>setcaron.ic</name>
  <title>绑定新特征</title>
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
    <param name="key" required="false" type="string" desc="绑定新特征/机器码"></param>
    <param name="icid" required="false" type="string" desc="直接传递卡号"></param>
    <param name="icpwd" required="false" type="string" desc="卡密码"></param>
  </params>
</api>
*/



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
        if ($key == '')
            Plug_Echo_Info($appen_str_log[5023], 5023);
        if (Plug_Bind_Key_Check($Get_DaTa, $key))
            Plug_Echo_Info(Plug_Lang('[5013]绑定成功'), 5013);
        if (!Plug_Bind_Key_CanAdd($Get_DaTa, $key))
            Plug_Echo_Info($appen_str_log[5025], 5025);

        if (Plug_App_DaTa('app_key_zhong') == 1) {
            $zhong_arr = Plug_Login_Key_Zhong($daihao, $key);
            if ($zhong_arr && (int)$zhong_arr['L_id'] !== (int)$Get_DaTa['L_id']) {
                Plug_Echo_Info(Plug_Lang('[5012]当前特征已经有人绑定,无法再绑定'), 5012);
            }
        }

        $tmp = Plug_Bind_Key_Add($Get_DaTa, $key);

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
