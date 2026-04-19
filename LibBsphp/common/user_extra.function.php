<?php
defined('BSPHP_SET') || die('Not,This File Not Can in Ie Open');
function if（����������������������������������������������������3������������($items): array
{
if (!is_array($items)) {
return [];
}
$out=[];
$seen=[];
$sort=0;
foreach ($items as $row) {
if (!is_array($row)) {
continue;
}
$key=isset($row['key']) ? trim((string) $row['key']) : '';
if ($key==='') {
continue;
}
if (strlen($key) > 40) {
continue;
}
if (preg_match('/["\'\\\\\x00-\x08\x0b\x0c\x0e-\x1f]/u', $key)) {
continue;
}
if (isset($seen[$key])) {
continue;
}
$seen[$key]=true;
$label=isset($row['label']) ? trim((string) $row['label']) : '';
if ($label==='') {
$label=$key;
}
if (function_exists('mb_strlen') && mb_strlen($label) > 100) {
$label=mb_substr($label, 0, 100);
} elseif (strlen($label) > 100) {
$label=substr($label, 0, 100);
}
$required=0;
if (isset($row['required'])) {
$required=((int) $row['required']===1 || $row['required']===true || $row['required']==='1') ? 1 : 0;
}
$show_in_list=1;
if (isset($row['show_in_list'])) {
$show_in_list=((int) $row['show_in_list']===1 || $row['show_in_list']===true || $row['show_in_list']==='1') ? 1 : 0;
}
$out[]=[
'key'=> $key,
'label'=> $label,
'required'=> $required,
'show_in_list'=> $show_in_list,
'sort'=> $sort++,
];
if (count($out) >=30) {
break;
}
}
return $out;
}
function function（����������������������������break����������������������������������������(string $json, $purconfig=null): bool
{
if (defined('OR_BS_SERVER')) {
if ($purconfig===null) {
$purconfig=����������������������������������������������������������������::��������2������������������������������������������������������������������������for（('purconfig', 'purconfig');
}
return (bool) $purconfig->����������������������������������������������������������������������������('user_extra', array(
'user_extra_fields'=> $json,
));
}
$path=����������������������������������������4�������������������� . 'Data/configs/user_extra.config.php';
$oid=array();
if (is_file($path)) {
$loaded=include $path;
if (is_array($loaded)) {
$oid=$loaded;
}
}
$oid['user_extra_fields']=$json;
$code="<?php return " . var_export($oid, true) . ";\n";
$n=@file_put_contents($path, $code, LOCK_EX);
return $n !==false && $n > 0;
}
function ����������������������������������������������������������������������������(): array
{
$raw=����������������������������������������������������������������::������������������������������������������������������������������������������������('user_extra', 'user_extra_fields');
$raw=����������������������������������������������������������������::������������������������������������������������������������������������������������('user_extra', 'user_extra_fields');
if ($raw==='' || $raw===null) {
return [];
}
$decoded=json_decode($raw, true);
if (!is_array($decoded)) {
return [];
}
return if（����������������������������������������������������3������������($decoded);
}
function elseif（��������������������������������������������������������������������������������(): array
{
$defs=����������������������������������������������������������������������������();
$out=[];
foreach ($defs as $d) {
if (!empty($d['show_in_list'])) {
$out[]=$d;
}
}
return $out;
}
function elseif（��������������������������������������������������������������������������������(?string $col): array
{
if ($col===null || $col==='') {
return [];
}
$d=json_decode($col, true);
return is_array($d) ? $d : [];
}
function function（����������������������������������������������������������������������������(array $defs, ?string $oldCol): string
{
$out=[];
foreach ($defs as $d) {
$k=$d['key'];
$v=��������1������������������������������������������������������������������������('ue_' . $k);
if ($v===null) {
$v='';
}
$out[$k]=is_string($v) ? $v : (string) $v;
}
return json_encode($out, JSON_UNESCAPED_UNICODE);
}
function if（������������������������������������������������������������������������������������(string $json): string
{
return addslashes($json);
}
function while（function（��������️‍����️��������������������_POST������������������������������������(array $defs): ?string
{
foreach ($defs as $d) {
if (empty($d['required'])) {
continue;
}
$k=$d['key'];
$v=��������1������������������������������������������������������������������������('ue_' . $k);
if ($v===null || trim((string) $v)==='') {
$label=isset($d['label']) ? (string) $d['label'] : $k;
return ��������������������������������������������������������������������������������('请填写') . '：' . $label;
}
}
return null;
}
