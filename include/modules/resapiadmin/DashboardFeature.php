<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class DashboardFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
private function admin_uid()
{
$uid=����������������������������������������������������������������for（��������('ADMIN_UID');
if ($uid==='' || $uid===null) {
$uid=isset($this->admin_array['Admin_ID']) ? $this->admin_array['Admin_ID'] : '';
}
return (string) $uid;
}
private function has_col($table, $col)
{
static $cache=array();
$key=$table . '.' . $col;
if (isset($cache[$key])) {
return $cache[$key];
}
$table=preg_replace('/[^a-zA-Z0-9_]/', '', $table);
$col=preg_replace('/[^a-zA-Z0-9_]/', '', $col);
$row=Plug_Query_Array("SHOW COLUMNS FROM `{$table}` LIKE '{$col}'");
$cache[$key]=!empty($row);
return $cache[$key];
}
private function has_index($table, $name)
{
$table=preg_replace('/[^a-zA-Z0-9_]/', '', $table);
$name=preg_replace('/[^a-zA-Z0-9_]/', '', $name);
$row=Plug_Query_Array("SHOW INDEX FROM `{$table}` WHERE `Key_name`='{$name}'");
return !empty($row);
}
private function ensure_quickstat_schema()
{
static $done=false;
if ($done) {
return;
}
$done=true;
if (!$this->has_table('bs_php_admin_quickstat')) {
return;
}
@Plug_Query("DELETE t1 FROM `bs_php_admin_quickstat` t1
INNER JOIN `bs_php_admin_quickstat` t2
ON t1.`last_user`=t2.`last_user` AND t1.`path`=t2.`path` AND t1.`id`<t2.`id`");
if ($this->has_index('bs_php_admin_quickstat', 'uniq_path_name')) {
@Plug_Query("ALTER TABLE `bs_php_admin_quickstat` DROP INDEX `uniq_path_name`");
}
if (!$this->has_index('bs_php_admin_quickstat', 'uniq_user_path')) {
@Plug_Query("ALTER TABLE `bs_php_admin_quickstat` ADD UNIQUE KEY `uniq_user_path` (`last_user`, `path`(191))");
}
}
private function has_table($table)
{
static $cache=array();
$table=preg_replace('/[^a-zA-Z0-9_]/', '', $table);
if (isset($cache[$table])) {
return $cache[$table];
}
$row=Plug_Query_Array("SHOW TABLES LIKE '{$table}'");
$cache[$table]=!empty($row);
return $cache[$table];
}
private function collect_stats()
{
$tody=date('Y-m-d');
$day0_unix=strtotime(date('Y-m-d 00:00:00'));
$day0=date('Y-m-d 00:00:00', $day0_unix);
$day1=date('Y-m-d 00:00:00', $day0_unix + 86400);
$week0_unix=$day0_unix - 604800;
$week0=date('Y-m-d 00:00:00', $week0_unix);
$out=array();
$row=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_user` WHERE `user_daili`=0");
$out['user_count']=(int) ($row['hangshu'] ?? 0);
$row=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_user` WHERE `user_daili`>=1");
$out['agent_count']=(int) ($row['hangshu'] ?? 0);
$row=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_appinfo`");
$out['app_count']=(int) ($row['hangshu'] ?? 0);
$row=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_admin`");
$out['admin_count']=(int) ($row['hangshu'] ?? 0);
$row=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_user` WHERE `user_Login_date`>'{$tody}'");
$out['today_login']=(int) ($row['hangshu'] ?? 0);
$row=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_user` WHERE `user_re_date`>'{$tody}'");
$out['today_reg']=(int) ($row['hangshu'] ?? 0);
$row=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_user` WHERE `user_re_date`>'{$tody}' AND `user_yao_User`!=''");
$out['today_invite']=(int) ($row['hangshu'] ?? 0);
$row=Plug_Query_Array("SELECT SUM(`user_rmb`) AS zongrmb FROM `bs_php_user`");
$out['user_rmb_all']=(float) ($row['zongrmb'] ?? 0);
$hot=PLUG_UNIX() - 1800;
$row=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_links_session` WHERE `links_chaoshi`>'{$hot}' AND `links_user_name`!=''");
$out['online_hot']=(int) ($row['hangshu'] ?? 0);
$row=Plug_Query_Array("SELECT
count(*) AS hangshu,
SUM(`car_Rmb`) AS car_Rmb,
SUM(`car_DaoLi_Rmb`) AS car_DaoLi_Rmb,
SUM(CASE WHEN `car_IsLock`='1' THEN 1 ELSE 0 END) AS ka_aut,
SUM(CASE WHEN `car_IsLock`='0' THEN 1 ELSE 0 END) AS ka_die,
SUM(CASE WHEN `car_IsLock`='1' AND `car_pur_date`>='{$day0}' AND `car_pur_date`<'{$day1}' THEN 1 ELSE 0 END) AS ka_tady_out
FROM `bs_php_cardseries`");
$out['ka_all']=(int) ($row['hangshu'] ?? 0);
$out['ka_all_rmb']=(float) ($row['car_Rmb'] ?? 0);
$out['ka_all_d_rmb']=(float) ($row['car_DaoLi_Rmb'] ?? 0);
$out['ka_aut']=(int) ($row['ka_aut'] ?? 0);
$out['ka_die']=(int) ($row['ka_die'] ?? 0);
$out['ka_tady_out']=(int) ($row['ka_tady_out'] ?? 0);
$out['today_pay_rmb']=0.0;
if ($this->has_table('bs_php_rmb_pay_log')) {
$row=Plug_Query_Array("SELECT SUM(`pay_rbm`) AS rmb FROM `bs_php_rmb_pay_log`
WHERE `pay_zhuangtai`='1' AND `pay_date`>='{$day0}' AND `pay_date`<'{$day1}'");
$out['today_pay_rmb']=(float) ($row['rmb'] ?? 0);
}
$out['today_buy_rmb']=0.0;
if ($this->has_table('bs_php_pay_log')) {
$row=Plug_Query_Array("SELECT SUM(`ka_shijia`) AS rmb FROM `bs_php_pay_log`
WHERE `pay_zhuangtai`='1' AND `pay_date`>='{$day0}' AND `pay_date`<'{$day1}'");
$out['today_buy_rmb']=(float) ($row['rmb'] ?? 0);
}
$out['log_today']=0;
$out['log_7day']=0;
if ($this->has_table('bs_php_log')) {
$row=Plug_Query_Array("SELECT
SUM(CASE WHEN `date`>='{$day0_unix}' THEN 1 ELSE 0 END) AS log_today,
count(*) AS log_7day
FROM `bs_php_log` WHERE `leixing`='exit_log' AND `date`>='{$week0_unix}'");
$out['log_today']=(int) ($row['log_today'] ?? 0);
$out['log_7day']=(int) ($row['log_7day'] ?? 0);
}
$out['api_dbug_today']=0;
$out['api_dbug_7day']=0;
if ($this->has_table('bs_php_api_dbug')) {
$row=Plug_Query_Array("SELECT
SUM(CASE WHEN `time`>='{$day0_unix}' THEN 1 ELSE 0 END) AS dbug_today,
count(*) AS dbug_7day
FROM `bs_php_api_dbug` WHERE `api`='' AND `time`>='{$week0_unix}'");
$out['api_dbug_today']=(int) ($row['dbug_today'] ?? 0);
$out['api_dbug_7day']=(int) ($row['dbug_7day'] ?? 0);
}
$out['users']=$out['user_count'];
$out['agents']=$out['agent_count'];
$out['apps']=$out['app_count'];
$out['admins']=$out['admin_count'];
return $out;
}
private function sys_shortcuts()
{
return array(
array('id'=> 'app_add', 'title'=> '添加软件', 'path'=> '/pages/apps/apps', 'ico'=> '软'),
array('id'=> 'app_list', 'title'=> '软件列表', 'path'=> '/pages/apps/apps', 'ico'=> '列'),
array('id'=> 'user_list', 'title'=> '用户账号', 'path'=> '/pages/users/users', 'ico'=> '账', 'tab'=> 1),
array('id'=> 'root', 'title'=> '后台账号', 'path'=> '/pages/root/root', 'ico'=> '管'),
array('id'=> 'cfg_sys', 'title'=> '系统配置', 'path'=> '/pages/config/config', 'ico'=> '配'),
array('id'=> 'api_debug', 'title'=> '接口调试', 'path'=> '/pages/api-debug/api-debug', 'ico'=> '调'),
);
}
private function load_quick_list($entry_type=1, $limit=20)
{
$user=$this->admin_uid();
if ($user==='') {
return array();
}
$user_sql=addslashes($user);
$limit=max(1, min(50, (int) $limit));
$has_type=$this->has_col('bs_php_admin_quickstat', 'entry_type');
$has_menu=$this->has_col('bs_php_admin_quickstat', 'menu_id');
$pinned=array();
$pin_rs=Plug_Query("SELECT `path` FROM `bs_php_admin_quickstat_pinned` WHERE `last_user`='{$user_sql}'");
if ($pin_rs) {
while ($pr=Plug_Pdo_Fetch_Assoc($pin_rs)) {
$pinned[$pr['path']]=true;
}
}
if ($has_type) {
$type=(int) $entry_type;
$sql="SELECT `path`,`name`,`hit_count`,`last_time`"
. ($has_menu ? ',`menu_id`' : '')
. ",`entry_type` FROM `bs_php_admin_quickstat`
WHERE `last_user`='{$user_sql}' AND `entry_type`='{$type}'
ORDER BY `last_time` DESC LIMIT {$limit}";
} else {
$like=($entry_type==1) ? "`path` LIKE '/pages/%'" : "`path` NOT LIKE '/pages/%'";
$sql="SELECT `path`,`name`,`hit_count`,`last_time` FROM `bs_php_admin_quickstat`
WHERE `last_user`='{$user_sql}' AND {$like}
ORDER BY `last_time` DESC LIMIT {$limit}";
}
$list=array();
$rs=@Plug_Query($sql);
if ($rs) {
while ($row=Plug_Pdo_Fetch_Assoc($rs)) {
$row['pinned']=!empty($pinned[$row['path']]);
$row['hit_count']=(int) ($row['hit_count'] ?? 0);
if (!$has_menu) {
$row['menu_id']='';
}
if (!$has_type) {
$row['entry_type']=(int) $entry_type;
} else {
$row['entry_type']=(int) ($row['entry_type'] ?? 0);
}
$list[]=$row;
}
usort($list, function ($a, $b) {
if ($a['pinned'] !=$b['pinned']) {
return $a['pinned'] ? -1 : 1;
}
return 0;
});
}
return $list;
}
function call_info()
{
$this->ensure_quickstat_schema();
$stats=$this->collect_stats();
Plug_Print_Json(array(
'code'=> 100,
'msg'=> Plug_Lang('ok'),
'data'=> array_merge($stats, array(
'admin_user'=> $this->admin_array['Admin_AdminUserName'],
'sys_name'=> (string) ����������������������������������������������������������������::������������������������������������������������������������������������������������('sys', 'name'),
'version'=> defined('BSPHP_VERSION') ? BSPHP_VERSION : '',
'quick_list'=> $this->load_quick_list(1, 20),
'sys_shortcuts'=> $this->sys_shortcuts(),
'has_entry_type'=> $this->has_col('bs_php_admin_quickstat', 'entry_type') ? 1 : 0,
), Bsphp_Db_Version_Info()),
));
}
function call_quickstat()
{
$this->ensure_quickstat_schema();
$path=trim((string) Plug_Set_Post('path'));
$name=trim((string) Plug_Set_Post('name'));
$url=trim((string) Plug_Set_Post('url'));
$menu_id=trim((string) Plug_Set_Post('menu_id'));
$entry_type=(int) Plug_Set_Post('entry_type');
if ($entry_type !==0) {
$entry_type=1;
}
if ($path !=='' && strpos($path, '/pages/')===0) {
$entry_type=1;
}
if ($path==='' || $name==='') {
Plug_Print_Json(array('code'=> 0, 'msg'=> 'invalid'));
return;
}
$user=$this->admin_uid();
if ($user==='') {
Plug_Print_Json(array('code'=> 0, 'msg'=> 'unauth'));
return;
}
if ($url==='') {
$url=$path;
}
$ip=isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
$now=date('Y-m-d H:i:s');
$path_sql=addslashes($path);
$name_sql=addslashes($name);
$url_sql=addslashes($url);
$ip_sql=addslashes($ip);
$user_sql=addslashes($user);
$menu_sql=addslashes($menu_id);
$has_type=$this->has_col('bs_php_admin_quickstat', 'entry_type');
$has_menu=$this->has_col('bs_php_admin_quickstat', 'menu_id');
$row=Plug_Query_Array("SELECT `id`,`hit_count` FROM `bs_php_admin_quickstat` WHERE `path`='{$path_sql}' AND `last_user`='{$user_sql}' ORDER BY `last_time` DESC LIMIT 1");
if ($row && !empty($row['id'])) {
$id=(int) $row['id'];
$hit=(int) $row['hit_count'] + 1;
$sets="`hit_count`={$hit},`last_url`='{$url_sql}',`last_ip`='{$ip_sql}',`name`='{$name_sql}',`last_user`='{$user_sql}',`last_time`='{$now}'";
if ($has_type) {
$sets .=",`entry_type`='{$entry_type}'";
}
if ($has_menu && $menu_id !=='') {
$sets .=",`menu_id`='{$menu_sql}'";
}
Plug_Query("UPDATE `bs_php_admin_quickstat` SET {$sets} WHERE `id`={$id} LIMIT 1");
} else {
if ($has_type && $has_menu) {
$ok=Plug_Query("INSERT INTO `bs_php_admin_quickstat`
(`path`,`name`,`hit_count`,`last_url`,`last_ip`,`last_user`,`last_time`,`entry_type`,`menu_id`)
VALUES ('{$path_sql}','{$name_sql}',1,'{$url_sql}','{$ip_sql}','{$user_sql}','{$now}','{$entry_type}','{$menu_sql}')");
} elseif ($has_type) {
$ok=Plug_Query("INSERT INTO `bs_php_admin_quickstat`
(`path`,`name`,`hit_count`,`last_url`,`last_ip`,`last_user`,`last_time`,`entry_type`)
VALUES ('{$path_sql}','{$name_sql}',1,'{$url_sql}','{$ip_sql}','{$user_sql}','{$now}','{$entry_type}')");
} else {
$ok=Plug_Query("INSERT INTO `bs_php_admin_quickstat`
(`path`,`name`,`hit_count`,`last_url`,`last_ip`,`last_user`,`last_time`)
VALUES ('{$path_sql}','{$name_sql}',1,'{$url_sql}','{$ip_sql}','{$user_sql}','{$now}')");
}
if (!$ok) {
$row2=Plug_Query_Array("SELECT `id`,`hit_count` FROM `bs_php_admin_quickstat` WHERE `path`='{$path_sql}' AND `last_user`='{$user_sql}' ORDER BY `last_time` DESC LIMIT 1");
if ($row2 && !empty($row2['id'])) {
$id=(int) $row2['id'];
$hit=(int) $row2['hit_count'] + 1;
$sets="`hit_count`={$hit},`last_url`='{$url_sql}',`last_ip`='{$ip_sql}',`name`='{$name_sql}',`last_time`='{$now}'";
if ($has_type) {
$sets .=",`entry_type`='{$entry_type}'";
}
if ($has_menu && $menu_id !=='') {
$sets .=",`menu_id`='{$menu_sql}'";
}
Plug_Query("UPDATE `bs_php_admin_quickstat` SET {$sets} WHERE `id`={$id} LIMIT 1");
}
}
}
Plug_Print_Json(array('code'=> 100, 'msg'=> 'ok'));
}
function call_quickstat_pin()
{
$path=trim((string) Plug_Set_Post('path'));
if ($path==='') {
$path=trim((string) Plug_Set_Get('path'));
}
if ($path==='') {
Plug_Print_Json(array('code'=> 0, 'msg'=> 'invalid'));
return;
}
$user=$this->admin_uid();
if ($user==='') {
Plug_Print_Json(array('code'=> 0, 'msg'=> 'unauth'));
return;
}
$path_sql=addslashes($path);
$user_sql=addslashes($user);
$row=Plug_Query_Array("SELECT 1 AS ok FROM `bs_php_admin_quickstat_pinned` WHERE `path`='{$path_sql}' AND `last_user`='{$user_sql}' LIMIT 1");
if ($row) {
Plug_Query("DELETE FROM `bs_php_admin_quickstat_pinned` WHERE `path`='{$path_sql}' AND `last_user`='{$user_sql}' LIMIT 1");
Plug_Print_Json(array('code'=> 100, 'pinned'=> 0, 'msg'=> 'ok'));
} else {
Plug_Query("INSERT INTO `bs_php_admin_quickstat_pinned` (`last_user`,`path`) VALUES ('{$user_sql}','{$path_sql}')");
Plug_Print_Json(array('code'=> 100, 'pinned'=> 1, 'msg'=> 'ok'));
}
}
function call_quickstat_del()
{
$path=trim((string) Plug_Set_Post('path'));
if ($path==='') {
$path=trim((string) Plug_Set_Get('path'));
}
if ($path==='') {
Plug_Print_Json(array('code'=> 0, 'msg'=> 'invalid'));
return;
}
$user=$this->admin_uid();
if ($user==='') {
Plug_Print_Json(array('code'=> 0, 'msg'=> 'unauth'));
return;
}
$path_sql=addslashes($path);
$user_sql=addslashes($user);
Plug_Query("DELETE FROM `bs_php_admin_quickstat` WHERE `path`='{$path_sql}' AND `last_user`='{$user_sql}' LIMIT 1");
Plug_Query("DELETE FROM `bs_php_admin_quickstat_pinned` WHERE `path`='{$path_sql}' AND `last_user`='{$user_sql}' LIMIT 1");
Plug_Print_Json(array('code'=> 100, 'msg'=> 'ok'));
}
}
