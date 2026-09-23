<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class AdminPlugFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
private function assert_qx()
{
Plug_Admin_Assert_Qx('top_9');
}
private function lines_from($text)
{
$text=str_replace("\r\n", "\n", (string) $text);
$text=str_replace("\r", "\n", $text);
$arr=explode("\n", $text);
$out=array();
foreach ($arr as $v) {
$v=trim($v);
if ($v !=='') {
$out[]=$v;
}
}
return $out;
}
function call_apps()
{
$this->assert_qx();
$rs=Plug_Query("SELECT `app_daihao`,`app_name`,`app_MoShi` FROM `bs_php_appinfo` ORDER BY `app_daihao` ASC");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=array(
'daihao'=> (string) $v['app_daihao'],
'name'=> $v['app_name'],
'moshi'=> isset($v['app_MoShi']) ? $v['app_MoShi'] : '',
);
}
Plug_Admin_Ok('ok', array('list'=> $list));
}
function call_add()
{
$this->assert_qx();
$daihao=(int) Plug_Set_Post('daihao');
$name=trim((string) Plug_Set_Post('name'));
if ($daihao <=0) {
Plug_Admin_Fail(Plug_Lang('请选择软件'));
}
if ($name==='') {
Plug_Admin_Fail(Plug_Lang('请输入添加的ID名'));
}
$name_sql=addslashes($name);
$exists=Plug_Query_Array(
"SELECT `L_id` FROM `bs_php_pattern_login` WHERE `L_User_uid`='{$name_sql}' AND `L_daihao`='{$daihao}' LIMIT 1"
);
if ($exists) {
Plug_Admin_Fail(Plug_Lang('已经存在'));
}
����������������������������������������������������������������::����������������������������N��������������������������������������������������������('applib', 'appen_appuser');
for（��������������������������������������������������������������������������������($name, $daihao, time(), '');
Plug_Admin_Ok(Plug_Lang('指令执行,到对应软件用户下查看即可'));
}
function call_carsoso()
{
$this->assert_qx();
$text=Plug_Set_Post('sosotxt');
if ($text==='') {
$text=Plug_Set_Post('textarea');
}
$lines=$this->lines_from($text);
if (!$lines) {
Plug_Admin_Fail(Plug_Lang('请输入卡号'));
}
$all='';
$unused='';
$used='';
$frozen='';
$missing='';
foreach ($lines as $v) {
$v_sql=addslashes($v);
$info=Plug_Query_Array(
"SELECT `car_admin`,`car_id`,`car_zhuangtai`,`car_IsLock`,`car_pur_date`,`car_cong_user` FROM `bs_php_cardseries` WHERE `car_name`='{$v_sql}' LIMIT 1"
);
if (!$info) {
$all .=$v . Plug_Lang(' >>>激活码不存在') . "\n";
$missing .=$v . "\n";
continue;
}
$admin_name=Plug_Lang('无法查阅制卡人');
$admin_uid=$info['car_admin'];
if ($admin_uid !=='' && $admin_uid !==null) {
$uid_sql=addslashes((string) $admin_uid);
$user=Plug_Query_Array("SELECT `user_user` FROM `bs_php_user` WHERE `user_uid`='{$uid_sql}' LIMIT 1");
if ($user && !empty($user['user_user'])) {
$admin_name=$user['user_user'];
}
}
if ((int) $info['car_zhuangtai']===1) {
$all .=$v . Plug_Lang(' >>>您查询的授权码被冻结,制卡人：') . $admin_name . "  \n";
$frozen .=$v . "\n";
continue;
}
if ((int) $info['car_IsLock']===1) {
$login_name=Plug_Lang('卡号');
$vip_unix=0;
if (isset($info['car_cong_user']) && $info['car_cong_user']==='cardid') {
$login=Plug_Query_Array(
"SELECT `L_id`,`L_vip_unix` FROM `bs_php_pattern_login` WHERE `L_User_uid`='{$v_sql}' LIMIT 1"
);
$login_name=Plug_Lang('卡号');
} else {
$login=Plug_Query_Array(
"SELECT `L_id`,`L_vip_unix` FROM `bs_php_pattern_login` WHERE `L_ic_pwd`='{$v_sql}' LIMIT 1"
);
$login_name=$info['car_cong_user'];
}
if ($login) {
$vip_unix=(int) $login['L_vip_unix'];
}
$expire=$vip_unix > 0 ? date('Y-m-d H:i:s', $vip_unix) : '-';
$all .=$v . Plug_Lang(' >>>授权码已激活,制卡人：') . $admin_name . ' '
. Plug_Lang('激活时间:') . $info['car_pur_date'] . ' '
. Plug_Lang('到期时间:') . $expire
. Plug_Lang(' 充值账号:') . $login_name . "\n";
$used .=$v . "\n";
} else {
$all .=$v . Plug_Lang(' >>>您查询的授权码未激活,制卡人：') . $admin_name . "  \n";
$unused .=$v . "\n";
}
}
$result=Plug_Lang('-------------全部激活码-------------') . "\n" . $all
. Plug_Lang('-------------全部未激活-------------') . "\n" . $unused
. Plug_Lang('-------------全部已激活-------------') . "\n" . $used
. Plug_Lang('-------------全部已冻结-------------') . "\n" . $frozen
. Plug_Lang('-------------全部不存在-------------') . "\n" . $missing;
Plug_Admin_Ok('ok', array(
'text'=> $result,
'groups'=> array(
'all'=> $all,
'unused'=> $unused,
'used'=> $used,
'frozen'=> $frozen,
'missing'=> $missing,
),
'count'=> count($lines),
));
}
function call_caroff()
{
$this->assert_qx();
$this->run_card_lock(1);
}
function call_caron()
{
$this->assert_qx();
$this->run_card_lock(0);
}
private function run_card_lock($lock)
{
$lock=(int) $lock===1 ? 1 : 0;
$lines=$this->lines_from(Plug_Set_Post('textarea'));
if (!$lines) {
$lines=$this->lines_from(Plug_Set_Post('sosotxt'));
}
if (!$lines) {
Plug_Admin_Fail(Plug_Lang('请输入卡号'));
}
$n=0;
foreach ($lines as $v) {
$v_sql=addslashes($v);
Plug_Query("UPDATE `bs_php_cardseries` SET `car_zhuangtai`='{$lock}' WHERE `car_name`='{$v_sql}'");
$card=Plug_Query_Array("SELECT * FROM `bs_php_cardseries` WHERE `car_name`='{$v_sql}' LIMIT 1");
if ($card) {
$daihao=addslashes((string) $card['car_DaiHao']);
$name=addslashes((string) $card['car_name']);
$chong=addslashes((string) $card['car_chong_uid']);
Plug_Query(
"UPDATE `bs_php_pattern_login` SET `L_IsLock`='{$lock}' WHERE `L_daihao`='{$daihao}' AND (`L_User_uid`='{$name}' OR `L_ic_pwd`='{$name}')"
);
if ($chong !=='') {
Plug_Query(
"UPDATE `bs_php_pattern_login` SET `L_IsLock`='{$lock}' WHERE `L_daihao`='{$daihao}' AND `L_User_uid`='{$chong}' AND `L_ic_pwd`='{$chong}'"
);
}
$n++;
}
}
Plug_Admin_Ok(Plug_Lang('执行完毕'), array('matched'=> $n, 'input'=> count($lines)));
}
function call_cardel()
{
$this->assert_qx();
$lines=$this->lines_from(Plug_Set_Post('textarea'));
if (!$lines) {
$lines=$this->lines_from(Plug_Set_Post('sosotxt'));
}
if (!$lines) {
Plug_Admin_Fail(Plug_Lang('请输入卡号'));
}
$n=0;
foreach ($lines as $v) {
$v_sql=addslashes($v);
$card=Plug_Query_Array("SELECT * FROM `bs_php_cardseries` WHERE `car_name`='{$v_sql}' LIMIT 1");
if (!$card) {
continue;
}
$daihao=addslashes((string) $card['car_DaiHao']);
$name=addslashes((string) $card['car_name']);
$chong=addslashes((string) $card['car_chong_uid']);
if (isset($card['car_cong_user']) && $card['car_cong_user']==='cardid') {
Plug_Query("DELETE FROM `bs_php_pattern_login` WHERE `L_daihao`='{$daihao}' AND `L_User_uid`='{$name}'");
} elseif ($chong !=='') {
Plug_Query(
"DELETE FROM `bs_php_pattern_login` WHERE `L_daihao`='{$daihao}' AND `L_User_uid`='{$chong}' AND `L_ic_pwd`='{$chong}'"
);
}
Plug_Query("DELETE FROM `bs_php_cardseries` WHERE `car_name`='{$v_sql}'");
$n++;
}
Plug_Admin_Ok(Plug_Lang('执行完毕'), array('deleted'=> $n, 'input'=> count($lines)));
}
}
