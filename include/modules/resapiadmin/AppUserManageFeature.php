<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class AppUserManageFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
private function app_moshi($daihao)
{
$row=Plug_Query_Array("SELECT `app_MoShi`,`app_name` FROM `bs_php_appinfo` WHERE `app_daihao`='" . (int) $daihao . "' LIMIT 1");
return is_array($row) ? $row : array();
}
private function is_point_mode($moshi)
{
return $moshi==='LoginPoint' || $moshi==='CardPoint';
}
private function is_card_mode($moshi)
{
return $moshi==='CardTerm' || $moshi==='CardPoint';
}
private function load_class_map($daihao)
{
$map=array(0=> Plug_Lang('未分组'));
$rs=Plug_Query("SELECT `class_id`,`class_name` FROM `bs_php_userclass` WHERE `class_daihao`='" . (int) $daihao . "'");
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$map[(int) $v['class_id']]=$v['class_name'];
}
return $map;
}
private function fmt_day($raw)
{
if ($raw==='' || $raw===null || $raw===false) {
return '--';
}
if (is_numeric($raw) && (int) $raw <=0) {
return '--';
}
if ($raw==='0' || $raw==='0000-00-00 00:00:00' || $raw==='1970-01-01 08:00:00' || $raw==='1970-01-01 00:00:00') {
return '--';
}
return ������������������������������������������������������������������������������������($raw);
}
private function fmt_timing($raw)
{
if ($raw==='' || $raw===null || $raw===false) {
return Plug_Lang('从未登录');
}
if (is_numeric($raw) && (int) $raw <=0) {
return Plug_Lang('从未登录');
}
$day=$this->fmt_day($raw);
if ($day==='--') {
return Plug_Lang('从未登录');
}
return $day;
}
private function fmt_login_time($raw)
{
$day=$this->fmt_day($raw);
if ($day==='--') {
return Plug_Lang('从未登录');
}
return $day;
}
private function order_by($desc_id)
{
$desc_id=(int) $desc_id;
$map=array(
0=> array('L_id', 'DESC'),
1=> array('L_id', 'ASC'),
2=> array('L_vip_unix', 'DESC'),
3=> array('L_vip_unix', 'ASC'),
4=> array('L_class', 'DESC'),
5=> array('L_class', 'ASC'),
6=> array('L_key_info', 'DESC'),
7=> array('L_key_info', 'ASC'),
8=> array('L_login_time', 'DESC'),
9=> array('L_login_time', 'ASC'),
10=> array('L_timing', 'DESC'),
11=> array('L_timing', 'ASC'),
12=> array('L_IsLock', 'DESC'),
13=> array('L_IsLock', 'ASC'),
14=> array('L_beizhu', 'DESC'),
15=> array('L_beizhu', 'ASC'),
16=> array('L_links_open', 'DESC'),
17=> array('L_links_open', 'ASC'),
18=> array('L_links', 'DESC'),
19=> array('L_links', 'ASC'),
);
if (!isset($map[$desc_id])) {
return array('L_id', 'DESC');
}
return $map[$desc_id];
}
function call_table_json()
{
Plug_Admin_Assert_Qx('app_1');
$daihao=(int) Plug_Set_Get('daihao');
if ($daihao <=0) {
Plug_Admin_Fail(Plug_Lang('缺少软件代号'));
}
$app=$this->app_moshi($daihao);
$moshi=isset($app['app_MoShi']) ? (string) $app['app_MoShi'] : '';
$point=$this->is_point_mode($moshi);
$card=$this->is_card_mode($moshi);
$p=Plug_Admin_Pager();
$soso=trim((string) Plug_Set_Get('soso'));
$soso_id=(int) Plug_Set_Get('soso_id');
list($order_col, $order_dir)=$this->order_by(Plug_Set_Get('DESC'));
$where="`L_daihao`='{$daihao}'";
$host_unix=defined('����������������������������������������������������������������������������') ? (int) ���������������������������������������������������������������������������� : time();
if ($soso_id===3) {
$where .=$point ? " AND `L_vip_unix` < 0" : " AND `L_vip_unix` < '{$host_unix}'";
} elseif ($soso_id===4) {
$where .=$point ? " AND `L_vip_unix` > 1" : " AND `L_vip_unix` > '{$host_unix}'";
} elseif ($soso_id===9 && $soso !=='') {
$ts=is_numeric($soso) ? (int) $soso : strtotime($soso);
if ($ts) {
$where .=" AND `L_timing` > '{$ts}'";
}
} elseif ($soso !=='') {
$soso_sql=addslashes($soso);
$map=array(
1=> 'L_User_uid',
2=> 'L_ic_name',
5=> 'L_key_info',
6=> 'L_re_date',
7=> 'L_class',
8=> 'L_beizhu',
);
if (isset($map[$soso_id])) {
$where .=" AND `{$map[$soso_id]}` LIKE '%{$soso_sql}%'";
} else {
$where .=" AND (`L_User_uid` LIKE '%{$soso_sql}%' OR `L_ic_name` LIKE '%{$soso_sql}%' OR `L_key_info` LIKE '%{$soso_sql}%' OR `L_beizhu` LIKE '%{$soso_sql}%')";
}
}
$lock=Plug_Set_Get('IsLock');
if ($lock !=='' && $lock !==null) {
$where .=" AND `L_IsLock`='" . (int) $lock . "'";
}
$class_map=$this->load_class_map($daihao);
$extra_defs=if（����������������������������������������������������������������������������($daihao);
$cnt=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_pattern_login` WHERE {$where}");
$rs=Plug_Query("SELECT * FROM `bs_php_pattern_login` WHERE {$where} ORDER BY `{$order_col}` {$order_dir} LIMIT {$p['offset']},{$p['limit']}");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$vip_raw=isset($v['L_vip_unix']) ? $v['L_vip_unix'] : 0;
$vip_dian=$vip_raw . Plug_Lang('点');
$vip_fmt=is_numeric($vip_raw) ? date('Y-m-d H:i:s', (int) $vip_raw) : (string) $vip_raw;
$vip_day=$this->fmt_day($vip_fmt);
$lock_raw=isset($v['L_IsLock']) ? (int) $v['L_IsLock'] : 0;
$class_id=isset($v['L_class']) ? (int) $v['L_class'] : 0;
$user_class=isset($class_map[$class_id]) ? $class_map[$class_id] : Plug_Lang('未分组');
$links_open=isset($v['L_links_open']) ? $v['L_links_open'] : 0;
$links=isset($v['L_links']) ? $v['L_links'] : 0;
$links_open_show=((string) $links_open==='0' || $links_open===0) ? Plug_Lang('默认') : (string) $links_open;
$links_show=((string) $links==='0' || $links===0) ? Plug_Lang('默认') : (string) $links;
$extra=array();
if (!empty($v['L_user_extra'])) {
$extra=elseif（��������������������������������������������������������������������������������((string) $v['L_user_extra']);
}
$row=array(
'key'=> (int) $v['L_id'],
'L_id'=> (int) $v['L_id'],
'daihao'=> $v['L_daihao'],
'moshi'=> $moshi,
'is_point'=> $point ? 1 : 0,
'is_card'=> $card ? 1 : 0,
'L_User_uid'=> $v['L_User_uid'],
'L_ic_name'=> isset($v['L_ic_name']) ? $v['L_ic_name'] : '',
'ic_name'=> isset($v['L_ic_name']) ? $v['L_ic_name'] : '',
'IsLock'=> $lock_raw==1 ? Plug_Lang('禁止该软件') : Plug_Lang('正常'),
'IsLock_raw'=> $lock_raw,
'links_open'=> $links_open_show,
'links'=> $links_show,
'L_links_open'=> $links_open,
'L_links'=> $links,
'L_class'=> $class_id,
'user_class'=> $user_class,
'vip_unix'=> $vip_fmt,
'vip_unix_raw'=> $vip_raw,
'vip_dian'=> $vip_dian,
'vip_Day'=> $vip_day,
'key_info'=> isset($v['L_key_info']) ? $v['L_key_info'] : '',
'L_key_info'=> isset($v['L_key_info']) ? $v['L_key_info'] : '',
'L_key_max'=> max(1, (int)($v['L_key_max'] ?? 1)),
'bind_keys'=> Plug_Bind_Key_List($v),
'bind_count'=> Plug_Bind_Key_Count($v),
'L_beizhu'=> isset($v['L_beizhu']) ? $v['L_beizhu'] : '',
're_date'=> $this->fmt_day(isset($v['L_re_date']) ? $v['L_re_date'] : ''),
'login_time'=> $this->fmt_login_time(isset($v['L_login_time']) ? $v['L_login_time'] : ''),
'login_ip'=> isset($v['L_login_ip']) ? $v['L_login_ip'] : '',
'L_login_ip'=> isset($v['L_login_ip']) ? $v['L_login_ip'] : '',
'login_region'=> '',
'login_ip_show'=> '',
'L_timing'=> $this->fmt_timing(isset($v['L_timing']) ? $v['L_timing'] : ''),
'L_user_extra'=> isset($v['L_user_extra']) ? $v['L_user_extra'] : '',
'user_extra'=> $extra,
);
$lip=trim((string) $row['login_ip']);
$row['login_region']=$lip !=='' ? Plug_Ip_Region($lip) : '';
$row['login_ip_show']=$lip !=='' ? Plug_Ip_Region_Show($lip) : '';
if (is_array($extra_defs)) {
foreach ($extra_defs as $def) {
if (!is_array($def) || empty($def['key'])) {
continue;
}
$ek=$def['key'];
$row['ue_' . $ek]=isset($extra[$ek]) ? (string) $extra[$ek] : '';
}
}
$list[]=$row;
}
Plug_Print_Json(array(
'code'=> 0,
'msg'=> '',
'count'=> (int) ($cnt['hangshu'] ?? 0),
'data'=> $list,
'meta'=> array(
'moshi'=> $moshi,
'is_point'=> $point ? 1 : 0,
'is_card'=> $card ? 1 : 0,
'app_name'=> isset($app['app_name']) ? $app['app_name'] : '',
),
));
}
function call_detail()
{
Plug_Admin_Assert_Qx('app_1');
$id=(int) Plug_Set_Get('id');
$row=Plug_Query_Array("SELECT * FROM `bs_php_pattern_login` WHERE `L_id`='{$id}' LIMIT 1");
if (!$row) {
Plug_Admin_Fail(Plug_Lang('用户不存在'));
}
$daihao=(int) $row['L_daihao'];
$app=$this->app_moshi($daihao);
$moshi=isset($app['app_MoShi']) ? (string) $app['app_MoShi'] : '';
$class_map=$this->load_class_map($daihao);
$class_id=isset($row['L_class']) ? (int) $row['L_class'] : 0;
$defs=����������������������������������������Y������������������������������������($daihao);
$extra=elseif（��������������������������������������������������������������������������������(isset($row['L_user_extra']) ? (string) $row['L_user_extra'] : '');
$vip_raw=isset($row['L_vip_unix']) ? $row['L_vip_unix'] : 0;
$vip_fmt=is_numeric($vip_raw) ? date('Y-m-d H:i:s', (int) $vip_raw) : (string) $vip_raw;
$login_ip=isset($row['L_login_ip']) ? trim((string) $row['L_login_ip']) : '';
$login_region=$login_ip !=='' ? Plug_Ip_Region($login_ip) : '';
$login_ip_show=$login_ip !=='' ? Plug_Ip_Region_Show($login_ip) : '';
Plug_Admin_Ok('ok', array(
'row'=> $row,
'moshi'=> $moshi,
'is_point'=> $this->is_point_mode($moshi) ? 1 : 0,
'is_card'=> $this->is_card_mode($moshi) ? 1 : 0,
'user_class'=> isset($class_map[$class_id]) ? $class_map[$class_id] : Plug_Lang('未分组'),
'vip_unix'=> $vip_fmt,
'vip_unix_raw'=> $vip_raw,
'vip_dian'=> $vip_raw . Plug_Lang('点'),
'vip_Day'=> $this->fmt_day($vip_fmt),
're_date'=> $this->fmt_day(isset($row['L_re_date']) ? $row['L_re_date'] : ''),
'login_time'=> $this->fmt_login_time(isset($row['L_login_time']) ? $row['L_login_time'] : ''),
'login_ip'=> $login_ip,
'login_region'=> $login_region,
'login_ip_show'=> $login_ip_show,
'L_timing'=> $this->fmt_timing(isset($row['L_timing']) ? $row['L_timing'] : ''),
'IsLock'=> ((int) ($row['L_IsLock'] ?? 0)===1) ? Plug_Lang('禁止该软件') : Plug_Lang('正常'),
'user_extra_defs'=> $defs,
'user_extra'=> $extra,
'L_key_max'=> Plug_Bind_Key_Max($row),
'bind_keys'=> Plug_Bind_Key_List($row),
'bind_count'=> Plug_Bind_Key_Count($row),
));
}
function call_modify()
{
Plug_Admin_Assert_Qx('app_1');
$id=(int) Plug_Set_Get('id');
if ($id <=0) {
$id=(int) Plug_Set_Post('tid');
}
if ($id <=0) {
$id=(int) Plug_Set_Post('L_id');
}
$row=Plug_Query_Array("SELECT * FROM `bs_php_pattern_login` WHERE `L_id`='{$id}' LIMIT 1");
if (!$row) {
Plug_Admin_Fail(Plug_Lang('用户不存在'));
}
$date=Plug_Set_Post('date');
$key=Plug_Set_Post('key');
if ($key==='' && isset($_POST['L_key_info'])) {
$key=Plug_Set_Post('L_key_info');
}
$class_id=Plug_Set_Post('class_id');
if ($class_id==='') {
$class_id=Plug_Set_Post('L_class');
}
$links_open=Plug_Set_Post('L_links_open');
$links=Plug_Set_Post('L_links');
$beizhu=Plug_Set_Post('L_beizhu');
$key_max=Plug_Set_Post('L_key_max');
$vip=$row['L_vip_unix'];
if ($date !=='') {
$vip=is_numeric($date) ? (int) $date : strtotime($date);
}
if ($class_id==='') {
$class_id=$row['L_class'];
}
if ($links_open==='') {
$links_open=$row['L_links_open'];
}
if ($links==='') {
$links=$row['L_links'];
}
if ($beizhu==='' && !isset($_POST['L_beizhu'])) {
$beizhu=$row['L_beizhu'];
}
if ($key_max==='') {
$key_max=isset($row['L_key_max']) ? $row['L_key_max'] : 1;
}
$key_max=max(1, (int) $key_max);
$beizhu_sql=addslashes((string) $beizhu);
Plug_Query("UPDATE `bs_php_pattern_login` SET
`L_vip_unix`='" . (int) $vip . "',
`L_class`='" . (int) $class_id . "',
`L_links_open`='" . addslashes((string) $links_open) . "',
`L_links`='" . addslashes((string) $links) . "',
`L_key_max`='{$key_max}',
`L_beizhu`='{$beizhu_sql}'
WHERE `L_id`='{$id}' LIMIT 1");
$bind_keys=null;
if (isset($_POST['bind_keys'])) {
$raw=$_POST['bind_keys'];
if (is_array($raw)) {
$bind_keys=$raw;
} elseif (is_string($raw) && $raw !=='') {
$decoded=json_decode($raw, true);
if (is_array($decoded)) {
$bind_keys=$decoded;
}
}
}
if ($bind_keys !==null) {
$row2=Plug_Query_Array("SELECT * FROM `bs_php_pattern_login` WHERE `L_id`='{$id}' LIMIT 1");
if ($row2) {
Plug_Bind_Key_Replace($row2, $bind_keys, $key_max);
}
} elseif (isset($_POST['key']) || isset($_POST['L_key_info'])) {
$row2=Plug_Query_Array("SELECT * FROM `bs_php_pattern_login` WHERE `L_id`='{$id}' LIMIT 1");
if ($row2) {
Plug_Bind_Key_Replace($row2, array($key), $key_max);
}
} elseif ((string) Plug_Set_Post('clear_bind_keys')==='1') {
$row2=Plug_Query_Array("SELECT * FROM `bs_php_pattern_login` WHERE `L_id`='{$id}' LIMIT 1");
if ($row2) {
Plug_Bind_Key_Clear($row2);
}
} else {
$remove_key=Plug_Set_Post('remove_bind_key');
if ($remove_key !=='') {
$row2=Plug_Query_Array("SELECT * FROM `bs_php_pattern_login` WHERE `L_id`='{$id}' LIMIT 1");
if ($row2) {
Plug_Bind_Key_Remove($row2, $remove_key);
}
}
}
$daihao=(int) $row['L_daihao'];
$defs=����������������������������������������Y������������������������������������($daihao);
if (count($defs) > 0) {
$old=isset($row['L_user_extra']) ? (string) $row['L_user_extra'] : '';
$json=function（����������������������������������������������������������������������������($defs, $old);
$sql_val=if（������������������������������������������������������������������������������������($json);
Plug_Query("UPDATE `bs_php_pattern_login` SET `L_user_extra`='{$sql_val}' WHERE `L_id`='{$id}' LIMIT 1");
}
Plug_Admin_Ok(Plug_Lang('保存成功'));
}
function call_batch()
{
Plug_Admin_Assert_Qx('app_1');
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
$select=(int) Plug_Set_Post('select_class');
$daihao=(int) Plug_Set_Get('daihao');
if ($all==='') {
Plug_Admin_Fail(Plug_Lang('没有选择记录条目！'));
}
$extra=$daihao > 0 ? " AND `L_daihao`='{$daihao}'" : '';
if ($select==1) {
Plug_Query("DELETE FROM `bs_php_pattern_login` WHERE `L_id` IN ({$all}){$extra}");
Plug_Admin_Ok(Plug_Lang('删除成功'));
}
if ($select==3) {
Plug_Query("UPDATE `bs_php_pattern_login` SET `L_IsLock`='1' WHERE `L_id` IN ({$all}){$extra}");
Plug_Admin_Ok(Plug_Lang('已冻结'));
}
if ($select==4) {
Plug_Query("UPDATE `bs_php_pattern_login` SET `L_IsLock`='0' WHERE `L_id` IN ({$all}){$extra}");
Plug_Admin_Ok(Plug_Lang('已解冻'));
}
Plug_Admin_Fail(Plug_Lang('你没有选择操作项目'));
}
}
