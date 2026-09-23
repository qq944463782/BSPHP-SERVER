<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class EnpwdFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_apps()
{
Plug_Admin_Assert_Qx('yy_2');
$rs=Plug_Query("SELECT `app_daihao`,`app_name`,`app_api_pwd` FROM `bs_php_appinfo` ORDER BY `app_daihao` ASC");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$pwd=isset($v['app_api_pwd']) ? (string) $v['app_api_pwd'] : '';
$list[]=array(
'daihao'=> (string) $v['app_daihao'],
'name'=> $v['app_name'],
'has_pwd'=> ($pwd !=='' && $pwd !=='0') ? 1 : 0,
);
}
Plug_Admin_Ok('ok', array('list'=> $list));
}
function call_run()
{
Plug_Admin_Assert_Qx('yy_2');
$text=isset($_POST['text']) ? $_POST['text'] : Plug_Set_Post('text');
if ($text==='' || $text===null) {
$text=Plug_Set_Post('dedetext');
}
$mode=trim((string) Plug_Set_Post('mode'));
if ($mode==='' || $mode==='deapi') {
if (Plug_Set_Post('deapi') !=='') {
$mode='to_alias';
}
if (Plug_Set_Post('enapi') !=='') {
$mode='to_api';
}
}
if ($mode==='base64_encode') {
Plug_Admin_Ok('ok', array('result'=> base64_encode((string) $text), 'mode'=> $mode));
}
if ($mode==='base64_decode') {
Plug_Admin_Ok('ok', array('result'=> base64_decode((string) $text), 'mode'=> $mode));
}
if ($mode==='md5') {
Plug_Admin_Ok('ok', array('result'=> md5((string) $text), 'mode'=> $mode));
}
if ($mode !=='to_alias' && $mode !=='to_api') {
Plug_Admin_Fail(Plug_Lang('未知模式'));
}
$daihao=(int) Plug_Set_Post('daihao');
if ($daihao <=0) {
Plug_Admin_Fail(Plug_Lang('请选择软件'));
}
$app=Plug_Query_Array("SELECT `app_daihao`,`app_name`,`app_api_pwd` FROM `bs_php_appinfo` WHERE `app_daihao`='{$daihao}' LIMIT 1");
if (!$app) {
Plug_Admin_Fail(Plug_Lang('软件不存在'));
}
$apipwd=isset($app['app_api_pwd']) ? (string) $app['app_api_pwd'] : '';
if ($apipwd==='' || $apipwd==='0') {
Plug_Admin_Fail(Plug_Lang('当前软件没有开启别名接口加密！'));
}
$map=$this->build_alias_map($apipwd);
$out=(string) $text;
if ($mode==='to_alias') {
$special=array('cancellation.lg', 'cancellation.ic');
foreach ($special as $sp) {
if (isset($map[$sp])) {
$tmp='XIAOZHOU_' . md5($sp);
$out=str_replace('remote' . $sp, $tmp, $out);
}
}
foreach ($map as $real=> $alias) {
if ($real==='' || $alias==='') {
continue;
}
$out=str_replace($real, $alias, $out);
}
foreach ($special as $sp) {
$tmp='XIAOZHOU_' . md5($sp);
$out=str_replace($tmp, 'remote' . $sp, $out);
}
} else {
foreach ($map as $real=> $alias) {
if ($real==='' || $alias==='') {
continue;
}
$out=str_replace($alias, $real, $out);
}
}
Plug_Admin_Ok('ok', array(
'result'=> $out,
'mode'=> $mode,
'daihao'=> $daihao,
'pairs'=> count($map),
));
}
private function build_alias_map($apipwd)
{
$map=array();
$root=����������������������������������������4�������������������� . 'include/applibapi/api';
if (!is_dir($root)) {
return $map;
}
$files=new RecursiveIteratorIterator(
new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)
);
foreach ($files as $f) {
if (!$f->isFile()) {
continue;
}
$fn=$f->getFilename();
if (strpos($fn, 'AppEn.')===false || substr($fn, -4) !=='.php') {
continue;
}
$apiname=str_replace(array('AppEn.', '.php'), '', $fn);
if ($apiname==='') {
continue;
}
$pwd=des_mencrypt($apiname, $apipwd);
$pwd=str_replace('=', '|MH171C', $pwd);
$pwd=str_replace('+', '|H370J', $pwd);
$pwd=str_replace('/', '|TJS7E', $pwd);
$map[$apiname]=$pwd;
}
return $map;
}
}
