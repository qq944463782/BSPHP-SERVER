<?php
header("Content-Type: text/html; charset=utf-8");
function convertToSQLiteSQL($mysql_sql)
{
$sql=trim($mysql_sql);
$sql=preg_replace('/\sCOMMENT\s+\'[^\']*\'/i', '', $sql);
$sql=preg_replace('/\sENGINE\s*=\s*\w+/i', '', $sql);
$sql=preg_replace('/\sDEFAULT\s+CHARSET\s*=\s*\w+/i', '', $sql);
$sql=preg_replace('/\sAUTO_INCREMENT/i', '', $sql);
$sql=preg_replace_callback(
'/(`?\w+`?)\s+int\([^)]+\)\s+NOT NULL\s+PRIMARY KEY\s+KEY?/i',
function ($matches) {
return $matches[1] . ' INTEGER PRIMARY KEY AUTOINCREMENT';
},
$sql
);
if (preg_match('/AUTO_INCREMENT/i', $sql) && preg_match('/PRIMARY KEY/i', $sql)) {
$sql=preg_replace('/\sAUTO_INCREMENT/i', ' AUTOINCREMENT', $sql);
}
$sql=preg_replace('/int\([^)]+\)/i', 'INTEGER', $sql);
$sql=preg_replace('/tinyint\([^)]+\)/i', 'INTEGER', $sql);
$sql=preg_replace('/\sUNSIGNED/i', '', $sql);
$sql=preg_replace(
'/DEFAULT\s+CURRENT_TIMESTAMP\s+ON UPDATE CURRENT_TIMESTAMP/i',
'DEFAULT CURRENT_TIMESTAMP',
$sql
);
$sql=preg_replace('/AUTO_INCREMENT\s*=\s*\d+/i', '', $sql);
$sql=preg_replace('/\)[^)]*;\s*$/s', ');', $sql);
return $sql;
}
define('INSTALL_ROOT', dirname(__FILE__));
define('ROOT_PATH', rtrim(str_replace('\\', '/', dirname(INSTALL_ROOT)), '/'));
define('DATA_PATH', ROOT_PATH . '/Data');
require_once(INSTALL_ROOT . '/data/languages.php');
$lang_code=isset($_GET['lang']) ? $_GET['lang'] : (isset($_COOKIE['bsphp_install_lang']) ? $_COOKIE['bsphp_install_lang'] : 'zh-cn');
if (!array_key_exists($lang_code, $lang_data)) {
$lang_code='zh-cn';
}
setcookie('bsphp_install_lang', $lang_code, time() + 3600, '/');
$L=$lang_data[$lang_code];
$_force_reinstall=isset($_GET['force']) && (string)$_GET['force']==='1';
$is_installed=file_exists(DATA_PATH . '/install.txt');
$step=isset($_GET['step']) ? intval($_GET['step']) : 1;
$mode=isset($_GET['mode']) ? $_GET['mode'] : '';
$install_base_path=str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if (substr($install_base_path, -1) !=='/') {
$install_base_path .='/';
}
$install_base=$install_base_path;
$install_base_url='//' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . $install_base_path;
function L($key)
{
global $L;
return isset($L[$key]) ? $L[$key] : $key;
}
function installed_notice_html()
{
$lock_files=array(
DATA_PATH . '/install.txt'
);
$items='';
$root_prefix=rtrim(str_replace('\\', '/', ROOT_PATH), '/') . '/';
foreach ($lock_files as $path) {
if (file_exists($path)) {
$normalized=str_replace('\\', '/', $path);
$display=(strpos($normalized, $root_prefix)===0) ? substr($normalized, strlen($root_prefix)) : $path;
$items .='<li><code>' . htmlspecialchars($display, ENT_QUOTES, 'UTF-8') . '</code></li>';
}
}
if ($items==='') {
foreach ($lock_files as $path) {
$normalized=str_replace('\\', '/', $path);
$display=(strpos($normalized, $root_prefix)===0) ? substr($normalized, strlen($root_prefix)) : $path;
$items .='<li><code>' . htmlspecialchars($display, ENT_QUOTES, 'UTF-8') . '</code></li>';
}
}
return '<div class="alert alert-warning">'
. L('already_installed_msg')
. '<div style="margin-top:10px;">' . L('reinstall_tips') . '</div>'
. '<ul style="margin:8px 0 0 18px;">' . $items . '</ul>'
. '</div>';
}
function dir_create($path, $mode=0777)
{
if (is_dir($path)) return true;
if (!mkdir($path, $mode, true)) return false;
return true;
}
function elseif（������������������������������������������������������������������������($file)
{
if (is_dir($file)) {
$dir=$file;
if ($fp=@fopen("$dir/test.txt", 'w')) {
@fclose($fp);
@unlink("$dir/test.txt");
return true;
}
} else {
if ($fp=@fopen($file, 'a+')) {
@fclose($fp);
return true;
}
}
return false;
}
function generate_random_string($length=10)
{
$characters='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength=strlen($characters);
$randomString='';
for ($i=0; $i < $length; $i++) {
$randomString .=$characters[rand(0, $charactersLength - 1)];
}
return $randomString;
}
function get_current_url()
{
$protocol=(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !=='off' || $_SERVER['SERVER_PORT']==443) ? "https://" : "http://";
$domainName=$_SERVER['HTTP_HOST'];
return $protocol . $domainName . $_SERVER['REQUEST_URI'];
}
function convert_mysql_to_sqlite($sql)
{
$queries=explode(';', $sql);
$new_queries=array();
foreach ($queries as $query) {
$query=trim($query);
if (empty($query)) continue;
if (stripos($query, 'CREATE TABLE')===0) {
$lines=explode("\n", $query);
$new_lines=array();
$indexes=array();
$tablename='';
if (preg_match('/CREATE TABLE IF NOT EXISTS `?(\w+)`?/i', $query, $m)) {
$tablename=$m[1];
}
foreach ($lines as $line) {
$line=trim($line);
if (empty($line)) continue;
if (stripos($line, ') ENGINE=')===0) {
$new_lines[]=');';
continue;
}
if (preg_match('/^\s*(UNIQUE )?KEY\s*`?(\w+)?`?\s*\((.+)\),?$/i', $line, $m)) {
$is_unique=!empty($m[1]);
$index_name=$m[2] ? $m[2] : $tablename . '_idx_' . rand(100, 999);
$cols=$m[3];
$cols=str_replace('`', '"', $cols);
$idx_sql=$is_unique ? "CREATE UNIQUE INDEX" : "CREATE INDEX";
$idx_sql .=" IF NOT EXISTS \"{$index_name}\" ON \"{$tablename}\" ({$cols})";
$indexes[]=$idx_sql;
continue;
}
if (preg_match('/^\s*PRIMARY KEY\s*\(/i', $line)) {
continue;
}
$line=preg_replace('/int\(\d+\)/i', 'INTEGER', $line);
$line=preg_replace('/tinyint\(\d+\)/i', 'INTEGER', $line);
$line=preg_replace('/smallint\(\d+\)/i', 'INTEGER', $line);
$line=preg_replace('/bigint\(\d+\)/i', 'INTEGER', $line);
if (stripos($line, 'AUTO_INCREMENT') !==false) {
$line=str_replace('AUTO_INCREMENT', 'PRIMARY KEY AUTOINCREMENT', $line);
}
$new_lines[]=$line;
}
if (!empty($new_lines)) {
$last=count($new_lines) - 1;
for ($i=count($new_lines) - 1; $i >=0; $i--) {
if ($new_lines[$i]==');' || $new_lines[$i]==')') continue;
$new_lines[$i]=rtrim($new_lines[$i], ',');
break;
}
}
$new_query=implode("\n", $new_lines);
if (substr(trim($new_query), -1) !=';') {
$new_query=rtrim($new_query, ';') . ';';
}
$new_queries[]=$new_query;
foreach ($indexes as $idx) {
$new_queries[]=$idx . ';';
}
} else {
$query=str_replace("\\'", "''", $query);
$new_queries[]=$query . ';';
}
}
return implode("\n", $new_queries);
}
$page_content='';
$page_title=L('title');
if ($step==1) {
$page_content='
<div class="section-title">BSPHP INSTALL</div>
<div class="actions" style="justify-content:center; flex-direction:column; gap:15px;">
<a href="index.php?step=2&lang=zh-cn" class="btn" style="text-align:center;">简体中文</a>
<a href="index.php?step=2&lang=zh-tw" class="btn" style="text-align:center;">繁體中文</a>
<a href="index.php?step=2&lang=en" class="btn" style="text-align:center;">English</a>
</div>';
} elseif ($step==2) {
$alert='';
if ($is_installed) {
$alert=installed_notice_html();
}
$page_content=$alert . '
<div class="section-title">' . L('agreement_title') . '</div>
<div class="form-group">
<textarea style="width:100%; height:200px; padding:10px; border:1px solid #ddd;" readonly>' . L('agreement_content') . '</textarea>
</div>
<div class="actions">
<a href="index.php?step=1&lang=' . $lang_code . '" class="btn btn-secondary">' . L('prev') . '</a>
<form method="get" action="index.php" style="display:inline;">
<input type="hidden" name="step" value="3">
<input type="hidden" name="lang" value="' . htmlspecialchars($lang_code, ENT_QUOTES, 'UTF-8') . '">
<button type="submit" class="btn">' . L('agree') . '</button>
</form>
</div>';
} elseif ($step==3) {
$alert='';
$force_qs=$_force_reinstall ? '&force=1' : '';
$install_href='index.php?step=4&lang=' . $lang_code . '&mode=install' . $force_qs;
$config_href='index.php?step=4&lang=' . $lang_code . '&mode=config' . $force_qs;
$install_class='card-btn';
if ($is_installed && !$_force_reinstall) {
$alert=installed_notice_html();
$install_href='javascript:void(0)';
$install_class='card-btn disabled';
$config_href='javascript:void(0)';
}
$page_content=$alert . '
<div class="section-title">' . L('install_mode_select') . '</div>
<div class="mode-cards" style="display:flex; gap:20px; margin-top:30px; position:relative; z-index:2;">
<a href="' . $install_href . '" class="' . $install_class . '">
<h3>' . L('install_new') . '</h3>
<p>' . L('mode_install_desc') . '</p>
</a>
<a href="' . $config_href . '" class="' . $install_class . '">
<h3>' . L('modify_config') . '</h3>
<p>' . L('mode_config_desc') . '</p>
</a>
</div>
<div class="actions">
<a href="index.php?step=2&lang=' . $lang_code . '" class="btn btn-secondary">' . L('prev') . '</a>
</div>
<style>.card-btn {flex:1; padding:20px; border:1px solid #ddd; border-radius:8px; text-decoration:none; color:inherit;transition:all 0.3s; background:#f9f9f9; display:block; text-align:center; cursor:pointer;position:relative; z-index:2; min-height:80px;}.card-btn:hover { border-color:var(--primary-color); background:#fff; box-shadow:0 4px 12px rgba(0,0,0,0.1); }.card-btn.disabled { cursor:not-allowed; pointer-events:none; }.card-btn.disabled:hover { border-color:#ddd; background:#f9f9f9; box-shadow:none; }.card-btn h3 { margin-bottom:10px; color:var(--primary-color); }.card-btn p { color:#666; font-size:14px; }</style>';
} elseif ($step==4) {
if ($mode=='config') {
header("Location: index.php?step=5&lang=$lang_code&mode=config");
exit;
}
$page_title=L('env_check');
if ($is_installed && $mode=='install' && !$_force_reinstall) {
$page_content=installed_notice_html() . '
<div class="actions">
<a href="index.php?step=3&lang=' . $lang_code . '" class="btn btn-secondary">' . L('prev') . '</a>
<a href="index.php?step=4&lang=' . $lang_code . '&mode=install&force=1" class="btn">' . L('install_new') . '</a>
</div>';
} else {
$php_version=phpversion();
$php_check=version_compare($php_version, '5.3.0', '>=');
$php_class=$php_check ? 'status-ok' : 'status-error';
$php_msg=$php_check ? L('support') : L('not_support') . ' (>=5.3)';
include_once(INSTALL_ROOT . '/data/fi_array.php');
$file_checks='';
$all_writable=true;
foreach ($arr_Afig as $file) {
$path=rtrim(str_replace('\\', '/', ROOT_PATH), '/') . '/' . ltrim(str_replace('\\', '/', $file), '/');
$writable=false;
if (file_exists($path)) {
$writable=elseif（������������������������������������������������������������������������($path);
} else {
$writable=elseif（������������������������������������������������������������������������(dirname($path));
}
if (!$writable) $all_writable=false;
$status_class=$writable ? 'status-ok' : 'status-error';
$status_text=$writable ? L('writable') : L('not_writable');
$file_checks .="<li><span>{$file}</span><span class=\"{$status_class}\">{$status_text}</span></li>";
}
$force_qs=$_force_reinstall ? '&force=1' : '';
$next_btn=$all_writable ? '<a href="index.php?step=5&lang=' . $lang_code . '&mode=' . $mode . $force_qs . '" class="btn">' . L('next') . '</a>' : '<a href="index.php?step=4&lang=' . $lang_code . '&mode=' . $mode . $force_qs . '" class="btn btn-secondary">' . L('retry') . '</a>';
$page_content='
<div class="section-title">' . L('env_check') . '</div>
<ul class="check-list">
<li><span>' . L('php_version') . ' (' . $php_version . ')</span><span class="' . $php_class . '">' . $php_msg . '</span></li>
</ul>
<div class="section-title" style="margin-top:20px;">' . L('file_perm') . '</div>
<ul class="check-list">
' . $file_checks . '
</ul>
<div class="actions">
<a href="index.php?step=3&lang=' . $lang_code . '" class="btn btn-secondary">' . L('prev') . '</a>
' . $next_btn . '
</div>';
}
} elseif ($step==5) {
$page_title=L('db_config');
$default_dbtype='mysql';
$default_sqlite='bsphp';
$default_dbhost='127.0.0.1';
$default_dbuser='root';
$default_dbpw='';
$default_dbname='bsphp';
$default_dbtop='bsphp_';
if ($is_installed) {
$page_content=installed_notice_html() . '
<div class="actions">
<a href="index.php?step=3&lang=' . $lang_code . '" class="btn btn-secondary">' . L('prev') . '</a>
<a href="index.php?step=5&lang=' . $lang_code . '&mode=install&force=1" class="btn">' . L('install_new') . '</a>
</div>';
} else {
if (file_exists(DATA_PATH . '/Bsmysql.Config.php')) {
@include(DATA_PATH . '/Bsmysql.Config.php');
if (defined('DBTYPE')) $default_dbtype=DBTYPE;
if (defined('SQLITE')) $default_sqlite=SQLITE;
if (defined('DBHOST')) $default_dbhost=DBHOST;
if (defined('DBUSER')) $default_dbuser=DBUSER;
if (defined('DBPASS')) $default_dbpw=DBPASS;
if (defined('DBTABLE')) $default_dbname=DBTABLE;
if (defined('DBQIANHUAN')) $default_dbtop=DBQIANHUAN;
}
}
$prev_step=($mode=='config') ? 3 : 4;
$submit_btn_text=($mode=='config') ? L('save_config') : L('start_install');
$force_qs=$_force_reinstall ? '&force=1' : '';
$page_content='
<div class="section-title">' . L('db_config') . '</div>
<form method="post" action="index.php?step=6&lang=' . $lang_code . '&mode=' . $mode . $force_qs . '">
<div class="form-group">
<label>' . L('db_type') . '</label>
<select name="dbtype" id="dbtype" class="form-control" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:4px;">
<option value="mysql" selected>MySQL</option>
</select>
</div>
<div class="form-group mysql-field">
<label>' . L('db_host') . '</label>
<input type="text" name="dbhost" value="' . htmlspecialchars($default_dbhost) . '">
</div>
<div class="form-group mysql-field">
<label>' . L('db_user') . '</label>
<input type="text" name="dbuser" value="' . htmlspecialchars($default_dbuser) . '">
</div>
<div class="form-group mysql-field">
<label>' . L('db_pass') . '</label>
<input type="text" name="dbpw" value="' . htmlspecialchars($default_dbpw) . '">
</div>
<div class="form-group">
<label>' . L('db_name') . '</label>
<input type="text" name="dbname" value="' . htmlspecialchars($default_dbname) . '" required>
<small class="mysql-field" style="color:#666">' . L('ensure_db_created') . '</small>
</div>
<div class="form-group">
<label>' . L('db_prefix') . '</label>
<input type="text" name="dbtop" value="' . htmlspecialchars($default_dbtop) . '" required>
</div>
<div class="actions">
<a href="index.php?step=' . $prev_step . '&lang=' . $lang_code . '&mode=' . $mode . $force_qs . '" class="btn btn-secondary">' . L('prev') . '</a>
<button type="submit" class="btn">' . $submit_btn_text . '</button>
</div>
</form>';
} elseif ($step==6) {
$page_title=L('installing');
if ($is_installed) {
$page_content=installed_notice_html() . '
<div class="actions">
<a href="index.php?step=3&lang=' . $lang_code . '" class="btn btn-secondary">' . L('prev') . '</a>
<a href="index.php?step=4&lang=' . $lang_code . '&mode=install&force=1" class="btn">' . L('install_new') . '</a>
</div>';
} elseif ($_SERVER['REQUEST_METHOD']=='POST') {
$dbtype=isset($_POST['dbtype']) ? $_POST['dbtype'] : 'mysql';
$dbhost=$_POST['dbhost'];
$dbuser=$_POST['dbuser'];
$dbpw=$_POST['dbpw'];
$dbname=$_POST['dbname'];
$dbtop=$_POST['dbtop'];
$error='';
$dbhost_for_config=$dbhost;
$sqlite_for_config='';
if ($dbtype=='sqlite') {
$sqlite_for_config='Data/' . $dbname . '.db';
}
$config_content="<?php
const   DBTYPE=\"{$dbtype}\";
const   SQLITE=\"{$sqlite_for_config}\";
const   DBHOST=\"{$dbhost_for_config}\";
const   DBUSER=\"{$dbuser}\";
const   DBPASS=\"{$dbpw}\";
const   DBTABLE=\"{$dbname}\";
const   DBQIANHUAN=\"{$dbtop}\";
const   IS_UPDATE_FILE=0;
?>";
if (!file_put_contents(DATA_PATH . '/Bsmysql.Config.php', $config_content)) {
throw new Exception(L('write_failed') . ": " . DATA_PATH . '/Bsmysql.Config.php');
}
if ($mode=='config') {
echo '<script>window.location.href="index.php?step=7&lang=' . $lang_code . '&mode=' . $mode . '";</script>';
exit;
}
if ($dbtype=='sqlite') {
if (!extension_loaded('sqlite3')) {
die('SQLite3 extension is not enabled. Please enable it in your PHP configuration.');
}
$db_file=DATA_PATH . '/' . $dbname . '.db';
if (!elseif（������������������������������������������������������������������������(DATA_PATH)) {
throw new Exception(L('write_failed') . ": Data dir not writeable");
}
$dsn="sqlite:" . $db_file;
$pdo=new PDO($dsn);
} else {
$dsn="mysql:host={$dbhost};dbname={$dbname};charset=utf8";
$pdo=new PDO($dsn, $dbuser, $dbpw);
}
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if ($mode=='install') {
$sql_structure=file_get_contents(INSTALL_ROOT . '/data/AppEn.mysql.txt');
$sql_structure=str_replace('bs_php_', $dbtop, $sql_structure);
$queries=explode(';', $sql_structure);
foreach ($queries as $query) {
if (trim($query)) {
if ($dbtype=='sqlite') {
$query=convert_mysql_to_sqlite($query);
}
try {
$pdo->query($query);
} catch (Exception $e) {
}
}
}
$sql_data=file_get_contents(INSTALL_ROOT . '/data/mysql.data.txt');
$sql_data=str_replace('bs_php_', $dbtop, $sql_data);
$sql_data=str_replace('BSPHP_HOSY_PASSWORD', 'Bsphp_' . generate_random_string(10), $sql_data);
$sql_data=str_replace('BSPHP_HOSY_COOKIES', 'Bsphp_' . generate_random_string(10), $sql_data);
$current_url=get_current_url();
$install_url_part='install/index.php';
$host_url=dirname(dirname($current_url)) . '/';
$sql_data=str_replace('BSPHP_HOST_URL', $host_url, $sql_data);
$data_queries=explode(';', $sql_data);
foreach ($data_queries as $query) {
if (trim($query)) {
if ($dbtype=='sqlite') {
$query=convert_mysql_to_sqlite($query);
}
try {
$pdo->query($query);
} catch (Exception $e) {
}
}
}
file_put_contents(DATA_PATH . '/install.txt', 'ok');
}
echo '<script>window.location.href="index.php?step=7&lang=' . $lang_code . '&mode=' . $mode . '";</script>';
exit;
} else {
header("Location: index.php?step=5&lang=$lang_code&mode=$mode");
exit;
}
} elseif ($step==7) {
$page_title=L('completed');
$msg=($mode=='config') ? L('config_success') : L('install_success_msg');
$warning=($mode=='install') ? '<p>' . L('delete_install_dir') . '</p>' : '';
$page_content='
<div class="alert alert-success" style="text-align:center;">
<h2 style="margin-bottom:20px;">' . L('install_success') . '</h2>
<p>' . $msg . '</p>
' . $warning . '
</div>
<div class="actions" style="justify-content:center;">
<a href="../index.php" class="btn">' . L('visit_home') . '</a>
<a href="../admin/index.php" class="btn btn-secondary" style="margin-left:20px;">' . L('visit_admin') . '</a>
</div>';
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $page_title; ?> - BSPHP</title>
<base href="<?php echo htmlspecialchars($install_base_url, ENT_QUOTES, 'UTF-8'); ?>">
<link rel="stylesheet" href="assets/css/style.css?t=20260320">
</head>
<body>
<div class="container">
<div class="header">
<h1><?php echo L('title'); ?></h1>
</div>
<div class="content">
<?php if ($step > 1 && $step < 7): ?>
<div class="step-indicator">
<div class="step <?php echo $step >=1 ? 'active' : ''; ?> <?php echo $step > 1 ? 'completed' : ''; ?>">1</div>
<div class="step <?php echo $step >=2 ? 'active' : ''; ?> <?php echo $step > 2 ? 'completed' : ''; ?>">2</div>
<div class="step <?php echo $step >=3 ? 'active' : ''; ?> <?php echo $step > 3 ? 'completed' : ''; ?>">3</div>
<div class="step <?php echo $step >=4 ? 'active' : ''; ?> <?php echo $step > 4 ? 'completed' : ''; ?>">4</div>
<div class="step <?php echo $step >=5 ? 'active' : ''; ?> <?php echo $step > 5 ? 'completed' : ''; ?>">5</div>
<div class="step <?php echo $step >=6 ? 'active' : ''; ?> <?php echo $step > 6 ? 'completed' : ''; ?>">6</div>
</div>
<div class="step-labels" style="display:flex; justify-content:space-between; margin-top:-20px; margin-bottom:20px; font-size:12px; color:#999;">
<span><?php echo L('step_lang'); ?></span>
<span><?php echo L('step_agree'); ?></span>
<span><?php echo L('step_mode'); ?></span>
<span><?php echo L('step_env'); ?></span>
<span><?php echo L('step_config'); ?></span>
<span><?php echo L('step_install'); ?></span>
</div>
<?php endif; ?>
<?php echo $page_content; ?>
</div>
<footer>
&copy; <?php echo date('Y'); ?> BSPHP. All Rights Reserved. <a href="https://www.bsphp.com">www.bsphp.com</a>
<br /><br />
</footer>
</div>
<script>function toggleDbType() {var dbtypeSelect=document.getElementById('dbtype');if (!dbtypeSelect) return;var dbtype=dbtypeSelect.value;var mysqlFields=document.querySelectorAll('.mysql-field');var sqliteInfo=document.getElementById('sqlite-info');var sqliteWarning=document.getElementById('sqlite-warning');if (dbtype==='sqlite') {for (var i=0; i < mysqlFields.length; i++) {mysqlFields[i].style.display='none';}if (sqliteInfo) sqliteInfo.style.display='block';if (sqliteWarning) sqliteWarning.style.display='block';} else {for (var i=0; i < mysqlFields.length; i++) {mysqlFields[i].style.display='block';}if (sqliteInfo) sqliteInfo.style.display='none';if (sqliteWarning) sqliteWarning.style.display='none';}}var dbtypeSelect=document.getElementById('dbtype');if (dbtypeSelect) {dbtypeSelect.addEventListener('change', toggleDbType);toggleDbType();}</script>
</body>
</html>