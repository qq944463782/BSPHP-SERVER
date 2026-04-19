<?php
/*
<api>
  <name>cancellation.lg</name>
  <title>注销登陆</title>
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
    <param name="BSphpSeSsL" required="false" type="string" desc="会话标识"></param>
  </params>
</api>
*/



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
