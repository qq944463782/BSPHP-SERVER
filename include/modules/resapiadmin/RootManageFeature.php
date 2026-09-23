<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class RootManageFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_table_json()
{
Plug_Admin_Assert_Qx('root_1');
$p=Plug_Admin_Pager();
$soso=Plug_Set_Get('soso');
$DESC=((int) Plug_Set_Get('DESC')==1) ? 'ASC' : 'DESC';
$where="`Admin_AdminUserName` LIKE '%{$soso}%'";
$cnt=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_admin` WHERE {$where}");
$rs=Plug_Query("SELECT `Admin_ID`,`Admin_AdminUserName`,`Admin_IsLock`,`Admin_LoGinNum`,`Admin_LoGDaTe`,`Admin_LoGinIP`,`Admin_Permission` FROM `bs_php_admin` WHERE {$where} ORDER BY `Admin_ID` {$DESC} LIMIT {$p['offset']},{$p['limit']}");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$lip=trim((string) ($v['Admin_LoGinIP'] ?? ''));
$login_region=$lip !=='' ? Plug_Ip_Region($lip) : '';
$login_ip_show=$lip !=='' ? Plug_Ip_Region_Show($lip) : '';
$list[]=array(
'key'=> (int) $v['Admin_ID'],
'id'=> (int) $v['Admin_ID'],
'AdminUserName'=> $v['Admin_AdminUserName'],
'IsLock'=> (int) $v['Admin_IsLock'],
'LoGinNum'=> $v['Admin_LoGinNum'],
'LoGDaTe'=> $v['Admin_LoGDaTe'],
'LoGinIP'=> $lip,
'login_region'=> $login_region,
'login_ip_show'=> $login_ip_show,
'Permission'=> $v['Admin_Permission'],
);
}
Plug_Admin_List_Json($list, (int) ($cnt['hangshu'] ?? 0));
}
function call_batch()
{
Plug_Admin_Assert_Qx('root_1');
$select=(int) Plug_Set_Post('select_class');
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
$self=(int) $this->admin_array['Admin_ID'];
if ($all==='') {
Plug_Admin_Fail(Plug_Lang('没有选择记录条目！'));
}
$ids=array_filter(explode(',', $all), function ($x) use ($self) {
return (int) $x !==$self && (int) $x > 0;
});
if (!$ids) {
Plug_Admin_Fail(Plug_Lang('没有可操作账号'));
}
$in=implode(',', $ids);
if ($select==1) {
Plug_Query("DELETE FROM `bs_php_admin` WHERE `Admin_ID` IN ({$in})");
Plug_Admin_Ok(Plug_Lang('删除成功'));
}
if ($select==2) {
Plug_Query("UPDATE `bs_php_admin` SET `Admin_IsLock`='0' WHERE `Admin_ID` IN ({$in})");
Plug_Admin_Ok(Plug_Lang('已解冻'));
}
if ($select==3) {
Plug_Query("UPDATE `bs_php_admin` SET `Admin_IsLock`='1' WHERE `Admin_ID` IN ({$in})");
Plug_Admin_Ok(Plug_Lang('已冻结'));
}
Plug_Admin_Fail(Plug_Lang('你没有选择操作项目'));
}
function call_add()
{
Plug_Admin_Assert_Qx('root_2');
$user=Plug_Set_Post('user');
$pass=Plug_Set_Post('pass');
$mibao=Plug_Set_Post('pass_key');
if ($user==='' || $pass==='') {
Plug_Admin_Fail(Plug_Lang('账号或密码不能为空'));
}
$exists=Plug_Query_Array("SELECT `Admin_ID` FROM `bs_php_admin` WHERE `Admin_AdminUserName`='{$user}' LIMIT 1");
if ($exists) {
Plug_Admin_Fail(Plug_Lang('账号已存在'));
}
$pwd=��������������������������������������������������������������������������������($pass);
$perm=json_encode(array('appenconfig'=> 1));
$date=����������������������������������������������������������������_GET;
Plug_Query("INSERT INTO `bs_php_admin` (`Admin_AdminUserName`,`Admin_AdminPassWord`,`Admin_MiBao`,`Admin_IsLock`,`Admin_LoGinNum`,`Admin_LoGDaTe`,`Admin_LoGinIP`,`Admin_Permission`) VALUES ('{$user}','{$pwd}','{$mibao}','0','0','{$date}','','{$perm}')");
Plug_Admin_Ok(Plug_Lang('添加成功'));
}
function call_usb()
{
Plug_Admin_Assert_Qx('root_1');
$id=(int) Plug_Set_Get('id');
$user=Plug_Set_Post('user');
$pass=Plug_Set_Post('pass');
$mibao=Plug_Set_Post('pass_key');
$sets=array();
if ($user !=='') {
$sets[]="`Admin_AdminUserName`='{$user}'";
}
if ($pass !=='') {
$pwd=��������������������������������������������������������������������������������($pass);
$sets[]="`Admin_AdminPassWord`='{$pwd}'";
}
if ($mibao !=='') {
$sets[]="`Admin_MiBao`='{$mibao}'";
}
if (!$sets) {
Plug_Admin_Fail(Plug_Lang('没有修改内容'));
}
Plug_Query('UPDATE `bs_php_admin` SET ' . implode(',', $sets) . " WHERE `Admin_ID`='{$id}' LIMIT 1");
Plug_Admin_Ok(Plug_Lang('保存成功'));
}
function call_qx_get()
{
Plug_Admin_Assert_Qx('root_1');
$id=(int) Plug_Set_Get('id');
$row=Plug_Query_Array("SELECT `Admin_ID`,`Admin_AdminUserName`,`Admin_Permission` FROM `bs_php_admin` WHERE `Admin_ID`='{$id}' LIMIT 1");
if (!$row) {
Plug_Admin_Fail(Plug_Lang('管理员不存在'));
}
$qx=json_decode($row['Admin_Permission'], true);
if (!is_array($qx)) {
$qx=array();
}
Plug_Admin_Ok('ok', array(
'id'=> (int) $row['Admin_ID'],
'user'=> $row['Admin_AdminUserName'],
'qx'=> $qx,
));
}
function call_qx_save()
{
Plug_Admin_Assert_Qx('root_1');
$id=(int) Plug_Set_Get('id');
$post=$_POST;
unset($post['appenconfig']);
$json=json_encode($post, JSON_UNESCAPED_UNICODE);
$json_sql=addslashes($json);
Plug_Query("UPDATE `bs_php_admin` SET `Admin_Permission`='{$json_sql}' WHERE `Admin_ID`='{$id}' LIMIT 1");
Plug_Admin_Ok(Plug_Lang('权限已保存'));
}
}
