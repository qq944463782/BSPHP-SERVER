<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class ApiDbugFeature
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
private function soso_col($soso_id)
{
$map=array(
1=> 'id',
2=> 'ip',
3=> 'uuid',
4=> 'Sessl',
5=> 'api',
6=> 'error',
7=> 'print_fun_data',
);
$id=(int) $soso_id;
return isset($map[$id]) ? $map[$id] : 'api';
}
private function table_exists()
{
$chk=Plug_Query_Array("SHOW TABLES LIKE 'bs_php_api_dbug'");
return !empty($chk);
}
function call_table_json()
{
$this->assert_qx();
if (!$this->table_exists()) {
Plug_Admin_List_Json(array(), 0);
}
$p=Plug_Admin_Pager();
$soso=trim((string) Plug_Set_Get('soso'));
$col=$this->soso_col(Plug_Set_Get('soso_id'));
$DESC=((int) Plug_Set_Get('DESC')==1) ? 'ASC' : 'DESC';
$soso_sql=addslashes($soso);
$where="`{$col}` LIKE '%{$soso_sql}%'";
$cnt=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_api_dbug` WHERE {$where}");
$rs=Plug_Query(
"SELECT * FROM `bs_php_api_dbug` WHERE {$where} ORDER BY `id` {$DESC} LIMIT {$p['offset']},{$p['limit']}"
);
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$time=isset($v['time']) ? $v['time'] : 0;
$list[]=array(
'key'=> (int) $v['id'],
'id'=> (int) $v['id'],
'time'=> is_numeric($time) ? date('Y-m-d H:i:s', (int) $time) : (string) $time,
'ip'=> isset($v['ip']) ? $v['ip'] : '',
'uuid'=> isset($v['uuid']) ? $v['uuid'] : '',
'Sessl'=> isset($v['Sessl']) ? $v['Sessl'] : '',
'api'=> isset($v['api']) ? $v['api'] : '',
'error'=> isset($v['error']) ? $v['error'] : '',
'print_fun_data'=> isset($v['print_fun_data']) ? $v['print_fun_data'] : '',
);
}
Plug_Admin_List_Json($list, (int) ($cnt['hangshu'] ?? 0));
}
function call_detail()
{
$this->assert_qx();
$id=(int) Plug_Set_Get('id');
if ($id <=0) {
$id=(int) Plug_Set_Post('id');
}
if ($id <=0) {
Plug_Admin_Fail(Plug_Lang('参数错误'));
}
if (!$this->table_exists()) {
Plug_Admin_Fail(Plug_Lang('记录不存在'));
}
$row=Plug_Query_Array("SELECT * FROM `bs_php_api_dbug` WHERE `id`='{$id}' LIMIT 1");
if (!$row) {
Plug_Admin_Fail(Plug_Lang('记录不存在'));
}
$get_data=$this->decode_json_field(isset($row['get_data']) ? $row['get_data'] : '');
$post_data=$this->decode_json_field(isset($row['post_data']) ? $row['post_data'] : '');
$head_data=$this->decode_json_field(isset($row['head_data']) ? $row['head_data'] : '');
$time=isset($row['time']) ? $row['time'] : 0;
Plug_Admin_Ok('ok', array(
'id'=> (int) $row['id'],
'time'=> is_numeric($time) ? date('Y-m-d H:i:s', (int) $time) : (string) $time,
'ip'=> isset($row['ip']) ? $row['ip'] : '',
'uuid'=> isset($row['uuid']) ? $row['uuid'] : '',
'Sessl'=> isset($row['Sessl']) ? $row['Sessl'] : '',
'api'=> isset($row['api']) ? $row['api'] : '',
'error'=> isset($row['error']) ? $row['error'] : '',
'print_fun_data'=> isset($row['print_fun_data']) ? $row['print_fun_data'] : '',
'get_data'=> $get_data,
'post_data'=> $post_data,
'head_data'=> $head_data,
'get_raw'=> isset($row['get_data']) ? $row['get_data'] : '',
'post_raw'=> isset($row['post_data']) ? $row['post_data'] : '',
'head_raw'=> isset($row['head_data']) ? $row['head_data'] : '',
));
}
private function decode_json_field($raw)
{
if ($raw==='' || $raw===null) {
return null;
}
$decoded=json_decode($raw, true);
if (is_array($decoded)) {
return $decoded;
}
$try=@iconv('GB2312', 'UTF-8', $raw);
if ($try !==false && $try !=='') {
$try=str_replace('\\', '/', $try);
$decoded=json_decode($try, true);
if (is_array($decoded)) {
return $decoded;
}
}
return null;
}
function call_batch()
{
$this->assert_qx();
if (!$this->table_exists()) {
Plug_Admin_Fail(Plug_Lang('表不存在'));
}
$select=(int) Plug_Set_Post('select_class');
if ($select===2) {
Plug_Query('DELETE FROM `bs_php_api_dbug`');
Plug_Admin_Ok(Plug_Lang('全部删除成功！'));
}
if ($select===3) {
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
if ($all==='') {
Plug_Admin_Fail(Plug_Lang('没有选择记录条目！'));
}
Plug_Query("DELETE FROM `bs_php_api_dbug` WHERE `id` IN ({$all})");
Plug_Admin_Ok(Plug_Lang('删除成功！'));
}
Plug_Admin_Fail(Plug_Lang('你没有选择操作项目'));
}
}
