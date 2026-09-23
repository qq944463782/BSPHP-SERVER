<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class ApplibapiDocFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_index()
{
Plug_Admin_Assert_Qx('yy_5');
$groups=$this->scan_groups();
$total=0;
foreach ($groups as $g) {
$total +=isset($g['items']) ? count($g['items']) : 0;
}
Plug_Admin_Ok('ok', array(
'groups'=> $groups,
'total'=> $total,
'hint'=> Plug_Lang('以下为 include/applibapi/api 目录下接口文件头注释中的 <api> 说明，由系统自动扫描生成。'),
'group_rule'=> array(
array('suffix'=> '.in', 'label'=> Plug_Lang('公共接口')),
array('suffix'=> '.lg', 'label'=> Plug_Lang('用户登录模式')),
array('suffix'=> '.ic', 'label'=> Plug_Lang('卡串验证模式')),
),
));
}
private function scan_groups()
{
$root=����������������������������������������4�������������������� . 'include/applibapi/api';
if (!is_dir($root)) {
return array();
}
$files=new RecursiveIteratorIterator(
new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)
);
$rows=array();
$base=rtrim(str_replace('\\', '/', ����������������������������������������4��������������������), '/');
foreach ($files as $f) {
if (!$f->isFile() || strtolower($f->getExtension()) !=='php') {
continue;
}
if (!preg_match('/^AppEn\..+\.php$/', $f->getFilename())) {
continue;
}
$content=@file_get_contents($f->getPathname());
if ($content===false || strpos($content, '<api>')===false) {
continue;
}
$block=$this->extract_api_xml_block($content);
if ($block===null) {
continue;
}
$parsed=$this->parse_api_xml($block);
if ($parsed===null) {
continue;
}
$rel=ltrim(str_replace('\\', '/', substr($f->getPathname(), strlen($base))), '/');
$parsed['file']=$rel;
$parsed['folder']=basename(dirname($f->getPathname()));
$parsed['basename']=$f->getFilename();
$parsed['raw_xml']=$block;
$parsed['mode']=$this->mode_from_filename($f->getFilename());
$rows[]=$parsed;
}
return $this->group_by_mode($rows);
}
private function mode_from_filename($filename)
{
if (preg_match('/\.(in|lg|ic)\.php$/i', $filename, $m)) {
return strtolower($m[1]);
}
return 'other';
}
private function group_by_mode(array $rows)
{
$labels=array(
'in'=> Plug_Lang('公共接口'),
'lg'=> Plug_Lang('用户登录模式'),
'ic'=> Plug_Lang('卡串验证模式'),
'other'=> Plug_Lang('其他'),
);
$buckets=array('in'=> array(), 'lg'=> array(), 'ic'=> array(), 'other'=> array());
foreach ($rows as $row) {
$m=isset($row['mode']) ? (string) $row['mode'] : 'other';
if (!isset($buckets[$m])) {
$m='other';
}
$buckets[$m][]=$row;
}
$groups=array();
foreach (array('in', 'lg', 'ic', 'other') as $key) {
if (empty($buckets[$key])) {
continue;
}
usort($buckets[$key], function ($a, $b) {
return strcmp((string) ($a['name'] ?? ''), (string) ($b['name'] ?? ''));
});
$groups[]=array(
'mode'=> $key,
'mode_label'=> $labels[$key],
'suffix'=> $key==='other' ? '' : ('.' . $key),
'count'=> count($buckets[$key]),
'items'=> $buckets[$key],
);
}
return $groups;
}
private function extract_api_xml_block($content)
{
if (!preg_match('/\/\*\s*(<api>[\s\S]*?<\/api>)\s*\*\//', $content, $m)) {
return null;
}
return trim($m[1]);
}
private function parse_api_xml($xmlstr)
{
libxml_use_internal_errors(true);
$sx=@simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $xmlstr);
libxml_clear_errors();
if ($sx===false) {
return null;
}
$row=array(
'name'=> trim((string) $sx->name),
'title'=> trim((string) $sx->title),
'intro'=> trim((string) $sx->intro),
'common_params'=> array(),
'params'=> array(),
);
if (isset($sx->common_params)) {
foreach ($sx->common_params->param as $p) {
$row['common_params'][]=$this->param_row($p);
}
}
if (isset($sx->params)) {
foreach ($sx->params->param as $p) {
$pr=$this->param_row($p);
if ($pr['name']==='') {
continue;
}
$row['params'][]=$pr;
}
}
return $row;
}
private function param_row($p)
{
$attrs=$p->attributes();
$pname=trim((string) $attrs['name']);
if ($pname==='' && isset($attrs['key'])) {
$pname=trim((string) $attrs['key']);
}
$dtype=(string) $attrs['dtype'];
$ptype=(string) $attrs['type'];
return array(
'name'=> $pname,
'type'=> $ptype,
'dtype'=> $dtype !=='' ? $dtype : $ptype,
'required'=> (string) $attrs['required'],
'desc'=> trim((string) $attrs['desc']),
);
}
}
