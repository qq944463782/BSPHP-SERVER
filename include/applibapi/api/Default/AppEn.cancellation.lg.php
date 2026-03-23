<?php


/***********************接口介绍说明******************************************
 * cancellation.lg
 * 注销登陆
 * *****************************************************************************
 */

$daihao = PLUG_DAIHAO();
$uid = Plug_Get_Session_Value('USER_UID');
$BSphpSeSsL = Plug_Set_Data('BSphpSeSsL');



$sql = "UPDATE `bs_php_links_session` SET  `links_user_name` = '' ,  `links_user_id` = '0' ,  `links_out_time` = '-2' , `links_set` = '-1' WHERE `links_session` = '{$BSphpSeSsL}' ;";
$tmp = Plug_Query($sql);

if ($tmp) {
   Plug_Set_Session_Value('USER_UID', ''); //登陆UID
   Plug_Set_Session_Value('USER_YSE', ''); //登陆MD7加密
   Plug_Set_Session_Value('USER_DATE', ''); //上一次登陆时间
   Plug_Set_Session_Value('USER_IP', ''); //上一次登陆IP
   Plug_Set_Session_Value('USER_MD7', ''); //OOKIE MD7验证串
   Plug_Links_Out_Session_Id($BSphpSeSsL);

   
   $log = Plug_User_Is_Login_Seesion();
   Plug_Echo_Info($log, 200);
} else {

   Plug_Echo_Info(-1, -1);
}
