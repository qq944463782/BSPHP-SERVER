<?php
/*
<api>
  <name>login.lg</name>
  <title>用户登录</title>
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
    <param name="user" required="false" type="string" desc="登录账号"></param>
    <param name="pwd" required="false" type="string" desc="登录密码"></param>
    <param name="key" required="false" type="string" desc="绑定特征,如果已经解除绑定会登录自动绑定"></param>
    <param name="maxoror" required="false" type="string" desc="控制多开机器数量机器码/唯一码"></param>
    <param name="img" required="false" type="string" desc="登录验证码，软件配置开启"></param>
  </params>
</api>
*/



/**
 * **********************接口介绍说明******************************************
 * login.lg
 * 用户登录
 * *****************************************************************************
 */


$daihao = PLUG_DAIHAO();
$user = Plug_Set_Data('user');        #登录账号
$user_pwd = Plug_Set_Data('pwd');     #登录密码
$key = Plug_Set_Data('key');          #绑定特征,如果已经解除绑定会登录自动绑定
$maxoror = Plug_Set_Data('maxoror');  #控制多开机器数量机器码/唯一码
$img = Plug_Set_Data('img');          #登录验证码，软件配置开启

$BSphpSeSsL = Plug_Set_data('BSphpSeSsL');
#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

if (Plug_App_data('app_MoShi') !== 'LoginPoint') {
    //Plug_Echo_Info('1119'); //不对应的模式
    //Plug_Echo_Info('[1119]当前软件是账号登录模式,需要账号登录扣点模式下软件使用.', 1119);
    Plug_Echo_Info($appen_str_log[5057], 5057);
}


//转换真实user信息,顺序账户,邮箱,手机 uid+密码
$user = Plug_UserTageToUser($user, $user_pwd);


$log = Plug_User_Web_Login($user, $user_pwd);


//登录前检查绑定--------------------------------------------------------------------------------

if ($log == 1011) { //登录成功

    //读取用户配置
    $uid = Plug_Query_One('bs_php_user', 'user_user', $user, '`user_uid`');

    /*查询是否重复绑定 / 登录自动追加绑定*/
    $arr = Plug_Get_App_User_Info($uid, $daihao);
    if ($arr && $key !== '') {
        if (Plug_App_data('app_key_zhong') == 1) {
            $zhong_arr = Plug_Login_Key_Zhong($daihao, $key);
            if ($zhong_arr && (int)$zhong_arr['L_id'] !== (int)$arr['L_id']) {
                // 已被他人占用，不自动绑
            } elseif (!Plug_Bind_Key_Check($arr, $key) && Plug_Bind_Key_CanAdd($arr, $key)) {
                Plug_Bind_Key_Add($arr, $key);
            }
        } else {
            if (!Plug_Bind_Key_Check($arr, $key) && Plug_Bind_Key_CanAdd($arr, $key)) {
                Plug_Bind_Key_Add($arr, $key);
            }
        }
    }
}
//end
//------------------------------------------------------------------------------





if ($log == 1011) { //登录成功

    $uid = Plug_Query_One('bs_php_user', 'user_user', $user, '`user_uid`');


    
    //查询是否注册使用过
    $arr = Plug_Get_App_User_Info($uid, $daihao);


    if (!$arr) {
        $app_re_date = (int)Plug_App_data('app_re_date'); //获取赠送时间
        /*查询是否重复绑定*/
        $zhong_arr = Plug_Login_Key_Zhong($daihao, $key);

        if ($zhong_arr != false & Plug_App_data('app_key_zhong') == 1)
            Plug_Echo_Info(Plug_Lang('[5009]绑定特征码,已经有人绑定过了,不能重复绑定,不能登录'), 5009); 
            //'绑定特征码,已经有人绑定过了,不能重复绑定,不能登录'

        if (Plug_App_Login_Add_Key($uid, $daihao, $app_re_date, $key, $user, $user)) {
            $arr = Plug_Get_App_User_Info($uid, $daihao);
        } else {
            Plug_Echo_Info(Plug_Lang('注册新用户失败,请联系管理员！'), -1);
        }
    }





    if ($arr['L_IsLock'] > 0) {
        Plug_Echo_Info(Plug_Lang('当前账号已经被冻结禁止登录当前软件.'), -200);
    }

    /**
     * 更新登录模式下最后登录 IP 与时间
     */
    $date = PLUG_DATE();
    $login_ip = addslashes(Plug_Get_IP());
    $sql = "UPDATE `bs_php_pattern_login` SET `L_login_ip`='{$login_ip}',`L_login_time`='{$date}' WHERE `bs_php_pattern_login`.`L_User_uid`='{$uid}' AND `bs_php_pattern_login`.`L_daihao`='{$daihao}';";
    Plug_Query($sql);

    #建立登录限制
    $log = Plug_Login_Multi_Control($user, $daihao, $maxoror, $uid);
    if ($log != 5047)
        Plug_Echo_Info($appen_str_log[$log], $log);


    #日志记录：账号、绑定机器码、多开机器码
    Plug_Add_AppenLog('user_login_log', Plug_Lang('账号扣点模式登录 账号:') . $user . Plug_Lang(' 机器码:') . $key . Plug_Lang(' 多开机器码:') . $maxoror, $user);


    //获取用户信息赋值给变量
    $uesr_key = $arr['L_key_info'];
    $uesr_vipdate = $arr['L_vip_unix'];
    $login_info = null;
    if (Plug_Bind_Key_Check($arr, $key) || Plug_App_data('app_set') == 0)
        $login_info = Plug_App_data('app_logininfo');


    //链接数验证
    Plug_Links_Add_Info($uid, $user, $key, $daihao, $maxoror);


    //-----------------------------------------
    /**
     * 返回数据说明
     */
    if ($arr['L_vip_unix'] > 0) {
        
        //登录成功  或者在免费使用


        if (Plug_App_data('app_set') == 1) {
            $bind_ok = Plug_Bind_Key_Login_Ensure($arr, $key, true);
            if ($bind_ok !== 1) {
                Plug_Set_Session_Value('USER_UID', '');
                Plug_Set_Session_Value('USER_YSE', '');
                Plug_Set_Session_Value('USER_DATE', '');
                Plug_Set_Session_Value('USER_IP', '');
                Plug_Set_Session_Value('USER_MD7', '');
                if ($bind_ok === -1) Plug_Echo_Info(Plug_Lang("还没有绑定,请先绑定再登录"), -3);
                Plug_Echo_Info('[5035]' . $appen_str_log[5035], 5035);
            }
            $arr = Plug_Get_App_User_Info($uid, $daihao);
        }



        //-----------------------------------------
        //记录登录时间用做扣点
        $UNIX = PLUG_UNIX();
        $sql = "UPDATE`bs_php_pattern_login`SET`L_timing`='$UNIX'WHERE`bs_php_pattern_login`.`L_User_uid`='$uid'AND`bs_php_pattern_login`.`L_daihao`='$daihao';";
        Plug_Query($sql);


        /**
         * 返回说明
         * 1.= 成功返回1
         * 2.= 登录成功代号
         * 3.= 用户绑定key
         * 4.= 用户登录成功返回特定数据
         * 5.= VIP到期时间
         */
        Plug_Echo_Info("01|1011|$uesr_key|$login_info|$uesr_vipdate|||||", 1011);
    } else {

        Plug_Echo_Info(Plug_Lang('[9908]使用已经到期.'), 9908);
    }
}
Plug_Echo_Info($user_str_log[$log]);
