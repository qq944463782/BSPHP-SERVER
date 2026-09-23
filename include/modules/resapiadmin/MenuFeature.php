<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class MenuFeature
{
public $admin_array;
public $qx;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
$qx=json_decode($this->admin_array['Admin_Permission'], true);
$this->qx=is_array($qx) ? $qx : array();
}
private function allowed($key)
{
$key=(string) $key;
if ($key==='') {
return true;
}
if (!isset($this->qx[$key])) {
return true;
}
return (int) $this->qx[$key]===0;
}
private function item($id, $title, $qx_key, $path='', $query=array(), $children=null, $list_mobile=null)
{
if (!$this->allowed($qx_key)) {
return null;
}
$has_path=$path !=='';
$mobile=$list_mobile !==null ? (bool) $list_mobile : $has_path;
$node=array(
'id'=> $id,
'title'=> Plug_Lang($title),
'qx'=> $qx_key,
'path'=> $has_path ? $path : null,
'query'=> $query ? $query : null,
'mobile'=> $mobile,
'web_only'=> !$has_path,
);
if (is_array($children)) {
$kids=array();
foreach ($children as $c) {
if ($c) {
$kids[]=$c;
}
}
if (!$kids) {
return null;
}
$node['children']=$kids;
$node['path']=null;
$node['mobile']=true;
$node['web_only']=false;
}
return $node;
}
private function scan_admin_plugs()
{
$dir=����������������������������������������4�������������������� . 'Plug/Admin_List';
$items=array();
if (!is_dir($dir)) {
return $items;
}
$files=scandir($dir);
if (!$files) {
return $items;
}
$idx=0;
foreach ($files as $name) {
if ($name==='.' || $name==='..') {
continue;
}
if (strpos($name, 'class_')===false) {
continue;
}
$html=@file_get_contents($dir . '/' . $name);
if ($html===false || $html==='') {
continue;
}
$html=str_replace('@id@', (string) (++$idx), $html);
if (preg_match_all('/<a\b([^>]*)>(.*?)<\/a>/is', $html, $m, PREG_SET_ORDER)) {
foreach ($m as $i=> $one) {
$attrs=$one[1];
$title=trim(html_entity_decode(strip_tags($one[2]), ENT_QUOTES, 'UTF-8'));
if ($title==='') {
continue;
}
$href='';
if (preg_match('/\blay-href\s*=\s*["\']([^"\']+)["\']/i', $attrs, $hm)) {
$href=trim($hm[1]);
} elseif (preg_match('/\bhref\s*=\s*["\']([^"\']+)["\']/i', $attrs, $hm)) {
$href=trim($hm[1]);
}
$id='plug_' . preg_replace('/[^a-zA-Z0-9_]+/', '_', pathinfo($name, PATHINFO_FILENAME));
if ($i > 0) {
$id .='_' . ($i + 1);
}
$mapped=$this->map_plug_route($href);
$path=$mapped['path'];
$query=$mapped['query'];
$node=$this->item($id, $title, 'top_9', $path, $query, null, true);
if ($node) {
if ($href !=='' && $path==='') {
$node['web_url']=$href;
}
$items[]=$node;
}
}
}
}
return $items;
}
private function map_plug_route($href)
{
$href=trim((string) $href);
$empty=array('path'=> '', 'query'=> array());
if ($href==='') {
return $empty;
}
if (preg_match('#^(https?:)?//#i', $href)) {
return $empty;
}
$q=array();
$qs='';
if (strpos($href, '?') !==false) {
$qs=substr($href, strpos($href, '?') + 1);
parse_str($qs, $q);
}
$m=isset($q['m']) ? strtolower((string) $q['m']) : '';
$c=isset($q['c']) ? strtolower((string) $q['c']) : '';
$a=isset($q['a']) ? strtolower((string) $q['a']) : '';
if ($m==='dbug' && $c==='log') {
return array('path'=> '/pages/api-dbug/api-dbug', 'query'=> array());
}
if ($m==='applib' && $c==='admin_addloginuser') {
$modes=array('add', 'carsoso', 'caroff', 'caron', 'cardel');
if (in_array($a, $modes, true)) {
return array(
'path'=> '/pages/plug-tools/plug-tools',
'query'=> array('mode'=> $a),
);
}
}
return $empty;
}
private function group($id, $title, $qx_key, $children)
{
if ($qx_key !=='' && !$this->allowed($qx_key)) {
return null;
}
$kids=array();
foreach ($children as $c) {
if ($c) {
$kids[]=$c;
}
}
if (!$kids) {
return null;
}
return array(
'id'=> $id,
'title'=> Plug_Lang($title),
'qx'=> $qx_key,
'children'=> $kids,
);
}
function call_qx()
{
Plug_Print_Json(array(
'code'=> 100,
'msg'=> Plug_Lang('ok'),
'data'=> array(
'uid'=> (int) $this->admin_array['Admin_ID'],
'user'=> $this->admin_array['Admin_AdminUserName'],
'qx'=> $this->qx,
'rule'=> 'missing_or_0=allow; non_0=deny',
),
));
}
function call_tree()
{
$mobile_only=(string) Plug_Set_Get('mobile_only')==='1';
$tree=array();
$console_children=array(
$this->item('home', '主页', '', '/pages/home/home'),
$this->item('online', '在线用户管理', 'link', '/pages/online/online'),
$this->item('feedback', '用户反馈', 'back', '/pages/feedback/feedback'),
);
$log_children=array(
$this->item('log_admin', '管理登录日志', 'log_1', '/pages/logs/logs', array('t'=> 'admin_login_log')),
$this->item('log_user', '用户登录日志', 'log_2', '/pages/logs/logs', array('t'=> 'user_login_log')),
$this->item('log_email', '发邮件日志', 'log_9', '/pages/logs/logs', array('t'=> 'email_log')),
$this->item('log_sms', '发短信日志', 'log_10', '/pages/logs/logs', array('t'=> 'sms_log')),
$this->item('log_ka', '系统制卡日志', 'log_8', '/pages/logs/logs', array('t'=> 'agent_ka_log')),
$this->item('log_od', '反破解日志', 'log_5', '/pages/logs/logs', array('t'=> 'od_po_log')),
$this->item('log_money', '接口余额扣除日志', 'log_6', '/pages/logs/logs', array('t'=> 'money_buy_log')),
$this->item('log_exit', '系统安全防护日志', 'log_7', '/pages/logs/logs', array('t'=> 'exit_log')),
);
if ($this->allowed('log_all')) {
$log_group=$this->item('logs', '系统日志', 'log_all', '', array(), $log_children);
if ($log_group) {
$console_children[]=$log_group;
}
}
$root_children=array(
$this->item('root_list', '管理员列表', 'root_1', '/pages/root/root'),
$this->item('root_add', '添加新管理员', 'root_2', '/pages/root/root', array('add'=> '1')),
);
if ($this->allowed('root')) {
$root_group=$this->item('root', '后台管理员', 'root', '', array(), $root_children);
if ($root_group) {
$console_children[]=$root_group;
}
}
$g=$this->group('console', '控制台', '', $console_children);
if ($g) {
$tree[]=$g;
}
$g=$this->group('apps', '应用APP管理', 'top_4', array(
$this->item('app_list', '软件管理', 'app_1', '/pages/apps/apps'),
$this->item('app_add', '添加新软件', 'app_2', '/pages/app-add/app-add'),
$this->item('card_weihu', '充值卡批量维护', 'app_3', '/pages/weihu/weihu', array('mode'=> 'card')),
$this->item('user_weihu_app', '软件用户批量维护', 'app_4', '/pages/weihu/weihu', array('mode'=> 'appuser')),
$this->item('kuka', '库卡分配', 'app_1', '/pages/kuka-make/kuka-make'),
));
if ($g) {
$tree[]=$g;
}
$g=$this->group('accounts', '账号管理', 'top_3', array(
$this->item('user_list', '用户账号管理', 'zh_1', '/pages/users/users', array('mode'=> '0')),
$this->item('agent_list', '代理账号管理', 'zh_2', '/pages/users/users', array('mode'=> '1')),
$this->item('user_add', '添加账号', 'zh_3', '/pages/users/users', array('add'=> '1')),
$this->item('user_weihu', '批量维护', 'zh_4', '/pages/weihu/weihu', array('mode'=> 'user')),
));
if ($g) {
$tree[]=$g;
}
$g=$this->group('config', '系统配置', 'top_2', array(
$this->item('cfg_sys', '系统信息设置', 'xt_1', '/pages/config/config', array('section'=> 'sys')),
$this->item('cfg_session', '个性化设置', 'xt_2', '/pages/config/config', array('section'=> 'session')),
$this->item('cfg_code', '验证码设置', 'xt_3', '/pages/config/config', array('section'=> 'code')),
$this->item('cfg_re_user', '账号注册设置', 'xt_4', '/pages/config/config', array('section'=> 're_user')),
$this->item('cfg_user_extra', '用户拓展字段', 'xt_13', '/pages/config/config', array('section'=> 'user_extra')),
$this->item('cfg_mobile', '手机客户端配置', 'xt_14', '/pages/config/config', array('section'=> 'mobile')),
$this->item('cfg_mail', '邮件设置', 'xt_5', '/pages/config/config', array('section'=> 'mail')),
$this->item('cfg_sms', '短信设置', 'xt_11', '/pages/config/config', array('section'=> 'sms')),
$this->item('cfg_storage', '云存储设置', 'xt_12', '/pages/config/config', array('section'=> 'storage')),
$this->item('cfg_extension', '邀请推广设置', 'xt_6', '/pages/config/config', array('section'=> 'extension')),
$this->item('cfg_pay', '在线支付设置', 'xt_7', '/pages/payment/payment'),
$this->item('cfg_template', '全球化语言设置', 'xt_8', '/pages/config/config', array('section'=> 'template')),
$this->item('cfg_language', '全球语言库设置', 'xt_8', '/pages/language/language'),
$this->item('cfg_agent', '代理商平台设置', 'xt_9', '/pages/config/config', array('section'=> 'agent')),
$this->item('cfg_agent_menu', '代理导航菜单控制', 'xt_9', '/pages/agent-menu/agent-menu'),
$this->item('cfg_plug', '三方插件配置', 'xt_10', '', array(), null, true),
));
if ($g) {
$tree[]=$g;
}
if (isset($this->qx['top_5']) && (int) $this->qx['top_5']===123) {
$g=$this->group('cms', '前端CMS内容', '', array(
$this->item('html_tpl', '前端HTML模板', 'html_1', ''),
));
if ($g) {
$tree[]=$g;
}
}
$g=$this->group('news', '文章公告管理', 'top_6', array(
$this->item('news_list', '文章列表', 'wz_1', '/pages/news/news'),
$this->item('news_add', '文章添加', 'wz_1', '/pages/news-edit/news-edit'),
$this->item('news_class', '栏目列表', 'wz_1', '/pages/news/news', array('panel'=> 'class')),
$this->item('news_class_add', '栏目添加', 'wz_1', '/pages/news/news', array('panel'=> 'class', 'add'=> '1')),
));
if ($g) {
$tree[]=$g;
}
$g=$this->group('card_stats', '充值卡信息统计', 'top_7', array(
$this->item('stat_car', '卡通过账号统计', 'cw_3', '/pages/card-stats/card-stats', array('mode'=> 'carinfo')),
$this->item('stat_carb', '卡通过代理批量统计', 'cw_4', '/pages/card-stats/card-stats', array('mode'=> 'carinfob')),
$this->item('stat_note', '卡备注使用统计', 'cw_5', '/pages/card-stats/card-stats', array('mode'=> 'rootcarinfo')),
$this->item('stat_note_all', '卡备注统计批量', 'cw_6', '/pages/card-stats/card-stats', array('mode'=> 'rootcarinfoall')),
$this->item('stat_note_user', '卡代理账号备注统计', 'cw_7', '/pages/card-stats/card-stats', array('mode'=> 'rootcarinfoall_user')),
));
if ($g) {
$tree[]=$g;
}
$g=$this->group('marketing', '充值营销', 'top_10', array(
$this->item('pay_chong', '余额充值订单', 'cz_1', '/pages/orders/orders', array('type'=> 'chong')),
$this->item('pay_info', '平台购卡订单', 'cz_2', '/pages/orders/orders', array('type'=> 'info')),
$this->item('yao_reg', '邀请推广管理', 'cz_3', '/pages/money-logs/money-logs', array('panel'=> 'yao')),
$this->item('yao_money', '佣金提成管理', 'cz_4', '/pages/commission/commission'),
$this->item('rmb_log', '余额变动日志', 'cz_4', '/pages/money-logs/money-logs', array('panel'=> 'rmb')),
));
if ($g) {
$tree[]=$g;
}
$g=$this->group('tools', '运营管理工具', 'top_8', array(
$this->item('enpwd', 'API匿名加解密', 'yy_2', '/pages/enpwd/enpwd'),
$this->item('webapi', 'WEBAPI接口', 'yy_3', '/pages/webapi/webapi'),
$this->item('api_doc', 'API接口帮助文档', 'yy_5', '/pages/api-doc/api-doc'),
$this->item('custom_form', '超级表单管理', 'yy_6', '/pages/custom-form/custom-form'),
$this->item('upgrade', '升级修复数据库', 'yy_4', '/pages/db-upgrade/db-upgrade'),
$this->item('api_debug', '客户端API调试工具', 'yy_7', '/pages/api-debug/api-debug'),
));
if ($g) {
$tree[]=$g;
}
$plug_children=$this->scan_admin_plugs();
if (!$plug_children) {
$fallback=$this->item('plug_empty', '还没有插件', 'top_9', '', array(), null, true);
if ($fallback) {
$plug_children[]=$fallback;
}
}
$rsa=$this->item('bsphp_rsa', 'Bsphp-Rsa', 'top_9', '', array(), null, true);
if ($rsa) {
$rsa['web_url']='http://www.bsphp.com/#Pro';
$plug_children[]=$rsa;
}
$g=$this->group('plugins', '运营插件', 'top_9', $plug_children);
if ($g) {
$tree[]=$g;
}
if ($mobile_only) {
$tree=$this->filter_mobile($tree);
}
Plug_Print_Json(array(
'code'=> 100,
'msg'=> Plug_Lang('ok'),
'data'=> array(
'uid'=> (int) $this->admin_array['Admin_ID'],
'user'=> $this->admin_array['Admin_AdminUserName'],
'tree'=> $tree,
),
));
}
private function filter_mobile($tree)
{
$out=array();
foreach ($tree as $g) {
$kids=isset($g['children']) ? $g['children'] : array();
$nk=array();
foreach ($kids as $c) {
if (!empty($c['children'])) {
$sub=array();
foreach ($c['children'] as $s) {
if (!empty($s['mobile'])) {
$sub[]=$s;
}
}
if ($sub) {
$c['children']=$sub;
$nk[]=$c;
}
} elseif (!empty($c['mobile'])) {
$nk[]=$c;
}
}
if ($nk) {
$g['children']=$nk;
$out[]=$g;
}
}
return $out;
}
}
