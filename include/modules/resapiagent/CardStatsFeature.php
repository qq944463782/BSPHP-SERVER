<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='AGENT') {
die('Not,This File Not Can in Ie Modules');
}
class CardStatsFeature
{
public $user_array;
public $Grade;
function __construct()
{
$this->user_array=Plug_Agent_Assert_Api_Login();
$this->Grade=Plug_Agent_Detect_Grade($this->user_array);
}
private function date_sql($col)
{
$date1=Plug_Set_Get('date1');
$date2=Plug_Set_Get('date2');
$w='';
if ($date1 !=='') {
$w .=" AND `{$col}` >='{$date1} 00:00:00'";
}
if ($date2 !=='') {
$w .=" AND `{$col}` <='{$date2} 23:59:59'";
}
return $w;
}
function call_by_type()
{
Plug_Agent_Assert_Api_Menu('card_account_stats', $this->Grade);
$uid=(int) $this->user_array['user_uid'];
$daihao=(int) Plug_Set_Get('daihao');
$date_type=(int) Plug_Set_Get('date_type');
$col=($date_type==1) ? 'car_reDATE' : 'car_pur_date';
$where="`car_admin`='{$uid}'";
if ($daihao > 0) {
$where .=" AND `car_DaiHao`='{$daihao}'";
}
$where .=$this->date_sql($col);
$rs=Plug_Query("SELECT `car_Lei`,`car_DaiHao`,
COUNT(*) AS total,
SUM(CASE WHEN `car_IsLock`=0 AND `car_zhuangtai`=0 THEN 1 ELSE 0 END) AS unused,
SUM(CASE WHEN `car_IsLock`=1 AND `car_zhuangtai`=0 THEN 1 ELSE 0 END) AS used,
SUM(CASE WHEN `car_zhuangtai`=1 THEN 1 ELSE 0 END) AS frozen
FROM `bs_php_cardseries` WHERE {$where} GROUP BY `car_Lei`,`car_DaiHao` ORDER BY `car_Lei` LIMIT 1000");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$lei=Plug_Query_One('bs_php_kalei', 'lei_id', $v['car_Lei'], '`lei_name`');
$v['lei_name']=$lei ? $lei['lei_name'] : '';
$list[]=$v;
}
Plug_Print_Json(array('code'=> 100, 'msg'=> 'ok', 'data'=> $list));
}
function call_by_note()
{
Plug_Agent_Assert_Api_Menu('card_note_usage_stats', $this->Grade);
$uid=(int) $this->user_array['user_uid'];
$date_type=(int) Plug_Set_Get('date_type');
$col=($date_type==1) ? 'car_reDATE' : 'car_pur_date';
if ($date_type==-1) {
$date_w='';
} else {
$date_w=$this->date_sql($col);
}
$rs=Plug_Query("SELECT `car_agnet_beizhu` AS name, COUNT(*) AS cnt
FROM `bs_php_cardseries`
WHERE `car_admin`='{$uid}' {$date_w}
GROUP BY `car_agnet_beizhu`
ORDER BY `car_agnet_beizhu`
LIMIT 3000");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=$v;
}
Plug_Print_Json(array('code'=> 100, 'msg'=> 'ok', 'data'=> $list));
}
function call_by_admin_note()
{
Plug_Agent_Assert_Api_Menu('card_account_note_stats', $this->Grade);
$uid=(int) $this->user_array['user_uid'];
$daihao=(int) Plug_Set_Get('daihao');
$beizhu=Plug_Set_Get('soso_beizhu');
$date_type=(int) Plug_Set_Get('date_type');
$col=($date_type==1) ? 'car_reDATE' : 'car_pur_date';
$where="`car_admin`='{$uid}'";
if ($daihao > 0) {
$where .=" AND `car_DaiHao`='{$daihao}'";
}
if ($beizhu !=='') {
$where .=" AND `car_admin_beizhu` LIKE '%{$beizhu}%'";
}
if ($date_type !=-1) {
$where .=$this->date_sql($col);
}
$rs=Plug_Query("SELECT `car_admin_beizhu` AS name, `car_DaiHao`, COUNT(*) AS cnt
FROM `bs_php_cardseries` WHERE {$where}
GROUP BY `car_admin_beizhu`,`car_DaiHao`
ORDER BY cnt DESC LIMIT 3000");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=$v;
}
Plug_Print_Json(array('code'=> 100, 'msg'=> 'ok', 'data'=> $list));
}
function call_apps()
{
Plug_Agent_Assert_Api_Menu('card_account_stats', $this->Grade);
$app_in=Plug_Get_Agent_Appinfo_Array($this->user_array['user_uid']);
$rs=Plug_Query("SELECT `app_daihao`,`app_name`,`app_MoShi` FROM `bs_php_appinfo` WHERE `app_daihao` {$app_in} LIMIT 100");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=$v;
}
Plug_Print_Json(array('code'=> 100, 'msg'=> 'ok', 'data'=> $list));
}
}
