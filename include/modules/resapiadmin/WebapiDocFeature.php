<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class WebapiDocFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
if (!function_exists('webapi_scan_apis')) {
����������������������������������������������������������������::����������������������������N��������������������������������������������������������('webapi', 'webapi');
}
}
function call_list()
{
Plug_Admin_Assert_Qx('yy_3');
$list=webapi_scan_apis();
$out=array();
foreach ((array) $list as $row) {
if (!is_array($row)) {
continue;
}
$id=isset($row['id']) ? (string) $row['id'] : '';
if ($id==='') {
continue;
}
$name=isset($row['name']) ? Plug_Lang($row['name']) : $id;
$params=array();
if (!empty($row['params']) && is_array($row['params'])) {
foreach ($row['params'] as $p) {
if (!is_array($p)) {
continue;
}
if (!empty($p['label'])) $p['label']=Plug_Lang($p['label']);
if (!empty($p['labelNote'])) $p['labelNote']=Plug_Lang($p['labelNote']);
if (!empty($p['tip'])) $p['tip']=Plug_Lang($p['tip']);
if (!empty($p['options']) && is_array($p['options'])) {
foreach ($p['options'] as $k=> $o) {
if (!empty($o['text'])) {
$p['options'][$k]['text']=Plug_Lang($o['text']);
}
}
}
$params[]=$p;
}
}
$out[]=array(
'id'=> $id,
'title'=> $name,
'name'=> $name,
'file'=> isset($row['file']) ? (string) $row['file'] : ($id . '.php'),
'path'=> isset($row['path']) ? (string) $row['path'] : '/index.php',
'method'=> !empty($row['method']) ? (string) $row['method'] : 'GET',
'fixed'=> !empty($row['fixed']) && is_array($row['fixed']) ? $row['fixed'] : array(),
'params'=> $params,
);
}
$base=rtrim(getSiteUrl(), '/');
Plug_Admin_Ok('ok', array(
'list'=> $out,
'soft_list'=> Plug_Admin_Webapi_Soft_List(),
'kalei_list'=> Plug_Admin_Webapi_Kalei_List(),
'base_url'=> $base,
'base_hint'=> $base . '/index.php?m=webapi&c={api}',
));
}
}
