<?php


/***********************接口介绍说明******************************************
 * jiekey.lg
 * 解除绑定
 * *****************************************************************************
 */
#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

$daihao = PLUG_DAIHAO();
$uid = Plug_Get_Session_Value('USER_UID');
$user = Plug_Set_data('user');
$pwd = Plug_Set_data('pwd');


//转换真实user信息,顺序账户,邮箱,手机 uid+密码
$user = Plug_UserTageToUser($user, $pwd);

//检测登录状态
if ($user != "" and $pwd != "") {
    $log = Plug_Is_User_Account($user, $pwd);

    //读取用户配置
    $User_Info = Plug_Query_One('bs_php_user', 'user_user', $user, '`user_uid`,`user_daili`,`user_user`');
    $uid = $User_Info['user_uid'];
} else {
    //登录连接数功能集代码
    // links_chaoshi_login();
    $log = Plug_User_Is_Login_Seesion();
}


if ($log == 1047 or $log == 1011) {


    //判断是否已经过期
    $arr = Plug_Get_App_User_Info($uid, $daihao);
    //判断是否已经绑定过了
    if ($arr['L_key_info'] == '')
        Plug_Echo_Info(Plug_Lang('已经是解除绑定了'), 200);

    //双模双判断
    if ($arr['L_vip_unix'] > 0) {
        /////////////////时间没有到期继续////////////////////

        //*********************判断转绑定后是否会到期
        $app_date = Plug_App_data('app_zhuang_date');
        //$app_date=$app_date*3600;
        $date = $arr['L_vip_unix'];

        $date = $date - $app_date;
        //双模双判断
        if ($date < 0)
            Plug_Echo_Info(Plug_Lang('解除绑定后将到0点数,解除绑定拒绝!'), -1);


        //解除绑定
        $sql = "UPDATE`bs_php_pattern_login`SET`L_key_info`='',`L_vip_unix`='$date' WHERE`L_id` ='{$arr['L_id']}'";
        $tmp = Plug_Query($sql);

        if ($tmp) {


            Plug_Echo_Info(Plug_Lang('解除绑定成功!,剩余点数:') . $date, 200);
        } else {
            Plug_Echo_Info(Plug_Lang('解除绑定失败,请重试!'), -1);
        }
    } else {

        $sql = "UPDATE`bs_php_pattern_login`SET`L_key_info`='' WHERE`L_id` ='{$arr['L_id']}'";
        $tmp = Plug_Query($sql);

        Plug_Echo_Info(Plug_Lang('使用期到了被强制解绑了'), 200);
    }
}
Plug_Echo_Info($user_str_log[$log], $log);
