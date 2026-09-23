<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class OnlineManageFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_table_json()
{
Plug_Admin_Assert_Qx('link');
$p=Plug_Admin_Pager();
$soso=Plug_Set_Get('soso');
$soso_id=(int) Plug_Set_Get('soso_id');
$DESC=((int) Plug_Set_Get('DESC')==1) ? 'ASC' : 'DESC';
$fields=array(
1=> 'links_user_name',
2=> 'links_key',
3=> 'links_biaoji',
4=> 'links_addip',
5=> 'links_daihao',
6=> 'links_session_id',
);
$col=isset($fields[$soso_id]) ? $fields[$soso_id] : 'links_user_name';
$where="1=1";
if ($soso_id !=6) {
$where .=" AND `links_user_name`<>''";
}
$where .=" AND `{$col}` LIKE '%{$soso}%'";
$cnt=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_links_session` WHERE {$where}");
$rs=Plug_Query("SELECT * FROM `bs_php_links_session` WHERE {$where} ORDER BY `links_id` {$DESC} LIMIT {$p['offset']},{$p['limit']}");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$lip=trim((string) ($v['links_addip'] ?? ''));
$login_region=$lip !=='' ? Plug_Ip_Region($lip) : '';
$login_ip_show=$lip !=='' ? Plug_Ip_Region_Show($lip) : '';
$list[]=array(
'key'=> (int) $v['links_id'],
'links_id'=> (int) $v['links_id'],
'links_user_name'=> $v['links_user_name'],
'links_set'=> $v['links_set'],
'links_bs_set'=> $v['links_bs_set'],
'links_key'=> $v['links_key'],
'links_biaoji'=> $v['links_biaoji'],
'links_session_id'=> $v['links_session_id'],
'links_addip'=> $lip,
'login_region'=> $login_region,
'login_ip_show'=> $login_ip_show,
'links_add_time'=> $v['links_add_time'],
'links_chaoshi'=> $v['links_chaoshi'],
'links_out_time'=> $v['links_out_time'],
'links_daihao'=> $v['links_daihao'],
);
}
Plug_Admin_List_Json($list, (int) ($cnt['hangshu'] ?? 0));
}
function call_kick()
{
Plug_Admin_Assert_Qx('link');
$id=(int) Plug_Set_Post('id');
if ($id <=0) {
$id=(int) Plug_Set_Get('id');
}
$session=����������������������������������������������������������������::��������2������������������������������������������������������������������������for（('session', 'session');
if (method_exists($session, 'links_delete_mysql_id')) {
$session->links_delete_mysql_id($id);
} else {
Plug_Query("DELETE FROM `bs_php_links_session` WHERE `links_id`='{$id}'");
}
Plug_Admin_Ok(Plug_Lang('已踢出'));
}
function call_batch()
{
Plug_Admin_Assert_Qx('link');
$select=(int) Plug_Set_Post('select_class');
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
if ($select==1) {
if ($all==='') {
Plug_Admin_Fail(Plug_Lang('没有选择记录条目！'));
}
Plug_Query("UPDATE `bs_php_links_session` SET `links_set`='-1' WHERE `links_bs_set`='APPEN' AND `links_id` IN ({$all})");
Plug_Admin_Ok(Plug_Lang('操作成功'));
}
if ($select==2) {
if ($all==='') {
Plug_Admin_Fail(Plug_Lang('没有选择记录条目！'));
}
Plug_Query("DELETE FROM `bs_php_links_session` WHERE `links_id` IN ({$all})");
Plug_Admin_Ok(Plug_Lang('删除成功'));
}
if ($select==4) {
$now=����������������������������������������������������������������������������;
Plug_Query("DELETE FROM `bs_php_links_session` WHERE `links_set`='-1' OR `links_out_time`<'{$now}'");
Plug_Admin_Ok(Plug_Lang('清理完成'));
}
Plug_Admin_Fail(Plug_Lang('你没有选择操作项目'));
}
}
