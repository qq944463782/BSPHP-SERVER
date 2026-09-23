<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class CardManageFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
����������������������������������������������������������������::����������������������������N��������������������������������������������������������('applib', 'makecard');
}
function call_table_json()
{
Plug_Admin_Assert_Qx('app_1');
$daihao=(int) Plug_Set_Get('daihao');
if ($daihao <=0) {
Plug_Admin_Fail(Plug_Lang('缺少软件代号'));
}
$app=Plug_Query_Array("SELECT `app_MoShi`,`app_name` FROM `bs_php_appinfo` WHERE `app_daihao`='{$daihao}' LIMIT 1");
$moshi=isset($app['app_MoShi']) ? (string) $app['app_MoShi'] : '';
$is_point=($moshi==='LoginPoint' || $moshi==='CardPoint') ? 1 : 0;
$is_card=($moshi==='CardTerm' || $moshi==='CardPoint') ? 1 : 0;
$type_unit=array(
0=> Plug_Lang('天'),
1=> Plug_Lang('月'),
2=> Plug_Lang('年'),
3=> Plug_Lang('小时'),
4=> Plug_Lang('分钟'),
5=> Plug_Lang('秒/点'),
);
$p=Plug_Admin_Pager();
$soso=Plug_Set_Get('soso');
$soso_id=(int) Plug_Set_Get('soso_id');
$DESC=((int) Plug_Set_Get('DESC')==1) ? 'ASC' : 'DESC';
$where="`car_DaiHao`='{$daihao}'";
if ($soso_id===5) {
$where .=" AND `car_zhuangtai`='1'";
} elseif ($soso_id===6) {
$where .=" AND `car_zhuangtai`='0'";
} elseif ($soso_id===7) {
$where .=" AND `car_IsLock`='0'";
} elseif ($soso_id===8) {
$where .=" AND `car_IsLock`='1'";
} else {
$map=array(
1=> 'car_name',
2=> 'car_reDATE',
3=> 'car_cong_user',
4=> 'car_admin',
9=> 'car_pur_date',
10=> 'car_admin_beizhu',
11=> 'car_agnet_beizhu',
14=> 'car_order',
);
$col=isset($map[$soso_id]) ? $map[$soso_id] : 'car_name';
if ($soso !=='') {
$soso_sql=addslashes($soso);
$where .=" AND `{$col}` LIKE '%{$soso_sql}%'";
}
}
$zt=(int) Plug_Set_Get('zhuangtai');
if ($zt==1) {
$where .=" AND `car_zhuangtai`='0'";
} elseif ($zt==2) {
$where .=" AND `car_zhuangtai`='1'";
}
$on=(int) Plug_Set_Get('on');
if ($on==1) {
$where .=" AND `car_IsLock`='1'";
} elseif ($on==2) {
$where .=" AND `car_IsLock`='0'";
}
$lei=(int) Plug_Set_Get('kalei');
if ($lei <=0) {
$lei=(int) Plug_Set_Get('car_Lei');
}
if ($lei > 0) {
$where .=" AND `car_Lei`='{$lei}'";
}
$cnt=Plug_Query_Array("SELECT count(*) AS hangshu FROM `bs_php_cardseries` WHERE {$where}");
$rs=Plug_Query("SELECT * FROM `bs_php_cardseries` WHERE {$where} ORDER BY `car_id` {$DESC} LIMIT {$p['offset']},{$p['limit']}");
$lei_map=array();
$lrs=Plug_Query("SELECT `lei_id`,`lei_name`,`lei_img`,`lei_beizhu`,`lei_key_max`,`lei_links_open`,`lei_links` FROM `bs_php_kalei` WHERE `lei_daihao`='{$daihao}'");
while ($lv=Plug_Pdo_Fetch_Assoc($lrs)) {
$lei_map[(int) $lv['lei_id']]=$lv;
}
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$used=((int) $v['car_IsLock']===1);
$frozen=((int) $v['car_zhuangtai']===1);
$unit=isset($type_unit[(int) $v['car_type']]) ? $type_unit[(int) $v['car_type']] : $type_unit[0];
$pur=isset($v['car_pur_date']) ? $v['car_pur_date'] : '';
if ($pur==='0000-00-00 00:00:00' || $pur==='1000-12-31 00:00:00') {
$pur='';
}
$chong_uid=isset($v['car_chong_uid']) ? (int) $v['car_chong_uid'] : 0;
$chong_user=isset($v['car_cong_user']) ? (string) $v['car_cong_user'] : '';
$chong_txt=$chong_user . ($chong_uid > 0 ? '(uid:' . $chong_uid . ')' : '');
$pwd=isset($v['car_pwd']) ? (string) $v['car_pwd'] : '';
if ($pwd==='') {
$pwd=Plug_Lang('无');
}
$lei_id=(int) ($v['car_Lei'] ?? 0);
$lei=isset($lei_map[$lei_id]) ? $lei_map[$lei_id] : null;
$v['key']=(int) $v['car_id'];
$v['IsLock']=$used ? Plug_Lang('已使用') : Plug_Lang('未使用');
$v['zhuangtai']=$frozen ? Plug_Lang('冻结') : Plug_Lang('正常');
$v['card_value']=$v['car_TianShu'] . $unit;
$v['make_admin']=isset($v['car_admin']) ? (string) $v['car_admin'] : '';
$v['make_date']=isset($v['car_reDATE']) ? (string) $v['car_reDATE'] : '';
$v['pur_date']=$pur;
$v['chong_txt']=$chong_txt;
$v['car_pwd_show']=$pwd;
$v['moshi']=$moshi;
$v['is_point']=$is_point;
$v['is_card']=$is_card;
$v['lei_id']=$lei_id;
$v['lei_name']=$lei ? (string) ($lei['lei_name'] ?? '') : '';
$v['lei_img']=$lei ? (string) ($lei['lei_img'] ?? '') : '';
$v['lei_beizhu']=$lei ? (string) ($lei['lei_beizhu'] ?? '') : '';
if (!isset($v['car_key_max']) || $v['car_key_max']==='' || $v['car_key_max']===null) {
$v['car_key_max']=$lei ? max(1, (int) ($lei['lei_key_max'] ?? 1)) : 1;
}
if (!isset($v['car_links_open']) || $v['car_links_open']==='' || $v['car_links_open']===null) {
$v['car_links_open']=$lei ? (int) ($lei['lei_links_open'] ?? 0) : 0;
}
if (!isset($v['car_links']) || $v['car_links']==='' || $v['car_links']===null) {
$v['car_links']=$lei ? (int) ($lei['lei_links'] ?? 0) : 0;
}
$list[]=$v;
}
Plug_Print_Json(array(
'code'=> 0,
'msg'=> '',
'count'=> (int) ($cnt['hangshu'] ?? 0),
'data'=> $list,
'meta'=> array(
'moshi'=> $moshi,
'is_point'=> $is_point,
'is_card'=> $is_card,
'app_name'=> isset($app['app_name']) ? $app['app_name'] : '',
),
));
}
function call_detail()
{
Plug_Admin_Assert_Qx('app_1');
$id=(int) Plug_Set_Get('id');
$row=Plug_Query_Array("SELECT * FROM `bs_php_cardseries` WHERE `car_id`='{$id}' LIMIT 1");
if (!$row) {
Plug_Admin_Fail(Plug_Lang('卡不存在!'));
}
Plug_Admin_Ok('ok', $row);
}
function call_carmodify()
{
Plug_Admin_Assert_Qx('app_1');
$carid=(int) Plug_Set_Post('carid');
if ($carid <=0) {
$carid=(int) Plug_Set_Get('id');
}
if ($carid <=0) {
Plug_Admin_Fail(Plug_Lang('参数错误'));
}
$admin_bz=Plug_Set_Post('car_admin_beizhu');
$agent_bz=Plug_Set_Post('car_agnet_beizhu');
Plug_Query("UPDATE `bs_php_cardseries` SET `car_admin_beizhu`='{$admin_bz}',`car_agnet_beizhu`='{$agent_bz}' WHERE `car_id`='{$carid}' LIMIT 1");
Plug_Admin_Ok(Plug_Lang('属性已经修改成功。!'));
}
function call_make()
{
Plug_Admin_Assert_Qx('app_1');
$lei=(int) Plug_Set_Post('select');
$num=(int) Plug_Set_Post('shulian');
$beizhu=Plug_Set_Post('car_admin_beizhu');
$sale=(int) Plug_Set_Post('car_sale_flag');
if ($sale < 0 || $sale > 2) {
$sale=0;
}
$agent=Plug_Set_Post('agnet_id');
$make_type=Plug_Set_Post('make_type');
if ($make_type==='') {
$make_type='auto';
}
if ($agent==='') {
$agent=$this->admin_array['Admin_AdminUserName'];
}
if ($lei <=0) {
Plug_Admin_Fail(Plug_Lang('请选择你制作类型!'));
}
$cards_list=array();
if ($make_type==='import') {
$import=isset($_POST['import_cards']) ? $_POST['import_cards'] : Plug_Set_Post('import_cards');
if ($import==='') {
Plug_Admin_Fail(Plug_Lang('请输入要导入的卡内容!'));
}
$import=str_replace(array("\r\n", "\r"), "\n", $import);
foreach (explode("\n", $import) as $line) {
$line=trim($line);
if ($line==='') {
continue;
}
$parts=explode('|', $line, 2);
$ka=trim($parts[0]);
$mi=isset($parts[1]) ? trim($parts[1]) : '';
if ($ka==='') {
continue;
}
$cards_list[]=array($ka, $mi);
}
$num=count($cards_list);
if ($num <=0) {
Plug_Admin_Fail(Plug_Lang('未识别到有效的卡号, 每行格式: 卡号 或 卡号|密码'));
}
$ret=������������������������������������������������������������������������($cards_list, $lei, $agent, '', -10, $beizhu, '', $sale, '');
} else {
if ($num <=0) {
Plug_Admin_Fail(Plug_Lang('请输入制作数量,建议1-500张一次!'));
}
$ret=Plug_ZhiZuoC($num, $lei, $agent, '', -10, $beizhu, '', $sale, '');
}
if ($ret===0 || $ret===false || $ret===null || $ret==='') {
Plug_Admin_Fail(Plug_Lang('制卡失败'));
}
Plug_Add_AppenLog('agent_ka_log', Plug_Lang('后台制卡') . " lei:{$lei} num:{$num}", $this->admin_array['Admin_AdminUserName']);
Plug_Admin_Ok(Plug_Lang('制卡成功'), array(
'make_date'=> $ret,
'lei_id'=> $lei,
'count'=> $num,
'make_type'=> $make_type,
));
}
function call_makeshow()
{
Plug_Admin_Assert_Qx('app_1');
$daihao=(int) Plug_Set_Get('daihao');
if ($daihao <=0) {
$daihao=(int) Plug_Set_Post('daihao');
}
$app=Plug_Query_Array("SELECT `app_name`,`app_daihao` FROM `bs_php_appinfo` WHERE `app_daihao`='{$daihao}' LIMIT 1");
if (!$app) {
Plug_Admin_Fail(Plug_Lang('软件不存在!'));
}
$soso=Plug_Set_Post('soso');
if ($soso==='') {
$soso=Plug_Set_Get('soso');
}
$soso_id=(int) Plug_Set_Post('soso_id');
if ($soso_id <=0) {
$soso_id=(int) Plug_Set_Get('soso_id');
}
$css=Plug_Set_Post('css');
if ($css==='') {
$css='卡号:{KAID} 密码:{KAPWD} 状态:{APPSDATES} 时间:{APPTIME} 软件:{APPNAME}';
}
$DESC=((int) Plug_Set_Post('DESC')==1 || (int) Plug_Set_Get('DESC')==1) ? 'ASC' : 'DESC';
$map=array(
1=> 'car_name',
2=> 'car_reDATE',
3=> 'car_cong_user',
4=> 'car_admin',
5=> 'car_zhuangtai',
6=> 'car_zhuangtai',
7=> 'car_IsLock',
8=> 'car_IsLock',
9=> 'car_TianShu',
);
$col=isset($map[$soso_id]) ? $map[$soso_id] : 'car_name';
if ($soso_id==5) {
$soso='1';
} elseif ($soso_id==6) {
$soso='0';
} elseif ($soso_id==7) {
$soso='0';
} elseif ($soso_id==8) {
$soso='1';
}
if ($soso_id==2) {
$sql="SELECT * FROM `bs_php_cardseries` WHERE `car_DaiHao`='{$daihao}' AND `{$col}` LIKE '{$soso}' ORDER BY `car_id` {$DESC} LIMIT 20000";
} else {
$sql="SELECT * FROM `bs_php_cardseries` WHERE `car_DaiHao`='{$daihao}' AND `{$col}` LIKE '%{$soso}%' ORDER BY `car_id` {$DESC} LIMIT 20000";
}
$rs=Plug_Query($sql);
$lines=array();
$rows=array();
$langs=array();
if (class_exists('����������������������������������������������������������������') && method_exists('����������������������������������������������������������������', '��������������������������������������������������������������������')) {
$langs=����������������������������������������������������������������::��������������������������������������������������������������������('applib', 'admin_card');
}
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$used=((int) $v['car_IsLock']==1) ? Plug_Lang('已使用') : Plug_Lang('未使用');
$zt=((int) $v['car_zhuangtai']==1) ? Plug_Lang('冻结') : Plug_Lang('正常');
$type_txt=isset($langs[$v['car_type']]) ? $langs[$v['car_type']] : $v['car_type'];
$pur=isset($v['car_pur_date']) ? $v['car_pur_date'] : '';
if ($pur==='1000-12-31 00:00:00' || $pur==='0000-00-00 00:00:00') {
$pur='';
}
$row=array(
'KAID'=> $v['car_name'],
'KAPWD'=> $v['car_pwd'],
'APPSDATES'=> $used,
'APPTIME'=> $v['car_TianShu'] . $type_txt,
'APPNAME'=> $app['app_name'],
'CARSTATUS'=> $zt,
'CARREdate'=> $v['car_reDATE'],
'CARADMIN'=> $v['car_admin'],
'CARUSER'=> $v['car_cong_user'],
'CARPURDATE'=> $pur,
'CARBEIZHU'=> $v['car_admin_beizhu'],
'CARAGENTBEIZHU'=> $v['car_agnet_beizhu'],
);
$s=$css;
foreach ($row as $k=> $val) {
$s=str_replace('{' . $k . '}', $val, $s);
}
$rows[]=$row;
$lines[]=$s;
}
Plug_Admin_Ok('ok', array(
'count'=> count($lines),
'text'=> implode("\n", $lines),
'lines'=> $lines,
'rows'=> $rows,
'app_name'=> $app['app_name'],
));
}
function call_batch()
{
Plug_Admin_Assert_Qx('app_1');
$daihao=(int) Plug_Set_Get('daihao');
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
$select=(int) Plug_Set_Post('select_class');
if ($all==='') {
Plug_Admin_Fail(Plug_Lang('没有选择记录条目！'));
}
$extra=$daihao > 0 ? " AND `car_DaiHao`='{$daihao}'" : '';
if ($select==1) {
Plug_Query("DELETE FROM `bs_php_cardseries` WHERE `car_id` IN ({$all}){$extra}");
Plug_Admin_Ok(Plug_Lang('你选择卡串已经删除!!'));
}
if ($select==2) {
Plug_Query("UPDATE `bs_php_cardseries` SET `car_BaoJi`='1' WHERE `car_id` IN ({$all}){$extra}");
Plug_Admin_Ok(Plug_Lang('你选卡串号已经标记!'));
}
if ($select==3) {
Plug_Query("UPDATE `bs_php_cardseries` SET `car_BaoJi`='0' WHERE `car_id` IN ({$all}){$extra}");
Plug_Admin_Ok(Plug_Lang('你选择卡串已经取消标记!'));
}
if ($select==4) {
$now=date('Y-m-d H:i:s');
Plug_Query("UPDATE `bs_php_cardseries` SET `car_IsLock`='1',`car_pur_date`='{$now}' WHERE `car_id` IN ({$all}){$extra}");
Plug_Admin_Ok(Plug_Lang('你选择卡串已设已经使!'));
}
if ($select==5) {
Plug_Query("UPDATE `bs_php_cardseries` SET `car_IsLock`='0' WHERE `car_id` IN ({$all}){$extra}");
Plug_Admin_Ok(Plug_Lang('你选择卡串已经设未使用!'));
}
if ($select==6) {
Plug_Query("UPDATE `bs_php_cardseries` SET `car_zhuangtai`='1' WHERE `car_id` IN ({$all}){$extra}");
Plug_Admin_Ok(Plug_Lang('你选择卡串已冻结!'));
}
if ($select==7) {
Plug_Query("UPDATE `bs_php_cardseries` SET `car_zhuangtai`='0' WHERE `car_id` IN ({$all}){$extra}");
Plug_Admin_Ok(Plug_Lang('你选择卡串已解冻!'));
}
if ($select==9) {
$rs=Plug_Query("SELECT * FROM `bs_php_cardseries` WHERE `car_id` IN ({$all})");
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
Plug_Query("UPDATE `bs_php_pattern_login` SET `L_IsLock`='1' WHERE `L_daihao`='{$v['car_DaiHao']}' AND (`L_User_uid`='{$v['car_chong_uid']}' OR `L_User_uid`='{$v['car_name']}')");
}
Plug_Query("UPDATE `bs_php_cardseries` SET `car_zhuangtai`='1' WHERE `car_id` IN ({$all}){$extra}");
Plug_Admin_Ok(Plug_Lang('功能已经执行，对应充值应用下账号也执行相同操作,没有充值的将忽略!'));
}
if ($select==10) {
$rs=Plug_Query("SELECT * FROM `bs_php_cardseries` WHERE `car_id` IN ({$all})");
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
Plug_Query("UPDATE `bs_php_pattern_login` SET `L_IsLock`='0' WHERE `L_daihao`='{$v['car_DaiHao']}' AND (`L_User_uid`='{$v['car_chong_uid']}' OR `L_User_uid`='{$v['car_name']}')");
}
Plug_Query("UPDATE `bs_php_cardseries` SET `car_zhuangtai`='0' WHERE `car_id` IN ({$all}){$extra}");
Plug_Admin_Ok(Plug_Lang('功能已经执行，对应充值应用下账号也执行相同操作,没有充值的将忽略!'));
}
if ($select==11) {
$rs=Plug_Query("SELECT * FROM `bs_php_cardseries` WHERE `car_id` IN ({$all})");
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
Plug_Query("DELETE FROM `bs_php_pattern_login` WHERE `L_daihao`='{$v['car_DaiHao']}' AND (`L_User_uid`='{$v['car_chong_uid']}' OR `L_User_uid`='{$v['car_name']}')");
}
Plug_Query("DELETE FROM `bs_php_cardseries` WHERE `car_id` IN ({$all}){$extra}");
Plug_Admin_Ok(Plug_Lang('功能已经执行，对应充值应用下账号也执行相同操作,没有充值的将忽略!'));
}
if ($select==12) {
$txt=Plug_Set_Post('txt');
Plug_Query("UPDATE `bs_php_cardseries` SET `car_admin_beizhu`='{$txt}' WHERE `car_id` IN ({$all}){$extra}");
Plug_Admin_Ok(Plug_Lang('修改成功 '));
}
Plug_Admin_Fail(Plug_Lang('你没有选择操作项目'));
}
}
