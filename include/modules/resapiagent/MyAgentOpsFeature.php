<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='AGENT') {
die('Not,This File Not Can in Ie Modules');
}
class MyAgentOpsFeature
{
public $user_array;
public $Grade;
function __construct()
{
$this->user_array=Plug_Agent_Assert_Api_Login();
$this->Grade=Plug_Agent_Detect_Grade($this->user_array);
Plug_Agent_Assert_Api_Menu('my_agent_list', $this->Grade);
}
private function scope_sql($all)
{
$uid=$this->user_array['user_uid'];
$user=$this->user_array['user_user'];
return "`user_uid` IN ({$all}) AND `user_daili`>0 AND (`user_yao_User`='{$uid}' OR `user_yao_User`='{$user}')";
}
function call_batch()
{
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
$select=(int) Plug_Set_Post('select_class');
if ($all==='') {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('没有选择记录条目！')));
}
$scope=$this->scope_sql($all);
if ($select==2) {
$txt=Plug_Set_Post('txt');
Plug_Query("UPDATE `bs_php_user` SET `user_anget_beizhu`='{$txt}' WHERE {$scope}");
Plug_Print_Json(array('code'=> 100, 'msg'=> Plug_Lang('备注修改成功')));
}
if ($select==3) {
Plug_Query("UPDATE `bs_php_user` SET `user_IsLock`='1' WHERE {$scope}");
Plug_Print_Json(array('code'=> 100, 'msg'=> Plug_Lang('冻结成功')));
}
if ($select==4) {
Plug_Query("UPDATE `bs_php_user` SET `user_IsLock`='0' WHERE {$scope}");
Plug_Print_Json(array('code'=> 100, 'msg'=> Plug_Lang('解封成功')));
}
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('你没有选择操作项目')));
}
function call_transfer()
{
$sub=$this->find_sub_agent();
$money_raw=Plug_Set_Post('money');
if ($money_raw==='' || !is_numeric($money_raw)) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('请输入金额')));
}
$money=round((float) $money_raw, 2);
if ($money==0.0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('请输入金额')));
}
if ($money > 10000) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('单次转账不能大于') . '10000'));
}
if ($money > 0) {
if ($money > (float) $this->user_array['user_rmb']) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('余额不足')));
}
} else {
$need=0 - $money;
if (((float) $sub['user_rmb'] - $need) < 0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('扣除账号点数不足')));
}
if ((float) Plug_Get_Configs_Value('extension', 'ticheng_baifenbi_1') > 0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('目前提成模式无法收回下级金额') . '.' . Plug_Lang('原因') . ':' . Plug_Lang('检测') . 'A' . Plug_Lang('提成大于') . '0' . Plug_Lang('无法收回') . '.'));
}
}
$amt=sprintf('%.2f', $money);
$to_before=(float) $sub['user_rmb'];
$to_after=$to_before + $money;
$from_before=(float) $this->user_array['user_rmb'];
$from_after=$from_before - $money;
Plug_Query("UPDATE `bs_php_user` SET `user_rmb`=`user_rmb`+({$amt}) WHERE `user_uid`='{$sub['user_uid']}'");
Plug_Add_Rmb_Log($sub['user_uid'], $to_before, $to_after, Plug_Lang('代理转账转入'));
Plug_Add_AppenLog(
'money_buy_log',
$this->user_array['user_user'] . Plug_Lang('向') . ' ' . $sub['user_user'] . ' ' . Plug_Lang('你加') . " {$amt} " . Plug_Lang('点'),
$sub['user_uid']
);
Plug_Query("UPDATE `bs_php_user` SET `user_rmb`=`user_rmb`-({$amt}) WHERE `user_uid`='{$this->user_array['user_uid']}'");
Plug_Add_Rmb_Log($this->user_array['user_uid'], $from_before, $from_after, Plug_Lang('代理转账转出'));
Plug_Add_AppenLog(
'money_buy_log',
Plug_Lang('你') . $this->user_array['user_user'] . Plug_Lang('向') . ' ' . $sub['user_user'] . ' ' . Plug_Lang('加') . " {$amt} " . Plug_Lang('点'),
$this->user_array['user_user']
);
Plug_Print_Json(array(
'code'=> 100,
'msg'=> Plug_Lang('成功') . ',' . Plug_Lang('如果金额没有变动') . ',' . Plug_Lang('请刷新查看'),
'data'=> array(
'uid'=> (int) $sub['user_uid'],
'money'=> (float) $amt,
'from_rmb'=> $from_after,
'to_rmb'=> $to_after,
),
));
}
function call_set_zhe()
{
$sub=$this->find_sub_agent();
$zhe_raw=Plug_Set_Post('zhe');
if ($zhe_raw==='' || $zhe_raw===null) {
$zhe_raw=Plug_Set_Post('money');
}
if ($zhe_raw==='' || !is_numeric($zhe_raw)) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('请输入折扣') . ' ' . Plug_Lang('如:8.8')));
}
$zhe=round((float) $zhe_raw, 2);
if ($zhe < 0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('请输入折扣') . ' ' . Plug_Lang('如:8.8')));
}
$zhe_sql=sprintf('%.2f', $zhe);
Plug_Query("UPDATE `bs_php_user` SET `user_Zhe`='{$zhe_sql}' WHERE `user_uid`='{$sub['user_uid']}'");
Plug_Print_Json(array(
'code'=> 100,
'msg'=> Plug_Lang('折扣设置成功'),
'data'=> array('uid'=> (int) $sub['user_uid'], 'zhe'=> (float) $zhe_sql),
));
}
function call_kuka_list()
{
$sub=$this->find_sub_agent();
$dir=Plug_Set_Get('dir');
if ($dir==='') {
$dir=Plug_Set_Post('dir');
}
$owner=($dir==='reduce') ? (int) $sub['user_uid'] : (int) $this->user_array['user_uid'];
$rs=Plug_Query("SELECT k.`kuka_id`,k.`kuka_daihao`,k.`kuka_kalei`,k.`kuka_val`,a.`app_name`
FROM `bs_php_kuka` k, `bs_php_appinfo` a
WHERE a.`app_daihao`=k.`kuka_daihao` AND k.`kuka_uid`='{$owner}'
ORDER BY k.`kuka_id` DESC");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$lei=Plug_Query_One('bs_php_kalei', 'lei_id', $v['kuka_kalei'], '`lei_name`');
$v['lei_name']=$lei ? $lei['lei_name'] : Plug_Lang('类型已经删除');
$v['kuka_id']=(int) $v['kuka_id'];
$v['kuka_val']=(int) $v['kuka_val'];
$list[]=$v;
}
Plug_Print_Json(array(
'code'=> 100,
'msg'=> 'ok',
'data'=> array(
'dir'=> ($dir==='reduce') ? 'reduce' : 'add',
'uid'=> (int) $sub['user_uid'],
'user'=> $sub['user_user'],
'list'=> $list,
),
));
}
function call_kuka_transfer()
{
$sub=$this->find_sub_agent();
$dir=Plug_Set_Post('dir');
$select=(int) Plug_Set_Post('select');
$shu=(int) Plug_Set_Post('shu');
if ($shu <=0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('请输入数量!')));
}
if ($shu > 100) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('超出范围,每次制卡最大数量100张!')));
}
if ($select <=0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('请选择你要软件的充值卡类型!')));
}
$kuka=Plug_Query_One('bs_php_kuka', 'kuka_id', $select, ' * ');
if (!$kuka) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('卡类不存在A!')));
}
$from_uid=($dir==='reduce') ? (int) $sub['user_uid'] : (int) $this->user_array['user_uid'];
$to_uid=($dir==='reduce') ? (int) $this->user_array['user_uid'] : (int) $sub['user_uid'];
$to_user=($dir==='reduce') ? $this->user_array['user_user'] : $sub['user_user'];
if ((int) $kuka['kuka_uid'] !==$from_uid) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('请不要恶意串权!')));
}
if ((int) $kuka['kuka_val'] <=0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('当前剩余卡已经为0!')));
}
if ((int) $kuka['kuka_val'] < $shu) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('当前卡类库存不足已你需要的量!')));
}
$lei=Plug_Query_One('bs_php_kalei', 'lei_id', $kuka['kuka_kalei'], ' * ');
if (!$lei) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('卡类不存在!')));
}
$ok=Plug_Query("UPDATE `bs_php_kuka` SET `kuka_val`=`kuka_val`-'{$shu}' WHERE `kuka_id`='{$kuka['kuka_id']}'");
if (!$ok) {
Plug_Print_Json(array('code'=> 1, 'msg'=> ($dir==='reduce') ? Plug_Lang('收回失败!') : Plug_Lang('转出失败!')));
}
$addid="{$to_uid}_{$lei['lei_daihao']}_{$lei['lei_id']}";
$dst=Plug_Query_Array("SELECT * FROM `bs_php_kuka` WHERE `kuka_biaoji`='{$addid}'");
if (!$dst) {
Plug_Query("INSERT INTO `bs_php_kuka` (`kuka_uid`,`kuka_daihao`,`kuka_kalei`,`kuka_biaoji`,`kuka_val`,`kuka_user`) VALUES ('{$to_uid}','{$lei['lei_daihao']}','{$lei['lei_id']}','{$addid}','0','{$to_user}')");
$dst=Plug_Query_Array("SELECT * FROM `bs_php_kuka` WHERE `kuka_biaoji`='{$addid}'");
}
Plug_Query("UPDATE `bs_php_kuka` SET `kuka_val`=`kuka_val`+'{$shu}' WHERE `kuka_id`='{$dst['kuka_id']}'");
$app_name=Plug_GetAppInfoNameArray();
$app_txt=isset($app_name[$lei['lei_daihao']]) ? $app_name[$lei['lei_daihao']] : $lei['lei_daihao'];
$lei_txt=isset($lei['lei_name']) ? $lei['lei_name'] : '';
if ($dir==='reduce') {
Plug_Add_AppenLog('agent_ka_log', Plug_Lang('库卡收回成功') . ",{$app_txt}-{$lei_txt} " . Plug_Lang('代理账号') . ":{$sub['user_user']}," . Plug_Lang('数量') . ":+{$shu}", $this->user_array['user_user']);
Plug_Add_AppenLog('agent_ka_log', Plug_Lang('库卡上级收回') . ",{$app_txt}-{$lei_txt} " . Plug_Lang('上级账号转给数量') . ":-{$shu}", $sub['user_user']);
$msg=Plug_Lang('收回成功!');
} else {
Plug_Add_AppenLog('agent_ka_log', Plug_Lang('转出库卡成功') . ",{$app_txt}-{$lei_txt} " . Plug_Lang('代理账号') . ":{$sub['user_user']}," . Plug_Lang('数量') . ":-{$shu}", $this->user_array['user_user']);
Plug_Add_AppenLog('agent_ka_log', Plug_Lang('库卡入卡成功') . ",{$app_txt}-{$lei_txt} " . Plug_Lang('上级账号转给数量') . ":+{$shu}", $sub['user_user']);
$msg=Plug_Lang('转出成功!');
}
Plug_Print_Json(array('code'=> 100, 'msg'=> $msg));
}
private function find_sub_agent()
{
$uid=(int) Plug_Set_Post('uid');
if ($uid <=0) {
$uid=(int) Plug_Set_Get('uid');
}
$heuser=Plug_Set_Post('heuser');
if ($heuser==='') {
$heuser=Plug_Set_Get('heuser');
}
if ($heuser==='') {
$heuser=Plug_Set_Post('user');
}
if ($heuser==='') {
$heuser=Plug_Set_Post('users');
}
$row=null;
if ($uid > 0) {
$row=Plug_Query_One('bs_php_user', 'user_uid', $uid, ' * ');
} elseif ($heuser !=='') {
$row=Plug_Query_One('bs_php_user', 'user_user', $heuser, ' * ');
}
if (!$row) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('账号不存在')));
}
if ((int) $row['user_daili'] <=0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('他不是您下级代理')));
}
$yao=(string) $row['user_yao_User'];
$self_uid=(string) $this->user_array['user_uid'];
$self_user=(string) $this->user_array['user_user'];
if ($yao !==$self_uid && $yao !==$self_user) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('您没有权限') . ',' . Plug_Lang('他不是您下级代理')));
}
return $row;
}
}
