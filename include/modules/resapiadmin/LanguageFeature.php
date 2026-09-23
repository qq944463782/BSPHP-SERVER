<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class LanguageFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
private function safe_lang_id($id)
{
$id=strtolower(trim((string) $id));
if (!preg_match('/^[a-f0-9]{16,32}$/', $id)) {
return '';
}
return $id;
}
private function safe_lang_ids($raw)
{
$parts=preg_split('/[,;\s]+/', (string) $raw);
$out=array();
if (!is_array($parts)) {
return '';
}
foreach ($parts as $p) {
$id=$this->safe_lang_id($p);
if ($id !=='') {
$out[$id]="'" . addslashes($id) . "'";
}
}
return implode(',', array_values($out));
}
function call_table_json()
{
Plug_Admin_Assert_Qx('xt_8');
$chk=Plug_Query_Array("SHOW TABLES LIKE 'bs_php_language'");
if (!$chk) {
Plug_Admin_List_Json(array(), 0);
}
$p=Plug_Admin_Pager();
$soso=trim((string) Plug_Set_Get('soso'));
$soso_id=(int) Plug_Set_Get('soso_id');
if ($soso_id < 0 || $soso_id > 15) {
$soso_id=0;
}
$DESC=((int) Plug_Set_Get('DESC')==1) ? 'ASC' : 'DESC';
$col='lang_' . $soso_id;
$soso_sql=addslashes($soso);
$where="`{$col}` LIKE '%{$soso_sql}%'";
$order_col='lang_id';
$has_time=Plug_Query_Array("SHOW COLUMNS FROM `bs_php_language` WHERE Field='time'");
if ($has_time) {
$order_col='time';
}
$cnt=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_language` WHERE {$where}");
$rs=Plug_Query("SELECT * FROM `bs_php_language` WHERE {$where} ORDER BY `{$order_col}` {$DESC} LIMIT {$p['offset']},{$p['limit']}");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
if (is_array($v) && isset($v['lang_id'])) {
$v['id']=$v['lang_id'];
$v['key']=$v['lang_id'];
}
$list[]=$v;
}
Plug_Admin_List_Json($list, (int) ($cnt['hangshu'] ?? 0));
}
function call_detail()
{
Plug_Admin_Assert_Qx('xt_8');
$id=$this->safe_lang_id(Plug_Set_Get('id'));
if ($id==='') {
Plug_Admin_Fail(Plug_Lang('参数错误'));
}
$row=Plug_Query_Array("SELECT * FROM `bs_php_language` WHERE `lang_id`='" . addslashes($id) . "' LIMIT 1");
if (!$row) {
Plug_Admin_Fail(Plug_Lang('记录不存在'));
}
$row['id']=$row['lang_id'];
$row['key']=$row['lang_id'];
Plug_Admin_Ok('ok', $row);
}
function call_edit()
{
Plug_Admin_Assert_Qx('xt_8');
$id=$this->safe_lang_id(Plug_Set_Post('id'));
$field=trim((string) Plug_Set_Post('field'));
$txt=(string) Plug_Set_Post('txt');
if ($id==='' || !preg_match('/^lang_([1-9]|1[0-5])$/', $field)) {
Plug_Admin_Fail(Plug_Lang('参数错误'));
}
$txt_sql=addslashes($txt);
Plug_Query("UPDATE `bs_php_language` SET `{$field}`='{$txt_sql}' WHERE `lang_id`='" . addslashes($id) . "' LIMIT 1");
Plug_Admin_Ok(Plug_Lang('修改完毕！'));
}
function call_delete()
{
Plug_Admin_Assert_Qx('xt_8');
$all=$this->safe_lang_ids(Plug_Set_Post('all'));
if ($all==='') {
Plug_Admin_Fail(Plug_Lang('没有选择记录条目！'));
}
Plug_Query("DELETE FROM `bs_php_language` WHERE `lang_id` IN ({$all})");
Plug_Admin_Ok(Plug_Lang('选择已经删除!'));
}
function call_clear_cache()
{
Plug_Admin_Assert_Qx('xt_8');
for ($i=0; $i < 15; $i++) {
foreach (array('ADMIN', 'AGENT', 'APPEN') as $scope) {
$path=����������������������������������������4�������������������� . 'Data/configs/lang_' . $scope . '_' . $i . '.config.php';
if (file_exists($path)) {
file_put_contents($path, '<?php return array(); ?>');
}
}
}
Plug_Admin_Ok(Plug_Lang('清空成功'));
}
}
