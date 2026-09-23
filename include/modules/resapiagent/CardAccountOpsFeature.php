<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='AGENT') {
die('Not,This File Not Can in Ie Modules');
}
class CardAccountOpsFeature
{
public $user_array;
public $Grade;
function __construct()
{
$this->user_array=Plug_Agent_Assert_Api_Login();
$this->Grade=Plug_Agent_Detect_Grade($this->user_array);
Plug_Agent_Assert_Api_Menu('card_account_manage', $this->Grade);
}
private function is_card_mode($daihao)
{
$app=Plug_Query_Array("SELECT `app_MoShi` FROM `bs_php_appinfo` WHERE `app_daihao`='" . (int) $daihao . "' LIMIT 1");
return $app && ($app['app_MoShi']=='CardTerm' || $app['app_MoShi']=='CardPoint');
}
private function find_linked_login($card)
{
$daihao=$card['car_DaiHao'];
$car_name=$card['car_name'];
$where="(`L_User_uid`='{$car_name}' OR `L_ic_pwd`='{$car_name}')";
$chong=isset($card['car_chong_uid']) ? trim((string) $card['car_chong_uid']) : '';
if ($chong !=='' && $chong !=='0') {
$where="(`L_User_uid`='{$car_name}' OR `L_ic_pwd`='{$car_name}' OR `L_User_uid`='{$chong}')";
}
return Plug_Query_Array("SELECT `L_id`,`L_vip_unix` FROM `bs_php_pattern_login` WHERE `L_daihao`='{$daihao}' AND {$where} LIMIT 1");
}
private function delete_linked_login($card)
{
$daihao=$card['car_DaiHao'];
$car_name=$card['car_name'];
$where="(`L_User_uid`='{$car_name}' OR `L_ic_pwd`='{$car_name}')";
$chong=isset($card['car_chong_uid']) ? trim((string) $card['car_chong_uid']) : '';
if ($chong !=='' && $chong !=='0') {
$where="(`L_User_uid`='{$car_name}' OR `L_ic_pwd`='{$car_name}' OR `L_User_uid`='{$chong}')";
}
Plug_Query("DELETE FROM `bs_php_pattern_login` WHERE `L_daihao`='{$daihao}' AND {$where}");
}
private function is_expired($login)
{
if (!$login) {
return false;
}
$vip=(int) $login['L_vip_unix'];
if ($vip <=0) {
return true;
}
if (date('Y', $vip)=='1970') {
return false;
}
return $vip <=PLUG_UNIX();
}
function call_batch()
{
$ids=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
if ($ids==='') {
$ids=(string) (int) Plug_Set_Post('id');
}
$select=(int) Plug_Set_Post('select_class');
if ($ids==='' || $ids==='0') {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('没有选择记录条目！')));
}
$in=Plug_Get_Agent_Info_In($this->user_array['user_user']);
$array=Plug_Query_Array("SELECT * FROM `bs_php_cardseries` WHERE `car_id`={$ids} AND `car_admin` IN ({$in}) LIMIT 1");
if (!$array) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('不存在')));
}
if (!$this->is_card_mode($array['car_DaiHao'])) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('仅卡模式软件卡可操作')));
}
if ($select==1) {
if (Plug_Get_Configs_Value('agents', "car_sdate_{$this->Grade}") !=1) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('你没有权限冻结!')));
}
if ((int) $array['car_IsLock']==1) {
$car_pur_date=PLUG_UNIX() - strtotime($array['car_pur_date']);
$car_on_time=(int) Plug_Get_Configs_Value('agents', "car_on_time_{$this->Grade}");
if ($car_pur_date > $car_on_time) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('激活时间超') . $car_on_time . Plug_Lang('秒,无法冻结')));
}
}
Plug_Query("UPDATE `bs_php_cardseries` SET `car_zhuangtai`='1' WHERE `car_id`='{$array['car_id']}' AND `car_admin` IN ({$in})");
if (Plug_Get_Configs_Value('agents', "car_on_{$this->Grade}")==1) {
Plug_Query("UPDATE `bs_php_pattern_login` SET `L_IsLock`='1' WHERE `L_daihao`='{$array['car_DaiHao']}' AND (`L_User_uid`='{$array['car_name']}' OR `L_ic_pwd`='{$array['car_name']}')");
}
Plug_Print_Json(array('code'=> 100, 'msg'=> Plug_Lang('冻结成功!')));
}
if ($select==2) {
if (Plug_Get_Configs_Value('agents', "car_sdate_no_{$this->Grade}") !=1) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('没有权限解冻!')));
}
Plug_Query("UPDATE `bs_php_cardseries` SET `car_zhuangtai`='0' WHERE `car_id`='{$array['car_id']}' AND `car_admin` IN ({$in})");
Plug_Print_Json(array('code'=> 100, 'msg'=> Plug_Lang('解结成功!')));
}
if ($select==3) {
if (Plug_Get_Configs_Value('agents', "car_expire_delete_{$this->Grade}") !=1) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('没有权限删除!')));
}
$linked=$this->find_linked_login($array);
if ($linked && !$this->is_expired($linked)) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('卡模式未到期,无法删除')));
}
Plug_Query("DELETE FROM `bs_php_cardseries` WHERE `car_id`='{$array['car_id']}' AND `car_admin` IN ({$in})");
$this->delete_linked_login($array);
Plug_Print_Json(array('code'=> 100, 'msg'=> Plug_Lang('删除已经执行!')));
}
if ($select==12) {
$txt=Plug_Set_Post('txt');
Plug_Query("UPDATE `bs_php_cardseries` SET `car_agnet_beizhu`='{$txt}' WHERE `car_id`='{$array['car_id']}' AND `car_admin`='{$this->user_array['user_uid']}'");
Plug_Print_Json(array('code'=> 100, 'msg'=> Plug_Lang('备注设置成功!')));
}
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('你没有选择操作项目!')));
}
}
