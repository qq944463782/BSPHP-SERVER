<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class CardTypeFeature
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
$where=$daihao > 0 ? "`lei_daihao`='{$daihao}'" : '1=1';
$moshi='';
if ($daihao > 0) {
$app=Plug_Query_Array("SELECT `app_MoShi` FROM `bs_php_appinfo` WHERE `app_daihao`='{$daihao}' LIMIT 1");
if ($app && isset($app['app_MoShi'])) {
$moshi=$app['app_MoShi'];
}
}
$moshi_map=array();
if ($daihao <=0) {
$ars=Plug_Query("SELECT `app_daihao`,`app_MoShi` FROM `bs_php_appinfo`");
while ($a=Plug_Pdo_Fetch_Assoc($ars)) {
$moshi_map[$a['app_daihao']]=$a['app_MoShi'];
}
}
$rs=Plug_Query("SELECT * FROM `bs_php_kalei` WHERE {$where} ORDER BY `lei_sort` ASC,`lei_id` ASC");
$class_map=array();
$crs=Plug_Query("SELECT `class_id`,`class_name` FROM `bs_php_userclass`" . ($daihao > 0 ? " WHERE `class_daihao`='{$daihao}'" : ''));
while ($cv=Plug_Pdo_Fetch_Assoc($crs)) {
$class_map[(int) $cv['class_id']]=(string) ($cv['class_name'] ?? '');
}
$charset=array(
0=> Plug_Lang('默认数字+大写+小写组合'),
1=> Plug_Lang('数字加大写字母'),
2=> Plug_Lang('数字加小写字母'),
3=> Plug_Lang('大小写字母'),
4=> Plug_Lang('全部大写字母'),
5=> Plug_Lang('全部小写字母'),
6=> Plug_Lang('全部数字'),
);
$list=array();
$n=0;
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$m=$moshi !=='' ? $moshi : (isset($moshi_map[$v['lei_daihao']]) ? $moshi_map[$v['lei_daihao']] : '');
$v['lei_unit']=Plug_Card_Type_Unit($v['lei_type'], $m);
$v['lei_date_label']=Plug_Card_Type_Date_Label($v['lei_date'], $v['lei_type'], $m);
$v['app_moshi']=$m;
$cid=(int) ($v['lei_class'] ?? 0);
$v['lei_class_name']=$cid > 0 && isset($class_map[$cid]) ? $class_map[$cid] : Plug_Lang('未分组');
$cs=(int) ($v['lei_cardset'] ?? 0);
$ps=(int) ($v['lei_pwdset'] ?? 0);
$v['lei_cardset_label']=isset($charset[$cs]) ? $charset[$cs] : $charset[0];
$v['lei_pwdset_label']=isset($charset[$ps]) ? $charset[$ps] : $charset[0];
$list[]=$v;
$n++;
}
Plug_Admin_List_Json($list, $n);
}
function call_detail()
{
Plug_Admin_Assert_Qx('app_1');
$id=(int) Plug_Set_Get('id');
$row=Plug_Query_Array("SELECT * FROM `bs_php_kalei` WHERE `lei_id`='{$id}' LIMIT 1");
if (!$row) {
Plug_Admin_Fail(Plug_Lang('卡类型不存在'));
}
Plug_Admin_Ok('ok', $row);
}
private function read_fields()
{
$ka_name=Plug_Set_Post('ka_name');
if ($ka_name==='') {
$ka_name=Plug_Set_Post('lei_name');
}
$ka_date=Plug_Set_Post('ka_date');
if ($ka_date==='') {
$ka_date=Plug_Set_Post('lei_date');
}
$ka_jiage=Plug_Set_Post('ka_jiage');
if ($ka_jiage==='') {
$ka_jiage=Plug_Set_Post('lei_jiage');
}
$ka_dai=Plug_Set_Post('ka_dai');
if ($ka_dai==='') {
$ka_dai=Plug_Set_Post('lei_daili');
}
$ka_ktzf=Plug_Set_Post('ka_ktzf');
if ($ka_ktzf==='') {
$ka_ktzf=Plug_Set_Post('lei_ktzf');
}
$lei_type=Plug_Set_Post('lei_type');
$car_weight=(int) Plug_Set_Post('car_weight');
if (isset($_POST['lei_weight'])) {
$car_weight=(int) Plug_Set_Post('lei_weight');
}
$car_class=Plug_Set_Post('car_class');
if ($car_class==='') {
$car_class=Plug_Set_Post('lei_class');
}
if ($car_class==='') {
$car_class='0';
}
$lei_cardint=(int) Plug_Set_Post('lei_cardint');
if ($lei_cardint==0) {
$lei_cardint=25;
}
$lei_cardset=(int) Plug_Set_Post('lei_cardset');
$lei_pwdint=(int) Plug_Set_Post('lei_pwdint');
$lei_pwdset=(int) Plug_Set_Post('lei_pwdset');
$lei_for=(int) Plug_Set_Post('lei_for');
if ($lei_for==0) {
$lei_for=1;
}
$lei_for_id=(int) Plug_Set_Post('lei_for_id');
$lei_money=Plug_Set_Post('lei_money');
if ($lei_money==='') {
$lei_money='0';
}
$lei_links_open=(int) Plug_Set_Post('lei_links_open');
$lei_links=(int) Plug_Set_Post('lei_links');
$lei_key_max=(int) Plug_Set_Post('lei_key_max');
if ($lei_key_max < 1) {
$lei_key_max=1;
}
$lei_sort=(int) Plug_Set_Post('lei_sort');
if ($lei_sort < 0) {
$lei_sort=0;
}
$lei_img=Plug_Set_Post('lei_img');
$lei_beizhu=Plug_Set_Post('lei_beizhu');
return compact(
'ka_name', 'ka_date', 'ka_jiage', 'ka_dai', 'ka_ktzf', 'lei_type',
'car_weight', 'car_class', 'lei_cardint', 'lei_cardset', 'lei_pwdint', 'lei_pwdset',
'lei_for', 'lei_for_id', 'lei_money', 'lei_links_open', 'lei_links', 'lei_key_max', 'lei_sort', 'lei_img', 'lei_beizhu'
);
}
function call_add()
{
Plug_Admin_Assert_Qx('app_1');
$daihao=(int) Plug_Set_Get('daihao');
if ($daihao <=0) {
$daihao=(int) Plug_Set_Post('daihao');
}
if ($daihao <=0) {
$daihao=(int) Plug_Set_Post('lei_daihao');
}
$f=$this->read_fields();
if ($f['ka_name']==='') {
Plug_Admin_Fail(Plug_Lang('名称不能为空'));
}
$chk=Plug_Query_Array("SHOW COLUMNS FROM `bs_php_kalei` WHERE Field='lei_beizhu'");
if (!$chk) {
Plug_Query("ALTER TABLE `bs_php_kalei` ADD `lei_beizhu` VARCHAR(500) NULL DEFAULT NULL COMMENT '卡类备注' AFTER `lei_name`");
}
$chk=Plug_Query_Array("SHOW COLUMNS FROM `bs_php_kalei` WHERE Field='lei_img'");
if (!$chk) {
Plug_Query("ALTER TABLE `bs_php_kalei` ADD `lei_img` VARCHAR(500) NULL DEFAULT NULL COMMENT '卡类图片' AFTER `lei_sort`");
}
$chk=Plug_Query_Array("SHOW COLUMNS FROM `bs_php_kalei` WHERE Field='lei_key_max'");
if (!$chk) {
Plug_Query("ALTER TABLE `bs_php_kalei` ADD `lei_key_max` INT(11) NOT NULL DEFAULT 1 COMMENT '可绑定机器码数量' AFTER `lei_links`");
}
Plug_Query("INSERT INTO `bs_php_kalei` (`lei_name`,`lei_beizhu`,`lei_date`,`lei_jiage`,`lei_daili`,`lei_daihao`,`lei_ktzf`,`lei_type`,`lei_weight`,`lei_class`,`lei_cardint`,`lei_cardset`,`lei_pwdint`,`lei_pwdset`,`lei_for`,`lei_for_id`,`lei_for_oid`,`lei_money`,`lei_links_open`,`lei_links`,`lei_key_max`,`lei_sort`,`lei_img`)
VALUES ('{$f['ka_name']}','{$f['lei_beizhu']}','{$f['ka_date']}','{$f['ka_jiage']}','{$f['ka_dai']}','{$daihao}','{$f['ka_ktzf']}','{$f['lei_type']}','{$f['car_weight']}','{$f['car_class']}','{$f['lei_cardint']}','{$f['lei_cardset']}','{$f['lei_pwdint']}','{$f['lei_pwdset']}','{$f['lei_for']}','{$f['lei_for_id']}','','{$f['lei_money']}','{$f['lei_links_open']}','{$f['lei_links']}','{$f['lei_key_max']}','{$f['lei_sort']}','{$f['lei_img']}')");
Plug_Admin_Ok(Plug_Lang('添加成功'), array('lei_id'=> Plug_Query_Insert_Id()));
}
function call_modify()
{
Plug_Admin_Assert_Qx('app_1');
$id=(int) Plug_Set_Get('id');
if ($id <=0) {
$id=(int) Plug_Set_Post('ka_id');
}
if ($id <=0) {
$id=(int) Plug_Set_Post('lei_id');
}
$f=$this->read_fields();
if ($f['ka_name']==='') {
Plug_Admin_Fail(Plug_Lang('名称不能为空'));
}
Plug_Query("UPDATE `bs_php_kalei` SET
`lei_img`='{$f['lei_img']}',`lei_beizhu`='{$f['lei_beizhu']}',`lei_links_open`='{$f['lei_links_open']}',`lei_links`='{$f['lei_links']}',`lei_key_max`='{$f['lei_key_max']}',
`lei_money`='{$f['lei_money']}',`lei_cardint`='{$f['lei_cardint']}',`lei_cardset`='{$f['lei_cardset']}',
`lei_pwdint`='{$f['lei_pwdint']}',`lei_pwdset`='{$f['lei_pwdset']}',`lei_for`='{$f['lei_for']}',`lei_for_id`='{$f['lei_for_id']}',
`lei_class`='{$f['car_class']}',`lei_weight`='{$f['car_weight']}',`lei_type`='{$f['lei_type']}',`lei_ktzf`='{$f['ka_ktzf']}',
`lei_name`='{$f['ka_name']}',`lei_date`='{$f['ka_date']}',`lei_jiage`='{$f['ka_jiage']}',`lei_daili`='{$f['ka_dai']}',`lei_sort`='{$f['lei_sort']}'
WHERE `lei_id`='{$id}' LIMIT 1");
Plug_Admin_Ok(Plug_Lang('保存成功'));
}
function call_delete()
{
Plug_Admin_Assert_Qx('app_1');
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
if ($all==='') {
$id=(int) Plug_Set_Post('id');
if ($id > 0) {
$all=(string) $id;
}
}
if ($all==='') {
Plug_Admin_Fail(Plug_Lang('没有选择记录条目！'));
}
Plug_Query("DELETE FROM `bs_php_kalei` WHERE `lei_id` IN ({$all})");
Plug_Admin_Ok(Plug_Lang('删除成功'));
}
function call_mock_add()
{
Plug_Admin_Assert_Qx('app_1');
$daihao=(int) Plug_Set_Get('daihao');
if ($daihao <=0) {
$daihao=(int) Plug_Set_Post('daihao');
}
$tpl=(int) Plug_Set_Post('mock_tpl');
if ($tpl===1) {
$rows=array(
array('name'=> '测试卡', 'date'=> 1),
array('name'=> '日卡', 'date'=> 1),
array('name'=> '周卡', 'date'=> 7),
array('name'=> '月卡', 'date'=> 30),
array('name'=> '年卡', 'date'=> 365),
);
} elseif ($tpl===2) {
$rows=array(
array('name'=> '测试100点卡', 'date'=> 100),
array('name'=> '100点卡', 'date'=> 100),
array('name'=> '2000点卡', 'date'=> 2000),
array('name'=> '3000点卡', 'date'=> 3000),
array('name'=> '4000天卡', 'date'=> 4000),
array('name'=> '1万点卡', 'date'=> 10000),
);
} else {
Plug_Admin_Fail(Plug_Lang('请选择模拟模板!'));
}
$sort=10;
$n=0;
foreach ($rows as $r) {
$name=addslashes($r['name']);
$date=(int) $r['date'];
Plug_Query("INSERT INTO `bs_php_kalei` (`lei_name`,`lei_date`,`lei_jiage`,`lei_daili`,`lei_daihao`,`lei_ktzf`,`lei_type`,`lei_weight`,`lei_class`,`lei_cardint`,`lei_cardset`,`lei_pwdint`,`lei_pwdset`,`lei_for`,`lei_for_id`,`lei_for_oid`,`lei_money`,`lei_links_open`,`lei_links`,`lei_sort`,`lei_img`)
VALUES ('{$name}','{$date}','1','1','{$daihao}','','5','0','0','25','0','0','0','1','0','','0','0','0','{$sort}','')");
$n++;
$sort +=10;
}
Plug_Admin_Ok(Plug_Lang('模拟卡类型添加成功!') . " ({$n})");
}
}
