<?php



/***********************接口介绍说明******************************************
 * chong.lg
 * 软件使用期充值 
 * *****************************************************************************
 */


$daihao = PLUG_DAIHAO();
$user = Plug_Set_Data('user');          #充值用户
$userpwd = Plug_Set_Data('userpwd');    #充值密码
$userset = Plug_Set_Data('userset');    #是否需要验证密码=1需要验证密码
$ka = Plug_Set_Data('ka');              #充值卡号
$pwd = Plug_Set_Data('pwd');            #充值卡密码


#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');


 //转换真实user信息,顺序账户,邮箱,手机 uid+密码
 $user = Plug_UserTageToUser($user, $userpwd);


if ($userset == '1') {
  $log = Plug_Is_User_Account($user, $userpwd);
  if ($log != 1011) Plug_Echo_Info($user_str_log[$log],$log);
}

if($ka==''){
  Plug_Echo_Info(Plug_Lang('请输入充值卡号'),-1);
}

$sql = "SELECT *  FROM `bs_php_cardseries` WHERE `car_name` = '{$ka}'  ";
$arrcar = Plug_Query_Assoc($sql);
if (!$arrcar) {
  Plug_Echo_Info($user_str_log[1138],1138);
}


 $sql = "SELECT `app_daihao`,`app_MoShi`,`car_DaiHao`,`app_name`  FROM `bs_php_cardseries`,`bs_php_appinfo` WHERE `car_name` LIKE '{$ka}' AND `app_daihao`= `car_DaiHao` ";
$arr = Plug_Query_Assoc($sql);



if (!$arr) {
  Plug_Echo_Info($user_str_log[1135], 1135);
}



#验证是否当前软件，很多用户拿A软件卡到B软件充值说B软件没时间，时间到对应卡软件上！
if ($arr["" . 'app_daihao'] == $daihao) {

  if ($arr["" . 'app_MoShi'] == 'LoginPoint' or $arr["" . 'app_MoShi'] == 'LoginTerm') {

    $log = Plug_User_Chong($user, $ka, $pwd);
    Plug_Echo_Info($user_str_log[$log],$log);
  } else {

    Plug_Echo_Info($user_str_log[1139], 1139);
  }
} else {
  $a  =   str_replace("[软件]", $arr["" . 'app_name'], $user_str_log[1137]);
  Plug_Echo_Info($a, 1137);
}
