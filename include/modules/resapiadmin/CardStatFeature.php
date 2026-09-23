<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class CardStatFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
private function date_where($col='car_reDATE')
{
$d1=Plug_Set_Get('date1');
$d2=Plug_Set_Get('date2');
$w='';
if ($d1 !=='') {
$w .=" AND `{$col}`>='{$d1}'";
}
if ($d2 !=='') {
$w .=" AND `{$col}`<='{$d2}'";
}
return $w;
}
function call_by_user()
{
Plug_Admin_Assert_Qx('cw_3');
$daihao=(int) Plug_Set_Get('daihao');
$where=$daihao > 0 ? "`car_DaiHao`='{$daihao}'" : '1=1';
$where .=$this->date_where();
$rs=Plug_Query("SELECT `car_Lei` AS name, count(*) AS cnt FROM `bs_php_cardseries` WHERE {$where} GROUP BY `car_Lei`");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=$v;
}
Plug_Admin_Ok('ok', $list);
}
function call_by_agent_batch()
{
Plug_Admin_Assert_Qx('cw_4');
$daihao=(int) Plug_Set_Get('daihao');
$where=$daihao > 0 ? "`car_DaiHao`='{$daihao}'" : '1=1';
$where .=$this->date_where();
$soso=Plug_Set_Get('soso');
if ($soso !=='') {
$where .=" AND `car_admin` LIKE '%{$soso}%'";
}
$rs=Plug_Query("SELECT `car_admin` AS name, count(*) AS cnt FROM `bs_php_cardseries` WHERE {$where} GROUP BY `car_admin`");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=$v;
}
Plug_Admin_Ok('ok', $list);
}
function call_by_note()
{
Plug_Admin_Assert_Qx('cw_5');
$where='1=1' . $this->date_where();
$rs=Plug_Query("SELECT `car_admin_beizhu` AS name, count(*) AS cnt FROM `bs_php_cardseries` WHERE {$where} GROUP BY `car_admin_beizhu`");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=$v;
}
Plug_Admin_Ok('ok', $list);
}
function call_by_note_batch()
{
Plug_Admin_Assert_Qx('cw_6');
$daihao=(int) Plug_Set_Get('daihao');
$where=$daihao > 0 ? "`car_DaiHao`='{$daihao}'" : '1=1';
$where .=$this->date_where();
$beizhu=Plug_Set_Get('soso_beizhu');
if ($beizhu !=='') {
$where .=" AND `car_admin_beizhu` LIKE '%{$beizhu}%'";
}
$rs=Plug_Query("SELECT `car_admin_beizhu` AS name, count(*) AS cnt FROM `bs_php_cardseries` WHERE {$where} GROUP BY `car_admin_beizhu`");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=$v;
}
Plug_Admin_Ok('ok', $list);
}
function call_by_agent_note()
{
Plug_Admin_Assert_Qx('cw_7');
$where='1=1' . $this->date_where();
$rs=Plug_Query("SELECT `car_agnet_beizhu` AS name, `car_admin`, count(*) AS cnt FROM `bs_php_cardseries` WHERE {$where} GROUP BY `car_agnet_beizhu`,`car_admin`");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=$v;
}
Plug_Admin_Ok('ok', $list);
}
}
