<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='AGENT') {
die('Not,This File Not Can in Ie Modules');
}
class DashboardFeature
{
public $user_array;
public $Grade;
function __construct()
{
$this->user_array=Plug_Agent_Assert_Api_Login();
$this->Grade=Plug_Agent_Detect_Grade($this->user_array);
}
private function cnt($sql)
{
$row=Plug_Query_Array($sql);
return (int) (isset($row['hangshu']) ? $row['hangshu'] : 0);
}
function call_info()
{
$uid=(int) $this->user_array['user_uid'];
$user=(string) $this->user_array['user_user'];
$date=date('Y-m-d');
$date_y=date('Y-m-d', time() - 86400);
$date_7=date('Y-m-d', time() - 604800);
$currency=Plug_Get_Configs_Value('sys', 'govicp');
$arr=��������������������������������������������������������������������������������($user);
if (!is_array($arr)) {
$arr=array();
}
$agent_uids=array();
foreach ($arr as $row) {
if (!empty($row['user_uid'])) {
$agent_uids[]=(int) $row['user_uid'];
}
}
$agent_uids[]=$uid;
$int=implode(',', $agent_uids);
if ($int==='') {
$int=(string) $uid;
}
$card_total=$this->cnt("SELECT count(*) AS hangshu FROM `bs_php_cardseries` WHERE `car_admin`='{$uid}'");
$card_used=$this->cnt("SELECT count(*) AS hangshu FROM `bs_php_cardseries` WHERE `car_admin`='{$uid}' AND `car_IsLock`='1' AND `car_zhuangtai`=0");
$card_unused=$this->cnt("SELECT count(*) AS hangshu FROM `bs_php_cardseries` WHERE `car_admin`='{$uid}' AND `car_IsLock`='0' AND `car_zhuangtai`=0");
$card_frozen=$this->cnt("SELECT count(*) AS hangshu FROM `bs_php_cardseries` WHERE `car_admin`='{$uid}' AND `car_zhuangtai`=1");
$today_make=$this->cnt("SELECT count(*) AS hangshu FROM `bs_php_cardseries` WHERE `car_admin`='{$uid}' AND `car_IsLock`='1' AND `car_zhuangtai`=0 AND `car_reDATE` > '{$date}'");
$today_active=$this->cnt("SELECT count(*) AS hangshu FROM `bs_php_cardseries` WHERE `car_admin`='{$uid}' AND `car_IsLock`='1' AND `car_zhuangtai`=0 AND `car_pur_date` > '{$date}'");
$today_freeze=$this->cnt("SELECT count(*) AS hangshu FROM `bs_php_cardseries` WHERE `car_admin`='{$uid}' AND `car_IsLock`='1' AND `car_zhuangtai`=1 AND `car_pur_date` > '{$date}'");
$yesterday_active=$this->cnt("SELECT count(*) AS hangshu FROM `bs_php_cardseries` WHERE `car_admin`='{$uid}' AND `car_zhuangtai`=1 AND `car_reDATE` > '{$date_y}' AND `car_reDATE` < '{$date}'");
$kuka_row=Plug_Query_Array("SELECT SUM(`kuka_val`) AS hangshu FROM `bs_php_kuka` WHERE `kuka_uid`='{$uid}'");
$kuka_total=(int) (isset($kuka_row['hangshu']) ? $kuka_row['hangshu'] : 0);
$nation_today_active=$this->cnt("SELECT count(*) AS hangshu FROM `bs_php_cardseries` WHERE `car_admin` IN ({$int}) AND `car_IsLock`='1' AND `car_zhuangtai`=0 AND `car_pur_date` > '{$date}'");
$nation_yesterday_active=$this->cnt("SELECT count(*) AS hangshu FROM `bs_php_cardseries` WHERE `car_admin` IN ({$int}) AND `car_zhuangtai`=1 AND `car_reDATE` > '{$date_y}' AND `car_reDATE` < '{$date}'");
$nation_7d_active=$this->cnt("SELECT count(*) AS hangshu FROM `bs_php_cardseries` WHERE `car_admin` > 0 AND `car_admin` IN ({$int}) AND `car_zhuangtai`=1 AND `car_reDATE` > '{$date_7}'");
$direct_agents=$this->cnt("SELECT count(*) AS hangshu FROM `bs_php_user` WHERE `user_yao_User`='{$user}'");
$born_today=0;
$active_today=0;
$active_yesterday=0;
$active_7d=0;
$locked_nation=0;
$day_ts=strtotime($date);
$day_y_ts=strtotime($date_y);
$day_7_ts=strtotime($date_7);
foreach ($arr as $key) {
$re=isset($key['user_re_date']) ? strtotime($key['user_re_date']) : 0;
$login=isset($key['user_Login_date']) ? strtotime($key['user_Login_date']) : 0;
if ($re > $day_ts) {
$born_today++;
}
if ($login > $day_ts) {
$active_today++;
}
if ($login > $day_y_ts && $login < $day_ts) {
$active_yesterday++;
}
if ($login > $day_7_ts) {
$active_7d++;
}
if (isset($key['user_IsLock']) && (int) $key['user_IsLock']===1) {
$locked_nation++;
}
}
$kingdom_pop=count($arr);
$my_users=$this->cnt("SELECT count(*) AS hangshu FROM `bs_php_user` WHERE `user_yao_User`='{$user}' AND `user_daili`='0'");
$my_agents=$this->cnt("SELECT count(*) AS hangshu FROM `bs_php_user` WHERE `user_yao_User`='{$user}' AND `user_daili`>'0'");
if ((int) $this->user_array['user_daili']===1) {
$news_sql="SELECT * FROM `bs_php_news` WHERE `news_class`='91000' OR `news_class`='92000' ORDER BY `news_id` DESC LIMIT 20";
} else {
$news_sql="SELECT * FROM `bs_php_news` WHERE `news_class`='91000' ORDER BY `news_id` DESC LIMIT 20";
}
$news_rs=Plug_Query($news_sql);
$news=array();
while ($n=Plug_Pdo_Fetch_Assoc($news_rs)) {
$cls=((int) $n['news_class']===91000) ? Plug_Lang('全体公告') : Plug_Lang('总代理可见');
$body='';
if (isset($n['news_test']) && $n['news_test'] !=='') {
$decoded=@base64_decode($n['news_test'], true);
$body=$decoded !==false ? $decoded : (string) $n['news_test'];
}
$news[]=array(
'id'=> (int) $n['news_id'],
'title'=> isset($n['news_table']) ? $n['news_table'] : '',
'content'=> $body,
'time'=> ������������������������������������������������������������������������������������($n['news_unix']),
'class'=> $cls,
);
}
$lei_map=array(0=> Plug_Lang('类型已经删除'));
$lei_rs=Plug_Query("SELECT `lei_id`,`lei_name` FROM `bs_php_kalei`");
while ($lei=Plug_Pdo_Fetch_Assoc($lei_rs)) {
$lei_map[(int) $lei['lei_id']]=$lei['lei_name'];
}
$app_map=array();
$app_rs=Plug_Query("SELECT `app_daihao`,`app_name` FROM `bs_php_appinfo`");
while ($app=Plug_Pdo_Fetch_Assoc($app_rs)) {
$app_map[$app['app_daihao']]=$app['app_name'];
}
$stock=array();
$kuka_rs=Plug_Query("SELECT * FROM `bs_php_kuka` WHERE `kuka_uid`='{$uid}' ORDER BY `kuka_id` DESC LIMIT 50");
while ($k=Plug_Pdo_Fetch_Assoc($kuka_rs)) {
$stock[]=array(
'kuka_id'=> (int) $k['kuka_id'],
'app_name'=> isset($app_map[$k['kuka_daihao']]) ? $app_map[$k['kuka_daihao']] : (string) $k['kuka_daihao'],
'lei_name'=> isset($lei_map[(int) $k['kuka_kalei']]) ? $lei_map[(int) $k['kuka_kalei']] : Plug_Lang('类型已经删除'),
'val'=> (int) $k['kuka_val'],
);
}
Plug_Print_Json(array(
'code'=> 100,
'msg'=> Plug_Lang('ok'),
'data'=> array(
'uid'=> $uid,
'user'=> $user,
'rmb'=> $this->user_array['user_rmb'],
'currency'=> $currency,
'grade'=> (int) $this->Grade,
'daili'=> (int) $this->user_array['user_daili'],
'my_user_count'=> $my_users,
'my_agent_count'=> $my_agents,
'card_count'=> $card_total,
'card_unused'=> $card_unused,
'card_total'=> $card_total,
'card_used'=> $card_used,
'card_unused_ok'=> $card_unused,
'card_frozen'=> $card_frozen,
'today_make'=> $today_make,
'today_active'=> $today_active,
'today_freeze'=> $today_freeze,
'yesterday_active'=> $yesterday_active,
'kuka_total'=> $kuka_total,
'nation_today_active'=> $nation_today_active,
'nation_yesterday_active'=> $nation_yesterday_active,
'nation_7d_active'=> $nation_7d_active,
'direct_agents'=> $direct_agents,
'born_today'=> $born_today,
'kingdom_active_today'=> $active_today,
'kingdom_active_yesterday'=> $active_yesterday,
'kingdom_active_7d'=> $active_7d,
'nation_locked_agents'=> $locked_nation,
'kingdom_population'=> $kingdom_pop,
'news'=> $news,
'stock'=> $stock,
),
));
}
}
