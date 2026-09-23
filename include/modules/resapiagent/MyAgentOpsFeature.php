<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='AGENT') {
die('Not,This File Not Can in Ie Modules');
}
class MyAgentOpsFeature
{
public $user_array;
public $Grade;
function __construct()
{
$this->user_array=Plug_Agent_Assert_Api_Login();
$this->Grade=Plug_Agent_Detect_Grade($this->user_array);
Plug_Agent_Assert_Api_Menu('my_agent_list', $this->Grade);
}
private function scope_sql($all)
{
$uid=$this->user_array['user_uid'];
$user=$this->user_array['user_user'];
return "`user_uid` IN ({$all}) AND `user_daili`>0 AND (`user_yao_User`='{$uid}' OR `user_yao_User`='{$user}')";
}
function call_batch()
{
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
$select=(int) Plug_Set_Post('select_class');
if ($all==='') {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('没有选择记录条目！')));
}
$scope=$this->scope_sql($all);
if ($select==2) {
$txt=Plug_Set_Post('txt');
Plug_Query("UPDATE `bs_php_user` SET `user_anget_beizhu`='{$txt}' WHERE {$scope}");
Plug_Print_Json(array('code'=> 100, 'msg'=> Plug_Lang('备注修改成功')));
}
if ($select==3) {
Plug_Query("UPDATE `bs_php_user` SET `user_IsLock`='1' WHERE {$scope}");
Plug_Print_Json(array('code'=> 100, 'msg'=> Plug_Lang('冻结成功')));
}
if ($select==4) {
Plug_Query("UPDATE `bs_php_user` SET `user_IsLock`='0' WHERE {$scope}");
Plug_Print_Json(array('code'=> 100, 'msg'=> Plug_Lang('解封成功')));
}
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('你没有选择操作项目')));
}
}
