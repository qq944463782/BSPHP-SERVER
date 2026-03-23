<?php


/**
 * **********************接口介绍说明******************************************
 * login_token.lg
 * 用户登录token
 * 用于验证软件通过WEB登陆之后一些初始化流程 token=BSphpSeSsL
 * *****************************************************************************
 */
#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');


$daihao = PLUG_DAIHAO();
$key = Plug_Set_Data('key');          #绑定特征,如果已经解除绑定会登录自动绑定
$maxoror = Plug_Set_Data('maxoror');  #控制多开机器数量机器码/唯一码
$img = Plug_Set_Data('img');          #登录验证码，软件配置开启
$BSphpSeSsL = Plug_Set_Data('BSphpSeSsL'); #token=BSphpSeSsL


if (Plug_App_DaTa('app_MoShi') !== 'LoginTerm') {

    Plug_Echo_Info($appen_str_log[5057], 5057);
}


$uid = Plug_Get_Session_Value('USER_UID');



//登陆状态
$log = Plug_User_Is_Login_Seesion();

if ($log == 1047) {



    /*查询是否重复绑定*/
    if (Plug_App_DaTa('app_key_zhong') == 1) {

        //查询该key是否已经在数据库
        $sql = "SELECT*FROM`bs_php_pattern_login`WHERE`L_daihao`='{$daihao}'AND`L_key_info`= '{$key}' LIMIT 1;";
        $zhong_arr = Plug_Query_Assoc($sql);


        if (!$zhong_arr) {
            $arr = Plug_Get_App_User_Info($uid, $daihao);
            //判断是否已经绑定过了
            if ($arr['L_key_info'] == '') {
                //添加绑定
                $sql = "UPDATE`bs_php_pattern_login`SET`L_key_info`='$key'WHERE  `L_id`='{$arr['L_id']}';";
                $tmp = Plug_Query($sql);
            }
        }
    } else {  #可重复绑定

        $arr = Plug_Get_App_User_Info($uid, $daihao);
        //判断是否已经绑定过了
        if ($arr and $arr['L_key_info'] == '') {
            //添加绑定
            $sql = "UPDATE`bs_php_pattern_login`SET`L_key_info`='$key'WHERE  `L_id`='{$arr['L_id']}';";
            $tmp = Plug_Query($sql);
        }
    }
}
//end
//------------------------------------------------------------------------------





if ($log == 1047) { #登录成功


    $user_info = Plug_Query_One('bs_php_user', 'user_uid', $uid, ' * ');
    if(empty($user_info)) {
        Plug_Echo_Info(Plug_Lang('用户不存在 UID:').$uid, -200);
    }

    $user = $user_info['user_user'];





    #获取软件用户信息
    $arr = Plug_Get_App_User_Info($uid, $daihao);



    #没有使用过的话就给程序添加上
    if (!$arr) {


        $date = (int)Plug_App_DaTa('app_re_date'); //获取赠送时间

        $date = PLUG_UNIX() + $date;

        /*查询是否重复绑定*/
        //查询该key是否已经在数据库
        $sql = "SELECT*FROM`bs_php_pattern_login`WHERE`L_daihao`='{$daihao}'AND`L_key_info`= '{$key}' LIMIT 1;";
        $zhong_arr = Plug_Query_Assoc($sql);
        if ($zhong_arr  and Plug_App_DaTa('app_key_zhong') == 1) {
            Plug_Echo_Info(Plug_Lang('[5009]绑定特征码,已经有人绑定过了,不能重复绑定,不能登陆'), 5009); //'绑定特征码,已经有人绑定过了,不能重复绑定,不能登陆'
        }

        if (Plug_App_Login_Add_Key($uid, $daihao, $date, $key, $user, $user)) {

            $arr = Plug_Get_App_User_Info($uid, $daihao);
        } else {
            Plug_Echo_Info(Plug_Lang('注册新用户失败,请联系管理员！'), -200);
        }
    }


    if ($arr['L_IsLock'] > 0) {
        Plug_Echo_Info(Plug_Lang('当前账号已经被冻结禁止登录当前软件.'), -200);
    }


    /**
     * 更新登录模式下最后登陆日期
     */
    $date = PLUG_DATE();
    $sql = "UPDATE`bs_php_pattern_login`SET`L_login_time`='$date'WHERE`bs_php_pattern_login`.`L_User_uid`='$uid'AND`bs_php_pattern_login`.`L_daihao`='$daihao';";
    Plug_Query($sql);

    #建立登录限制
    $log = Plug_Login_Multi_Control($user, $daihao, $maxoror, $uid);
    if ($log != 5047)
        Plug_Echo_Info($appen_str_log[$log], $log);



    #日志记录
    Plug_Add_AppenLog('user_login_log', Plug_Lang('软件登录 机器码:') . $key, $user);



    //获取用户信息赋值给变量
    $uesr_key = $arr['L_key_info'];
    $uesr_vipdate = $arr['L_vip_unix'];
    $login_info = null;
    if ($key == $uesr_key & $uesr_key != '' or Plug_App_DaTa('app_set') == 0)
        $login_info = Plug_App_DaTa('app_logininfo');


    //链接数验证


    //更新在线用户列表信息
    Plug_Links_Add_Info($uid, $user, $key, $daihao, $maxoror);


    //-----------------------------------------


    /**
     * 返回数据说明
     */
    if ($arr['L_vip_unix'] > PLUG_UNIX()) {

        //登陆成功  或者在免费使用


        if (Plug_App_DaTa('app_set') == 1) {


            if ($arr['L_key_info'] !== $key) {
                //注销登录
                Plug_Set_Session_Value('USER_UID', ''); //登陆UID
                Plug_Set_Session_Value('USER_YSE', ''); //登陆MD7加密
                Plug_Set_Session_Value('USER_DATE', ''); //上一次登陆时间
                Plug_Set_Session_Value('USER_IP', ''); //上一次登陆IP
                Plug_Set_Session_Value('USER_MD7', ''); //OOKIE MD7验证串
                //Plug_Links_Out_Session_Id($BSphpSeSsL); 注销不能用会注销锁定sessl

                if ($arr['L_key_info'] == '') Plug_Echo_Info(Plug_Lang("还没有绑定,请绑定在登录"), -3);





                Plug_Echo_Info('[5035]' . $appen_str_log[5035], 5035);
            }
        }


        //---------------------------------------


        //链接数验证

        //-----------------------------------------
        //记录登录时间用做扣点
        $UNIX = PLUG_UNIX();
        $sql = "UPDATE`bs_php_pattern_login`SET`L_timing`='$UNIX'WHERE`bs_php_pattern_login`.`L_User_uid`='$uid'AND`bs_php_pattern_login`.`L_daihao`='$daihao';";
        Plug_Query($sql);


        $uesr_vipdate = date('Y-m-d H:i:s', $uesr_vipdate);
        /**
         * 返回说明
         * 1.= 成功返回1
         * 2.= 登陆成功代号
         * 3.= 用户绑定key
         * 4.= 用户登陆成功返回特定数据
         * 5.= VIP到期时间
         */
        Plug_Echo_Info("01|1011|$uesr_key|$login_info|$uesr_vipdate|||||", 1011);
    } else {

        Plug_Echo_Info(Plug_Lang('[9908]使用已经到期.'), 9908);
    }
}

Plug_Echo_Info($user_str_log[$log], $log);
