<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='AGENT') {
die('Not,This File Not Can in Ie Modules');
}
class MeFeature
{
public $user_array;
public $Grade;
function __construct()
{
$this->user_array=Plug_Agent_Assert_Api_Login();
$this->Grade=Plug_Agent_Detect_Grade($this->user_array);
}
function call_profile()
{
$u=$this->user_array;
unset($u['user_pwd']);
Plug_Print_Json(array(
'code'=> 100,
'msg'=> Plug_Lang('ok'),
'data'=> array(
'uid'=> (int) $u['user_uid'],
'user'=> $u['user_user'],
'daili'=> (int) $u['user_daili'],
'rmb'=> $u['user_rmb'],
'grade'=> (int) $this->Grade,
'qq'=> $u['user_qq'],
'email'=> $u['user_email'],
'Mobile'=> $u['user_Mobile'],
),
));
}
function call_password()
{
$pwd=Plug_Set_Post('pwd');
$pwda=Plug_Set_Post('pwda');
$pwdb=Plug_Set_Post('pwdb');
$uid=(int) $this->user_array['user_uid'];
$user_str_log=Plug_Load_Langs_Array('user', 'user_str_log');
if ($pwd==='' || $pwd===null) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('请输入旧密码')));
}
if ($pwda==='' || $pwda===null || $pwdb==='' || $pwdb===null) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('请输入新密码和确认密码')));
}
$log=Plug_User_Modify_PassWord($uid, $pwd, $pwda, $pwdb);
$msg=isset($user_str_log[$log]) ? $user_str_log[$log] : Plug_Lang('操作完成');
if ((int) $log===1031) {
Plug_Add_AppenLog('user_login_log', Plug_Lang('代理修改登录密码'), $this->user_array['user_user']);
Plug_Print_Json(array(
'code'=> 100,
'msg'=> $msg,
'data'=> array('biz'=> (int) $log),
));
}
Plug_Print_Json(array(
'code'=> 1,
'msg'=> $msg,
'data'=> array('biz'=> (int) $log),
));
}
}
