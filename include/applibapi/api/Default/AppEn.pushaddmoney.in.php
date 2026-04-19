<?php
/*
<api>
  <name>pushaddmoney.in</name>
  <title>GetPleaseregister.lg</title>
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
    <param name="user" required="false" type="string" desc="充值账号"></param>
    <param name="ka" required="false" type="string" desc="充值卡号"></param>
  </params>
</api>
*/



/***********************接口介绍说明******************************************
 * GetPleaseregister.lg
 * 余额充值 * 作废
 * *****************************************************************************
 */

$daihao = PLUG_DAIHAO();
$user = Plug_Set_Data('user'); //充值账号
$ka = Plug_Set_Data('ka'); //充值卡号


$array_user = Plug_Query_One('bs_php_user', 'user_user', $user, '`user_uid`,`user_user`,`user_rmb`');



if (!is_array($array_user)) {

  Plug_Echo_Info(Plug_Lang('充值账号不存在'));
}




$array_card = Plug_Query_One('plug_bsphp_car_addmoney', 'amoney_kaname', $ka, ' * ');
if (!is_array($array_card)) {

  Plug_Echo_Info(Plug_Lang('充值卡错误/或者不存在！'));
}

if ($array_card['amoney_lock'] == 1) {
  Plug_Echo_Info(Plug_Lang('充值卡已经冻结'));
}
if ($array_card['amoney_zhuangtai'] == 1) {
  Plug_Echo_Info(Plug_Lang('充值卡已经充值作废,请购买新充值使用！'));
}



$rmb_before = isset($array_user['user_rmb']) ? (float)$array_user['user_rmb'] : 0;
$rmb_after = $rmb_before + (float)$array_card['amoney_jine'];
$sql = "UPDATE`bs_php_user`SET`user_rmb`=`user_rmb`+'{$array_card['amoney_jine']}' WHERE`bs_php_user`.`user_user`='{$array_user['user_user']}';";
$tmp = Plug_Query($sql);
if ($tmp) {
  Plug_Add_Rmb_Log($array_user['user_user'], $rmb_before, $rmb_after, Plug_Lang('接口充值'));
  $date = PLUG_UNIX();

  $sql = "UPDATE`plug_bsphp_car_addmoney`SET `amoney_zhuangtai`='1',`amoeny_chong`='{$array_user['user_user']}',`amoney_yongtime`='$date' WHERE`plug_bsphp_car_addmoney`.`amoney_id`='{$array_card['amoney_id']}';";
  Plug_Query($sql);

  Plug_Echo_Info(Plug_Lang('充值成功'));
} else {
  Plug_Echo_Info(Plug_Lang('充值失败！'));
}
