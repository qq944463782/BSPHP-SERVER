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
function call_perms()
{
$g=(int) $this->Grade;
$can_freeze=(Plug_Get_Configs_Value('agents', 'car_sdate_' . $g) !=0)
|| (Plug_Get_Configs_Value('agents', 'car_off_' . $g) !=0);
$can_unfreeze=Plug_Get_Configs_Value('agents', 'car_sdate_no_' . $g) !=0;
$can_delete=Plug_Get_Configs_Value('agents', 'car_expire_delete_' . $g) !=0;
Plug_Print_Json(array(
'code'=> 100,
'msg'=> 'ok',
'data'=> array(
'can_freeze'=> $can_freeze ? 1 : 0,
'can_unfreeze'=> $can_unfreeze ? 1 : 0,
'can_delete'=> $can_delete ? 1 : 0,
'can_remark'=> 1,
),
));
}
function call_filters()
{
$app_in=Plug_Get_Agent_Appinfo_Array($this->user_array['user_uid']);
$apps=array();
$app_map=array();
$rs=Plug_Query("SELECT `app_daihao`,`app_name` FROM `bs_php_appinfo` WHERE `app_daihao` {$app_in} LIMIT 100");
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$apps[]=$v;
$app_map[$v['app_daihao']]=$v['app_name'];
}
$rule=(string) $this->user_array['user_anget_carid'];
$types=array();
$lei_rs=Plug_Query("SELECT `lei_id`,`lei_name`,`lei_daihao` FROM `bs_php_kalei` ORDER BY `lei_id` ASC");
while ($v=Plug_Pdo_Fetch_Assoc($lei_rs)) {
if ($rule !=='' && $rule !=='*') {
if (!strrpos('###' . $rule, $v['lei_id'] . ',')) {
continue;
}
}
$v['app_name']=isset($app_map[$v['lei_daihao']]) ? $app_map[$v['lei_daihao']] : '';
$types[]=$v;
}
Plug_Print_Json(array('code'=> 100, 'msg'=> 'ok', 'data'=> array('apps'=> $apps, 'types'=> $types)));
}
function call_batch()
{
$raw=Plug_Set_Post('all');
if ($raw==='' || $raw===null) {
$raw=Plug_Set_Post('id');
}
$select=(int) Plug_Set_Post('select_class');
$txt=Plug_Set_Post('txt');
$ids=array();
foreach (explode(',', (string) $raw) as $pid) {
$pid=trim($pid);
if ($pid==='' || !ctype_digit($pid)) {
continue;
}
$ids[]=(int) $pid;
if (count($ids) >=50) {
break;
}
}
if (empty($ids)) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('没有选择记录条目！')));
}
if (count($ids)===1) {
$this->batch_one($ids[0], $select, $txt, true);
}
$results=array();
$ok=0;
$fail=0;
foreach ($ids as $id) {
$ret=$this->batch_one($id, $select, $txt, false);
$name=isset($ret['card']) ? $ret['card'] : (string) $id;
$msg=isset($ret['msg']) ? $ret['msg'] : '';
$success=!empty($ret['ok']);
if ($success) {
$ok++;
} else {
$fail++;
}
$results[]=array(
'id'=> $id,
'card'=> $name,
'ok'=> $success ? 1 : 0,
'msg'=> $msg,
'line'=> $name . ' >>> ' . $msg,
);
}
Plug_Print_Json(array(
'code'=> 100,
'msg'=> Plug_Lang('处理完成') . "({$ok}/" . count($ids) . ')',
'data'=> array(
'ok'=> $ok,
'fail'=> $fail,
'total'=> count($ids),
'results'=> $results,
'log'=> implode("\n", array_map(function ($r) {
return $r['line'];
}, $results)),
),
));
}
private function batch_one($id, $select, $txt, $exit_json)
{
$id=(int) $id;
$in=Plug_Get_Agent_Info_In($this->user_array['user_user']);
$fail=function ($msg, $card='') use ($exit_json, $id) {
$card=$card !=='' ? $card : (string) $id;
if ($exit_json) {
Plug_Print_Json(array('code'=> 1, 'msg'=> $msg));
}
return array('ok'=> false, 'msg'=> $msg, 'card'=> $card);
};
$ok=function ($msg, $card='') use ($exit_json) {
if ($exit_json) {
Plug_Print_Json(array('code'=> 100, 'msg'=> $msg));
}
return array('ok'=> true, 'msg'=> $msg, 'card'=> $card);
};
$array=Plug_Query_Array("SELECT * FROM `bs_php_cardseries` WHERE `car_id`={$id} AND `car_admin` IN ({$in}) LIMIT 1");
if (!$array) {
return $fail(Plug_Lang('不存在'));
}
$card=$array['car_name'];
if (!$this->is_card_mode($array['car_DaiHao'])) {
return $fail(Plug_Lang('仅卡模式软件卡可操作'), $card);
}
if ($select==1) {
if (Plug_Get_Configs_Value('agents', "car_sdate_{$this->Grade}") !=1) {
return $fail(Plug_Lang('你没有权限冻结!'), $card);
}
if ((int) $array['car_IsLock']==1) {
$car_pur_date=PLUG_UNIX() - strtotime($array['car_pur_date']);
$car_on_time=(int) Plug_Get_Configs_Value('agents', "car_on_time_{$this->Grade}");
if ($car_pur_date > $car_on_time) {
return $fail(Plug_Lang('激活时间超') . $car_on_time . Plug_Lang('秒,无法冻结'), $card);
}
}
Plug_Query("UPDATE `bs_php_cardseries` SET `car_zhuangtai`='1' WHERE `car_id`='{$array['car_id']}' AND `car_admin` IN ({$in})");
if (Plug_Get_Configs_Value('agents', "car_on_{$this->Grade}")==1) {
Plug_Query("UPDATE `bs_php_pattern_login` SET `L_IsLock`='1' WHERE `L_daihao`='{$array['car_DaiHao']}' AND (`L_User_uid`='{$array['car_name']}' OR `L_ic_pwd`='{$array['car_name']}')");
}
return $ok(Plug_Lang('冻结成功!'), $card);
}
if ($select==2) {
if (Plug_Get_Configs_Value('agents', "car_sdate_no_{$this->Grade}") !=1) {
return $fail(Plug_Lang('没有权限解冻!'), $card);
}
Plug_Query("UPDATE `bs_php_cardseries` SET `car_zhuangtai`='0' WHERE `car_id`='{$array['car_id']}' AND `car_admin` IN ({$in})");
return $ok(Plug_Lang('解结成功!'), $card);
}
if ($select==3) {
if (Plug_Get_Configs_Value('agents', "car_expire_delete_{$this->Grade}") !=1) {
return $fail(Plug_Lang('没有权限删除!'), $card);
}
$linked=$this->find_linked_login($array);
if ($linked && !$this->is_expired($linked)) {
return $fail(Plug_Lang('卡模式未到期,无法删除'), $card);
}
Plug_Query("DELETE FROM `bs_php_cardseries` WHERE `car_id`='{$array['car_id']}' AND `car_admin` IN ({$in})");
$this->delete_linked_login($array);
return $ok(Plug_Lang('删除已经执行!'), $card);
}
if ($select==12) {
Plug_Query("UPDATE `bs_php_cardseries` SET `car_agnet_beizhu`='{$txt}' WHERE `car_id`='{$array['car_id']}' AND `car_admin`='{$this->user_array['user_uid']}'");
return $ok(Plug_Lang('备注设置成功!'), $card);
}
return $fail(Plug_Lang('你没有选择操作项目!'), $card);
}
}
