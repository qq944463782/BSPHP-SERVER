<?php
define('BSPHP_VERSION','v1.0.5');
define('BSPHP_VERSION_ID','20260817');
define('BSPHP_VERSION_TIME','20260817');
define('BSPHP_DB_VERSION','v1.0.1');
function Bsphp_Db_Version_Table()
{
return 'bs_php_db_version';
}
function Bsphp_Db_Version_Get()
{
if (!defined('BSPHP_DB_VERSION')) {
return '';
}
$table=Bsphp_Db_Version_Table();
$safe=addslashes($table);
$exists=Plug_Query_Array("SHOW TABLES LIKE '{$safe}'");
if (!$exists) {
return '';
}
$row=Plug_Query_Array("SELECT `db_version` FROM `{$table}` ORDER BY `id` ASC LIMIT 1");
if (!$row || !isset($row['db_version'])) {
return '';
}
return trim((string) $row['db_version']);
}
function Bsphp_Db_Version_Needs_Upgrade()
{
if (!defined('BSPHP_DB_VERSION')) {
return false;
}
$code=trim((string) BSPHP_DB_VERSION);
if ($code==='') {
return false;
}
$installed=Bsphp_Db_Version_Get();
if ($installed==='') {
return true;
}
return ($installed !==$code);
}
function Bsphp_Db_Version_Info()
{
$code=defined('BSPHP_DB_VERSION') ? trim((string) BSPHP_DB_VERSION) : '';
$db=Bsphp_Db_Version_Get();
$need=0;
if ($code !=='' && ($db==='' || $db !==$code)) {
$need=1;
}
return array(
'code_version'=> $code,
'db_version'=> $db,
'need_upgrade'=> $need,
);
}
function Bsphp_Db_Version_Mark_Current($version=null)
{
if ($version===null || $version==='') {
if (!defined('BSPHP_DB_VERSION')) {
return false;
}
$version=BSPHP_DB_VERSION;
}
$version=trim((string) $version);
if ($version==='') {
return false;
}
$table=Bsphp_Db_Version_Table();
$safe=addslashes($table);
$exists=Plug_Query_Array("SHOW TABLES LIKE '{$safe}'");
if (!$exists) {
$charset='utf8';
$cs=Plug_Query_Array("SHOW CHARACTER SET LIKE 'utf8mb4'");
if ($cs) {
$charset='utf8mb4';
}
$create="CREATE TABLE `{$table}` ("
. "`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',"
. "`db_version` varchar(32) NOT NULL DEFAULT '' COMMENT '数据库版本',"
. "`update_time` datetime DEFAULT NULL COMMENT '更新时间',"
. "`remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',"
. "PRIMARY KEY (`id`)"
. ") ENGINE=MyISAM DEFAULT CHARSET={$charset} COMMENT='数据库版本'";
if (!Plug_Query($create)) {
return false;
}
}
$ver_sql=addslashes($version);
$now=date('Y-m-d H:i:s');
$now_sql=addslashes($now);
$row=Plug_Query_Array("SELECT `id` FROM `{$table}` ORDER BY `id` ASC LIMIT 1");
if ($row && !empty($row['id'])) {
$id=(int) $row['id'];
return (bool) Plug_Query(
"UPDATE `{$table}` SET `db_version`='{$ver_sql}',`update_time`='{$now_sql}' WHERE `id`={$id} LIMIT 1"
);
}
return (bool) Plug_Query(
"INSERT INTO `{$table}` (`db_version`,`update_time`,`remark`) VALUES ('{$ver_sql}','{$now_sql}','')"
);
}
function Bsphp_Db_Version_Is_Upgrade_Request()
{
$m=isset($_GET['m']) ? trim((string) $_GET['m']) : '';
$c=isset($_GET['c']) ? trim((string) $_GET['c']) : '';
if ($m==='upgrade' && $c==='admin_upgrade') {
return true;
}
if ($m==='resapiadmin' && $c==='UpgradeFeature') {
return true;
}
return false;
}
?>
