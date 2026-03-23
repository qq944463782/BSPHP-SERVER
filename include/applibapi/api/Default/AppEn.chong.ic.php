<?php



/***********************接口介绍说明******************************************
 * chong.ic
 * 卡模式软件使用期充值
 * *****************************************************************************
 */


$daihao = PLUG_DAIHAO();
$icid = Plug_Set_Data('icid');   #充值的卡模式下账号，可以用新卡转化时间或者AddCardFeatures.key.ic 充值
$ka = Plug_Set_Data('ka');       #充值的卡号
$pwd = Plug_Set_Data('pwd');     #充值的卡号密码


#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

$sql = "SELECT *  FROM `bs_php_cardseries` WHERE `car_name` = '{$ka}'  ";
$arrcar = Plug_Query_Assoc($sql);
if (!$arrcar) {
   Plug_Echo_Info($user_str_log[1138], 1138);
}


$sql = "SELECT `app_daihao`,`app_MoShi`,`car_DaiHao`,`app_name`  FROM `bs_php_cardseries`,`bs_php_appinfo` WHERE `car_name` LIKE '{$ka}' AND `app_daihao`= `car_DaiHao` ";
$arr = Plug_Query_Assoc($sql);



if (!$arr) {
   Plug_Echo_Info($user_str_log[1135], 1135);
}



if ($arr["" . 'app_daihao'] == $daihao) {




   if ($arr["" . 'app_MoShi'] == 'LoginPoint' or $arr["" . 'app_MoShi'] == 'LoginTerm') {
      Plug_Echo_Info($user_str_log[1140], 1140);
   } else {



      $log = Plug_User_Chong_card($icid, $ka, $pwd);
      Plug_Echo_Info($user_str_log[$log], $log);
   }
} else {
   $a  =   str_replace("[软件]", $arr["" . 'app_name'], $user_str_log[1137]);
   Plug_Echo_Info($a, 1137);
}
