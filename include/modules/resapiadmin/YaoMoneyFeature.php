<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class YaoMoneyFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_table_json()
{
Plug_Admin_Assert_Qx('cz_4');
$p=Plug_Admin_Pager();
$soso=Plug_Set_Get('soso');
$where='1=1';
if ($soso !=='') {
$where="(`log_user` LIKE '%{$soso}%' OR `log_order` LIKE '%{$soso}%' OR `log_remark` LIKE '%{$soso}%')";
}
$cnt=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_yao_money_log` WHERE {$where}");
$rs=Plug_Query("SELECT * FROM `bs_php_yao_money_log` WHERE {$where} ORDER BY `id` DESC LIMIT {$p['offset']},{$p['limit']}");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=$v;
}
Plug_Admin_List_Json($list, (int) ($cnt['hangshu'] ?? 0));
}
function call_recall()
{
Plug_Admin_Assert_Qx('cz_4');
$id=(int) Plug_Set_Post('id');
if ($id <=0) {
Plug_Admin_Fail(Plug_Lang('请指定记录ID'));
}
$row=Plug_Query_Array("SELECT `id`,`log_user`,`log_amount`,`log_status`,`log_remark`,`log_order` FROM `bs_php_yao_money_log` WHERE `id`='{$id}' LIMIT 1");
if (!$row) {
Plug_Admin_Fail(Plug_Lang('记录不存在'));
}
if ((int) $row['log_status'] !=1) {
Plug_Admin_Fail(Plug_Lang('仅分成完毕状态可扣回'));
}
$ok=$this->do_recall_row($row, Plug_Set_Post('remark'));
if ($ok) {
Plug_Admin_Ok(Plug_Lang('分成扣回成功'));
}
Plug_Admin_Fail(Plug_Lang('分成金额异常'));
}
function call_recall_batch()
{
Plug_Admin_Assert_Qx('cz_4');
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
if ($all==='') {
Plug_Admin_Fail(Plug_Lang('请选择要收回的记录'));
}
$remark=Plug_Set_Post('remark');
$ok=0;
$err=0;
$rs=Plug_Query("SELECT `id`,`log_user`,`log_amount`,`log_status`,`log_remark`,`log_order` FROM `bs_php_yao_money_log` WHERE `id` IN ({$all})");
while ($row=Plug_Pdo_Fetch_Assoc($rs)) {
if ((int) $row['log_status'] !=1) {
$err++;
continue;
}
if ($this->do_recall_row($row, $remark)) {
$ok++;
} else {
$err++;
}
}
$msg=Plug_Lang('批量收回完成') . '：成功 ' . $ok . ' 条';
if ($err > 0) {
$msg .='，跳过 ' . $err . ' 条（非分成完毕或异常）';
}
Plug_Admin_Ok($msg);
}
private function do_recall_row($row, $remark)
{
$log_user=addslashes(trim($row['log_user']));
$log_amount=(float) $row['log_amount'];
$log_order=isset($row['log_order']) ? trim((string) $row['log_order']) : '';
if ($log_amount <=0) {
return false;
}
$append=$remark !=='' ? ' ' . $remark : ' ' . Plug_Lang('扣回');
$new_remark=(isset($row['log_remark']) ? $row['log_remark'] : '') . $append;
if (strlen($new_remark) > 250) {
$new_remark=substr($new_remark, -250);
}
$new_remark=addslashes($new_remark);
$urow=Plug_Query_Array("SELECT `user_rmb` FROM `bs_php_user` WHERE `user_user`='{$log_user}' LIMIT 1");
$rmb_before=$urow ? (float) $urow['user_rmb'] : 0;
$rmb_after=max(0, $rmb_before - $log_amount);
Plug_Query("UPDATE `bs_php_user` SET `user_rmb`=GREATEST(0, `user_rmb` - {$log_amount}) WHERE `user_user`='{$log_user}'");
Plug_Query("UPDATE `bs_php_yao_money_log` SET `log_status`=2,`log_remark`='{$new_remark}' WHERE `id`='" . (int) $row['id'] . "' LIMIT 1");
Plug_Add_Rmb_Log($log_user, $rmb_before, $rmb_after, Plug_Lang('分成扣回'), $log_order);
return true;
}
}
