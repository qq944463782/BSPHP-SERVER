<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class LogManageFeature
{
public $admin_array;
private $type_qx=array(
'admin_login_log'=> 'log_1',
'user_login_log'=> 'log_2',
'yao_registration_log'=> 'log_3',
'yao_money_log'=> 'log_4',
'od_po_log'=> 'log_5',
'money_buy_log'=> 'log_6',
'exit_log'=> 'log_7',
'agent_ka_log'=> 'log_8',
'email_log'=> 'log_9',
'sms_log'=> 'log_10',
);
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_table_json()
{
$t=Plug_Set_Get('t');
if ($t=='' || !isset($this->type_qx[$t])) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('日志类型错误'), 'count'=> 0, 'data'=> array()));
}
Plug_Admin_Assert_Qx($this->type_qx[$t]);
$FANYE=(int) Plug_Set_Get('page');
$db_ID=$FANYE > 0 ? $FANYE - 1 : 0;
$shu=(int) Plug_Set_Get('limit');
if ($shu <=0) {
$shu=10;
}
if ($shu > 200) {
$shu=200;
}
$db_ID=$db_ID * $shu;
$soso=Plug_Set_Get('soso');
$soso_id=(int) Plug_Set_Get('soso_id');
$DESC_id=(int) Plug_Set_Get('DESC');
$DESC=$DESC_id==1 ? 'ASC' : 'DESC';
if ($soso_id==2) {
$soso_db_table='ip';
} elseif ($soso_id==3) {
$soso_db_table='test';
} else {
$soso_db_table='user';
}
$where="`leixing`='{$t}' AND `{$soso_db_table}` LIKE '%{$soso}%'";
$sql_rows="SELECT count(*) AS hangshu FROM `bs_php_log` WHERE {$where}";
$sql="SELECT * FROM `bs_php_log` WHERE {$where} ORDER BY `id` {$DESC} LIMIT {$db_ID},{$shu}";
$rows_arr=Plug_Query_Array($sql_rows);
$zongshu=(int) ($rows_arr['hangshu'] ?? 0);
$rs=Plug_Query($sql);
$list=array();
while ($value=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=array(
'key'=> (int) $value['id'],
'id'=> (int) $value['id'],
'user'=> $value['user'],
'date'=> date('Y-m-d H:i', (int) $value['date']),
'date_unix'=> (int) $value['date'],
'ip'=> $value['ip'],
'test'=> $value['test'],
'leixing'=> $value['leixing'],
);
}
Plug_Print_Json(array(
'code'=> 0,
'msg'=> '',
'count'=> $zongshu,
'data'=> $list,
));
}
function call_types()
{
Plug_Admin_Assert_Qx('');
$names=array(
'admin_login_log'=> Plug_Lang('管理登录日志'),
'user_login_log'=> Plug_Lang('用户登录日志'),
'yao_registration_log'=> Plug_Lang('邀请日志'),
'yao_money_log'=> Plug_Lang('佣金提成'),
'od_po_log'=> Plug_Lang('反破解日志'),
'money_buy_log'=> Plug_Lang('接口余额扣除日志'),
'exit_log'=> Plug_Lang('系统安全防护日志'),
'agent_ka_log'=> Plug_Lang('系统制卡日志'),
'email_log'=> Plug_Lang('发邮件日志'),
'sms_log'=> Plug_Lang('发短信日志'),
);
$data=array();
foreach ($this->type_qx as $k=> $qx) {
$data[]=array(
't'=> $k,
'name'=> isset($names[$k]) ? $names[$k] : $k,
'qx'=> $qx,
);
}
Plug_Print_Json(array('code'=> 100, 'msg'=> Plug_Lang('ok'), 'data'=> $data));
}
function call_batch()
{
$t=Plug_Set_Get('t');
if ($t=='' || !isset($this->type_qx[$t])) {
Plug_Admin_Fail(Plug_Lang('日志类型错误'));
}
Plug_Admin_Assert_Qx($this->type_qx[$t]);
$select=(int) Plug_Set_Post('select_class');
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
if ($select==1) {
$date=���������������������������������������������������������������������������� - 181200;
Plug_Query("DELETE FROM `bs_php_log` WHERE `date`<'{$date}' AND `leixing`='{$t}'");
Plug_Admin_Ok(Plug_Lang('清理50天前信息执行成功'));
}
if ($select==2) {
if ($all==='') {
Plug_Admin_Fail(Plug_Lang('没有选择记录条目！'));
}
Plug_Query("DELETE FROM `bs_php_log` WHERE `id` IN ({$all}) AND `leixing`='{$t}'");
Plug_Admin_Ok(Plug_Lang('选择的记录已经删除!'));
}
if ($select==3) {
$date=���������������������������������������������������������������������������� - 604800;
Plug_Query("DELETE FROM `bs_php_log` WHERE `date`<'{$date}' AND `leixing`='{$t}'");
Plug_Admin_Ok(Plug_Lang('清理7天前信息执行成功'));
}
if ($select==4) {
Plug_Query("DELETE FROM `bs_php_log` WHERE `leixing`='{$t}'");
Plug_Admin_Ok(Plug_Lang('清理全部信息执行成功'));
}
Plug_Admin_Fail(Plug_Lang('你没有选择操作项目'));
}
}
