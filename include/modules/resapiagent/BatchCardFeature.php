<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='AGENT') {
die('Not,This File Not Can in Ie Modules');
}
class BatchCardFeature
{
public $user_array;
public $Grade;
function __construct()
{
$this->user_array=Plug_Agent_Assert_Api_Login();
$this->Grade=Plug_Agent_Detect_Grade($this->user_array);
}
private function lines()
{
$textarea=isset($_POST['sosotxt']) ? $_POST['sosotxt'] : Plug_Set_Post('sosotxt');
$arr=preg_split("/\r\n|\n|\r/", (string) $textarea);
$out=array();
foreach ($arr as $v) {
$v=trim($v);
if ($v==='') {
continue;
}
$out[]=$v;
}
return $out;
}
function call_query()
{
Plug_Agent_Assert_Api_Menu('batch_query', $this->Grade);
$rows=array();
foreach ($this->lines() as $v) {
$info=Plug_Query_One('bs_php_cardseries', 'car_name', $v, ' `car_admin`,`car_id`,`car_zhuangtai`,`car_IsLock`,`car_pur_date`,`car_cong_user`,`car_DaiHao` ');
if (!$info) {
$rows[]=array('card'=> $v, 'status'=> 'not_found', 'msg'=> Plug_Lang('激活码不存在'));
continue;
}
$admin_name=$info['car_admin'];
$user_login=Plug_Query_One('bs_php_user', 'user_uid', $info['car_admin'], '`user_user`');
if ($user_login) {
$admin_name=$user_login['user_user'];
}
$item=array(
'card'=> $v,
'admin'=> $admin_name,
'zhuangtai'=> (int) $info['car_zhuangtai'],
'IsLock'=> (int) $info['car_IsLock'],
'pur_date'=> $info['car_pur_date'],
);
if ((int) $info['car_zhuangtai']==1) {
$item['status']='frozen';
$item['msg']=Plug_Lang('已冻结');
} elseif ((int) $info['car_IsLock']==1) {
$item['status']='used';
$item['msg']=Plug_Lang('已激活');
$item['cong_user']=$info['car_cong_user'];
} else {
$item['status']='unused';
$item['msg']=Plug_Lang('未激活');
}
$rows[]=$item;
}
Plug_Print_Json(array('code'=> 100, 'msg'=> 'ok', 'data'=> $rows));
}
function call_freeze()
{
Plug_Agent_Assert_Api_Menu('batch_freeze', $this->Grade);
$BS_val_IN=Plug_get_agent_info_in($this->user_array['user_user']);
$car_on_time=(int) Plug_Get_Configs_Value('agents', "car_on_time_{$this->Grade}");
$rows=array();
foreach ($this->lines() as $v) {
if (Plug_Get_Configs_Value('agents', "car_sdate_{$this->Grade}") !=1) {
$rows[]=array('card'=> $v, 'ok'=> 0, 'msg'=> Plug_Lang('你没有权限冻结'));
continue;
}
$array=Plug_Query_Array("SELECT * FROM `bs_php_cardseries` WHERE `car_name`='{$v}' AND `car_admin` IN ({$BS_val_IN}) LIMIT 1");
if (!$array) {
$rows[]=array('card'=> $v, 'ok'=> 0, 'msg'=> Plug_Lang('激活码不存在'));
continue;
}
if ((int) $array['car_zhuangtai']==1) {
$rows[]=array('card'=> $v, 'ok'=> 0, 'msg'=> Plug_Lang('原来已经冻结'));
continue;
}
if ((int) $array['car_IsLock']==1) {
$car_pur_date=���������������������������������������������������������������������������� - strtotime($array['car_pur_date']);
if ($car_pur_date > $car_on_time) {
$rows[]=array('card'=> $v, 'ok'=> 0, 'msg'=> Plug_Lang('激活时间超') . $car_on_time . Plug_Lang('秒,无法冻结'));
continue;
}
}
if (Plug_Get_Configs_Value('agents', "car_off_{$this->Grade}")==0 && (int) $array['car_IsLock']==0) {
$rows[]=array('card'=> $v, 'ok'=> 0, 'msg'=> Plug_Lang('未激活卡不能冻结'));
continue;
}
Plug_Query("UPDATE `bs_php_cardseries` SET `car_zhuangtai`='1' WHERE `car_name`='{$v}' AND `car_admin` IN ({$BS_val_IN})");
if (Plug_Get_Configs_Value('agents', "car_on_{$this->Grade}")==1) {
Plug_Query("UPDATE `bs_php_pattern_login` SET `L_IsLock`='1' WHERE `L_daihao`='{$array['car_DaiHao']}' AND (`L_User_uid`='{$array['car_name']}' OR `L_ic_pwd`='{$array['car_name']}')");
Plug_Query("UPDATE `bs_php_pattern_login` SET `L_IsLock`='1' WHERE `L_daihao`='{$array['car_DaiHao']}' AND `L_User_uid`='{$array['car_chong_uid']}' AND `L_ic_pwd`='{$array['car_chong_uid']}'");
}
$rows[]=array('card'=> $v, 'ok'=> 1, 'msg'=> Plug_Lang('冻结成功'));
}
Plug_Print_Json(array('code'=> 100, 'msg'=> 'ok', 'data'=> $rows));
}
function call_unfreeze()
{
Plug_Agent_Assert_Api_Menu('batch_unfreeze', $this->Grade);
$BS_val_IN=Plug_get_agent_info_in($this->user_array['user_user']);
$rows=array();
foreach ($this->lines() as $v) {
if (Plug_Get_Configs_Value('agents', "car_sdate_no_{$this->Grade}") !=1) {
$rows[]=array('card'=> $v, 'ok'=> 0, 'msg'=> Plug_Lang('没有权限解冻'));
continue;
}
$array=Plug_Query_Array("SELECT * FROM `bs_php_cardseries` WHERE `car_name`='{$v}' AND `car_admin` IN ({$BS_val_IN}) LIMIT 1");
if (!$array) {
$rows[]=array('card'=> $v, 'ok'=> 0, 'msg'=> Plug_Lang('激活码不存在'));
continue;
}
Plug_Query("UPDATE `bs_php_cardseries` SET `car_zhuangtai`='0' WHERE `car_id`='{$array['car_id']}' AND `car_admin`='{$this->user_array['user_uid']}'");
if (Plug_Get_Configs_Value('agents', "car_on_{$this->Grade}")==1) {
if ($array['car_cong_user']=='cardid') {
Plug_Query("UPDATE `bs_php_pattern_login` SET `L_IsLock`='0' WHERE `L_daihao`='{$array['car_DaiHao']}' AND `L_User_uid`='{$array['car_name']}'");
} else {
Plug_Query("UPDATE `bs_php_pattern_login` SET `L_IsLock`='0' WHERE `L_daihao`='{$array['car_DaiHao']}' AND `L_User_uid`='{$array['car_chong_uid']}' AND `L_ic_pwd`='{$array['car_chong_uid']}'");
}
}
$rows[]=array('card'=> $v, 'ok'=> 1, 'msg'=> Plug_Lang('解冻成功'));
}
Plug_Print_Json(array('code'=> 100, 'msg'=> 'ok', 'data'=> $rows));
}
function call_delete()
{
Plug_Agent_Assert_Api_Menu('batch_delete', $this->Grade);
$BS_val_IN=Plug_get_agent_info_in($this->user_array['user_user']);
$rows=array();
foreach ($this->lines() as $v) {
if (Plug_Get_Configs_Value('agents', "car_delete_{$this->Grade}") !=1) {
$rows[]=array('card'=> $v, 'ok'=> 0, 'msg'=> Plug_Lang('没有权限删除'));
continue;
}
$array=Plug_Query_Array("SELECT * FROM `bs_php_cardseries` WHERE `car_name`='{$v}' AND `car_admin` IN ({$BS_val_IN}) LIMIT 1");
if (!$array) {
$rows[]=array('card'=> $v, 'ok'=> 0, 'msg'=> Plug_Lang('激活码不存在'));
continue;
}
if ((int) $array['car_IsLock']==1) {
$car_on_time=(int) Plug_Get_Configs_Value('agents', "car_delete_time_{$this->Grade}");
$car_pur_date=���������������������������������������������������������������������������� - strtotime($array['car_pur_date']);
if ($car_pur_date > $car_on_time) {
$rows[]=array('card'=> $v, 'ok'=> 0, 'msg'=> Plug_Lang('激活时间超') . $car_on_time . Plug_Lang('秒,无法删除'));
continue;
}
}
Plug_Query("DELETE FROM `bs_php_cardseries` WHERE `car_id`={$array['car_id']} AND `car_admin` IN ({$BS_val_IN})");
if (Plug_Get_Configs_Value('agents', "car_on_{$this->Grade}")==1) {
if ($array['car_cong_user']=='cardid') {
Plug_Query("DELETE FROM `bs_php_pattern_login` WHERE `L_daihao`='{$array['car_DaiHao']}' AND `L_User_uid`='{$array['car_name']}'");
} else {
Plug_Query("DELETE FROM `bs_php_pattern_login` WHERE `L_daihao`='{$array['car_DaiHao']}' AND `L_User_uid`='{$array['car_chong_uid']}' AND `L_ic_pwd`='{$array['car_chong_uid']}'");
}
}
$rows[]=array('card'=> $v, 'ok'=> 1, 'msg'=> Plug_Lang('删除已经执行'));
}
Plug_Print_Json(array('code'=> 100, 'msg'=> 'ok', 'data'=> $rows));
}
}
