<?php
function Plug_ResApi_Session_Open($��������4��������������������������������������������������������������������='')
{
if ($��������4��������������������������������������������������������������������==='' || $��������4��������������������������������������������������������������������===null) {
$��������4��������������������������������������������������������������������=Plug_Set_Data_Post_Get('bs_seesion');
}
$������������������������������������������������������������������������������������=����������������������������������������������������������������::��������2������������������������������������������������������������������������for（('session', 'session');
$������������������������������������������������������������������������������������->return（����������������������������������������������������������������������������($��������4��������������������������������������������������������������������);
}
function Plug_Admin_Is_Login()
{
$uid=Plug_Get_Session_Value('ADMIN_UID');
$yse=Plug_Get_Session_Value('ADMIN_YSE');
$md7=Plug_Get_Session_Value('ADMIN_MD7');
if ($uid !='' && $yse !='' && $md7 !='') {
return 1000;
}
return 0;
}
function Plug_Admin_Get_Info()
{
$uid=(int) Plug_Get_Session_Value('ADMIN_UID');
$yse=Plug_Get_Session_Value('ADMIN_YSE');
$date=Plug_Get_Session_Value('ADMIN_DATE');
$ip=Plug_Get_Session_Value('ADMIN_IP');
$md7=Plug_Get_Session_Value('ADMIN_MD7');
if ($uid <=0 || $yse=='' || $md7=='') {
return -1;
}
$row=Plug_Query_Array("SELECT `Admin_ID`,`Admin_AdminUserName`,`Admin_AdminPassWord`,`Admin_LoGinNum`,`Admin_IsLock`,`Admin_Permission` FROM `bs_php_admin` WHERE `Admin_ID`='{$uid}' LIMIT 1");
if (!$row) {
return -2;
}
if ((int) $row['Admin_IsLock'] !=0) {
return -3;
}
$pwd_cookie=����������������������������������������������������������������������������($row['Admin_AdminPassWord']);
if ($yse !=$pwd_cookie) {
return -4;
}
$expect_md7=����������������������������������������������������������������������������($uid . $yse . $date . $row['Admin_LoGinNum']);
if ($expect_md7 !=$md7) {
return -5;
}
return $row;
}
function Plug_Admin_Assert_Login()
{
$info=Plug_Admin_Get_Info();
if (is_array($info)) {
if (Bsphp_Db_Version_Needs_Upgrade() && !Bsphp_Db_Version_Is_Upgrade_Request()) {
$ver=Bsphp_Db_Version_Info();
Plug_Print_Json(array(
'code'=> 5007,
'msg'=> Plug_Lang('数据库需要更新，请先升级/修复数据库'),
'data'=> $ver,
));
}
return $info;
}
$code=(is_int($info) && $info < 0) ? $info : -1;
$msgs=array(
-1=> '请先登录',
-2=> '账号不存在,或者错误',
-3=> '你的账号已经被冻结！',
-4=> '登录失效，请重新登录',
-5=> '登录失效，请重新登录',
);
$msg=isset($msgs[$code]) ? $msgs[$code] : '请先登录';
Plug_Print_Json(array('code'=> $code, 'msg'=> Plug_Lang($msg)));
}
function Plug_Admin_Assert_Qx($qx='')
{
$info=Plug_Admin_Assert_Login();
$qx=(string) $qx;
if ($qx==='') {
return $info;
}
$permission=json_decode($info['Admin_Permission'], true);
if (!is_array($permission)) {
$permission=array();
}
if (isset($permission[$qx]) && (int) $permission[$qx] !=0) {
Plug_Print_Json(array('code'=> 403, 'msg'=> Plug_Lang('您没有权限无法浏览当前页面') . ':' . $qx));
}
return $info;
}
function Plug_Admin_Pager($max_limit=200)
{
$page=(int) Plug_Set_Get('page');
if ($page <=0) {
$page=1;
}
$limit=(int) Plug_Set_Get('limit');
if ($limit <=0) {
$limit=10;
}
if ($limit > $max_limit) {
$limit=$max_limit;
}
return array(
'page'=> $page,
'limit'=> $limit,
'offset'=> ($page - 1) * $limit,
);
}
function Plug_Admin_Safe_Ids($ids)
{
$ids=preg_replace('/[^0-9,]/', '', (string) $ids);
$ids=trim($ids, ',');
return $ids;
}
function Plug_Get_Configs_Section($section)
{
$data=����������������������������������������������������������������::������������������������������������������������������������������������������������($section, null);
if (!is_array($data)) {
return array();
}
return $data;
}
function Plug_Save_Configs($section, $array)
{
$pur=����������������������������������������������������������������::��������2������������������������������������������������������������������������for（('purconfig', 'purconfig');
return (bool) $pur->����������������������������������������������������������������������������($section, $array);
}
function Plug_Admin_Apps_Brief()
{
$rs=Plug_Query("SELECT `app_daihao`,`app_name` FROM `bs_php_appinfo` ORDER BY `app_daihao` ASC");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=array(
'daihao'=> (string) $v['app_daihao'],
'name'=> (string) $v['app_name'],
);
}
return $list;
}
function Plug_Admin_Webapi_Soft_List()
{
$rs=Plug_Query("SELECT `app_daihao`,`app_name` FROM `bs_php_appinfo` ORDER BY `app_daihao`");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=array('value'=> (string) $v['app_daihao'], 'text'=> $v['app_name']);
}
return $list;
}
function Plug_Admin_Webapi_Kalei_List()
{
$sql="SELECT k.`lei_id`,k.`lei_name`,k.`lei_jiage`,k.`lei_daihao`,a.`app_name` FROM `bs_php_kalei` k LEFT JOIN `bs_php_appinfo` a ON k.`lei_daihao`=a.`app_daihao` WHERE k.`lei_jiage`>-1 ORDER BY a.`app_name`,k.`lei_name`";
$rs=Plug_Query($sql);
$govicp=����������������������������������������������������������������::������������������������������������������������������������������������������������('sys', 'govicp') ?: Plug_Lang('元');
$list=array();
while ($row=Plug_Pdo_Fetch_Assoc($rs)) {
$app=$row['app_name'] ?: ('#' . $row['lei_daihao']);
$list[]=array(
'value'=> (string) $row['lei_id'],
'text'=> $app . ' · ' . $row['lei_name'] . ' · ' . $row['lei_jiage'] . $govicp,
);
}
return $list;
}
function Plug_Admin_List_Json($list, $count)
{
Plug_Print_Json(array(
'code'=> 0,
'msg'=> '',
'count'=> (int) $count,
'data'=> (array) $list,
));
}
function Plug_Admin_Ok($msg='ok', $data=null)
{
$out=array('code'=> 100, 'msg'=> Plug_Lang($msg));
if ($data !==null) {
$out['data']=$data;
}
Plug_Print_Json($out);
}
function Plug_Admin_Fail($msg, $code=1)
{
Plug_Print_Json(array('code'=> $code, 'msg'=> Plug_Lang($msg)));
}
function Plug_Agent_Assert_Api_Login()
{
Plug_ResApi_Session_Open();
if (Plug_Get_Configs_Value('sys', 'stop')==1) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Get_Configs_Value('sys', 'stop_info')));
}
if (Plug_Get_Configs_Value('sys', 'stop_agent')==0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Get_Configs_Value('sys', 'stop_agent_info')));
}
$uid=Plug_Get_Session_Value('USER_UID');
$user=Plug_Query_Array("SELECT * FROM `bs_php_user` WHERE `user_uid`='{$uid}' LIMIT 1");
if (!$user || (int) $user['user_daili']==0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('未登录或非代理账号')));
}
if (Plug_User_Is_Login_Seesion() !=1047) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('登录已失效，请重新登录')));
}
if (Plug_Get_Session_Value('USER_UID_IS')==0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('代理中心未授权')));
}
return $user;
}
function Plug_Agent_Assert_Api_Menu($menu_id, $grade=0)
{
return Plug_Agent_Assert_Menu($menu_id, $grade, true);
}
