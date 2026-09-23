<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='AGENT') {
die('Not,This File Not Can in Ie Modules');
}
class CardManageOpsFeature
{
public $user_array;
public $Grade;
function __construct()
{
$this->user_array=Plug_Agent_Assert_Api_Login();
$this->Grade=Plug_Agent_Detect_Grade($this->user_array);
Plug_Agent_Assert_Api_Menu('card_manage', $this->Grade);
}
function call_detail()
{
$id=(int) Plug_Set_Get('id');
$in=Plug_Get_Agent_Info_In($this->user_array['user_user']);
$row=Plug_Query_Array("SELECT * FROM `bs_php_cardseries` WHERE `car_id`='{$id}' AND `car_admin` IN ({$in}) LIMIT 1");
if (!$row) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('不存在')));
}
Plug_Print_Json(array('code'=> 100, 'msg'=> 'ok', 'data'=> $row));
}
function call_perms()
{
$g=(int) $this->Grade;
$can_freeze=(Plug_Get_Configs_Value('agents', 'car_sdate_' . $g) !=0)
|| (Plug_Get_Configs_Value('agents', 'car_off_' . $g) !=0);
$can_unfreeze=Plug_Get_Configs_Value('agents', 'car_sdate_no_' . $g) !=0;
$can_delete=(Plug_Get_Configs_Value('agents', 'car_delete_' . $g) !=0)
|| (Plug_Get_Configs_Value('agents', 'pay_chong_' . $g) !=0);
Plug_Print_Json(array(
'code'=> 100,
'msg'=> 'ok',
'data'=> array(
'grade'=> $g,
'can_freeze'=> $can_freeze ? 1 : 0,
'can_unfreeze'=> $can_unfreeze ? 1 : 0,
'can_delete'=> $can_delete ? 1 : 0,
'can_remark'=> 1,
'labels'=> array(
'freeze'=> Plug_Lang('冻结'),
'unfreeze'=> Plug_Lang('解冻'),
'delete'=> Plug_Lang('删除'),
'remark'=> Plug_Lang('备注(编辑)'),
'batch_freeze'=> Plug_Lang('批量冻结'),
'batch_unfreeze'=> Plug_Lang('批量解冻'),
'batch_delete'=> Plug_Lang('批量删除'),
'export'=> Plug_Lang('导出选中卡号'),
'download'=> Plug_Lang('下载选中卡号'),
),
),
));
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
$ok=function ($msg, $card='') use ($exit_json, $id) {
$card=$card !=='' ? $card : (string) $id;
if ($exit_json) {
Plug_Print_Json(array('code'=> 100, 'msg'=> $msg));
}
return array('ok'=> true, 'msg'=> $msg, 'card'=> $card);
};
if ($select==1) {
if (Plug_Get_Configs_Value('agents', "car_sdate_{$this->Grade}") !=1) {
return $fail(Plug_Lang('你没有权限冻结!'));
}
$array=Plug_Query_Array("SELECT * FROM `bs_php_cardseries` WHERE `car_id`={$id} AND `car_admin` IN ({$in}) LIMIT 1");
if (!$array) {
return $fail(Plug_Lang('不存在'));
}
$card=$array['car_name'];
if ((int) $array['car_IsLock']==1) {
$car_pur_date=PLUG_UNIX() - strtotime($array['car_pur_date']);
$car_on_time=(int) Plug_Get_Configs_Value('agents', "car_on_time_{$this->Grade}");
if ($car_pur_date > $car_on_time) {
return $fail(Plug_Lang('激活时间超') . $car_on_time . Plug_Lang('秒,无法冻结'), $card);
}
}
if (Plug_Get_Configs_Value('agents', "car_off_{$this->Grade}")==0) {
return $fail(Plug_Lang('未激活使用的卡不能冻结!'), $card);
}
Plug_Query("UPDATE `bs_php_cardseries` SET `car_zhuangtai`='1' WHERE `car_id`='{$array['car_id']}' AND `car_admin` IN ({$in})");
if (Plug_Get_Configs_Value('agents', "car_on_{$this->Grade}")==1) {
if ($array['car_cong_user']=='cardid') {
Plug_Query("UPDATE `bs_php_pattern_login` SET `L_IsLock`='1' WHERE `L_daihao`='{$array['car_DaiHao']}' AND (`L_User_uid`='{$array['car_name']}' OR `L_ic_pwd`='{$array['car_name']}')");
} else {
Plug_Query("UPDATE `bs_php_pattern_login` SET `L_IsLock`='1' WHERE `L_daihao`='{$array['car_DaiHao']}' AND `L_User_uid`='{$array['car_chong_uid']}'");
}
}
return $ok(Plug_Lang('冻结成功!'), $card);
}
if ($select==2) {
if (Plug_Get_Configs_Value('agents', "car_sdate_no_{$this->Grade}") !=1) {
return $fail(Plug_Lang('没有权限解冻!'));
}
$array=Plug_Query_Array("SELECT * FROM `bs_php_cardseries` WHERE `car_id`={$id} AND `car_admin` IN ({$in}) LIMIT 1");
if (!$array) {
return $fail(Plug_Lang('选择卡不存在!'));
}
Plug_Query("UPDATE `bs_php_cardseries` SET `car_zhuangtai`='0' WHERE `car_id`='{$array['car_id']}' AND `car_admin` IN ({$in})");
return $ok(Plug_Lang('解结成功!'), $array['car_name']);
}
if ($select==3) {
if (Plug_Get_Configs_Value('agents', "pay_chong_{$this->Grade}") !=1 && Plug_Get_Configs_Value('agents', "car_delete_{$this->Grade}") !=1) {
return $fail(Plug_Lang('没有权限删除!'));
}
$array=Plug_Query_Array("SELECT * FROM `bs_php_cardseries` WHERE `car_id`={$id} AND `car_admin` IN ({$in}) LIMIT 1");
if (!$array) {
return $fail(Plug_Lang('不存在!'));
}
$card=$array['car_name'];
if ((int) $array['car_IsLock']==1) {
if (Plug_Get_Configs_Value('agents', "pay_chong_{$this->Grade}")==0) {
return $fail(Plug_Lang('删除失败，已经激活没有权限!'), $card);
}
$car_pur_date=PLUG_UNIX() - strtotime($array['car_pur_date']);
$car_on_time=(int) Plug_Get_Configs_Value('agents', "car_delete_time_{$this->Grade}");
if ($car_pur_date > $car_on_time) {
return $fail(Plug_Lang('激活时间超') . $car_on_time . Plug_Lang('秒,无法删除'), $card);
}
} else {
if (Plug_Get_Configs_Value('agents', "car_delete_{$this->Grade}")==0) {
return $fail(Plug_Lang('删除失败，未激活没有权限!'), $card);
}
}
Plug_Query("DELETE FROM `bs_php_cardseries` WHERE `car_id`={$array['car_id']} AND `car_admin` IN ({$in})");
return $ok(Plug_Lang('删除已经执行!'), $card);
}
if ($select==12) {
$array=Plug_Query_Array("SELECT `car_id`,`car_name` FROM `bs_php_cardseries` WHERE `car_id`={$id} AND `car_admin`='{$this->user_array['user_uid']}' LIMIT 1");
if (!$array) {
return $fail(Plug_Lang('不存在'));
}
$safe=addslashes((string) $txt);
Plug_Query("UPDATE `bs_php_cardseries` SET `car_agnet_beizhu`='{$safe}' WHERE `car_id`='{$id}' AND `car_admin`='{$this->user_array['user_uid']}'");
return $ok(Plug_Lang('备注设置成功!'), $array['car_name']);
}
return $fail(Plug_Lang('你没有选择操作项目!'));
}
}
