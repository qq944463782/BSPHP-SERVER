<?php
/*
<api>
  <name>login.ic</name>
  <title>卡模式用户登录验证</title>
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
    <param name="icid" required="false" type="string" desc="登录的卡号"></param>
    <param name="icpwd" required="false" type="string" desc="登录卡密码，没有留空"></param>
    <param name="key" required="false" type="string" desc="登录验证绑定机器码，软件配置控制开关"></param>
    <param name="maxoror" required="false" type="string" desc="登录控制多开设备的机器码，必须唯一不然达不到效果"></param>
    <param name="BSphpSeSsL" required="false" type="string" desc="会话标识"></param>
  </params>
</api>
*/


/***********************接口介绍说明******************************************
 * login.ic
 * 卡模式用户登录验证
 * *****************************************************************************
 */

$icid = Plug_Set_Data('icid');        #登录的卡号
$icpwd = Plug_Set_Data('icpwd');      #登录卡密码，没有留空
$key = Plug_Set_Data('key');          #登录验证绑定机器码，软件配置控制开关
$maxoror = Plug_Set_Data('maxoror');  #登录控制多开设备的机器码，必须唯一不然达不到效果
$BSphpSeSsL = Plug_Set_Data('BSphpSeSsL');



#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

$daihao = PLUG_DAIHAO();


// //验证session是否正常，或者被踢出的需要更换BSphpSeSsL
// if(!Plug_Is_Session_Ok($BSphpSeSsL)){
//     Plug_Echo_Info('系统检测到SeSsL需要更换新.', -1092);
// }






if (Plug_App_DaTa('app_MoShi') != 'CardTerm') {
    
    Plug_Echo_Info($appen_str_log[5058], 5058);
}

if ($icid == '') {
    Plug_Echo_Info(Plug_Lang('请输入激活码'), -1);
}

//登陆前绑定-------------------------------------------------------------------------
//读取用户数据
$Get_DaTa = Plug_Get_Card_Info($icid, $icpwd, $daihao);
if (is_array($Get_DaTa)) {
    //判断是否已经解除绑定

    if ($Get_DaTa['L_key_info'] == '' and $key !== '') {
        //添加绑定
        $sql = "UPDATE`bs_php_pattern_login`SET `L_key_info`='$key' WHERE  `L_id`='{$Get_DaTa['L_id']}';";
        $tmp = Plug_Query($sql);
    }
}
//END
//-----------------------------------------

$log = Plug_Car_Login($icid, $icpwd, $key, $daihao);
if ($log == 1069) $log = Plug_Car_Login($icid, $icpwd, $key, $daihao);


if ($log == 1081) {




    /**
     * 建立登录限制
     * 控制用户多开操作
     */
    $log = Plug_Login_Multi_Control($icid, $daihao, $maxoror, $icid);
    if ($log != 5047) Plug_Echo_Info($appen_str_log[$log], $log);

    /**
     * 查询用户信息
     */
    $carinfo = Plug_Get_Card_Info($icid, $icpwd, $daihao);
    if ($carinfo == 1083 || $carinfo == 1084) Plug_Echo_Info($user_str_log[$arr_log], $arr_log);
    if ($carinfo['L_IsLock'] > 0) {
        Plug_Echo_Info(Plug_Lang('当前激活码已经被冻结禁止登录当前软件.'), 5055);
    }

    if (Plug_App_data('app_set') == 1) {
        if ((string)$carinfo['L_key_info'] != (string)$key) {

            //注销登录
            Plug_Set_Session_Value('ic_carid', ''); //登陆UID
            Plug_Set_Session_Value('ic_pwd', ''); //登陆MD7加密
            Plug_Set_Session_Value('USER_UID', '');

            Plug_Echo_Info('[5035]' . $appen_str_log[5035], 5035);
        }
    }




    //---------------------------------------


    //链接数验证


    //$login_ssl = MD5($BSphpSeSsL);
    Plug_Links_Add_Info('-1', $icid, $key, $daihao, $maxoror);


    //-----------------------------------------
    //记录登录时间用做扣点




    $ic_vipdate = date('Y-m-d H:i:s', $carinfo['L_vip_unix']);

    $ic_key = $carinfo['L_key_info'];

    $login_info = NULL;
    if ($key == $ic_key & $ic_key != '' or Plug_App_DaTa('app_set') == 0) $login_info = Plug_App_DaTa('app_logininfo');




    /**
     * 返回说明
     * 1.= 成功返回1
     * 2.= 登陆成功代号
     * 3.= 用户绑定key
     * 4.= 用户登陆成功返回特定数据
     * 5.= VIP到期时间
     */
    Plug_Echo_Info("01|1081|$ic_key|$login_info|$ic_vipdate|||||", 1081);
} else {

    Plug_Echo_Info($user_str_log[$log], $log);
}
