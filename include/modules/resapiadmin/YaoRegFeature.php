<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class YaoRegFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_table_json()
{
Plug_Admin_Assert_Qx('cz_3');
$p=Plug_Admin_Pager();
$soso=Plug_Set_Get('soso');
$soso_id=(int) Plug_Set_Get('soso_id');
$map=array(1=> 'log_user', 2=> 'log_beinvited', 3=> 'log_desc');
$col=isset($map[$soso_id]) ? $map[$soso_id] : 'log_user';
$where="`{$col}` LIKE '%{$soso}%'";
$cnt=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_yao_registration_log` WHERE {$where}");
$rs=Plug_Query("SELECT * FROM `bs_php_yao_registration_log` WHERE {$where} ORDER BY `id` DESC LIMIT {$p['offset']},{$p['limit']}");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=$v;
}
Plug_Admin_List_Json($list, (int) ($cnt['hangshu'] ?? 0));
}
}
