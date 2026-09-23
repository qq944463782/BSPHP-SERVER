<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class KukaManageFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_apps()
{
Plug_Admin_Assert_Qx('app_1');
Plug_Admin_Ok('ok', array('list'=> Plug_Admin_Apps_Brief()));
}
function call_table_json()
{
Plug_Admin_Assert_Qx('app_1');
$p=Plug_Admin_Pager();
$daihao=(int) Plug_Set_Get('daihao');
$soso=Plug_Set_Get('soso');
$soso_id=(int) Plug_Set_Get('soso_id');
$DESC=((int) Plug_Set_Get('DESC')==1) ? 'ASC' : 'DESC';
$chk=Plug_Query_Array("SHOW TABLES LIKE 'bs_php_kuka'");
if (!$chk) {
Plug_Admin_List_Json(array(), 0);
}
$col='kuka_user';
if ($soso_id==2) {
$col='kuka_uid';
} elseif ($soso_id==3) {
$col='kuka_kalei';
} elseif ($soso_id==4) {
$col='kuka_user';
}
$where='1=1';
if ($daihao > 0) {
$where .=" AND `kuka_daihao`='{$daihao}'";
}
if ($soso !=='') {
$where .=" AND `{$col}` LIKE '%{$soso}%'";
}
$cnt=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_kuka` WHERE {$where}");
$rs=Plug_Query("SELECT * FROM `bs_php_kuka` WHERE {$where} ORDER BY `kuka_id` {$DESC} LIMIT {$p['offset']},{$p['limit']}");
$lei_map=array();
if ($daihao > 0) {
$lrs=Plug_Query("SELECT `lei_id`,`lei_name` FROM `bs_php_kalei` WHERE `lei_daihao`='{$daihao}'");
while ($l=Plug_Pdo_Fetch_Assoc($lrs)) {
$lei_map[$l['lei_id']]=$l['lei_name'];
}
}
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$v['kalei_name']=isset($lei_map[$v['kuka_kalei']]) ? $lei_map[$v['kuka_kalei']] : '';
$list[]=$v;
}
Plug_Admin_List_Json($list, (int) ($cnt['hangshu'] ?? 0));
}
function call_make()
{
Plug_Admin_Assert_Qx('app_1');
$daihao=(int) Plug_Set_Get('daihao');
if ($daihao <=0) {
$daihao=(int) Plug_Set_Post('daihao');
}
$select=(int) Plug_Set_Post('select');
$shulian=(int) Plug_Set_Post('shulian');
$agnet_id=Plug_Set_Post('agnet_id');
if ($agnet_id==='') {
Plug_Admin_Fail(Plug_Lang('请输入代理商账号!'));
}
if ($select <=0) {
Plug_Admin_Fail(Plug_Lang('请选择分配类型!'));
}
$agent=Plug_Query_Array("SELECT * FROM `bs_php_user` WHERE `user_user`='{$agnet_id}' LIMIT 1");
if (!$agent) {
Plug_Admin_Fail(Plug_Lang('请输入代理商') . "【{$agnet_id}】" . Plug_Lang('账号不存在!'));
}
$biaoji=$agent['user_uid'] . '_' . $daihao . '_' . $select;
$row=Plug_Query_Array("SELECT * FROM `bs_php_kuka` WHERE `kuka_biaoji`='{$biaoji}' LIMIT 1");
if (!$row) {
Plug_Query("INSERT INTO `bs_php_kuka` (`kuka_uid`,`kuka_daihao`,`kuka_kalei`,`kuka_biaoji`,`kuka_val`,`kuka_user`) VALUES ('{$agent['user_uid']}','{$daihao}','{$select}','{$biaoji}','0','{$agnet_id}')");
$row=Plug_Query_Array("SELECT * FROM `bs_php_kuka` WHERE `kuka_biaoji`='{$biaoji}' LIMIT 1");
}
$before=isset($row['kuka_val']) ? $row['kuka_val'] : 0;
Plug_Query("UPDATE `bs_php_kuka` SET `kuka_val`=`kuka_val`+'{$shulian}' WHERE `kuka_biaoji`='{$biaoji}'");
Plug_Add_AppenLog('agent_ka_log', "后台库卡分配成功,分配卡给账号:{$agnet_id},{$shulian} 张,分配前数量:{$before}", $this->admin_array['Admin_AdminUserName']);
Plug_Admin_Ok(Plug_Lang('分配成功') . "[{$shulian}]" . Plug_Lang('数量,详细请到库卡列表查询!'));
}
function call_batch()
{
Plug_Admin_Assert_Qx('app_1');
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
$select=(int) Plug_Set_Post('select_class');
if ($all==='') {
Plug_Admin_Fail(Plug_Lang('没有选择记录条目！'));
}
if ($select==1) {
Plug_Query("DELETE FROM `bs_php_kuka` WHERE `kuka_id` IN ({$all})");
Plug_Admin_Ok(Plug_Lang('删除成功'));
}
if ($select==4) {
Plug_Query("UPDATE `bs_php_kuka` SET `kuka_val`='0' WHERE `kuka_id` IN ({$all})");
Plug_Admin_Ok(Plug_Lang('已清零'));
}
Plug_Admin_Fail(Plug_Lang('你没有选择操作项目'));
}
}
