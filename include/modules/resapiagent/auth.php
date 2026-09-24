<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='AGENT') {
die('Not,This File Not Can in Ie Modules');
}
class auth
{
public $user_str_log;
function __construct()
{
Plug_ResApi_Session_Open(Plug_Set_Data_Post_Get('bs_seesion'));
$this->user_str_log=Plug_Load_Langs_Array('user', 'user_str_log');
if (Plug_Get_Configs_Value('sys', 'stop')==1) {
Plug_Print_Json(array(
'code'=> 1,
'msg'=> Plug_Get_Configs_Value('sys', 'stop_info'),
));
}
}
function call_prelogin()
{
$need=Plug_Get_Configs_Value('code', 'coode_login')==true;
Plug_Print_Json(array(
'code'=> 100,
'msg'=> Plug_Lang('ok'),
'data'=> array(
'need_code'=> $need ? 1 : 0,
'bs_seesion'=> session_id(),
'captcha_path'=> 'index.php?m=coode',
),
));
}
function call_login()
{
$amdin_name=Plug_Set_Post('amdin_name');
$admin_password=Plug_Set_Post('admin_password');
$imga_yan=Plug_Set_Post('code');
$lang=(int) Plug_Set_Post('lang');
if ($amdin_name=='' || $admin_password=='') {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('账号或密码不能为空')));
}
if (Plug_Get_Configs_Value('code', 'coode_login')==true) {
if ($imga_yan==='' || $imga_yan===null) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('请输入验证码')));
}
$log=Plug_Push_Cood_Imges($imga_yan);
if ($log !=1037) {
Plug_Print_Json(array('code'=> 1, 'msg'=> $this->user_str_log[$log]));
}
}
$log=Plug_User_Web_Login($amdin_name, $admin_password);
if ($log !=1011) {
Plug_Print_Json(array('code'=> 1, 'msg'=> $this->user_str_log[$log]));
}
if (Plug_Get_Configs_Value('sys', 'stop_agent')==0) {
Plug_Set_Session_Value('USER_UID', 'Not');
Plug_Print_Json(array(
'code'=> 1,
'msg'=> Plug_Get_Configs_Value('sys', 'stop_agent_info'),
));
}
$user_array=Plug_Query_One('bs_php_user', 'user_user', $amdin_name, ' * ');
if (!$user_array || $user_array['user_daili']==0) {
Plug_Set_Session_Value('USER_UID', 'Not');
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('需要代理商才可登录,你没有权限。')));
}
$i=0;
$BS_val_agent_ok=0;
$BS_val_agent_array=Plug_Query_One('bs_php_user', 'user_user', $amdin_name, ' `user_uid`,`user_user`,`user_IsLock`,`user_yao_User` ');
while ($i < 100) {
$i++;
if (!$BS_val_agent_array) {
break;
}
if ($BS_val_agent_array['user_IsLock']==1) {
$BS_val_agent_ok=1;
break;
}
$BS_val_agent_array=Plug_Query_One('bs_php_user', 'user_user', $BS_val_agent_array['user_yao_User'], ' `user_uid`,`user_user`,`user_IsLock`,`user_yao_User` ');
}
if ($BS_val_agent_ok==1) {
Plug_Set_Session_Value('USER_UID', 'Not');
Plug_Print_Json(array(
'code'=> 1,
'msg'=> Plug_Lang('上级代理账号被冻结无法登录uid:') . $BS_val_agent_array['user_uid'],
));
}
if (Plug_Get_Session_Value('USER_UID_IS')==0) {
Plug_Set_Session_Value('USER_UID', 'Not');
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('登录校验失败')));
}
Plug_Add_AppenLog('user_login_log', Plug_Lang('登录代理平台'), $user_array['user_user']);
Plug_Links_Add_Info(0, $user_array['user_user']);
Plug_Set_Session_Value('AGENT_LANG', $lang);
Plug_Print_Json(array(
'code'=> 100,
'msg'=> Plug_Lang('登录成功'),
'data'=> array(
'uid'=> (int) Plug_Get_Session_Value('USER_UID'),
'user'=> $user_array['user_user'],
'bs_seesion'=> session_id(),
),
));
}
function call_check()
{
$login_log=Plug_User_Is_Login_Seesion();
if ($login_log !=1047) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('未登录')));
}
$USER_UID=Plug_Get_Session_Value('USER_UID');
$user_array=Plug_Query_Array("SELECT `user_uid`,`user_user`,`user_daili` FROM bs_php_user WHERE user_uid='{$USER_UID}'");
if (!$user_array || $user_array['user_daili']==0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('未登录')));
}
Plug_Print_Json(array(
'code'=> 100,
'msg'=> Plug_Lang('已登录'),
'data'=> array(
'uid'=> (int) $user_array['user_uid'],
'user'=> $user_array['user_user'],
'bs_seesion'=> session_id(),
),
));
}
function call_logout()
{
Plug_Set_Session_Value('USER_UID', '');
Plug_Set_Session_Value('USER_YSE', '');
Plug_Set_Session_Value('USER_DATE', '');
Plug_Set_Session_Value('USER_IP', '');
Plug_Set_Session_Value('USER_MD7', '');
Plug_Print_Json(array('code'=> 100, 'msg'=> Plug_Lang('已退出')));
}
}
