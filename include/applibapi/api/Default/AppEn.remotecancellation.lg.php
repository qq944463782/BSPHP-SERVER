<?php


/***********************接口介绍说明******************************************
 * remotecancellation.lg
 * 远程注销登陆
 * *****************************************************************************
 */
#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

$daihao = PLUG_DAIHAO();
$user = Plug_Set_Data('user');     #账号
$user_pwd = Plug_Set_Data('pwd');  #密码
$type = (int)Plug_Set_Data('type'); #=0 注销全部  非0=注销最早登录的/注销最早登录设备全部账号
$biaoji = Plug_Set_Data('biaoji');  #设备机器码全球唯一的，不限制设备使用量时候不填写


//转换真实user信息,顺序账户,邮箱,手机 uid+密码
$user = Plug_UserTageToUser($user, $user_pwd);


/**
 * 用户登陆
 */
$log = Plug_Is_User_Account($user, $user_pwd);
if ($log == 1011) {


    $uid = Plug_Query_One('bs_php_user', 'user_user', $user, '`user_uid`');
    if ($type == 0) {
        //查询是否注册使用过

        $tmp = Plug_Delete_All_UID($daihao, $uid);

        if ($tmp == 1) {
            Plug_Echo_Info($user_str_log[1116], 1116);
        } else {
            Plug_Echo_Info($user_str_log[1117], 1117);
        }
    } else {


        $log  = Plug_Login_Multi_Control($user, $daihao, $biaoji, $uid, 1);
        Plug_Echo_Info($this->appen_str_log[$log], $log);
    }
} //登录成功
Plug_Echo_Info($user_str_log[$log], $log);
