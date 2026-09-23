<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class PaymentConfigFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
private function pay_root()
{
return ����������������������������������������4�������������������� . 'include/modules/payment/paycood';
}
private function load_form($dir)
{
$file=$this->pay_root() . '/' . $dir . '/form_config.php';
if (!file_exists($file)) {
return null;
}
$form=include($file);
if (!is_array($form) || !isset($form['pay_config'])) {
return null;
}
return $form;
}
private function sanitize_dir($dir)
{
$dir=preg_replace('/[^a-zA-Z0-9_\-]/', '', (string) $dir);
return $dir;
}
private function build_gateway($dir, $form)
{
$cfg=$form['pay_config'];
$name=isset($cfg['name']) ? $cfg['name'] : $dir;
$section='pay_' . $name;
$values=Plug_Get_Configs_Section($section);
$fields=array();
foreach ($form as $key=> $meta) {
if ($key==='pay_config' || !is_array($meta)) {
continue;
}
$type=isset($meta['type']) ? (string) $meta['type'] : '';
if ($type==='submit' || $type==='-1') {
continue;
}
$cur=isset($values[$key]) ? $values[$key] : (isset($meta['values']) && !is_array($meta['values']) ? $meta['values'] : '');
$fields[]=array(
'key'=> $key,
'label'=> isset($meta['label']) ? $meta['label'] : $key,
'type'=> $type,
'info'=> isset($meta['info']) ? $meta['info'] : '',
'options'=> (isset($meta['values']) && is_array($meta['values'])) ? $meta['values'] : null,
'value'=> $cur,
);
}
$enabled=Plug_Get_Configs_Value($section, 'pay_' . $name . '_set');
return array(
'dir'=> $dir,
'name'=> $name,
'label'=> isset($cfg['label']) ? $cfg['label'] : $name,
'show_name'=> isset($cfg['show_name']) ? $cfg['show_name'] : $name,
'url'=> isset($cfg['url']) ? $cfg['url'] : '',
'info'=> isset($cfg['info']) ? $cfg['info'] : '',
'enabled'=> ((string) $enabled==='0' || $enabled===0),
'section'=> $section,
'fields'=> $fields,
'values'=> $values,
);
}
function call_list()
{
Plug_Admin_Assert_Qx('xt_7');
$dirs=Plug_Open_List_Dir($this->pay_root());
$list=array();
if (is_array($dirs)) {
foreach ($dirs as $dir) {
$form=$this->load_form($dir);
if (!$form) {
continue;
}
$list[]=$this->build_gateway($dir, $form);
}
}
Plug_Admin_Ok('ok', array('gateways'=> $list));
}
function call_detail()
{
Plug_Admin_Assert_Qx('xt_7');
$dir=$this->sanitize_dir(Plug_Set_Get('config'));
if ($dir==='') {
$dir=$this->sanitize_dir(Plug_Set_Get('name'));
}
$form=$this->load_form($dir);
if (!$form) {
Plug_Admin_Fail(Plug_Lang('支付接口不存在'));
}
Plug_Admin_Ok('ok', $this->build_gateway($dir, $form));
}
function call_save()
{
Plug_Admin_Assert_Qx('xt_7');
if ((int) Plug_Get_Session_Value('ADMIN_UID_IS')===0) {
Plug_Admin_Fail(Plug_Lang('演示账号禁止修改支付配置'));
}
$dir=$this->sanitize_dir(Plug_Set_Post('config'));
if ($dir==='') {
$dir=$this->sanitize_dir(Plug_Set_Post('name'));
}
$form=$this->load_form($dir);
if (!$form) {
Plug_Admin_Fail(Plug_Lang('支付接口不存在'));
}
$name=isset($form['pay_config']['name']) ? $form['pay_config']['name'] : $dir;
$payload=array('config'=> $name);
foreach ($form as $key=> $meta) {
if ($key==='pay_config' || !is_array($meta)) {
continue;
}
$type=isset($meta['type']) ? (string) $meta['type'] : '';
if ($type==='submit' || $type==='-1') {
continue;
}
if (isset($_POST[$key])) {
$payload[$key]=is_array($_POST[$key]) ? '' : (string) $_POST[$key];
}
}
$oid=Plug_Get_Configs_Section('pay_' . $name);
if (!is_array($oid)) {
$oid=array();
}
foreach ($oid as $k=> $v) {
if (is_array($v)) {
unset($oid[$k]);
}
}
$pur=����������������������������������������������������������������::��������2������������������������������������������������������������������������for（('purconfig', 'purconfig');
$ok=$pur->����������������������������������������������������������������������������($name, $payload, $oid, 'pay_');
if ($ok) {
Plug_Admin_Ok(Plug_Lang('保存成功') . ' ' . $name);
}
Plug_Admin_Fail(Plug_Lang('保存失败'));
}
function call_buychong_get()
{
Plug_Admin_Assert_Qx('xt_7');
Plug_Admin_Ok('ok', Plug_Get_Configs_Section('buychong'));
}
function call_buychong_save()
{
Plug_Admin_Assert_Qx('xt_7');
$out=array();
foreach ($_POST as $k=> $v) {
if ($k==='appenconfig') {
continue;
}
$out[$k]=$v;
}
Plug_Save_Configs('buychong', $out) ? Plug_Admin_Ok(Plug_Lang('保存成功')) : Plug_Admin_Fail(Plug_Lang('保存失败'));
}
}
