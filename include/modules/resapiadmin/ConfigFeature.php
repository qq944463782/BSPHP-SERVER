<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class ConfigFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
private function post_map()
{
$out=array();
foreach ($_POST as $k=> $v) {
if ($k==='appenconfig') {
continue;
}
$out[$k]=$v;
}
return $out;
}
function call_sys_get()
{
Plug_Admin_Assert_Qx('xt_1');
Plug_Admin_Ok('ok', Plug_Get_Configs_Section('sys'));
}
function call_sys_save()
{
Plug_Admin_Assert_Qx('xt_1');
Plug_Save_Configs('sys', $this->post_map()) ? Plug_Admin_Ok(Plug_Lang('保存成功')) : Plug_Admin_Fail(Plug_Lang('保存失败'));
}
function call_session_get()
{
Plug_Admin_Assert_Qx('xt_2');
Plug_Admin_Ok('ok', Plug_Get_Configs_Section('sys'));
}
function call_session_save()
{
Plug_Admin_Assert_Qx('xt_2');
Plug_Save_Configs('sys', $this->post_map()) ? Plug_Admin_Ok(Plug_Lang('保存成功')) : Plug_Admin_Fail(Plug_Lang('保存失败'));
}
function call_code_get()
{
Plug_Admin_Assert_Qx('xt_3');
Plug_Admin_Ok('ok', Plug_Get_Configs_Section('code'));
}
function call_code_save()
{
Plug_Admin_Assert_Qx('xt_3');
Plug_Save_Configs('code', $this->post_map()) ? Plug_Admin_Ok(Plug_Lang('保存成功')) : Plug_Admin_Fail(Plug_Lang('保存失败'));
}
function call_re_user_get()
{
Plug_Admin_Assert_Qx('xt_4');
Plug_Admin_Ok('ok', Plug_Get_Configs_Section('user'));
}
function call_re_user_save()
{
Plug_Admin_Assert_Qx('xt_4');
Plug_Save_Configs('user', $this->post_map()) ? Plug_Admin_Ok(Plug_Lang('保存成功')) : Plug_Admin_Fail(Plug_Lang('保存失败'));
}
function call_mail_get()
{
Plug_Admin_Assert_Qx('xt_5');
Plug_Admin_Ok('ok', Plug_Get_Configs_Section('mail'));
}
function call_mail_save()
{
Plug_Admin_Assert_Qx('xt_5');
Plug_Save_Configs('mail', $this->post_map()) ? Plug_Admin_Ok(Plug_Lang('保存成功')) : Plug_Admin_Fail(Plug_Lang('保存失败'));
}
function call_mail_test()
{
Plug_Admin_Assert_Qx('xt_5');
$to=trim((string) Plug_Set_Post('send_mail_text'));
if ($to==='') {
$to=trim((string) Plug_Set_Post('to'));
}
if ($to==='') {
Plug_Admin_Fail(Plug_Lang('请填写收件邮箱'));
}
$mailobj=����������������������������������������������������������������::��������2������������������������������������������������������������������������for（('mail', 'mail');
$ret=$mailobj->send_mail($to, Plug_Lang('测试邮件-Bsphp') . ����������������������������������������������������������������_GET, Plug_Lang('测试邮件Bsphp') . ����������������������������������������������������������������_GET);
if ($ret==-1) {
Plug_Admin_Ok(Plug_Lang('发送成功！(可能在垃圾箱里)'));
}
Plug_Admin_Fail(Plug_Lang('发送失败，错误信息:') . $ret);
}
function call_sms_get()
{
Plug_Admin_Assert_Qx('xt_11');
Plug_Admin_Ok('ok', Plug_Get_Configs_Section('sms'));
}
function call_sms_save()
{
Plug_Admin_Assert_Qx('xt_11');
Plug_Save_Configs('sms', $this->post_map()) ? Plug_Admin_Ok(Plug_Lang('保存成功')) : Plug_Admin_Fail(Plug_Lang('保存失败'));
}
function call_sms_test()
{
Plug_Admin_Assert_Qx('xt_11');
$phone=trim((string) Plug_Set_Post('test_sms_phone'));
if ($phone==='') {
$phone=trim((string) Plug_Set_Post('phone'));
}
if ($phone==='') {
Plug_Admin_Fail(Plug_Lang('请填写手机号'));
}
$area=trim((string) Plug_Set_Post('test_sms_area'));
if ($area==='') {
$area=trim((string) Plug_Set_Post('area'));
}
if ($area==='') {
$area='86';
}
$sms_file=����������������������������������������4�������������������� . 'Plug/sms/sms_manager.class.php';
if (!file_exists($sms_file)) {
Plug_Admin_Fail(Plug_Lang('短信模块不存在'));
}
require_once $sms_file;
$sms_manager=new sms_manager();
$ret=$sms_manager->send_verification_code($area, $phone, '');
if (isset($ret['code']) && (int) $ret['code']===0) {
Plug_Admin_Ok(Plug_Lang('验证码已发送，请查收手机'));
}
Plug_Admin_Fail(isset($ret['msg']) ? $ret['msg'] : Plug_Lang('发送失败'));
}
function call_storage_get()
{
Plug_Admin_Assert_Qx('xt_12');
Plug_Admin_Ok('ok', Plug_Get_Configs_Section('StorageConfig'));
}
function call_storage_save()
{
Plug_Admin_Assert_Qx('xt_12');
Plug_Save_Configs('StorageConfig', $this->post_map()) ? Plug_Admin_Ok(Plug_Lang('保存成功')) : Plug_Admin_Fail(Plug_Lang('保存失败'));
}
function call_extension_get()
{
Plug_Admin_Assert_Qx('xt_6');
Plug_Admin_Ok('ok', Plug_Get_Configs_Section('extension'));
}
function call_extension_save()
{
Plug_Admin_Assert_Qx('xt_6');
Plug_Save_Configs('extension', $this->post_map()) ? Plug_Admin_Ok(Plug_Lang('保存成功')) : Plug_Admin_Fail(Plug_Lang('保存失败'));
}
function call_agent_get()
{
Plug_Admin_Assert_Qx('xt_9');
Plug_Admin_Ok('ok', Plug_Get_Configs_Section('agents'));
}
function call_agent_save()
{
Plug_Admin_Assert_Qx('xt_9');
Plug_Save_Configs('agents', $this->post_map()) ? Plug_Admin_Ok(Plug_Lang('保存成功')) : Plug_Admin_Fail(Plug_Lang('保存失败'));
}
private function scan_agent_menu_tree()
{
$items=array();
$all_ids=array();
$menu_dir=����������������������������������������4�������������������� . 'Plug/Agent_list';
if (!is_dir($menu_dir)) {
return array($items, $all_ids);
}
$files=@scandir($menu_dir);
if (!is_array($files)) {
return array($items, $all_ids);
}
foreach ($files as $fn) {
if (strpos($fn, 'agent_') !==0 || substr($fn, -4) !=='.php') {
continue;
}
$path=$menu_dir . '/' . $fn;
if (!is_file($path)) {
continue;
}
$text=@file_get_contents($path);
if ($text===false) {
continue;
}
$json=json_decode(trim($text), true);
if (!is_array($json) || !isset($json['agentMenu']) || !is_array($json['agentMenu'])) {
continue;
}
foreach ($json['agentMenu'] as $menu_item) {
if (!is_array($menu_item) || empty($menu_item['id'])) {
continue;
}
$id=trim((string) $menu_item['id']);
$all_ids[$id]=1;
$node=array(
'id'=> $id,
'name'=> isset($menu_item['name']) ? $menu_item['name'] : $id,
'children'=> array(),
);
if (isset($menu_item['children']) && is_array($menu_item['children'])) {
foreach ($menu_item['children'] as $child) {
if (!is_array($child) || empty($child['id'])) {
continue;
}
$cid=trim((string) $child['id']);
$all_ids[$cid]=1;
$node['children'][]=array(
'id'=> $cid,
'name'=> isset($child['name']) ? $child['name'] : $cid,
);
}
}
$items[]=$node;
}
}
return array($items, $all_ids);
}
function call_agent_menu_get()
{
Plug_Admin_Assert_Qx('xt_9');
list($tree, $all_ids)=$this->scan_agent_menu_tree();
$agents=Plug_Get_Configs_Section('agents');
$grades=array();
for ($g=1; $g <=3; $g++) {
$hide_raw=isset($agents['agent_menu_hide_ids_' . $g]) ? (string) $agents['agent_menu_hide_ids_' . $g] : '';
$hide_map=array();
foreach (explode(',', $hide_raw) as $hid) {
$hid=trim($hid);
if ($hid !=='') {
$hide_map[$hid]=1;
}
}
$show_ids=array();
foreach ($all_ids as $mid=> $_v) {
if (!isset($hide_map[$mid])) {
$show_ids[]=$mid;
}
}
$grades[$g]=array(
'show_ids'=> $show_ids,
'hide_ids'=> array_keys($hide_map),
'hide_ids_raw'=> $hide_raw,
);
}
Plug_Admin_Ok('ok', array(
'menus'=> $tree,
'all_ids'=> array_keys($all_ids),
'grades'=> $grades,
));
}
function call_agent_menu_save()
{
Plug_Admin_Assert_Qx('xt_9');
list($_tree, $all_ids)=$this->scan_agent_menu_tree();
$payload=Plug_Get_Configs_Section('agents');
if (!is_array($payload)) {
$payload=array();
}
for ($g=1; $g <=3; $g++) {
$show=array();
if (isset($_POST['show_ids_' . $g]) && is_array($_POST['show_ids_' . $g])) {
foreach ($_POST['show_ids_' . $g] as $sid) {
$sid=trim((string) $sid);
if ($sid !=='') {
$show[]=$sid;
}
}
} else {
$raw=Plug_Set_Post('show_ids_' . $g);
if ($raw==='') {
$raw=Plug_Set_Post('agent_menu_show_ids_arr_' . $g);
}
if (is_array($raw)) {
foreach ($raw as $sid) {
$sid=trim((string) $sid);
if ($sid !=='') {
$show[]=$sid;
}
}
} else {
foreach (explode(',', (string) $raw) as $sid) {
$sid=trim($sid);
if ($sid !=='') {
$show[]=$sid;
}
}
}
}
$show=array_values(array_unique($show));
$show_map=array_fill_keys($show, 1);
$hide=array();
foreach ($all_ids as $mid=> $_v) {
if (!isset($show_map[$mid])) {
$hide[]=$mid;
}
}
$payload['agent_menu_hide_ids_' . $g]=implode(',', $hide);
}
Plug_Save_Configs('agents', $payload) ? Plug_Admin_Ok(Plug_Lang('保存成功')) : Plug_Admin_Fail(Plug_Lang('保存失败'));
}
private function list_config_dirs($dir)
{
$out=array();
if (!is_dir($dir)) {
return $out;
}
$list=switch（����������������������������������������������������������������������������_SERVER($dir);
if (!is_array($list)) {
return $out;
}
foreach ($list as $name) {
$name=trim((string) $name);
if ($name==='' || !is_dir($dir . '/' . $name)) {
continue;
}
$out[]=$name;
}
sort($out, SORT_STRING);
return array_values(array_unique($out));
}
function call_template_get()
{
Plug_Admin_Assert_Qx('xt_8');
$cfg=Plug_Get_Configs_Section('sys');
if (!is_array($cfg)) {
$cfg=array();
}
$templates=$this->list_config_dirs(����������������������������������������4�������������������� . 'Plug/templates');
$views=$this->list_config_dirs(����������������������������������������4�������������������� . 'include/templates');
$cur_t=isset($cfg['cms_template']) ? trim((string) $cfg['cms_template']) : '';
$cur_v=isset($cfg['cms_view']) ? trim((string) $cfg['cms_view']) : '';
if ($cur_t !=='' && !in_array($cur_t, $templates, true)) {
array_unshift($templates, $cur_t);
}
if ($cur_v !=='' && !in_array($cur_v, $views, true)) {
array_unshift($views, $cur_v);
}
if (!$templates) {
$templates=array('default');
}
if (!$views) {
$views=array('default');
}
$cfg['cms_template_options']=$templates;
$cfg['cms_view_options']=$views;
Plug_Admin_Ok('ok', $cfg);
}
function call_template_save()
{
Plug_Admin_Assert_Qx('xt_8');
$map=$this->post_map();
unset($map['cms_template_options'], $map['cms_view_options']);
Plug_Save_Configs('sys', $map) ? Plug_Admin_Ok(Plug_Lang('保存成功')) : Plug_Admin_Fail(Plug_Lang('保存失败'));
}
function call_user_extra_get()
{
Plug_Admin_Assert_Qx('xt_13');
$defs=����������������������������������������������������������������������������();
$cfg=Plug_Get_Configs_Section('user_extra');
if (!is_array($cfg)) {
$cfg=array();
}
$cfg['user_extra_defs']=$defs;
$cfg['user_extra_fields']=json_encode($defs, JSON_UNESCAPED_UNICODE);
$cfg['hint']=Plug_Lang('字段键为英文标识，列表与编辑页将按此处表头显示。注册接口传参示例：&user_extra={"key1":"","key2":""}');
Plug_Admin_Ok('ok', $cfg);
}
function call_user_extra_save()
{
Plug_Admin_Assert_Qx('xt_13');
$raw='';
if (isset($_POST['user_extra_fields_b64']) && (string) $_POST['user_extra_fields_b64'] !=='') {
$b64=str_replace(' ', '+', trim((string) $_POST['user_extra_fields_b64']));
$dec=base64_decode($b64, true);
if ($dec===false) {
$dec=base64_decode($b64);
}
if ($dec !==false) {
$raw=(string) $dec;
}
}
if ($raw==='' && isset($_POST['user_extra_fields'])) {
$raw=(string) $_POST['user_extra_fields'];
}
$raw=trim($raw);
if ($raw==='') {
$raw='[]';
}
$decoded=json_decode($raw, true);
if (!is_array($decoded)) {
Plug_Admin_Fail(Plug_Lang('保存失败!数据格式错误'));
}
$normalized=if（����������������������������������������������������3������������($decoded);
$json=json_encode($normalized, JSON_UNESCAPED_UNICODE);
$ok=function（����������������������������break����������������������������������������($json);
$ok ? Plug_Admin_Ok(Plug_Lang('保存成功')) : Plug_Admin_Fail(Plug_Lang('保存失败'));
}
function call_mobile_get()
{
Plug_Admin_Assert_Qx('xt_14');
$cfg=Plug_Get_Configs_Section('mobile');
if (!is_array($cfg)) {
$cfg=array();
}
if (!isset($cfg['h5_show'])) {
$cfg['h5_show']='1';
}
Plug_Admin_Ok('ok', $cfg);
}
function call_mobile_save()
{
Plug_Admin_Assert_Qx('xt_14');
Plug_Save_Configs('mobile', $this->post_map())
? Plug_Admin_Ok(Plug_Lang('保存成功'))
: Plug_Admin_Fail(Plug_Lang('保存失败'));
}
}
