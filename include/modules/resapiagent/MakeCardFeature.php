<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='AGENT') {
die('Not,This File Not Can in Ie Modules');
}
class MakeCardFeature
{
public $user_array;
public $Grade;
public $user_str_log;
function __construct()
{
$this->user_array=Plug_Agent_Assert_Api_Login();
$this->Grade=Plug_Agent_Detect_Grade($this->user_array);
$this->user_str_log=Plug_Load_Langs_Array('user', 'user_str_log');
}
function call_types()
{
Plug_Agent_Assert_Api_Menu('make_card_balance', $this->Grade);
$app_in=Plug_Get_Agent_Appinfo_Array($this->user_array['user_uid']);
$sql="SELECT k.*, a.`app_name`, a.`app_daihao`, a.`app_MoShi` FROM `bs_php_kalei` k, `bs_php_appinfo` a
WHERE k.`lei_daili` > -1 AND a.`app_daihao`=k.`lei_daihao` AND a.`app_daihao` {$app_in}
ORDER BY a.`app_name` ASC, k.`lei_sort` ASC, k.`lei_id` ASC";
$rs=Plug_Query($sql);
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$moshi=isset($v['app_MoShi']) ? $v['app_MoShi'] : '';
$lei_type=isset($v['lei_type']) ? (int) $v['lei_type'] : 0;
$list[]=array(
'lei_id'=> (int) $v['lei_id'],
'lei_name'=> $v['lei_name'],
'lei_daihao'=> $v['lei_daihao'],
'lei_date'=> $v['lei_date'],
'lei_type'=> $lei_type,
'lei_unit'=> Plug_Card_Type_Unit($lei_type, $moshi),
'lei_date_label'=> Plug_Card_Type_Date_Label($v['lei_date'], $lei_type, $moshi),
'lei_jiage'=> $v['lei_jiage'],
'lei_daili'=> $v['lei_daili'],
'app_daihao'=> $v['app_daihao'],
'app_name'=> isset($v['app_name']) ? $v['app_name'] : '',
'app_moshi'=> $moshi,
);
}
Plug_Print_Json(array('code'=> 100, 'msg'=> 'ok', 'data'=> $list));
}
function call_make()
{
$make_mode=Plug_Set_Post('make_mode');
if ($make_mode=='stock') {
Plug_Agent_Assert_Api_Menu('make_card_stock', $this->Grade);
} else {
Plug_Agent_Assert_Api_Menu('make_card_balance', $this->Grade);
$make_mode='direct';
}
$select=(int) Plug_Set_Post('select');
$shu=(int) Plug_Set_Post('shu');
$beizhu=Plug_Set_Post('beizhu');
$bin_time=(int) Plug_Get_Session_Value('bin_time');
if (time() - $bin_time < 5) {
Plug_Set_Session_Value('bin_time', time());
Plug_Print_Json(array('code'=> -11, 'msg'=> Plug_Lang('你制卡太频繁,请10秒后再试!')));
}
if ($shu <=0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('请输入制作的数量。!')));
}
$make_card_mun=(int) Plug_Get_Configs_Value('agents', 'make_card_mun');
if ($make_card_mun==0) {
$make_card_mun=100;
}
if ($shu > $make_card_mun) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('超出范围,每次制卡最大数量') . " {$make_card_mun} 张!"));
}
if ($select <=0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('请选择你要制作的软件的充值卡类型!')));
}
$leixing_array=Plug_Query_One('bs_php_kalei', 'lei_id', $select, ' * ');
if (!$leixing_array || (int) $leixing_array['lei_daili']==-1) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('代理价格-1,不能制卡哦!')));
}
$jiage=(float) $leixing_array['lei_daili'];
$uesr_zhe=$this->user_array['user_Zhe'];
$zheinfo='';
if ($uesr_zhe > 0) {
$jiage=$jiage / 100 * $uesr_zhe * 10;
$zheinfo=$uesr_zhe . Plug_Lang('折后,');
}
$zong=$jiage * $shu;
$cha=$this->user_array['user_rmb'] - $zong;
if ($zong > $this->user_array['user_rmb']) {
Plug_Print_Json(array('code'=> 1, 'msg'=> "{$zheinfo}" . Plug_Lang('你当前价格还不够制作') . "{$shu}" . Plug_Lang('张卡,还差') . "{$cha}" . Plug_Lang('元!')));
}
Plug_Set_Session_Value('bin_time', time());
Plug_Load_Modules_Common('applib', 'makecard');
$zhi_date=Plug_ZhiZuoC($shu, $select, $this->user_array['user_uid'], '', -10, '', $beizhu);
if ($zhi_date===0 || $zhi_date===false || $zhi_date==='') {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('制卡失败')));
}
Plug_Add_AppenLog('agent_ka_log', "UID:{$this->user_array['user_uid']}," . Plug_Lang('制作数量') . ":{$shu}," . Plug_Lang('金额') . ":{$zong}", $this->user_array['user_user']);
$rmb_before=(float) $this->user_array['user_rmb'];
$rmb_after=max(0, $rmb_before - $zong);
Plug_Query("UPDATE `bs_php_user` SET `user_rmb`=`user_rmb`-'{$zong}' WHERE `user_uid`='{$this->user_array['user_uid']}'");
Plug_Add_Rmb_Log($this->user_array['user_uid'], $rmb_before, $rmb_after, Plug_Lang('代理制卡扣款'));
if ($make_mode=='stock') {
$addid="{$this->user_array['user_uid']}_{$leixing_array['lei_daihao']}_{$leixing_array['lei_id']}";
$keka=Plug_Query_Array("SELECT * FROM `bs_php_kuka` WHERE `kuka_biaoji`='{$addid}'");
if (!$keka) {
Plug_Query("INSERT INTO `bs_php_kuka` (`kuka_uid`,`kuka_daihao`,`kuka_kalei`,`kuka_biaoji`,`kuka_val`,`kuka_user`) VALUES ('{$this->user_array['user_uid']}','{$leixing_array['lei_daihao']}','{$leixing_array['lei_id']}','{$addid}','0','{$this->user_array['user_user']}')");
$keka=Plug_Query_Array("SELECT * FROM `bs_php_kuka` WHERE `kuka_biaoji`='{$addid}'");
}
if ($keka) {
Plug_Query("UPDATE `bs_php_kuka` SET `kuka_val`=`kuka_val`+'{$shu}' WHERE `kuka_id`='{$keka['kuka_id']}'");
}
Plug_Print_Json(array(
'code'=> 100,
'msg'=> Plug_Lang('制卡成功,已存到库存卡!'),
'data'=> array('make_date'=> $zhi_date, 'count'=> $shu, 'mode'=> 'stock', 'rmb_after'=> $rmb_after),
));
}
Plug_Print_Json(array(
'code'=> 100,
'msg'=> Plug_Lang('制卡成功!'),
'data'=> array(
'make_date'=> $zhi_date,
'lei_id'=> $select,
'count'=> $shu,
'mode'=> 'direct',
'rmb_after'=> $rmb_after,
'cards'=> $this->cards_by_date($zhi_date, $select),
'cards_url'=> 'index.php?m=agent&c=CardManageFeature&a=show&date=' . urlencode($zhi_date) . '&id=' . $select,
),
));
}
private function cards_by_date($date, $lei_id)
{
$uid=(int) $this->user_array['user_uid'];
$user=addslashes((string) $this->user_array['user_user']);
$date=addslashes((string) $date);
$lei_id=(int) $lei_id;
$limit=2000;
$rs=Plug_Query("SELECT `car_id`,`car_name`,`car_pwd`,`car_TianShu`,`car_reDATE` FROM `bs_php_cardseries`
WHERE (`car_admin`='{$uid}' OR `car_admin`='{$user}') AND `car_reDATE`='{$date}'
ORDER BY `car_id` DESC LIMIT {$limit}");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=$v;
}
return $list;
}
}
