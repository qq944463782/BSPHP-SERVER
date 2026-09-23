<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class PayChongFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_table_json()
{
Plug_Admin_Assert_Qx('cz_1');
$p=Plug_Admin_Pager();
$soso=Plug_Set_Get('soso');
$soso_id=(int) Plug_Set_Get('soso_id');
$map=array(1=> 'pay_id', 2=> 'pay_uid', 3=> 'pay_zhuangtai', 4=> 'pay_lei', 5=> 'pay_rbm');
$col=isset($map[$soso_id]) ? $map[$soso_id] : 'pay_id';
$where="`{$col}` LIKE '%{$soso}%'";
$zt=(int) Plug_Set_Get('zhuangtai');
if ($zt==1) {
$where .=" AND `pay_zhuangtai`='0'";
} elseif ($zt==2) {
$where .=" AND `pay_zhuangtai`='1'";
}
$DESC_id=(int) Plug_Set_Get('DESC');
$DESC=$DESC_id==1 ? 'ASC' : 'DESC';
$cnt=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_rmb_pay_log` WHERE {$where}");
$rs=Plug_Query("SELECT * FROM `bs_php_rmb_pay_log` WHERE {$where} ORDER BY `pay_id` {$DESC} LIMIT {$p['offset']},{$p['limit']}");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=$v;
}
Plug_Admin_List_Json($list, (int) ($cnt['hangshu'] ?? 0));
}
function call_batch()
{
Plug_Admin_Assert_Qx('cz_1');
$select=(int) Plug_Set_Post('select_class');
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
if ($select==1) {
if ($all==='') {
Plug_Admin_Fail(Plug_Lang('没有选择记录条目！'));
}
$chk=Plug_Query_Array("SHOW COLUMNS FROM `bs_php_rmb_pay_log` WHERE Field='id'");
if ($chk) {
Plug_Query("DELETE FROM `bs_php_rmb_pay_log` WHERE `id` IN ({$all})");
} else {
Plug_Query("DELETE FROM `bs_php_rmb_pay_log` WHERE `pay_id` IN ({$all})");
}
Plug_Admin_Ok(Plug_Lang('订单信息已经删除!'));
}
if ($select==2) {
$date=date('Y-m-d H:i:s', ���������������������������������������������������������������������������� - 181200);
Plug_Query("DELETE FROM `bs_php_rmb_pay_log` WHERE `pay_date`<'{$date}'");
Plug_Admin_Ok(Plug_Lang('清理50天前信息执行成功!'));
}
if ($select==3) {
$date=date('Y-m-d H:i:s', ���������������������������������������������������������������������������� - 181200);
Plug_Query("DELETE FROM `bs_php_rmb_pay_log` WHERE `pay_date`>'{$date}' AND `pay_zhuangtai`!='1'");
Plug_Admin_Ok(Plug_Lang('清理未成功订单执行成功!'));
}
Plug_Admin_Fail(Plug_Lang('你没有选择操作项目'));
}
function call_manual_complete()
{
Plug_Admin_Assert_Qx('cz_1');
$pay_id=trim(Plug_Set_Post('pay_id'));
if ($pay_id==='') {
Plug_Admin_Fail(Plug_Lang('缺少订单号'));
}
$pay_id_sql=addslashes($pay_id);
$row=Plug_Query_Array("SELECT * FROM `bs_php_rmb_pay_log` WHERE `pay_id`='{$pay_id_sql}' LIMIT 1");
if ($row && isset($row['pay_zhuangtai']) && (string) $row['pay_zhuangtai']==='1') {
Plug_Admin_Ok(Plug_Lang('订单已成功完成,不需要再操作'));
}
if (!class_exists('user')) {
����������������������������������������������������������������::for（�️‍���������������������������������������������������������������������('user', 'user');
}
$user_class=new user();
$ret=$user_class->����������������������������������������������������������������������������($pay_id, -1);
$code=(is_array($ret) && isset($ret['code'])) ? $ret['code'] : '';
$msg=(is_array($ret) && isset($ret['msg'])) ? $ret['msg'] : Plug_Lang('操作完成');
if ((string) $code==='300' || $ret===true) {
$remark=addslashes(Plug_Lang('手动完成'));
Plug_Query("UPDATE `bs_php_rmb_pay_log` SET `pay_info1`='{$remark}' WHERE `pay_id`='{$pay_id_sql}' LIMIT 1");
Plug_Admin_Ok(Plug_Lang('手动完成充值成功'));
}
Plug_Admin_Fail($msg);
}
}
