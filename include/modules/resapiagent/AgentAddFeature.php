<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='AGENT') {
die('Not,This File Not Can in Ie Modules');
}
class AgentAddFeature
{
public $user_array;
public $Grade;
public $user_str_log;
function __construct()
{
$this->user_array=Plug_Agent_Assert_Api_Login();
$this->Grade=Plug_Agent_Detect_Grade($this->user_array);
$this->user_str_log=Plug_Load_Langs_Array('user', 'user_str_log');
}
function call_add()
{
Plug_Agent_Assert_Api_Menu('add_agent', $this->Grade);
if ((int) $this->user_array['user_daili']==3) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('你无权添加代理商。')));
}
$user=Plug_Set_Post('user');
$pwd=Plug_Set_Post('pwd');
$qq=Plug_Set_Post('qq');
$mail=Plug_Set_Post('mail');
$xiaji=(int) Plug_Set_Post('xiaji');
$mobile=Plug_Set_Post('mobile');
if (is_numeric($user)) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('不要使用纯数字做为账号.')));
}
$yao_user=$this->user_array['user_uid'];
$log=Plug_User_Add_User($user, $pwd, $pwd, $qq, $mail, $yao_user, $mobile);
$dengji=($xiaji==1) ? 3 : 2;
if ($log==1005 || $log==1107) {
Plug_Query("UPDATE `bs_php_user` SET `user_daili`='{$dengji}',`user_anget_carid`='{$this->user_array['user_anget_carid']}' WHERE `user_user`='{$user}'");
Plug_Print_Json(array(
'code'=> 100,
'msg'=> isset($this->user_str_log[$log]) ? $this->user_str_log[$log] : Plug_Lang('添加成功'),
'data'=> array('user'=> $user, 'daili'=> $dengji),
));
}
$msg=isset($this->user_str_log[$log]) ? $this->user_str_log[$log] : (string) $log;
Plug_Print_Json(array('code'=> 1, 'msg'=> '[' . $log . ']' . $msg));
}
}
