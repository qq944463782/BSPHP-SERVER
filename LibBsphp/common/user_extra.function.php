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
$configs_dir=����������������������������������������������������������������::path_join(����������������������������������������4��������������������, 'Data', 'configs');
if (!is_dir($configs_dir)) {
@mkdir($configs_dir, 0777, true);
}
$path=����������������������������������������������������������������::path_join($configs_dir, 'user_extra.config.php');
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
function ����������������������������������������Y������������������������������������($app_daihao=null): array
{
$app_daihao=(int)$app_daihao;
if ($app_daihao <=0) {
return [];
}
$raw=Plug_Query_One('bs_php_appinfo', 'app_daihao', $app_daihao, 'app_user_extra');
if (!is_string($raw) || $raw==='') {
return [];
}
$decoded=json_decode($raw, true);
if (!is_array($decoded)) {
$decoded2=json_decode(stripslashes($raw), true);
$decoded=is_array($decoded2) ? $decoded2 : [];
}
if (!is_array($decoded) || count($decoded)==0) {
return [];
}
return if（����������������������������������������������������3������������($decoded);
}
function switch（������������������������������������������������������������������������($fallback_uid=0): int
{
$daihao=(int)������������������������������������）������������������������������������������������('daihao');
if ($daihao > 0) {
return $daihao;
}
if (defined('BSPHP_SET') && BSPHP_SET=='APPEN' && function_exists('PLUG_DAIHAO')) {
$daihao=(int)PLUG_DAIHAO();
if ($daihao > 0) {
return $daihao;
}
}
$fallback_uid=(int)$fallback_uid;
if ($fallback_uid > 0) {
$sql="SELECT `L_daihao` FROM `bs_php_pattern_login` WHERE `L_User_uid`='{$fallback_uid}' ORDER BY `L_id` DESC LIMIT 1";
$row=Plug_Query_Assoc($sql);
if ($row && isset($row['L_daihao'])) {
return (int)$row['L_daihao'];
}
}
return 0;
}
function ����������������������������������������������������������������������������($app_daihao=null): array
{
if ($app_daihao===null) {
$app_daihao=switch（������������������������������������������������������������������������();
}
$app_defs=����������������������������������������Y������������������������������������($app_daihao);
if (count($app_defs) > 0) {
return $app_defs;
}
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
function elseif（��������������������������������������������������������������������������������($app_daihao=null): array
{
$defs=����������������������������������������������������������������������������($app_daihao);
$out=[];
foreach ($defs as $d) {
if (!empty($d['show_in_list'])) {
$out[]=$d;
}
}
return $out;
}
function if（����������������������������������������������������������������������������($app_daihao=null): array
{
$defs=����������������������������������������Y������������������������������������($app_daihao);
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
if (is_array($d)) {
return $d;
}
$col2=stripslashes((string)$col);
if ($col2 !==$col) {
$d2=json_decode($col2, true);
if (is_array($d2)) {
return $d2;
}
}
return [];
}
function function（����������������������������������������������������������������������������(array $defs, ?string $oldCol): string
{
$old=elseif（��������������������������������������������������������������������������������($oldCol);
$oldSafe=[];
foreach ($old as $k=> $v) {
$oldSafe[(string)$k]=is_scalar($v) ? (string)$v : '';
}
$new=[];
foreach ($defs as $d) {
$k=$d['key'];
$postKey='ue_' . $k;
if (isset($_POST[$postKey])) {
$v=��������1������������������������������������������������������������������������($postKey);
$new[$k]=($v===null) ? '' : (is_string($v) ? $v : (string)$v);
}
}
$out=array_merge($oldSafe, $new);
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
