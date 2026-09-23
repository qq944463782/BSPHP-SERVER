<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='AGENT') {
die('Not,This File Not Can in Ie Modules');
}
class RenewFeature
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
function call_checkcardpwd()
{
Plug_Agent_Assert_Api_Menu('user_card_renew_recharge', $this->Grade);
$ka_name=trim((string) Plug_Set_Post('ka_name'));
if ($ka_name==='') {
Plug_Print_Json(array('code'=> 1, 'exists'=> 0, 'need_password'=> 0, 'msg'=> Plug_Lang('请输入卡号')));
}
$card=Plug_Query_Array("SELECT `car_pwd` FROM `bs_php_cardseries` WHERE `car_name`='{$ka_name}' LIMIT 1");
if (!$card) {
Plug_Print_Json(array('code'=> 1, 'exists'=> 0, 'need_password'=> 0, 'msg'=> Plug_Lang('卡号不存在')));
}
$need=(trim((string) $card['car_pwd']) !=='') ? 1 : 0;
Plug_Print_Json(array('code'=> 100, 'exists'=> 1, 'need_password'=> $need, 'msg'=> 'ok'));
}
function call_run()
{
Plug_Agent_Assert_Api_Menu('user_card_renew_recharge', $this->Grade);
$user_user=trim((string) Plug_Set_Post('user_user'));
$ka_name=trim((string) Plug_Set_Post('ka_name'));
$ka_pwd=trim((string) Plug_Set_Post('ka_pwd'));
if ($user_user==='') {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('充值账户/卡号不能为空')));
}
if ($ka_name==='') {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('充值卡号不能为空')));
}
$log=Plug_User_Chong($user_user, $ka_name, $ka_pwd);
$msg=isset($this->user_str_log[$log]) ? $this->user_str_log[$log] : Plug_Lang('操作完成');
if ((int) $log==1062 || (int) $log==1069) {
Plug_Print_Json(array('code'=> 100, 'msg'=> $msg, 'data'=> array('biz'=> $log)));
}
Plug_Print_Json(array('code'=> 1, 'msg'=> $msg, 'data'=> array('biz'=> $log)));
}
}
