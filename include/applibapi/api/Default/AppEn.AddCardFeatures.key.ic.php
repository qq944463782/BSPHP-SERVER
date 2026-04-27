<?php
/*
<api>
  <name>AddCardFeatures.key.ic</name>
  <title>自定义卡激活码/机器码激活验证/没有就注册</title>
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
    <param name="carid" required="false" type="string" desc="需要登录特征，没有就会注册"></param>
    <param name="key" required="false" type="string" desc="绑定特征"></param>
    <param name="maxoror" required="false" type="string" desc="多开控制唯一特征码"></param>
    <param name="app_user_extra" required="false" type="string" desc="软件用户拓展字段(JSON文本字符串)"></param>
  </params>
</api>
*/



/***********************接口介绍说明******************************************
 * AddCardFeatures.key.ic
 * 自定义卡激活码/机器码激活验证/没有就注册
 * *****************************************************************************
 */

$key_carid = Plug_Set_Data('carid');  #需要登录特征，没有就会注册
$key = Plug_Set_Data('key');          #绑定特征
$maxoror = Plug_Set_Data('maxoror');  #多开控制唯一特征码
$app_user_extra = Plug_Set_Data('app_user_extra');  #软件用户拓展字段(JSON文本字符串)
$daihao = PLUG_DAIHAO();

#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

if (Plug_App_DaTa('app_MoShi') !== 'CardTerm') {

    Plug_Echo_Info($user_str_log[1119], 1119);
}




if ($key == '') Plug_Echo_Info(Plug_Lang('key不能空'), -1);



$log = Plug_Car_Login($key_carid, '', $key, $daihao);

//1073不存在给系统添加注册
if ($log == 1073) {

    if (Plug_App_DaTa('app_MoShi') == 'CardTerm') {
        $date = (int)Plug_App_DaTa('app_re_date'); //获取赠送时间
        $date = PLUG_UNIX() + $date;
    }



    Plug_App_Login_Add_Key($key_carid, $daihao, $date, $key, '', '', '0', 0, 0, $app_user_extra);

    //再次登录验证
    $log = Plug_Car_Login($key_carid, '', $maxoror, $daihao);
}


if ($log == 1081) {


    //建立登录限制
    $log = Plug_Login_Multi_Control($key_carid, $daihao, $maxoror, $key_carid);
    if ($log != 5047)
        Plug_Echo_Info($appen_str_log[$log], $log);

    /**
     * 查询用户信息
     */
    $carinfo = Plug_Get_Card_Info($key_carid, '', $daihao);
    if ($carinfo == 1083 || $carinfo == 1084) {
        Plug_Echo_Info($user_str_log[$arr_log], $arr_log);
    }

    //检测是否验证绑定特征
    if (Plug_App_DaTa('app_set') == 1) {
        if ((string)$carinfo['L_key_info'] != (string)$key) {

            //注销登录
            Plug_Set_Session_Value('ic_carid', ''); //登陆UID
            Plug_Set_Session_Value('ic_pwd', ''); //登陆MD7加密
            Plug_Set_Session_Value('USER_UID', '');

            Plug_Echo_Info(Plug_Lang('[5035]非绑定机器，到绑定机器登录'), 5035);
        }
    }


    //---------------------------------------<?php echo Plug_Lang('说明地址'); 


    //链接数验证
    Plug_Links_Add_Info('-1', $key_carid, $key, $daihao, $maxoror);


    //-----------------------------------------
    //记录登录时间用做扣点


    $ic_vipdate =  $carinfo['L_vip_unix'];
    $ic_vipdate = date('Y-m-d H:i:s', $ic_vipdate);
    $ic_key = $carinfo['L_key_info'];

    $login_info = null;
    /*if ($key = $ic_key & $ic_key != '')*/
    $login_info = Plug_App_DaTa('app_logininfo');


    /**
     * 返回数据说明
     */
    if ($carinfo['L_vip_unix'] > PLUG_UNIX()) {
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
        Plug_Echo_Info(Plug_Lang('[9908]使用到期请续费.'), 9908);
    }
} else {

    Plug_Echo_Info($user_str_log[$log], $log);
}
