<?php


/***********************接口介绍说明******************************************
 * cancellation.ic
 * 注销登录
 * *****************************************************************************
 */



$BSphpSeSsL = Plug_Set_Data('BSphpSeSsL');      #注销登录的BSphpSeSsL值
$car_id = Plug_Get_Session_Value('ic_carid');
$car_pwd = Plug_Get_Session_Value('ic_pwd');
$daihao = PLUG_DAIHAO();
$sql = "UPDATE `bs_php_links_session` SET  `links_user_name` = '' ,  `links_user_id` = '0' ,  `links_out_time` = '-2' , `links_set` = '-1' WHERE `links_session` = '$BSphpSeSsL' ;";
$tmp = Plug_Query($sql);

if ($tmp) {

  Plug_Echo_Info(1,200);
} else {

  Plug_Echo_Info(-1,-1);
}
