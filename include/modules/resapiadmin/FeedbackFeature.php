<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class FeedbackFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_table_json()
{
Plug_Admin_Assert_Qx('back');
$p=Plug_Admin_Pager();
$soso=Plug_Set_Get('soso');
$col=Plug_Set_Get('soso_id');
$allow=array('id', 'add_uid', 'add_daihao', 'add_table', 'add_leix', 'add_qq', 'add_txt', 'add_date');
if (!in_array($col, $allow, true)) {
$col='add_txt';
}
$DESC=((int) Plug_Set_Get('DESC')==1) ? 'ASC' : 'DESC';
$where="`{$col}` LIKE '%{$soso}%'";
$cnt=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_add` WHERE {$where}");
$rs=Plug_Query("SELECT * FROM `bs_php_add` WHERE {$where} ORDER BY `id` {$DESC} LIMIT {$p['offset']},{$p['limit']}");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=array(
'key'=> (int) $v['id'],
'id'=> (int) $v['id'],
'add_uid'=> $v['add_uid'],
'add_daihao'=> $v['add_daihao'],
'add_date'=> $v['add_date'],
'add_table'=> $v['add_table'],
'add_leix'=> $v['add_leix'],
'add_qq'=> $v['add_qq'],
'add_txt'=> $v['add_txt'],
);
}
Plug_Admin_List_Json($list, (int) ($cnt['hangshu'] ?? 0));
}
function call_delete()
{
Plug_Admin_Assert_Qx('back');
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
if ($all==='') {
Plug_Admin_Fail(Plug_Lang('没有选择记录条目！'));
}
Plug_Query("DELETE FROM `bs_php_add` WHERE `id` IN ({$all})");
Plug_Admin_Ok(Plug_Lang('删除成功'));
}
}
