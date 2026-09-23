<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class UpgradeFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
private function schema_path()
{
return ����������������������������������������4�������������������� . 'Plug/admin_upgrade/updatemysql/mysql.php';
}
private function load_admin_upgrade()
{
if (class_exists('admin_upgrade', false)) {
return true;
}
$path=����������������������������������������4�������������������� . 'include/modules/upgrade/admin_upgrade.php';
if (!is_file($path)) {
return false;
}
require_once $path;
return class_exists('admin_upgrade', false);
}
private function assert_upgrade_qx()
{
$need=Bsphp_Db_Version_Needs_Upgrade();
if ($need) {
return;
}
Plug_Admin_Assert_Qx('yy_4');
}
private function version_payload()
{
return Bsphp_Db_Version_Info();
}
function call_check()
{
Plug_Admin_Ok('ok', $this->version_payload());
}
function call_info()
{
$this->assert_upgrade_qx();
$schema=$this->schema_path();
$exists=is_file($schema) ? 1 : 0;
$table_count=0;
if ($exists) {
$arr=include $schema;
if (is_array($arr) && isset($arr['tables']) && is_array($arr['tables'])) {
$table_count=count($arr['tables']);
}
}
$ver=$this->version_payload();
Plug_Admin_Ok('ok', array_merge($ver, array(
'schema_exists'=> $exists,
'schema_file'=> 'Plug/admin_upgrade/updatemysql/mysql.php',
'schema_abs'=> $schema,
'table_count'=> $table_count,
'module_ok'=> $this->load_admin_upgrade() ? 1 : 0,
'hint'=> Plug_Lang('仅补缺失表/字段，不改已有字段，避免影响线上数据'),
)));
}
function call_run()
{
$this->assert_upgrade_qx();
$action=trim((string) Plug_Set_Post('action'));
if ($action==='') {
$action=trim((string) Plug_Set_Get('action'));
}
if ($action !=='repair') {
Plug_Admin_Fail(Plug_Lang('未知操作'));
}
$schema=$this->schema_path();
if (!is_file($schema)) {
Plug_Admin_Fail(Plug_Lang('未找到结构文件 mysql.php'));
}
@set_time_limit(300);
@ini_set('max_execution_time', '300');
if (!$this->load_admin_upgrade()) {
Plug_Admin_Fail(Plug_Lang('升级模块不可用') . ' (admin_upgrade.php)');
}
$logs=array();
try {
$obj=new admin_upgrade(true);
if (method_exists($obj, '����������������������������������������������������������������return（����������������������������')) {
$logs=$obj->����������������������������������������������������������������return（����������������������������();
} else {
$ref=new ReflectionClass($obj);
$m=$ref->getMethod('repair_from_schema');
$m->setAccessible(true);
$logs=$m->invoke($obj);
}
} catch (Throwable $e) {
Plug_Admin_Fail(Plug_Lang('执行失败') . ': ' . $e->getMessage());
}
if (!is_array($logs)) {
$logs=array((string) $logs);
}
Plug_Admin_Ok(Plug_Lang('修复完成'), array(
'logs'=> $logs,
'lines'=> count($logs),
'version'=> $this->version_payload(),
));
}
}
