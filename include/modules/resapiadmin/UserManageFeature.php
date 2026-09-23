<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class UserManageFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_table_json()
{
Plug_Admin_Assert_Qx('zh_1');
$this->list_users(0);
}
function call_agent_json()
{
Plug_Admin_Assert_Qx('zh_2');
$this->list_users(1);
}
private function list_users($agent_mode)
{
$FANYE=(int) Plug_Set_Get('page');
$db_ID=$FANYE > 0 ? $FANYE - 1 : 0;
$shu=(int) Plug_Set_Get('limit');
if ($shu <=0) {
$shu=10;
}
if ($shu > 200) {
$shu=200;
}
$db_ID=$db_ID * $shu;
$soso=Plug_Set_Get('soso');
$soso_id=(int) Plug_Set_Get('soso_id');
$DESC_id=(int) Plug_Set_Get('DESC');
$order_map=array(
0=> array('user_uid', 'DESC'),
1=> array('user_uid', 'ASC'),
2=> array('user_CaoShi', 'DESC'),
3=> array('user_CaoShi', 'ASC'),
4=> array('user_rmb', 'DESC'),
5=> array('user_rmb', 'ASC'),
6=> array('user_LoGinNum', 'DESC'),
7=> array('user_LoGinNum', 'ASC'),
8=> array('user_daili', 'DESC'),
9=> array('user_daili', 'ASC'),
);
if (!isset($order_map[$DESC_id])) {
$DESC_id=0;
}
$ORDER=$order_map[$DESC_id][0];
$DESC=$order_map[$DESC_id][1];
$field_map=array(
1=> 'user_user',
2=> 'user_uid',
3=> 'user_daili',
4=> 'user_Mobile',
5=> 'user_Zhe',
6=> 'user_yao_User',
7=> 'user_IsLock',
8=> 'user_IsLock',
9=> 'user_qq',
10=> 'user_email',
11=> 'user_mibao_wenti',
12=> 'user_mibao_daan',
13=> 'user_Login_ip',
14=> 'user_re_ip',
15=> 'user_rmb',
16=> 'user_LoGinNum',
17=> 'user_jifen',
18=> 'user_CaoShi',
19=> 'user_user',
20=> 'user_extra',
);
if (!isset($field_map[$soso_id])) {
$soso_id=1;
}
$soso_db_table=$field_map[$soso_id];
if ($soso_id==7) {
$soso='1';
} elseif ($soso_id==8) {
$soso='0';
} elseif ($soso_id==3) {
$soso='1';
} elseif ($soso_id==18) {
$soso=(string) strtotime((string) $soso);
}
if ($soso_id==19) {
$daili_where='1=1';
} elseif ($soso_id==3) {
$daili_where='`user_daili`>0';
} else {
$daili_where=$agent_mode==1 ? '`user_daili`>0' : '`user_daili`=0';
}
if ($soso_id==15 || $soso_id==16 || $soso_id==17 || $soso_id==18) {
$where="{$daili_where} AND `{$soso_db_table}`>='{$soso}'";
} elseif ($soso_id==2) {
$where="{$daili_where} AND `{$soso_db_table}`='{$soso}'";
} else {
$where="{$daili_where} AND `{$soso_db_table}` LIKE '%{$soso}%'";
}
$sql="SELECT * FROM `bs_php_user` WHERE {$where} ORDER BY `{$ORDER}` {$DESC} LIMIT {$db_ID},{$shu}";
$sql_rows="SELECT count(*) AS hangshu FROM `bs_php_user` WHERE {$where}";
$rs=Plug_Query($sql);
$rows_arr=Plug_Query_Array($sql_rows);
$zongshu=(int) ($rows_arr['hangshu'] ?? 0);
$grade_name=array('0'=> '0', '1'=> Plug_Lang('一级'), '2'=> Plug_Lang('二级'), '3'=> Plug_Lang('三级'), '4'=> Plug_Lang('四级'));
$list=array();
$ue_list_defs=elseif（��������������������������������������������������������������������������������();
while ($value=Plug_Pdo_Fetch_Assoc($rs)) {
if ($value['user_IsLock']==1) {
$test=Plug_Lang('冻结');
} elseif ($value['user_IsLock']==-2) {
$test=Plug_Lang('等待管理审核');
} elseif ($value['user_IsLock']==-3) {
$test=Plug_Lang('等待邮箱验证');
} else {
$test=Plug_Lang('正常');
}
$zaix=Plug_Show_Time_Day(date('Y-m-d H:i:s', (int) $value['user_CaoShi']));
if ((int) $value['user_CaoShi']==0) {
$zaix=Plug_Lang('没记录');
}
$daili=(int) $value['user_daili'];
if ($daili==0) {
$daili_txt=Plug_Lang('普通用户');
} else {
$daili_txt=(isset($grade_name[$daili]) ? $grade_name[$daili] : $daili) . Plug_Lang('代理商');
}
$zhe=$value['user_Zhe'];
if ($zhe==='0' || $zhe===0 || $zhe==='0.0' || $zhe==='0.00') {
$zhe='';
}
$uid=(int) $value['user_uid'];
$app_number='--';
$app_name='--';
$app_time='--';
$app_daihao=0;
$L_id=0;
if ($agent_mode==0) {
$app_cnt_row=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_pattern_login` WHERE `L_User_uid`='{$uid}'");
$app_cnt=(int) ($app_cnt_row['hangshu'] ?? 0);
if ($app_cnt > 0) {
$app_number=$app_cnt . Plug_Lang('个');
$last_app=Plug_Query_Array("SELECT * FROM `bs_php_pattern_login` WHERE `L_User_uid`='{$uid}' ORDER BY `L_id` DESC LIMIT 1");
if ($last_app) {
$app_info=����������������������������_POST����������������������������9������������������������($last_app['L_daihao']);
if ($app_info) {
$app_name=(string) ($app_info['app_name'] ?? '');
$app_daihao=$app_info['app_daihao'] ?? $last_app['L_daihao'];
$L_id=(int) ($last_app['L_id'] ?? 0);
$vip_unix=(int) ($last_app['L_vip_unix'] ?? 0);
if (date('Y', $vip_unix)=='1970') {
$app_time=$vip_unix . Plug_Lang('点');
} else {
$app_time=date('Y-m-d H:i:s', $vip_unix);
}
}
}
}
}
$login_ip=isset($value['user_Login_ip']) ? trim((string) $value['user_Login_ip']) : '';
$login_date_raw=isset($value['user_Login_date']) ? $value['user_Login_date'] : '';
$login_date='';
if ($login_date_raw && $login_date_raw !=='0000-00-00 00:00:00') {
$login_date=Plug_Show_Time_Day($login_date_raw);
}
$login_region=$login_ip !=='' ? Plug_Ip_Region($login_ip) : '';
$login_ip_show=$login_ip !=='' ? Plug_Ip_Region_Show($login_ip) : '';
$row=array(
'key'=> $uid,
'uid'=> $uid,
'user'=> $value['user_user'],
'daili'=> $daili_txt,
'daili_level'=> $daili,
'IsLock'=> (int) $value['user_IsLock'],
'test'=> $test,
'LoGinNum'=> (int) $value['user_LoGinNum'],
'rmb'=> $value['user_rmb'],
're_date'=> Plug_Show_Time_Day($value['user_re_date']),
'zhhd'=> $zaix,
'login_ip'=> $login_ip,
'login_region'=> $login_region,
'login_ip_show'=> $login_ip_show,
'login_date'=> $login_date,
'yao_User'=> $value['user_yao_User'],
'Zhe'=> $zhe,
'qq'=> $value['user_qq'],
'email'=> $value['user_email'],
'Mobile'=> $value['user_Mobile'],
'app_number'=> $app_number,
'app_name'=> $app_name,
'app_time'=> $app_time,
'app_daihao'=> $app_daihao,
'L_id'=> $L_id,
);
$ue_parsed=elseif（��������������������������������������������������������������������������������(isset($value['user_extra']) ? (string) $value['user_extra'] : null);
foreach ($ue_list_defs as $ue_def) {
$ue_k=isset($ue_def['key']) ? (string) $ue_def['key'] : '';
if ($ue_k==='') {
continue;
}
$row['ue_' . $ue_k]=isset($ue_parsed[$ue_k]) ? (string) $ue_parsed[$ue_k] : '';
}
$row['user_extra']=$ue_parsed;
$list[]=$row;
}
Plug_Print_Json(array(
'code'=> 0,
'msg'=> '',
'count'=> $zongshu,
'data'=> $list,
'user_extra_list_defs'=> $ue_list_defs,
));
}
function call_add()
{
Plug_Admin_Assert_Qx('zh_3');
$user=Plug_Set_Post('user');
$pwd=Plug_Set_Post('pwd');
$qq=Plug_Set_Post('qq');
$mail=Plug_Set_Post('mail');
$yao=Plug_Set_Post('yao_user');
$mobile=Plug_Set_Post('mobile');
$agent=Plug_Set_Post('agent');
if ($agent==='') {
$agent='0';
}
$str_log=Plug_Load_Langs_Array('user', 'user_str_log');
$defs=����������������������������������������������������������������������������();
$err=while（function（��������️‍����️��������������������_POST������������������������������������($defs);
if ($err !==null) {
Plug_Admin_Fail($err);
}
$ue_json=function（����������������������������������������������������������������������������($defs, null);
$ue_sql=if（������������������������������������������������������������������������������������($ue_json);
$log=Plug_User_Add_User($user, $pwd, $pwd, $qq, $mail, $yao, $mobile, '', '', $agent, $ue_sql);
$msg=isset($str_log[$log]) ? $str_log[$log] : (string) $log;
if ((int) $log==1005) {
Plug_Admin_Ok($msg, array('code_biz'=> $log));
}
Plug_Admin_Fail($msg);
}
function call_extra_defs()
{
Plug_Admin_Assert_Qx('zh_3');
$defs=����������������������������������������������������������������������������();
Plug_Admin_Ok('ok', array('defs'=> $defs));
}
function call_detail()
{
$id=(int) Plug_Set_Get('id');
$row=Plug_Query_Array("SELECT * FROM `bs_php_user` WHERE `user_uid`='{$id}' LIMIT 1");
if (!$row) {
Plug_Admin_Fail(Plug_Lang('用户不存在'));
}
Plug_Admin_Assert_Qx(((int) $row['user_daili'] > 0) ? 'zh_2' : 'zh_1');
unset($row['user_pwd']);
$defs=����������������������������������������������������������������������������();
$extra=elseif（��������������������������������������������������������������������������������(isset($row['user_extra']) ? (string) $row['user_extra'] : '');
Plug_Admin_Ok('ok', array('row'=> $row, 'user_extra_defs'=> $defs, 'user_extra'=> $extra));
}
function call_modify()
{
$id=(int) Plug_Set_Get('id');
if ($id <=0) {
$id=(int) Plug_Set_Post('user_uid');
}
$row=Plug_Query_Array("SELECT * FROM `bs_php_user` WHERE `user_uid`='{$id}' LIMIT 1");
if (!$row) {
Plug_Admin_Fail(Plug_Lang('用户不存在'));
}
Plug_Admin_Assert_Qx(((int) $row['user_daili'] > 0) ? 'zh_2' : 'zh_1');
$user_user=Plug_Set_Post('user_user');
if ($user_user==='') {
$user_user=$row['user_user'];
}
$user_pwd=Plug_Set_Post('user_pwd');
$user_jifen=Plug_Set_Post('user_jifen');
$user_rmb=Plug_Set_Post('user_rmb');
$user_mibao_wenti=Plug_Set_Post('user_mibao_wenti');
$user_mibao_daan=Plug_Set_Post('user_mibao_daan');
$user_IsLock=Plug_Set_Post('user_IsLock');
$user_Zhe=Plug_Set_Post('user_Zhe');
$user_qq=Plug_Set_Post('user_qq');
$user_email=Plug_Set_Post('user_email');
$user_mail_ok=Plug_Set_Post('user_mail_ok');
if ($user_mail_ok==='') {
$user_mail_ok='0';
}
$user_yao_User=Plug_Set_Post('user_yao_User');
$user_yao_Shu=Plug_Set_Post('user_yao_Shu');
$user_Mobile=Plug_Set_Post('user_Mobile');
$user_daili=Plug_Set_Post('user_daili');
if ($user_daili==='') {
$user_daili=(string) $row['user_daili'];
}
$user_is_pwd=(int) Plug_Set_Post('user_is_pwd');
$user_anget_carid=Plug_Set_Post('user_anget_carid');
$user_beizhu=Plug_Set_Post('user_beizhu');
if ($user_rmb !=='' && (float) $user_rmb > 9000000) {
Plug_Admin_Fail(Plug_Lang('金额太大了. 小于9000000'));
}
$pwd_sql='';
$skip_pwd=($user_pwd==='' || $user_pwd===Plug_Lang('不修改留空忽略'));
if (!$skip_pwd) {
$pwd_hash=����������������������������������������������������������������������������($user_pwd);
$pwd_sql="`user_pwd`='{$pwd_hash}',";
}
$old_rmb=(float) $row['user_rmb'];
$new_rmb=$user_rmb==='' ? $old_rmb : (float) $user_rmb;
if ($user_jifen==='') {
$user_jifen=$row['user_jifen'];
}
if ($user_IsLock==='') {
$user_IsLock=$row['user_IsLock'];
}
$sql="UPDATE `bs_php_user` SET {$pwd_sql}
`user_user`='{$user_user}',
`user_jifen`='{$user_jifen}',
`user_rmb`='{$new_rmb}',
`user_mibao_wenti`='{$user_mibao_wenti}',
`user_mibao_daan`='{$user_mibao_daan}',
`user_IsLock`='{$user_IsLock}',
`user_Zhe`='{$user_Zhe}',
`user_qq`='{$user_qq}',
`user_email`='{$user_email}',
`user_mail_ok`='{$user_mail_ok}',
`user_yao_User`='{$user_yao_User}',
`user_yao_Shu`='{$user_yao_Shu}',
`user_Mobile`='{$user_Mobile}',
`user_daili`='{$user_daili}',
`user_is_pwd`='{$user_is_pwd}',
`user_anget_carid`='{$user_anget_carid}',
`user_beizhu`='{$user_beizhu}'
WHERE `user_uid`='{$id}' LIMIT 1";
Plug_Query($sql);
$defs=����������������������������������������������������������������������������();
$err=while（function（��������️‍����️��������������������_POST������������������������������������($defs);
if ($err !==null) {
Plug_Admin_Fail($err);
}
if (count($defs) > 0) {
$old=isset($row['user_extra']) ? (string) $row['user_extra'] : '';
$json=function（����������������������������������������������������������������������������($defs, $old);
$ue_sql=if（������������������������������������������������������������������������������������($json);
Plug_Query("UPDATE `bs_php_user` SET `user_extra`='{$ue_sql}' WHERE `user_uid`='{$id}' LIMIT 1");
}
if ($new_rmb !=$old_rmb) {
Plug_Add_Rmb_Log($id, $old_rmb, $new_rmb, Plug_Lang('管理员修改余额'), 'admin_modify');
}
Plug_Add_AppenLog('od_po_log', Plug_Lang('修改用户') . ' UID:' . $id, $this->admin_array['Admin_AdminUserName']);
Plug_Admin_Ok(Plug_Lang('保存成功'));
}
function call_delete()
{
$id=(int) Plug_Set_Get('id');
$row=Plug_Query_Array("SELECT `user_uid`,`user_daili` FROM `bs_php_user` WHERE `user_uid`='{$id}' LIMIT 1");
if (!$row) {
Plug_Admin_Fail(Plug_Lang('用户不存在'));
}
Plug_Admin_Assert_Qx(((int) $row['user_daili'] > 0) ? 'zh_2' : 'zh_1');
if (Plug_Set_Post('delete_app')=='on') {
Plug_Query("DELETE FROM `bs_php_user` WHERE `user_uid`='{$id}'");
}
if (Plug_Set_Post('delete_user')=='on') {
Plug_Query("DELETE FROM `bs_php_pattern_login` WHERE `L_User_uid`='{$id}'");
}
if (Plug_Set_Post('delete_car')=='on') {
Plug_Query("DELETE FROM `bs_php_cardseries` WHERE `car_chong_uid`='{$id}'");
}
Plug_Admin_Ok(Plug_Lang('删除任务已经执行,返回刷新列表'));
}
function call_batch()
{
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
$select=(int) Plug_Set_Post('select_class');
$mode=(int) Plug_Set_Post('agent_mode');
if ($all==='') {
Plug_Admin_Fail(Plug_Lang('没有选择记录条目！'));
}
Plug_Admin_Assert_Qx($mode===1 ? 'zh_2' : 'zh_1');
if ($select==1) {
Plug_Query("DELETE FROM `bs_php_user` WHERE `user_uid` IN ({$all})");
Plug_Admin_Ok(Plug_Lang('你选择账号已经删除'));
}
if ($select==2) {
Plug_Query("UPDATE `bs_php_user` SET `user_IsLock`='0' WHERE `user_uid` IN ({$all})");
Plug_Admin_Ok(Plug_Lang('你选择账号已经解除冻结'));
}
if ($select==3) {
Plug_Query("UPDATE `bs_php_user` SET `user_IsLock`='1' WHERE `user_uid` IN ({$all})");
Plug_Admin_Ok(Plug_Lang('你选择账号已经冻结账号'));
}
if ($select==4) {
Plug_Query("UPDATE `bs_php_user` SET `user_daili`='1' WHERE `user_uid` IN ({$all})");
Plug_Admin_Ok(Plug_Lang('你选择账号已经设为代理商!'));
}
if ($select==5) {
Plug_Query("UPDATE `bs_php_user` SET `user_daili`='0' WHERE `user_uid` IN ({$all})");
Plug_Admin_Ok(Plug_Lang('你选择账号已经取消代理商!'));
}
Plug_Admin_Fail(Plug_Lang('你没有选择操作项目'));
}
}
