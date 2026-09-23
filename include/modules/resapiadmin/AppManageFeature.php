<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class AppManageFeature
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
$p=Plug_Admin_Pager();
$kw=Plug_Set_Get('keyword');
if ($kw==='') {
$kw=Plug_Set_Get('soso');
}
$sort=Plug_Set_Get('app_sort');
if ($sort==='') {
$sort=Plug_Set_Get('sort');
}
$order='ORDER BY `app_sort` DESC,`app_daihao` DESC';
if ($sort==='daihao_asc' || $sort==='代号排升') {
$order='ORDER BY `app_daihao` ASC';
} elseif ($sort==='daihao_desc' || $sort==='代号排降') {
$order='ORDER BY `app_daihao` DESC';
} elseif ($sort==='name_asc' || $sort==='名称排升') {
$order='ORDER BY `app_name` ASC';
} elseif ($sort==='name_desc' || $sort==='名称排降') {
$order='ORDER BY `app_name` DESC';
} elseif ($sort==='sort_asc' || $sort==='排序升') {
$order='ORDER BY `app_sort` ASC,`app_daihao` ASC';
} elseif ($sort==='sort_desc' || $sort==='排序降') {
$order='ORDER BY `app_sort` DESC,`app_daihao` DESC';
}
$where='1=1';
if ($kw !=='') {
$where .=" AND (`app_name` LIKE '%{$kw}%' OR `app_daihao` LIKE '%{$kw}%')";
}
$cnt=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_appinfo` WHERE {$where}");
$rs=Plug_Query("SELECT `app_daihao`,`app_name`,`app_MoShi`,`app_off`,`app_v`,`app_sort`,`app_gg` FROM `bs_php_appinfo` WHERE {$where} {$order} LIMIT {$p['offset']},{$p['limit']}");
$with_stats=(string) Plug_Set_Get('with_stats') !=='0';
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
if ($with_stats) {
$v['stats']=$this->app_list_stats((int) $v['app_daihao']);
}
$list[]=$v;
}
Plug_Admin_List_Json($list, (int) ($cnt['hangshu'] ?? 0));
}
private function app_list_stats($daihao)
{
$daihao=(int) $daihao;
$empty=array(
'user_total'=> 0, 'user_today'=> 0, 'user_yesterday'=> 0, 'user_month'=> 0,
'card_total'=> 0, 'card_actived'=> 0, 'card_unactived'=> 0,
'card_today'=> 0, 'card_yesterday'=> 0, 'card_month'=> 0,
'kuka_total'=> 0, 'kuka_remain'=> 0, 'kuka_agents'=> 0,
'group_count'=> 0, 'type_count'=> 0,
'online_sess'=> 0, 'online_dev'=> 0,
);
if ($daihao <=0) {
return $empty;
}
$u=Plug_Query_Array("SELECT
COUNT(*) AS hangshu,
SUM(CASE WHEN DATE(`L_re_date`)=CURDATE() THEN 1 ELSE 0 END) AS today_add,
SUM(CASE WHEN DATE(`L_re_date`)=CURDATE() - INTERVAL 1 DAY THEN 1 ELSE 0 END) AS yesterday_add,
SUM(CASE WHEN YEAR(`L_re_date`)=YEAR(CURDATE()) AND MONTH(`L_re_date`)=MONTH(CURDATE()) THEN 1 ELSE 0 END) AS month_add
FROM `bs_php_pattern_login` WHERE `L_daihao`='{$daihao}'");
$c=Plug_Query_Array("SELECT
COUNT(*) AS total,
SUM(CASE WHEN `car_IsLock`='1' THEN 1 ELSE 0 END) AS actived,
SUM(CASE WHEN `car_IsLock`='0' THEN 1 ELSE 0 END) AS unactived,
SUM(CASE WHEN `car_IsLock`='1' AND DATE(`car_pur_date`)=CURDATE() THEN 1 ELSE 0 END) AS today_actived,
SUM(CASE WHEN `car_IsLock`='1' AND DATE(`car_pur_date`)=CURDATE() - INTERVAL 1 DAY THEN 1 ELSE 0 END) AS yesterday_actived,
SUM(CASE WHEN `car_IsLock`='1' AND YEAR(`car_pur_date`)=YEAR(CURDATE()) AND MONTH(`car_pur_date`)=MONTH(CURDATE()) THEN 1 ELSE 0 END) AS month_actived
FROM `bs_php_cardseries` WHERE `car_DaiHao`='{$daihao}'");
$kuka_total=0;
$kuka_agents=0;
$chk=Plug_Query_Array("SHOW TABLES LIKE 'bs_php_kuka'");
if ($chk) {
$k=Plug_Query_Array("SELECT IFNULL(SUM(`kuka_val`),0) AS total_val, COUNT(*) AS kuka_agent_count FROM `bs_php_kuka` WHERE `kuka_daihao`='{$daihao}'");
$kuka_total=(int) ($k['total_val'] ?? 0);
$kuka_agents=(int) ($k['kuka_agent_count'] ?? 0);
}
$g=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_userclass` WHERE `class_daihao`='{$daihao}'");
$t=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_kalei` WHERE `lei_daihao`='{$daihao}'");
$online_sess=0;
$online_dev=0;
$lnk=Plug_Query_Array("SHOW TABLES LIKE 'bs_php_links_session'");
if ($lnk) {
$o=Plug_Query_Array("SELECT COUNT(*) AS links_online_sess,
COUNT(DISTINCT CASE WHEN TRIM(IFNULL(`links_biaoji`,'')) <> '' THEN `links_biaoji` END) AS links_online_dev
FROM `bs_php_links_session`
WHERE `links_daihao`='{$daihao}' AND `links_bs_set`='APPEN' AND `links_user_name`!='' AND IFNULL(`links_set`,'0')<>'-1'");
$online_sess=(int) ($o['links_online_sess'] ?? 0);
$online_dev=(int) ($o['links_online_dev'] ?? 0);
}
return array(
'user_total'=> (int) ($u['hangshu'] ?? 0),
'user_today'=> (int) ($u['today_add'] ?? 0),
'user_yesterday'=> (int) ($u['yesterday_add'] ?? 0),
'user_month'=> (int) ($u['month_add'] ?? 0),
'card_total'=> (int) ($c['total'] ?? 0),
'card_actived'=> (int) ($c['actived'] ?? 0),
'card_unactived'=> (int) ($c['unactived'] ?? 0),
'card_today'=> (int) ($c['today_actived'] ?? 0),
'card_yesterday'=> (int) ($c['yesterday_actived'] ?? 0),
'card_month'=> (int) ($c['month_actived'] ?? 0),
'kuka_total'=> $kuka_total,
'kuka_remain'=> $kuka_total,
'kuka_agents'=> $kuka_agents,
'group_count'=> (int) ($g['hangshu'] ?? 0),
'type_count'=> (int) ($t['hangshu'] ?? 0),
'online_sess'=> $online_sess,
'online_dev'=> $online_dev,
);
}
function call_detail()
{
Plug_Admin_Assert_Qx('app_1');
$daihao=(int) Plug_Set_Get('daihao');
if ($daihao <=0) {
$daihao=(int) Plug_Set_Get('id');
}
$row=Plug_Query_Array("SELECT * FROM `bs_php_appinfo` WHERE `app_daihao`='{$daihao}' LIMIT 1");
if (!$row) {
Plug_Admin_Fail(Plug_Lang('软件不存在'));
}
Plug_Admin_Ok('ok', $row);
}
function call_moshi_list()
{
Plug_Admin_Assert_Qx('app_2');
$path=defined('����������������������������������������4��������������������') ? (����������������������������������������4�������������������� . 'include/applibapi/api') : '';
$list=array();
if ($path !=='' && is_dir($path)) {
$dirs=switch（����������������������������������������������������������������������������_SERVER($path);
if (is_array($dirs)) {
foreach ($dirs as $id) {
if ($id==='' || $id==='index.html') {
continue;
}
$name=$id;
$arr=�������������������������������������������������������������������������������������️‍�($id);
if (!is_array($arr) || (string) @$arr['really'] !=='1') {
continue;
}
if (!empty($arr['name'])) {
$name=$arr['name'];
}
$list[]=array('id'=> $id, 'name'=> $name);
}
}
}
if (!$list) {
$list=array(
array('id'=> 'LoginPoint', 'name'=> '账号扣点'),
array('id'=> 'LoginTerm', 'name'=> '账号限时'),
array('id'=> 'CardPoint', 'name'=> '卡扣点'),
array('id'=> 'CardTerm', 'name'=> '卡限时'),
);
}
Plug_Admin_Ok('ok', array('list'=> $list));
}
function call_add()
{
Plug_Admin_Assert_Qx('app_2');
$daihao=(int) Plug_Set_Post('daihao');
$moshi=Plug_Set_Post('moshi');
$name=Plug_Set_Post('name');
if ($name==='') {
$name=Plug_Set_Post('app_name');
}
if ($daihao <=0) {
Plug_Admin_Fail(Plug_Lang('代号不能为0 必须数字!'));
}
if ($name==='') {
Plug_Admin_Fail(Plug_Lang('软件别名不能为空!'));
}
if (strlen((string) $daihao) > 8) {
Plug_Admin_Fail(Plug_Lang('软件代号长度不能超8位数字!'));
}
$exists=Plug_Query_Array("SELECT `app_daihao` FROM `bs_php_appinfo` WHERE `app_daihao`='{$daihao}' LIMIT 1");
if ($exists) {
Plug_Admin_Fail(Plug_Lang('无需添加,软件代号[') . $daihao . Plug_Lang(']已经存在,请到列表查看'));
}
if ($moshi==='') {
$moshi=Plug_Set_Post('app_MoShi');
}
if ($moshi==='') {
$moshi='LoginPoint';
}
$moshi=preg_replace('/[^A-Za-z0-9_\\-]/', '', $moshi);
if ($moshi==='') {
$moshi='LoginPoint';
}
$nameSql=addslashes($name);
$moshiSql=addslashes($moshi);
$app_pwd=for（����������������������������������������������������������������������������������������(18);
$app_pwd=addslashes($app_pwd);
$app_sort=defined('����������������������������������������������������������������������������') ? ���������������������������������������������������������������������������� : time();
$server_pem=$server_key=$client_pem=$client_key='';
if (function_exists('openssl_pkey_new')) {
$keys=$this->make_rsa_pair();
if ($keys) {
$server_pem=addslashes($keys['pem']);
$server_key=addslashes($keys['key']);
}
$keys=$this->make_rsa_pair();
if ($keys) {
$client_pem=addslashes($keys['pem']);
$client_key=addslashes($keys['key']);
}
}
$sql="INSERT INTO `bs_php_appinfo` (
`app_daihao`,`app_name`,`app_off`,`app_off_name`,`app_set`,`app_set_date`,
`app_WEB_URL`,`app_URL`,`app_v`,`app_key_zhong`,`app_gg`,
`app_LogicA`,`app_LogicB`,`app_LogicinfoA`,`app_LogicinfoB`,`app_logininfo`,`app_md5`,
`app_MoShi`,`app_miaoshu`,`app_info`,`app_re_date`,`app_zhuang_date`,`app_links`,
`app_coode`,`app_chaoshi`,`app_pwd`,`app_get`,`app_breaking`,`app_links_chaoshi`,
`app_chargeset`,`app_links_open`,`app_point_open`,`app_api_pwd`,`app_api_dir`,
`app_get_encryption`,`app_show_encryption`,`app_output`,`app_langs`,
`app_server_pem`,`app_server_key`,`app_client_pem`,`app_client_key`,`app_sort`
) VALUES (
'{$daihao}','{$nameSql}','0','系统维护,暂时性关闭,请稍后再访问！','0','0',
'http://www.xxxx.com/index.php','http://www.xxxxx.com/up.zip','v1.0','0','xxxxxx公告',
'0','0','逻辑值','逻辑值','验证数据',NULL,
'{$moshiSql}',NULL,NULL,'864000','600','99',
'','12000','{$app_pwd}','0','0','12000',
'0','99','0','0','-1',
'bsphp_aes_rsa_base64','bsphp_aes_rsa_base64','notfun','zh-cn',
'{$server_pem}','{$server_key}','{$client_pem}','{$client_key}','{$app_sort}'
)";
Plug_Query($sql);
$defaults=array(
array('myapp', '软件配置', '这是我设置配置内容', 0, 1, 0),
array('myvip', 'VIP配置', '这是我VIP没有到期的获取设置配置内容', 1, 0, 1),
array('mylogin', '登录配置', '这是我登录后才能获取内容', 2, 1, 2),
);
$chk=Plug_Query_Array("SHOW TABLES LIKE 'bs_php_app_custom_config'");
if ($chk) {
foreach ($defaults as $cfg) {
$fk=addslashes($cfg[0]);
$mn=addslashes(Plug_Lang($cfg[1]));
$fd=addslashes(Plug_Lang($cfg[2]));
$lr=(int) $cfg[3];
$ea=(int) $cfg[4];
$so=(int) $cfg[5];
Plug_Query("INSERT INTO `bs_php_app_custom_config`
(`app_daihao`,`field_key`,`field_type`,`field_val`,`field_desc`,`field_options`,`model_name`,`remark`,`login_required`,`expire_allow`,`sort_order`)
VALUES ({$daihao},'{$fk}','textarea','{$fd}','{$fd}','','{$mn}','',{$lr},{$ea},{$so})");
}
}
Plug_Admin_Ok($name . ' ' . Plug_Lang('添加成功,请到软件管理中查看!'), array('daihao'=> $daihao));
}
private function make_rsa_pair()
{
$config=array(
'private_key_bits'=> 2048,
'private_key_type'=> OPENSSL_KEYTYPE_RSA,
);
$res=@openssl_pkey_new($config);
if (!$res) {
return null;
}
$private='';
openssl_pkey_export($res, $private);
$details=openssl_pkey_get_details($res);
$public=isset($details['key']) ? $details['key'] : '';
$public=if（function（��������������������������������������������������������������������($public);
$private=if（function（��������������������������������������������������������������������($private);
return array('pem'=> $public, 'key'=> $private);
}
function call_delete()
{
Plug_Admin_Assert_Qx('app_1');
$daihao=(int) Plug_Set_Get('daihao');
if ($daihao <=0) {
$daihao=(int) Plug_Set_Post('daihao');
}
if ($daihao <=0) {
Plug_Admin_Fail(Plug_Lang('参数不完整'));
}
$flag=function ($key) {
$v=Plug_Set_Post($key);
return $v==='on' || $v==='1' || $v===1 || $v===true || $v==='true';
};
$did=false;
if ($flag('delete_app')) {
Plug_Query("DELETE FROM `bs_php_appinfo` WHERE `app_daihao`='{$daihao}'");
Plug_Query("DELETE FROM `bs_php_app_custom_config` WHERE `app_daihao`='{$daihao}'");
$did=true;
}
if ($flag('delete_user')) {
Plug_Query("DELETE FROM `bs_php_pattern_login` WHERE `L_daihao`='{$daihao}'");
$did=true;
}
if ($flag('delete_car')) {
Plug_Query("DELETE FROM `bs_php_cardseries` WHERE `car_DaiHao`='{$daihao}'");
$did=true;
}
if ($flag('delete_class')) {
Plug_Query("DELETE FROM `bs_php_kalei` WHERE `lei_daihao`='{$daihao}'");
$did=true;
}
if ($flag('delete_list')) {
Plug_Query("DELETE FROM `bs_php_userclass` WHERE `class_daihao`='{$daihao}' OR `daihao`='{$daihao}'");
$did=true;
}
if ($flag('delete_kuka')) {
$chk=Plug_Query_Array("SHOW TABLES LIKE 'bs_php_kuka'");
if ($chk) {
Plug_Query("DELETE FROM `bs_php_kuka` WHERE `kuka_daihao`='{$daihao}'");
}
$did=true;
}
if (!$did) {
Plug_Admin_Fail(Plug_Lang('请至少勾选一项'));
}
Plug_Admin_Ok(Plug_Lang('删除任务已执行'));
}
function call_appini_get()
{
return $this->call_detail();
}
function call_appini_save()
{
Plug_Admin_Assert_Qx('app_1');
$daihao=(int) Plug_Set_Get('daihao');
if ($daihao <=0) {
$daihao=(int) Plug_Set_Get('id');
}
if ($daihao <=0) {
$daihao=(int) Plug_Set_Post('app_daihao');
}
$row=Plug_Query_Array("SELECT `app_daihao` FROM `bs_php_appinfo` WHERE `app_daihao`='{$daihao}' LIMIT 1");
if (!$row) {
Plug_Admin_Fail(Plug_Lang('软件不存在'));
}
$allow=array(
'app_name', 'app_off', 'app_off_name', 'app_set', 'app_v', 'app_WEB_URL', 'app_URL', 'app_gg',
'app_logininfo', 'app_key_zhong', 'app_md5', 'app_miaoshu', 'app_info', 'app_MoShi',
'app_set_date', 'app_re_date', 'app_zhuang_date', 'app_links',
'app_breaking', 'app_chargeset', 'app_links_chaoshi', 'app_links_open', 'app_coode',
'app_api_pwd', 'app_api_dir', 'app_get_encryption', 'app_show_encryption', 'app_output',
'app_langs', 'app_sort', 'app_chaoshi', 'app_LogicA', 'app_LogicinfoA', 'app_LogicB', 'app_LogicinfoB',
'app_links_open_off', 'app_sale_title', 'app_sale_img', 'app_sale_desc', 'app_sale_kefu',
'app_server_pem', 'app_server_key', 'app_client_pem', 'app_client_key',
'app_insgin', 'app_tosgin',
);
$sets=array();
foreach ($allow as $k) {
$post_key=$k;
if ($k==='app_links_open_off' && isset($_POST['links_open_off'])) {
$post_key='links_open_off';
}
if ($k==='app_insgin' && isset($_POST['insgin'])) {
$post_key='insgin';
}
if ($k==='app_tosgin' && isset($_POST['tosgin'])) {
$post_key='tosgin';
}
if (!isset($_POST[$post_key]) && !isset($_POST[$k])) {
continue;
}
$val=isset($_POST[$post_key]) ? Plug_Set_Post($post_key) : Plug_Set_Post($k);
if ($k==='app_LogicA' || $k==='app_LogicB' || $k==='app_breaking' || $k==='app_links_open_off') {
$val=(int) $val;
}
$sets[]="`{$k}`='{$val}'";
}
if (isset($_POST['chaoshi'])) {
$sets[]="`app_chaoshi`='" . Plug_Set_Post('chaoshi') . "'";
}
if (isset($_POST['password'])) {
$sets[]="`app_pwd`='" . Plug_Set_Post('password') . "'";
}
if (isset($_POST['get_post'])) {
$sets[]="`app_get`='" . Plug_Set_Post('get_post') . "'";
}
if (isset($_POST['app_user_extra'])) {
$extra=trim((string) $_POST['app_user_extra']);
if ($extra !=='') {
$decoded=json_decode($extra, true);
if (!is_array($decoded)) {
$decoded=array();
}
$extra=json_encode(if（����������������������������������������������������3������������($decoded), JSON_UNESCAPED_UNICODE);
}
$sets[]="`app_user_extra`='" . addslashes($extra) . "'";
}
if (!$sets) {
Plug_Admin_Fail(Plug_Lang('没有修改内容'));
}
Plug_Query('UPDATE `bs_php_appinfo` SET ' . implode(',', $sets) . " WHERE `app_daihao`='{$daihao}' LIMIT 1");
Plug_Admin_Ok(Plug_Lang('保存成功'));
}
function call_custom_config_list()
{
Plug_Admin_Assert_Qx('app_1');
$id=(int) Plug_Set_Get('daihao');
if ($id <=0) {
$id=(int) Plug_Set_Get('id');
}
$model=Plug_Set_Get('model_name');
$field=Plug_Set_Get('search_field');
$kw=Plug_Set_Get('keyword');
if ($kw==='') {
$kw=Plug_Set_Get('soso');
}
$where="`app_daihao`='{$id}'";
if ($model !=='') {
$where .=" AND `model_name`='" . addslashes($model) . "'";
}
if ($kw !=='' && $field !=='' && preg_match('/^[a-zA-Z0-9_]+$/', $field)) {
$where .=" AND `{$field}` LIKE '%" . addslashes($kw) . "%'";
}
$rs=Plug_Query("SELECT `id`,`app_daihao`,`field_key`,`field_type`,`field_val`,`field_desc`,`field_options`,`model_name`,`remark`,`login_required`,`expire_allow`,`sort_order` FROM `bs_php_app_custom_config` WHERE {$where} ORDER BY `id` DESC");
$list=array();
$n=0;
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=$v;
$n++;
}
$models=array();
$mrs=Plug_Query("SELECT DISTINCT `model_name` FROM `bs_php_app_custom_config` WHERE `app_daihao`='{$id}' AND `model_name`<>'' ORDER BY `id` DESC");
while ($m=Plug_Pdo_Fetch_Assoc($mrs)) {
$models[]=$m['model_name'];
}
Plug_Print_Json(array('code'=> 0, 'msg'=> '', 'count'=> $n, 'data'=> $list, 'models'=> $models));
}
function call_custom_config_save()
{
Plug_Admin_Assert_Qx('app_1');
$id=(int) Plug_Set_Post('id');
if ($id <=0) {
$id=(int) Plug_Set_Post('daihao');
}
$field_key=trim(Plug_Set_Post('field_key'));
$field_type=Plug_Set_Post('field_type');
$field_val=Plug_Set_Post('field_val');
$field_desc=Plug_Set_Post('field_desc');
$field_options=Plug_Set_Post('field_options');
$model_name=Plug_Set_Post('model_name');
$remark=Plug_Set_Post('remark');
$login_required=(int) Plug_Set_Post('login_required');
$expire_allow=(int) Plug_Set_Post('expire_allow');
$exist_id=(int) Plug_Set_Post('exist_id');
$attr_only=(int) Plug_Set_Post('attr_only');
if (!$id || $field_key==='') {
Plug_Admin_Fail(Plug_Lang('参数错误'));
}
if (!preg_match('/^[a-zA-Z0-9_]+$/', $field_key)) {
Plug_Admin_Fail(Plug_Lang('字段key仅允许字母数字下划线'));
}
if (!in_array($field_type, array('input', 'textarea', 'code_textarea', 'select', 'upload'), true)) {
$field_type='input';
}
if ($exist_id > 0) {
if ($attr_only) {
Plug_Query("UPDATE `bs_php_app_custom_config` SET `field_type`='{$field_type}',`field_desc`='{$field_desc}',`field_options`='{$field_options}',`model_name`='{$model_name}',`remark`='{$remark}',`login_required`={$login_required},`expire_allow`={$expire_allow} WHERE `id`={$exist_id} AND `app_daihao`={$id}");
} else {
Plug_Query("UPDATE `bs_php_app_custom_config` SET `field_type`='{$field_type}',`field_val`='{$field_val}',`field_desc`='{$field_desc}',`field_options`='{$field_options}',`model_name`='{$model_name}',`remark`='{$remark}',`login_required`={$login_required},`expire_allow`={$expire_allow} WHERE `id`={$exist_id} AND `app_daihao`={$id}");
}
Plug_Admin_Ok(Plug_Lang('保存成功'));
}
Plug_Query("INSERT INTO `bs_php_app_custom_config` (`app_daihao`,`field_key`,`field_type`,`field_val`,`field_desc`,`field_options`,`model_name`,`remark`,`login_required`,`expire_allow`,`sort_order`) VALUES ({$id},'{$field_key}','{$field_type}','{$field_val}','{$field_desc}','{$field_options}','{$model_name}','{$remark}',{$login_required},{$expire_allow},0)");
Plug_Admin_Ok(Plug_Lang('添加成功'));
}
function call_custom_config_save_val()
{
Plug_Admin_Assert_Qx('app_1');
$id=(int) Plug_Set_Post('id');
if ($id <=0) {
$id=(int) Plug_Set_Post('daihao');
}
$exist_id=(int) Plug_Set_Post('exist_id');
$field_val=Plug_Set_Post('field_val');
if (!$id || !$exist_id) {
Plug_Admin_Fail(Plug_Lang('参数错误'));
}
Plug_Query("UPDATE `bs_php_app_custom_config` SET `field_val`='{$field_val}' WHERE `id`={$exist_id} AND `app_daihao`={$id}");
Plug_Admin_Ok(Plug_Lang('保存成功'));
}
function call_custom_config_del()
{
Plug_Admin_Assert_Qx('app_1');
$id=(int) Plug_Set_Post('id');
if ($id <=0) {
$id=(int) Plug_Set_Post('daihao');
}
$del_id=(int) Plug_Set_Post('del_id');
if ($del_id <=0) {
$del_id=(int) Plug_Set_Post('exist_id');
}
if (!$id || !$del_id) {
Plug_Admin_Fail(Plug_Lang('参数错误'));
}
Plug_Query("DELETE FROM `bs_php_app_custom_config` WHERE `id`={$del_id} AND `app_daihao`={$id}");
Plug_Admin_Ok(Plug_Lang('删除成功'));
}
function call_gen_cert()
{
Plug_Admin_Assert_Qx('app_1');
if (!function_exists('openssl_pkey_new')) {
Plug_Admin_Fail(Plug_Lang('生成失败') . ': openssl unavailable');
}
$config=array(
'private_key_bits'=> 2048,
'private_key_type'=> OPENSSL_KEYTYPE_RSA,
);
$res=@openssl_pkey_new($config);
if (!$res) {
$msg=openssl_error_string();
Plug_Admin_Fail(Plug_Lang('生成失败') . ($msg ? ': ' . $msg : ''));
}
$private='';
openssl_pkey_export($res, $private);
$details=openssl_pkey_get_details($res);
$public=isset($details['key']) ? $details['key'] : '';
$public=if（function（��������������������������������������������������������������������($public);
$private=if（function（��������������������������������������������������������������������($private);
Plug_Print_Json(array(
'code'=> 100,
'msg'=> Plug_Lang('ok'),
'data'=> array('pem'=> $public, 'key'=> $private),
'pem'=> $public,
'key'=> $private,
));
}
function call_storage_upload()
{
Plug_Admin_Assert_Qx('app_1');
if (!defined('IS_UPDATE_FILE') || IS_UPDATE_FILE !=1) {
Plug_Admin_Fail(Plug_Lang('当前禁止上传文件，如需开放请将 Data/Bsmysql.Config.php 中 IS_UPDATE_FILE 设置为 1'));
}
$file_key=isset($_FILES['file']) ? 'file' : (isset($_FILES['imgFile']) ? 'imgFile' : '');
if ($file_key==='' || empty($_FILES[$file_key]['tmp_name']) || !is_uploaded_file($_FILES[$file_key]['tmp_name'])) {
Plug_Admin_Fail(Plug_Lang('请选择要上传的文件'));
}
$file=$_FILES[$file_key];
$ext_arr=array('zip', 'rar', '7z', 'gz', 'apk', 'ipa', 'exe', 'dmg', 'json', 'js', 'css', 'html', 'txt', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png', 'gif', 'webp');
$ext=strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($ext, $ext_arr, true)) {
Plug_Admin_Fail(Plug_Lang('不允许的文件类型') . ': ' . $ext);
}
if ($file['size'] > 500 * 1024 * 1024) {
Plug_Admin_Fail(Plug_Lang('文件大小超过500MB限制'));
}
$result=array('success'=> false, 'url'=> '', 'path'=> '');
$storage_file=����������������������������������������4�������������������� . 'Plug/storage/storage_manager.class.php';
if (file_exists($storage_file)) {
try {
require_once $storage_file;
$storage_manager=new storage_manager();
$ret=$storage_manager->uploadFile($file);
if (!empty($ret['success']) && !empty($ret['url'])) {
$result['success']=true;
$result['url']=$ret['url'];
$result['path']=isset($ret['path']) ? $ret['path'] : $ret['url'];
} elseif (!empty($ret['message'])) {
Plug_Admin_Fail($ret['message']);
}
} catch (Exception $e) {
}
}
if (!$result['success']) {
$save_dir=����������������������������������������4�������������������� . 'upfiles/';
$ymd=date('Y/m/d');
$target_dir=$save_dir . $ymd . '/';
if (!is_dir($target_dir)) {
@mkdir($target_dir, 0755, true);
}
$safe_name=date('YmdHis') . '_' . substr(md5(uniqid()), 0, 8) . '.' . $ext;
$target_path=$target_dir . $safe_name;
if (!move_uploaded_file($file['tmp_name'], $target_path)) {
Plug_Admin_Fail(Plug_Lang('本地保存失败'));
}
$rel_path='upfiles/' . $ymd . '/' . $safe_name;
$result['url']=��������������������Q����������������������������������������������������($rel_path);
$result['path']=$rel_path;
$result['success']=true;
}
Plug_Admin_Ok(Plug_Lang('上传成功'), array(
'url'=> $result['url'],
'path'=> $result['path'],
));
}
}
