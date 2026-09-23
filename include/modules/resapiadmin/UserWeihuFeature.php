<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class UserWeihuFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_run()
{
Plug_Admin_Assert_Qx('zh_4');
$select=Plug_Set_Post('select');
$only_user=Plug_Set_Post('checkbox');
$radio=(int) Plug_Set_Post('radiobutton');
$val=Plug_Set_Post('intval');
if ($val==='' || $val===null) {
$val=Plug_Set_Post('int');
}
if ($select==='all') {
$daiil="`user_daili`>'0'";
} elseif ($only_user) {
$daiil="`user_daili`='0'";
} else {
$daiil="`user_daili`>'0'";
}
if ($select==='user_all' || $select==='') {
$where=$daiil;
} elseif ($select==='out_1') {
$where="`user_IsLock`='1' AND {$daiil}";
} elseif ($select==='out_0') {
$where="`user_IsLock`='0' AND {$daiil}";
} elseif ($select==='login_not') {
$where="`user_LoGinNum`='0' AND {$daiil}";
} elseif ($select==='login_today') {
$today=date('Y-m-d', ����������������������������������������������������������������������������);
$where="`user_Login_date`>'{$today}' AND {$daiil}";
} elseif ($select==='all') {
$where="`user_daili`>'0'";
} else {
Plug_Admin_Fail(Plug_Lang('请选择维护的范围'));
}
if ($radio===1) {
if ($val==='' || $val===null || (float) $val < 0) {
Plug_Admin_Fail(Plug_Lang('请输入要添加金额'));
}
$n=(float) $val;
$rs=Plug_Query("SELECT `user_uid`,`user_rmb` FROM `bs_php_user` WHERE {$where}");
while ($u=Plug_Pdo_Fetch_Assoc($rs)) {
$before=(float) $u['user_rmb'];
$after=$before + $n;
Plug_Query("UPDATE `bs_php_user` SET `user_rmb`='{$after}' WHERE `user_uid`='{$u['user_uid']}'");
Plug_Add_Rmb_Log($u['user_uid'], $before, $after, Plug_Lang('后台批量加余额'), 'admin_weihu');
}
Plug_Admin_Ok(Plug_Lang('执行成功'));
}
if ($radio===2) {
if ($val==='' || $val===null || (float) $val < 0) {
Plug_Admin_Fail(Plug_Lang('请输入要减少金额'));
}
$n=(float) $val;
$rs=Plug_Query("SELECT `user_uid`,`user_rmb` FROM `bs_php_user` WHERE {$where}");
while ($u=Plug_Pdo_Fetch_Assoc($rs)) {
$before=(float) $u['user_rmb'];
$after=$before - $n;
Plug_Query("UPDATE `bs_php_user` SET `user_rmb`='{$after}' WHERE `user_uid`='{$u['user_uid']}'");
Plug_Add_Rmb_Log($u['user_uid'], $before, $after, Plug_Lang('后台批量减余额'), 'admin_weihu');
}
Plug_Admin_Ok(Plug_Lang('执行成功'));
}
if ($radio===3) {
$v=addslashes((string) $val);
Plug_Query("UPDATE `bs_php_user` SET `user_Zhe`='{$v}' WHERE {$where}");
Plug_Admin_Ok(Plug_Lang('执行成功'));
}
if ($radio===4) {
Plug_Query("UPDATE `bs_php_user` SET `user_IsLock`='1' WHERE {$where}");
Plug_Admin_Ok(Plug_Lang('执行成功'));
}
if ($radio===5) {
Plug_Query("UPDATE `bs_php_user` SET `user_IsLock`='0' WHERE {$where}");
Plug_Admin_Ok(Plug_Lang('执行成功'));
}
if ($radio===6) {
Plug_Query("DELETE FROM `bs_php_user` WHERE {$where}");
Plug_Admin_Ok(Plug_Lang('执行成功'));
}
if ($radio===7) {
if ($val==='' || !preg_match('/^\d+$/', (string) $val)) {
Plug_Admin_Fail(Plug_Lang('请输入未登录天数'));
}
$days=(int) $val;
$date=date('Y-m-d H:i:s', ���������������������������������������������������������������������������� - ($days * 86400));
Plug_Query("DELETE FROM `bs_php_user` WHERE {$where} AND `user_Login_date`<'{$date}'");
Plug_Admin_Ok(Plug_Lang('执行成功'));
}
Plug_Admin_Fail(Plug_Lang('请选择功能'));
}
}
