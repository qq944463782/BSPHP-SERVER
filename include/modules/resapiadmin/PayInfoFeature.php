<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class PayInfoFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_table_json()
{
Plug_Admin_Assert_Qx('cz_2');
$p=Plug_Admin_Pager();
$soso=Plug_Set_Get('soso');
$where="(`ali_id` LIKE '%{$soso}%' OR `pay_uid` LIKE '%{$soso}%' OR `pay_id` LIKE '%{$soso}%')";
$DESC_id=(int) Plug_Set_Get('DESC');
$DESC=$DESC_id==1 ? 'ASC' : 'DESC';
$cnt=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_pay_log` WHERE {$where}");
$rs=Plug_Query("SELECT * FROM `bs_php_pay_log` WHERE {$where} ORDER BY `ali_id` {$DESC} LIMIT {$p['offset']},{$p['limit']}");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=$v;
}
Plug_Admin_List_Json($list, (int) ($cnt['hangshu'] ?? 0));
}
function call_batch()
{
Plug_Admin_Assert_Qx('cz_2');
$select=(int) Plug_Set_Post('select_class');
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
if ($select==1) {
if ($all==='') {
Plug_Admin_Fail(Plug_Lang('没有选择记录条目！'));
}
Plug_Query("DELETE FROM `bs_php_pay_log` WHERE `ali_id` IN ({$all})");
Plug_Admin_Ok(Plug_Lang('订单信息已经删除'));
}
Plug_Admin_Fail(Plug_Lang('你没有选择操作项目!'));
}
function call_manual_complete()
{
Plug_Admin_Assert_Qx('cz_2');
$pay_id=trim(Plug_Set_Post('pay_id'));
if ($pay_id==='') {
Plug_Admin_Fail(Plug_Lang('缺少订单号'));
}
$pay_id_sql=addslashes($pay_id);
$done=Plug_Query_Array("SELECT * FROM `bs_php_pay_log` WHERE `pay_id`='{$pay_id_sql}' AND `pay_zhuangtai`='1' LIMIT 1");
if ($done) {
Plug_Admin_Ok(Plug_Lang('订单已成功完成,不需要再操作'));
}
$row=Plug_Query_Array("SELECT `ka_shijia` FROM `bs_php_pay_log` WHERE `pay_id`='{$pay_id_sql}' LIMIT 1");
$rmb=($row && isset($row['ka_shijia'])) ? (float) $row['ka_shijia'] : -1;
if (!class_exists('user')) {
����������������������������������������������������������������::for（�️‍���������������������������������������������������������������������('user', 'user');
}
$user_class=new user();
$ret=$user_class->����������������������������������������������������������������������������($pay_id, $rmb);
$code=(is_array($ret) && isset($ret['code'])) ? $ret['code'] : '';
$msg=(is_array($ret) && isset($ret['msg'])) ? $ret['msg'] : Plug_Lang('操作完成');
if ((string) $code==='300' || $ret===true) {
$remark=addslashes(Plug_Lang('手动完成'));
Plug_Query("UPDATE `bs_php_pay_log` SET `pay_remark`='{$remark}' WHERE `pay_id`='{$pay_id_sql}' LIMIT 1");
Plug_Admin_Ok(Plug_Lang('手动完成充值成功'));
}
Plug_Admin_Fail($msg);
}
}
