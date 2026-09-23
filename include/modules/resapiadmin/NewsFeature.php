<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class NewsFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_apps()
{
Plug_Admin_Assert_Qx('wz_1');
Plug_Admin_Ok('ok', array('list'=> Plug_Admin_Apps_Brief()));
}
function call_table_json()
{
Plug_Admin_Assert_Qx('wz_1');
$p=Plug_Admin_Pager();
$soso=Plug_Set_Get('soso');
$where="`news_table` LIKE '%{$soso}%'";
$cnt=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_news` WHERE {$where}");
$rs=Plug_Query("SELECT `news_id`,`news_table`,`news_class`,`news_unix`,`news_daihao` FROM `bs_php_news` WHERE {$where} ORDER BY `news_id` DESC LIMIT {$p['offset']},{$p['limit']}");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=array(
'key'=> (int) $v['news_id'],
'news_id'=> (int) $v['news_id'],
'news_table'=> $v['news_table'],
'news_class'=> $v['news_class'],
'news_unix'=> $v['news_unix'],
'news_daihao'=> $v['news_daihao'],
);
}
Plug_Admin_List_Json($list, (int) ($cnt['hangshu'] ?? 0));
}
function call_detail()
{
Plug_Admin_Assert_Qx('wz_1');
$id=(int) Plug_Set_Get('id');
$row=Plug_Query_Array("SELECT * FROM `bs_php_news` WHERE `news_id`='{$id}' LIMIT 1");
if (!$row) {
Plug_Admin_Fail(Plug_Lang('文章不存在'));
}
if (!empty($row['news_test'])) {
$dec=@base64_decode($row['news_test']);
if ($dec !==false) {
$row['news_test_raw']=$dec;
}
}
Plug_Admin_Ok('ok', $row);
}
function call_add()
{
Plug_Admin_Assert_Qx('wz_1');
$class=Plug_Set_Post('news_class');
$table=Plug_Set_Post('news_table');
$test=isset($_POST['news_test']) ? $_POST['news_test'] : '';
$daihao=Plug_Set_Post('news_daihao');
$b64=base64_encode($test);
$unix=����������������������������������������������������������������������������;
Plug_Query("INSERT INTO `bs_php_news` (`news_class`,`news_table`,`news_test`,`news_daihao`,`news_unix`) VALUES ('{$class}','{$table}','{$b64}','{$daihao}','{$unix}')");
Plug_Admin_Ok(Plug_Lang('添加成功'));
}
function call_modify()
{
Plug_Admin_Assert_Qx('wz_1');
$id=(int) Plug_Set_Get('id');
$class=Plug_Set_Post('news_class');
$table=Plug_Set_Post('news_table');
$test=isset($_POST['news_test']) ? $_POST['news_test'] : '';
$daihao=Plug_Set_Post('news_daihao');
$b64=base64_encode($test);
Plug_Query("UPDATE `bs_php_news` SET `news_class`='{$class}',`news_table`='{$table}',`news_test`='{$b64}',`news_daihao`='{$daihao}' WHERE `news_id`='{$id}' LIMIT 1");
Plug_Admin_Ok(Plug_Lang('保存成功'));
}
function call_delete()
{
Plug_Admin_Assert_Qx('wz_1');
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
if ($all==='') {
Plug_Admin_Fail(Plug_Lang('没有选择记录条目！'));
}
Plug_Query("DELETE FROM `bs_php_news` WHERE `news_id` IN ({$all})");
Plug_Admin_Ok(Plug_Lang('删除成功'));
}
}
