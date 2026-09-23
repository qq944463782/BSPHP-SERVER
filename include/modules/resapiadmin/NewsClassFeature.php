<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class NewsClassFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_table_json()
{
Plug_Admin_Assert_Qx('wz_1');
$rs=Plug_Query("SELECT * FROM `bs_php_news_class` ORDER BY `class_id` DESC");
$list=array();
$n=0;
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=array(
'key'=> (int) $v['class_id'],
'class_id'=> (int) $v['class_id'],
'class_name'=> $v['class_name'],
);
$n++;
}
Plug_Admin_List_Json($list, $n);
}
function call_add()
{
Plug_Admin_Assert_Qx('wz_1');
$name=Plug_Set_Post('name');
if ($name==='') {
Plug_Admin_Fail(Plug_Lang('名称不能为空'));
}
Plug_Query("INSERT INTO `bs_php_news_class` (`class_name`) VALUES ('{$name}')");
Plug_Admin_Ok(Plug_Lang('添加成功'));
}
function call_modify()
{
Plug_Admin_Assert_Qx('wz_1');
$id=(int) Plug_Set_Post('class_id');
$name=Plug_Set_Post('name');
Plug_Query("UPDATE `bs_php_news_class` SET `class_name`='{$name}' WHERE `class_id`='{$id}' LIMIT 1");
Plug_Admin_Ok(Plug_Lang('保存成功'));
}
function call_delete()
{
Plug_Admin_Assert_Qx('wz_1');
$id=(int) Plug_Set_Post('id');
if ($id <=0) {
$id=(int) Plug_Set_Get('id');
}
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
if ($all !=='') {
Plug_Query("DELETE FROM `bs_php_news_class` WHERE `class_id` IN ({$all})");
} elseif ($id > 0) {
Plug_Query("DELETE FROM `bs_php_news_class` WHERE `class_id`='{$id}'");
} else {
Plug_Admin_Fail(Plug_Lang('参数错误'));
}
Plug_Admin_Ok(Plug_Lang('删除成功'));
}
}
