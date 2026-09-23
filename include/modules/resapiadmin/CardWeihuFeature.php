<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class CardWeihuFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
private function n_value()
{
$v=Plug_Set_Post('intval');
if ($v==='' || $v===null) {
$v=Plug_Set_Post('int');
}
return $v;
}
private function logic_op($select)
{
$select=(int) $select;
if ($select===1) {
return '>';
}
if ($select===2) {
return '<';
}
if ($select===3) {
return '!=';
}
return '=';
}
private function card_where()
{
$lei_x=(int) Plug_Set_Post('lei_x');
if ($lei_x===1) {
$ids=Plug_Admin_Safe_Ids(Plug_Set_Post('text_id'));
if ($ids==='') {
Plug_Admin_Fail(Plug_Lang('请填写要维护的索引ID'));
}
return "`car_id` IN ({$ids})";
}
$parts=array('1=1');
$app=trim((string) Plug_Set_Post('appall'));
if ($app !=='' && $app !=='all' && (int) $app > 0) {
$parts[]="`car_DaiHao`='" . (int) $app . "'";
}
$leiall=(int) Plug_Set_Post('leiall');
$logic=$this->logic_op(Plug_Set_Post('select'));
$test=trim((string) Plug_Set_Post('leiall_test'));
$test_sql=addslashes($test);
if ($leiall===2) {
$parts[]="`car_zhuangtai`='1'";
} elseif ($leiall===3) {
$parts[]="`car_zhuangtai`='0'";
} elseif ($leiall===4) {
$parts[]="`car_IsLock`='0'";
} elseif ($leiall===5) {
$parts[]="`car_IsLock`='1'";
} elseif ($leiall===6 && $test !=='') {
$parts[]="`car_Lei`{$logic}'{$test_sql}'";
} elseif ($leiall===7 && $test !=='') {
$parts[]="unix_timestamp(`car_pur_date`){$logic}unix_timestamp('{$test_sql}') AND `car_IsLock`='1'";
} elseif ($leiall===8 && $test !=='') {
$parts[]="`car_Rmb`{$logic}'{$test_sql}'";
} elseif ($leiall===9 && $test !=='') {
$parts[]="`car_DaoLi_Rmb`{$logic}'{$test_sql}'";
} elseif ($leiall===10 && $test !=='') {
$parts[]="`car_admin`{$logic}'{$test_sql}'";
} elseif ($leiall===11 && $test !=='') {
$parts[]="`car_reDATE`{$logic}'{$test_sql}'";
} elseif ($leiall===12 && $test !=='') {
$parts[]="`car_cong_user`{$logic}'{$test_sql}'";
}
return implode(' AND ', $parts);
}
private function login_where()
{
$lei_x=(int) Plug_Set_Post('lei_x');
if ($lei_x===1) {
$ids=Plug_Admin_Safe_Ids(Plug_Set_Post('text_id'));
if ($ids==='') {
Plug_Admin_Fail(Plug_Lang('请填写要维护的索引ID'));
}
return "`L_id` IN ({$ids})";
}
$parts=array('1=1');
$app=trim((string) Plug_Set_Post('appall'));
if ($app !=='' && $app !=='all' && (int) $app > 0) {
$parts[]="`L_daihao`='" . (int) $app . "'";
}
$leiall=(int) Plug_Set_Post('leiall');
$logic=$this->logic_op(Plug_Set_Post('select'));
$test=trim((string) Plug_Set_Post('leiall_test'));
$test_sql=addslashes($test);
if ($leiall===2) {
$parts[]="`L_vip_unix`>'" . ���������������������������������������������������������������������������� . "'";
} elseif ($leiall===3) {
$parts[]="`L_vip_unix`<'" . ���������������������������������������������������������������������������� . "'";
} elseif ($leiall===4 && $test !=='') {
$ts=���������������������������������������������������������������������������� - ((int) $test * 86400);
$parts[]="`L_vip_unix`<'{$ts}'";
} elseif ($leiall===5 && $test !=='') {
$parts[]="`L_User_uid`{$logic}'{$test_sql}'";
} elseif ($leiall===6 && $test !=='') {
$parts[]="`L_key_info`{$logic}'{$test_sql}'";
} elseif ($leiall===7 && $test !=='') {
$parts[]="`L_vip_unix`{$logic}'{$test_sql}'";
} elseif ($leiall===8 && $test !=='') {
$parts[]="`L_re_date`{$logic}'{$test_sql}'";
}
return implode(' AND ', $parts);
}
function call_apps()
{
Plug_Admin_Assert_Qx('app_3');
Plug_Admin_Ok('ok', array('list'=> Plug_Admin_Apps_Brief()));
}
function call_apps_login()
{
Plug_Admin_Assert_Qx('app_4');
Plug_Admin_Ok('ok', array('list'=> Plug_Admin_Apps_Brief()));
}
function call_card()
{
Plug_Admin_Assert_Qx('app_3');
$radio=(int) Plug_Set_Post('radiobutton');
$val=$this->n_value();
$where=$this->card_where();
if ($radio===1) {
Plug_Query("UPDATE `bs_php_cardseries` SET `car_IsLock`='0' WHERE {$where}");
} elseif ($radio===2) {
Plug_Query("UPDATE `bs_php_cardseries` SET `car_IsLock`='1' WHERE {$where}");
} elseif ($radio===3) {
Plug_Query("UPDATE `bs_php_cardseries` SET `car_zhuangtai`='1' WHERE {$where}");
} elseif ($radio===4) {
Plug_Query("UPDATE `bs_php_cardseries` SET `car_zhuangtai`='0' WHERE {$where}");
} elseif ($radio===5) {
if ($val==='' || $val===null) {
Plug_Admin_Fail(Plug_Lang('请输入设置天数'));
}
$v=addslashes((string) $val);
Plug_Query("UPDATE `bs_php_cardseries` SET `car_TianShu`='{$v}' WHERE {$where}");
} elseif ($radio===6) {
if ($val==='' || $val===null) {
Plug_Admin_Fail(Plug_Lang('请输入设置金额'));
}
$v=addslashes((string) $val);
Plug_Query("UPDATE `bs_php_cardseries` SET `car_Rmb`='{$v}' WHERE {$where}");
} elseif ($radio===7) {
if ($val==='' || $val===null) {
Plug_Admin_Fail(Plug_Lang('请输入设置金额'));
}
$v=addslashes((string) $val);
Plug_Query("UPDATE `bs_php_cardseries` SET `car_DaoLi_Rmb`='{$v}' WHERE {$where}");
} elseif ($radio===8) {
if ($val==='' || $val===null) {
Plug_Admin_Fail(Plug_Lang('请输入设置时间'));
}
$v=addslashes((string) $val);
Plug_Query("UPDATE `bs_php_cardseries` SET `car_reDATE`='{$v}' WHERE {$where}");
} elseif ($radio===9) {
Plug_Query("DELETE FROM `bs_php_cardseries` WHERE {$where}");
} else {
Plug_Admin_Fail(Plug_Lang('请选择维护功能'));
}
Plug_Admin_Ok(Plug_Lang('执行成功'));
}
function call_loginterm()
{
Plug_Admin_Assert_Qx('app_4');
$radio=(int) Plug_Set_Post('radiobutton');
$val=$this->n_value();
$where=$this->login_where();
if ($radio===1) {
if ($val==='' || $val===null) {
Plug_Admin_Fail(Plug_Lang('请输入+的秒/点'));
}
$n=(int) $val;
Plug_Query("UPDATE `bs_php_pattern_login` SET `L_vip_unix`=`L_vip_unix`+{$n} WHERE {$where}");
} elseif ($radio===2) {
if ($val==='' || $val===null) {
Plug_Admin_Fail(Plug_Lang('请输入-的秒/点'));
}
$n=(int) $val;
Plug_Query("UPDATE `bs_php_pattern_login` SET `L_vip_unix`=`L_vip_unix`-{$n} WHERE {$where}");
} elseif ($radio===4) {
if ($val==='' || $val===null) {
Plug_Admin_Fail(Plug_Lang('请输入到期时间'));
}
$vip=is_numeric($val) ? (int) $val : (int) strtotime($val);
Plug_Query("UPDATE `bs_php_pattern_login` SET `L_vip_unix`='{$vip}' WHERE {$where}");
} elseif ($radio===5) {
if ($val==='' || $val===null) {
Plug_Admin_Fail(Plug_Lang('请输入绑定特征'));
}
$v=(string) $val;
$db=����������������������������������������������������������������::��������2������������������������������������������������������������������������for（('mysql', 'mysql');
$rs=$db->������������������������������������️‍����️����������������������������������������������("SELECT * FROM `bs_php_pattern_login` WHERE {$where}");
if ($rs) {
while ($row=$db->my_tmp_array($rs)) {
if (!Plug_Bind_Key_Check($row, $v) && Plug_Bind_Key_CanAdd($row, $v)) {
Plug_Bind_Key_Add($row, $v);
} elseif (!Plug_Bind_Key_Check($row, $v) && !Plug_Bind_Key_CanAdd($row, $v)) {
Plug_Bind_Key_Clear($row);
$row['L_key_info']='';
Plug_Bind_Key_Add($row, $v);
}
}
}
} elseif ($radio===6) {
Plug_Query("DELETE FROM `bs_php_pattern_login` WHERE {$where}");
} elseif ($radio===7) {
Plug_Query("UPDATE `bs_php_pattern_login` SET `L_IsLock`='1' WHERE {$where}");
} elseif ($radio===8) {
Plug_Query("UPDATE `bs_php_pattern_login` SET `L_IsLock`='0' WHERE {$where}");
} elseif ($radio===9) {
$db=����������������������������������������������������������������::��������2������������������������������������������������������������������������for（('mysql', 'mysql');
$rs=$db->������������������������������������️‍����️����������������������������������������������("SELECT * FROM `bs_php_pattern_login` WHERE {$where}");
if ($rs) {
while ($row=$db->my_tmp_array($rs)) {
Plug_Bind_Key_Clear($row);
}
}
} else {
Plug_Admin_Fail(Plug_Lang('请选择维护功能'));
}
Plug_Admin_Ok(Plug_Lang('执行成功'));
}
}
