<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='AGENT') {
die('Not,This File Not Can in Ie Modules');
}
class MenuFeature
{
public $user_array;
public $Grade;
function __construct()
{
$this->user_array=Plug_Agent_Assert_Api_Login();
$this->Grade=Plug_Agent_Detect_Grade($this->user_array);
}
private function api_map()
{
return array(
'console'=> 'm=resapiagent&c=DashboardFeature&a=info',
'dashboard'=> 'm=resapiagent&c=DashboardFeature&a=info',
'my_users_table'=> 'm=agent&c=MyUsersTableFeature&a=table_json',
'software_users_table'=> 'm=agent&c=SoftwareUsersTableFeature&a=table_json',
'card_manage'=> 'm=agent&c=CardManageFeature&a=table_json',
'make_card_balance'=> 'm=resapiagent&c=MakeCardFeature&a=make',
'make_card_stock'=> 'm=resapiagent&c=StockCardFeature&a=make',
'my_agent_list'=> 'm=agent&c=MyAgentListFeature&a=table_json',
'add_agent'=> 'm=resapiagent&c=AgentAddFeature&a=add',
'invite_users'=> 'm=resapiagent&c=InviteFeature&a=links',
'commission_logs'=> 'm=agent&c=CommissionLogsFeature&a=table_json',
'balance_recharge'=> 'm=resapiagent&c=PayMethodsFeature&a=list',
'batch_query'=> 'm=resapiagent&c=BatchCardFeature&a=query',
'batch_freeze'=> 'm=resapiagent&c=BatchCardFeature&a=freeze',
'batch_unfreeze'=> 'm=resapiagent&c=BatchCardFeature&a=unfreeze',
'batch_delete'=> 'm=resapiagent&c=BatchCardFeature&a=delete',
'unbind_user'=> 'm=resapiagent&c=UnbindFeature&a=run',
'user_card_renew_recharge'=> 'm=resapiagent&c=RenewFeature&a=run',
'card_account_stats'=> 'm=resapiagent&c=CardStatsFeature&a=by_type',
'card_note_usage_stats'=> 'm=resapiagent&c=CardStatsFeature&a=by_note',
'card_account_note_stats'=> 'm=resapiagent&c=CardStatsFeature&a=by_admin_note',
'card_account_manage'=> 'm=agent&c=CardAccountManageFeature&a=table_json',
);
}
private function scan_agent_menu_files()
{
$files=array();
$menu_dir=����������������������������������������4�������������������� . 'Plug/Agent_list';
if (!is_dir($menu_dir)) {
return $files;
}
$names=@scandir($menu_dir);
if (!is_array($names)) {
return $files;
}
foreach ($names as $fn) {
if (strpos($fn, 'agent_') !==0 || substr($fn, -4) !=='.php') {
continue;
}
$path=$menu_dir . '/' . $fn;
if (is_file($path)) {
$files[]=$path;
}
}
sort($files);
return $files;
}
private function decorate_leaf($id, $name, $api_map, $deny)
{
$api=isset($api_map[$id]) ? $api_map[$id] : '';
return array(
'id'=> $id,
'name'=> $name,
'api'=> $api,
'url'=> $api !=='' ? ('index.php?' . $api) : '',
'allowed'=> empty($deny) || !isset($deny[$id]),
);
}
function call_list()
{
$deny=Plug_Agent_Menu_Deny_Map((int) $this->Grade);
$api_map=$this->api_map();
$tree=array();
$flat=array();
foreach ($this->scan_agent_menu_files() as $path) {
$text=@file_get_contents($path);
if ($text===false) {
continue;
}
$trimmed=ltrim($text);
if ($trimmed==='' || ($trimmed[0] !=='{' && $trimmed[0] !=='[')) {
continue;
}
$json=json_decode($trimmed, true);
if (!is_array($json) || !isset($json['agentMenu']) || !is_array($json['agentMenu'])) {
continue;
}
foreach ($json['agentMenu'] as $menu_item) {
if (!is_array($menu_item) || empty($menu_item['id'])) {
continue;
}
$item_id=trim((string) $menu_item['id']);
if ($item_id !=='' && isset($deny[$item_id])) {
continue;
}
$item_name=isset($menu_item['name']) ? (string) $menu_item['name'] : $item_id;
$children_raw=(isset($menu_item['children']) && is_array($menu_item['children']))
? $menu_item['children']
: array();
$children=array();
foreach ($children_raw as $child) {
if (!is_array($child) || empty($child['id'])) {
continue;
}
$cid=trim((string) $child['id']);
if ($cid !=='' && isset($deny[$cid])) {
continue;
}
$cname=isset($child['name']) ? (string) $child['name'] : $cid;
$leaf=$this->decorate_leaf($cid, $cname, $api_map, $deny);
$children[]=$leaf;
$flat[]=$leaf;
}
$has_children=!empty($children_raw);
if ($has_children) {
if (empty($children)) {
continue;
}
$tree[]=array(
'id'=> $item_id,
'name'=> $item_name,
'title'=> $item_name,
'allowed'=> true,
'children'=> $children,
);
continue;
}
$leaf=$this->decorate_leaf($item_id, $item_name, $api_map, $deny);
if (!$leaf['allowed']) {
continue;
}
$tree[]=array(
'id'=> $item_id,
'name'=> $item_name,
'title'=> $item_name,
'allowed'=> true,
'children'=> array($leaf),
);
$flat[]=$leaf;
}
}
Plug_Print_Json(array(
'code'=> 100,
'msg'=> Plug_Lang('ok'),
'data'=> array(
'grade'=> (int) $this->Grade,
'tree'=> $tree,
'menus'=> $flat,
'auth'=> array(
'login'=> 'm=resapiagent&c=auth&a=login',
'check'=> 'm=resapiagent&c=auth&a=check',
'logout'=> 'm=resapiagent&c=auth&a=logout',
'profile'=> 'm=resapiagent&c=MeFeature&a=profile',
),
),
));
}
}
