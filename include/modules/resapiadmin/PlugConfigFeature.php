<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class PlugConfigFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_get()
{
Plug_Admin_Assert_Qx('xt_10');
$section=Plug_Set_Get('section');
if ($section==='') {
$section='plug';
}
Plug_Admin_Ok('ok', Plug_Get_Configs_Section($section));
}
function call_save()
{
Plug_Admin_Assert_Qx('xt_10');
$section=Plug_Set_Post('section');
if ($section==='') {
$section='plug';
}
$out=array();
foreach ($_POST as $k=> $v) {
if ($k==='appenconfig' || $k==='section') {
continue;
}
$out[$k]=$v;
}
Plug_Save_Configs($section, $out) ? Plug_Admin_Ok(Plug_Lang('保存成功')) : Plug_Admin_Fail(Plug_Lang('保存失败'));
}
}
