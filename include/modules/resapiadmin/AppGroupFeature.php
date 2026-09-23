<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class AppGroupFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_table_json()
{
Plug_Admin_Assert_Qx('app_1');
$daihao=(int) Plug_Set_Get('daihao');
$where=$daihao > 0 ? "`class_daihao`='{$daihao}'" : '1=1';
$rs=Plug_Query("SELECT * FROM `bs_php_userclass` WHERE {$where} ORDER BY `class_id` DESC");
$list=array();
$n=0;
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=array(
'key'=> (int) $v['class_id'],
'class_id'=> (int) $v['class_id'],
'class_name'=> $v['class_name'] ?? ($v['userclass_name'] ?? ''),
'calss_mark'=> $v['calss_mark'] ?? ($v['class_mark'] ?? ''),
'daihao'=> $v['class_daihao'] ?? '',
);
$n++;
}
Plug_Admin_List_Json($list, $n);
}
function call_add()
{
Plug_Admin_Assert_Qx('app_1');
$daihao=(int) Plug_Set_Get('daihao');
if ($daihao <=0) {
$daihao=(int) Plug_Set_Post('daihao');
}
if ($daihao <=0) {
Plug_Admin_Fail(Plug_Lang('缺少软件代号'));
}
$name=Plug_Set_Post('userclass_name');
if ($name==='') {
$name=Plug_Set_Post('class_name');
}
$mark=Plug_Set_Post('userclass_mark');
if ($mark==='') {
$mark=Plug_Set_Post('calss_mark');
}
if ($name==='') {
Plug_Admin_Fail(Plug_Lang('名称不能为空'));
}
$name=addslashes($name);
$mark=addslashes($mark);
Plug_Query("INSERT INTO `bs_php_userclass` (`class_name`,`calss_mark`,`class_daihao`) VALUES ('{$name}','{$mark}','{$daihao}')");
Plug_Admin_Ok(Plug_Lang('添加成功'), array('class_id'=> Plug_Query_Insert_Id()));
}
function call_modify()
{
Plug_Admin_Assert_Qx('app_1');
$id=(int) Plug_Set_Post('userclass_id');
if ($id <=0) {
$id=(int) Plug_Set_Get('id');
}
$name=Plug_Set_Post('userclass_name');
$mark=Plug_Set_Post('userclass_mark');
Plug_Query("UPDATE `bs_php_userclass` SET `class_name`='{$name}',`calss_mark`='{$mark}' WHERE `class_id`='{$id}' LIMIT 1");
Plug_Admin_Ok(Plug_Lang('保存成功'));
}
function call_delete()
{
Plug_Admin_Assert_Qx('app_1');
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
if ($all==='') {
Plug_Admin_Fail(Plug_Lang('没有选择记录条目！'));
}
Plug_Query("DELETE FROM `bs_php_userclass` WHERE `class_id` IN ({$all})");
Plug_Admin_Ok(Plug_Lang('删除成功'));
}
}
