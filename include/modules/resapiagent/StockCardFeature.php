<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='AGENT') {
die('Not,This File Not Can in Ie Modules');
}
class StockCardFeature
{
public $user_array;
public $Grade;
function __construct()
{
$this->user_array=Plug_Agent_Assert_Api_Login();
$this->Grade=Plug_Agent_Detect_Grade($this->user_array);
}
function call_list()
{
Plug_Agent_Assert_Api_Menu('make_card_stock', $this->Grade);
$uid=(int) $this->user_array['user_uid'];
$rs=Plug_Query("SELECT k.`kuka_id`,k.`kuka_daihao`,k.`kuka_kalei`,k.`kuka_val`,k.`kuka_biaoji`,a.`app_name`
FROM `bs_php_kuka` k
LEFT JOIN `bs_php_appinfo` a ON a.`app_daihao`=k.`kuka_daihao`
WHERE k.`kuka_uid`='{$uid}'
ORDER BY k.`kuka_id` DESC");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$lei=Plug_Query_One('bs_php_kalei', 'lei_id', $v['kuka_kalei'], '`lei_name`');
$v['lei_name']=$lei ? $lei['lei_name'] : '';
$list[]=$v;
}
Plug_Print_Json(array('code'=> 100, 'msg'=> 'ok', 'data'=> $list));
}
function call_make()
{
Plug_Agent_Assert_Api_Menu('make_card_stock', $this->Grade);
$select=(int) Plug_Set_Post('select');
$shu=(int) Plug_Set_Post('shu');
$beizhu=Plug_Set_Post('beizhu');
$bin_time=(int) Plug_Get_Session_Value('bin_time');
if (time() - $bin_time < 5) {
Plug_Set_Session_Value('bin_time', time());
Plug_Print_Json(array('code'=> -11, 'msg'=> Plug_Lang('你制卡太频繁,请10秒后再试!')));
}
if ($shu <=0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('请输入制作的数量!')));
}
if ($shu > 100) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('超出范围,每次制卡最大数量100张!')));
}
if ($select <=0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('请选择你要制作的软件的充值卡类型!')));
}
$kuka=Plug_Query_One('bs_php_kuka', 'kuka_id', $select, ' * ');
if (!$kuka || $kuka['kuka_uid'] !=$this->user_array['user_uid']) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('请不要恶意串权!')));
}
if ((int) $kuka['kuka_val'] <=0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('当前剩余卡已经为0!')));
}
if ((int) $kuka['kuka_val'] < $shu) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('当前卡类库存不足已制作你需要的量!')));
}
Plug_Set_Session_Value('bin_time', time());
Plug_Load_Modules_Common('applib', 'makecard');
$zhi_date=Plug_ZhiZuoC($shu, $kuka['kuka_kalei'], $this->user_array['user_uid'], '', -10, '', $beizhu);
if ($zhi_date===0 || $zhi_date===false || $zhi_date==='') {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('制卡失败')));
}
Plug_Query("UPDATE `bs_php_kuka` SET `kuka_val`=`kuka_val`-'{$shu}' WHERE `kuka_id`='{$kuka['kuka_id']}'");
Plug_Add_AppenLog('agent_ka_log', "UID:{$this->user_array['user_uid']}," . Plug_Lang('库存制作数量') . ":{$shu}", $this->user_array['user_user']);
$cards=$this->cards_by_date($zhi_date, (int) $kuka['kuka_kalei']);
Plug_Print_Json(array(
'code'=> 100,
'msg'=> Plug_Lang('库卡制作成功!'),
'data'=> array(
'make_date'=> $zhi_date,
'kuka_id'=> $select,
'lei_id'=> $kuka['kuka_kalei'],
'count'=> $shu,
'cards'=> $cards,
),
));
}
private function cards_by_date($date, $lei_id)
{
$uid=(int) $this->user_array['user_uid'];
$user=addslashes((string) $this->user_array['user_user']);
$date=addslashes((string) $date);
$lei_id=(int) $lei_id;
$rs=Plug_Query("SELECT `car_id`,`car_name`,`car_pwd`,`car_TianShu`,`car_reDATE` FROM `bs_php_cardseries`
WHERE (`car_admin`='{$uid}' OR `car_admin`='{$user}') AND `car_reDATE`='{$date}'
ORDER BY `car_id` DESC LIMIT 2000");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=$v;
}
return $list;
}
}
