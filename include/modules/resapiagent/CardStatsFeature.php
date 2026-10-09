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
Plug_Print_Json(array('code'=> 100, 'msg'=> 'ok', 'data'=> $this->filter_apps()));
}
function call_by_account()
{
Plug_Agent_Assert_Api_Menu('card_account_stats', $this->Grade);
$soso=Plug_Set_Get('soso');
if ($soso==='') {
$soso=$this->user_array['user_user'];
}
if (!$this->agent_in_scope($soso)) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('没有权限查看该代理')));
}
$soso_id=(int) Plug_Set_Get('soso_id');
$agenttype=(int) Plug_Set_Get('agenttype');
$daihao=Plug_Set_Get('daihao');
$date1=Plug_Set_Get('date1');
$date2=Plug_Set_Get('date2');
if ($soso_id==1) {
$user_sql=" AND `user_yao_User`='{$soso}' ";
} else {
$user_sql=" AND `user_user`='{$soso}' ";
}
$rs_user=Plug_Query("SELECT `user_uid`,`user_user`,`user_rmb` FROM `bs_php_user` WHERE `user_daili`>0 {$user_sql} LIMIT 3000");
$tree_in='';
if ($agenttype==1) {
$tree_in=Plug_Get_Agent_Info_In($soso);
}
$out=array();
while ($u=Plug_Pdo_Fetch_Assoc($rs_user)) {
$kuka_row=Plug_Query_Array("SELECT SUM(`kuka_val`) AS hangshu FROM `bs_php_kuka` WHERE `kuka_uid`='{$u['user_uid']}'");
$admin_sql=($agenttype==1 && $tree_in !=='')
? " `car_admin` IN ({$tree_in}) AND "
: " `car_admin`='{$u['user_uid']}' AND ";
$daihao_sql=((int) $daihao > 0) ? " `car_DaiHao`='{$daihao}' AND " : '';
$a1=($date1 !=='') ? " `car_reDATE` > '{$date1} 00:00:00' AND " : '';
$a2=($date2 !=='') ? " `car_reDATE` < '{$date2} 23:59:59' AND " : '';
$b1=($date1 !=='') ? " `car_pur_date` > '{$date1} 00:00:00' AND " : '';
$b2=($date2 !=='') ? " `car_pur_date` < '{$date2} 23:59:59' AND " : '';
$group_sql="SELECT `car_Lei`,`car_DaiHao`, COUNT(*) AS row FROM `bs_php_cardseries` WHERE {$daihao_sql} {$a1} {$a2} {$admin_sql} car_id>0 OR {$daihao_sql} {$b1} {$b2} {$admin_sql} car_id>0 GROUP BY `car_Lei` ORDER BY `car_Lei` LIMIT 1000";
$rs=Plug_Query($group_sql);
$types=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$lei=Plug_Query_One('bs_php_kalei', 'lei_id', $v['car_Lei'], '`lei_name`');
$app=Plug_Query_Array("SELECT `app_name` FROM `bs_php_appinfo` WHERE `app_daihao`='{$v['car_DaiHao']}' LIMIT 1");
$date_make_1=($date1 !=='') ? " `car_reDATE` > '{$date1} 00:00:00' AND " : '';
$date_make_2=($date2 !=='') ? " `car_reDATE` < '{$date2} 23:59:59' AND " : '';
$date_use_1=($date1 !=='') ? " `car_pur_date` > '{$date1} 00:00:00' AND " : '';
$date_use_2=($date2 !=='') ? " `car_pur_date` < '{$date2} 23:59:59' AND " : '';
$used=Plug_Query_Array("SELECT COUNT(*) AS hangshu FROM `bs_php_cardseries` WHERE {$date_use_1} {$date_use_2} `car_Lei`={$v['car_Lei']} AND `car_IsLock`=1 AND {$admin_sql} `car_zhuangtai`=0 AND `car_DaiHao`='{$v['car_DaiHao']}'");
$unused=Plug_Query_Array("SELECT COUNT(*) AS hangshu FROM `bs_php_cardseries` WHERE {$date_make_1} {$date_make_2} `car_Lei`={$v['car_Lei']} AND `car_IsLock`=0 AND {$admin_sql} `car_zhuangtai`=0 AND `car_DaiHao`='{$v['car_DaiHao']}'");
$frozen=Plug_Query_Array("SELECT COUNT(*) AS hangshu FROM `bs_php_cardseries` WHERE {$date_make_1} {$date_make_2} `car_Lei`={$v['car_Lei']} AND {$admin_sql} `car_zhuangtai`=1 AND `car_DaiHao`='{$v['car_DaiHao']}'");
$zongshu_a=(int) $used['hangshu'];
$zongshu_b=(int) $unused['hangshu'];
$zongshu_c=(int) $frozen['hangshu'];
$types[]=array(
'car_Lei'=> (int) $v['car_Lei'],
'lei_name'=> $lei ? $lei['lei_name'] : '',
'app_name'=> $app ? $app['app_name'] : '',
'car_DaiHao'=> $v['car_DaiHao'],
'used'=> $zongshu_a,
'unused'=> $zongshu_b,
'frozen'=> $zongshu_c,
'total'=> $zongshu_a + $zongshu_b + $zongshu_c,
);
}
$out[]=array(
'uid'=> (int) $u['user_uid'],
'user'=> $u['user_user'],
'rmb'=> $u['user_rmb'],
'kuka'=> (int) (isset($kuka_row['hangshu']) ? $kuka_row['hangshu'] : 0),
'types'=> $types,
);
}
Plug_Print_Json(array('code'=> 100, 'msg'=> 'ok', 'data'=> $out));
}
private function filter_apps()
{
$app_in=Plug_Get_Agent_Appinfo_Array($this->user_array['user_uid']);
$rs=Plug_Query("SELECT `app_daihao`,`app_name`,`app_MoShi` FROM `bs_php_appinfo` WHERE `app_daihao` {$app_in} LIMIT 100");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=$v;
}
return $list;
}
private function agent_in_scope($soso)
{
if ($soso==='' || $soso===$this->user_array['user_user']) {
return true;
}
$row=Plug_Query_One('bs_php_user', 'user_user', $soso, ' `user_uid`,`user_user`,`user_yao_User` ');
$i=0;
while ($i < 100) {
$i++;
if (!$row) {
return false;
}
if ($row['user_yao_User']==$this->user_array['user_user'] || $row['user_user']==$this->user_array['user_user']) {
return true;
}
$row=Plug_Query_One('bs_php_user', 'user_user', $row['user_yao_User'], ' `user_uid`,`user_user`,`user_yao_User` ');
}
return false;
}
}
