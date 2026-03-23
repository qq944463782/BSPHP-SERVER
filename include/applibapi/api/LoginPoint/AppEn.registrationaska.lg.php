<?php


/***********************接口介绍说明******************************************
 * registrationaska.lg
 * 注册账号 带卡注册
 * *****************************************************************************
 */
#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

$daihao = PLUG_DAIHAO();
$user = Plug_Set_Data('user');
$pwd = Plug_Set_Data('pwd');
$pwdb = Plug_Set_Data('pwdb');
$qq = Plug_Set_Data('qq');
$mail = Plug_Set_Data('mail');

$key = Plug_Set_Data('key');
$img = Plug_Set_Data('img');


$kaid = Plug_Set_Data('kaid');
$kapwd = Plug_Set_Data('kapwd');



$Mobile = Plug_Set_Data('mobile');
$user_mibao_wenti = Plug_Set_Data('mibao_wenti');
$user_mibao_daan = Plug_Set_Data('mibao_daan');

$extension = Plug_Set_Data('extension');


/**
 * 判断检测账号重复
 */

$sql = "SELECT*FROM`bs_php_pattern_login`WHERE`L_daihao`='$daihao'AND`L_key_info`LIKE \"$key\";";
$tmp = Plug_Query_Assoc($sql);
if (Plug_App_DaTa('app_key_zhong') == 1 & $tmp) {

    Plug_Echo_Info(Plug_Lang('[5010],当前账号已经注册过,无法在同一环境注册多个账号'), 5010);

}



#查询激活码是否存在
$sql = "SELECT * FROM  `bs_php_cardseries` WHERE  `car_name` =  '$kaid' and `car_pwd` =  '$kapwd'  and `car_DaiHao` =  '$daihao'  LIMIT 1;";
$tmp = Plug_Query_Assoc($sql);
if (!$tmp) {
    Plug_Echo_Info("激活码无效", -1); //当前绑定特征已经有人绑定了 

}

if ($tmp['car_IsLock'] == 1) {
    Plug_Echo_Info("激活码无效", -1); //当前绑定特征已经有人绑定了 

}


/**
 * 判断邀请注册IUD是否存在
 */

if ($extension > 0) {
    $uid_extension = Plug_Query_One('bs_php_user', 'user_uid', $extension, '`user_uid`');
    if (!$uid_extension)
        Plug_Echo_Info('推荐人不错误,没有请不要填写！', -2);
}
/**
 * 用户注册
 */
$log = Plug_User_Re_Add($user, $pwd, $pwdb, $qq, $mail, $extension, $Mobile, $user_mibao_wenti, $user_mibao_daan);
if ($log == 1005) {


    $date = (int)Plug_App_DaTa('app_re_date'); //获取赠送时间


    // /*查询是否重复绑定*/
    $uid = Plug_Query_One('bs_php_user', 'user_user', $user, '`user_uid`');



    Plug_App_Login_Add_Key($uid, $daihao, $date, $key, $user, $user); //添加软件下用户

    Plug_User_Chong($user, $kaid, $kapwd, $daihao);

    if ((int)Plug_App_DaTa('app_re_date') == 0) {
        Plug_Echo_Info('注册成功', 1005);
    } else {

       
        Plug_Echo_Info('注册成功,恭喜你获得了' . $date . '点使用期限', 1005);
    }
}
Plug_Echo_Info($user_str_log[$log], $log);
