<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='AGENT') {
die('Not,This File Not Can in Ie Modules');
}
class MyUsersOpsFeature
{
public $user_array;
public $Grade;
function __construct()
{
$this->user_array=Plug_Agent_Assert_Api_Login();
$this->Grade=Plug_Agent_Detect_Grade($this->user_array);
Plug_Agent_Assert_Api_Menu('my_users_table', $this->Grade);
}
function call_batch()
{
$all=Plug_Admin_Safe_Ids(Plug_Set_Post('all'));
$select=(int) Plug_Set_Post('select_class');
if ($all==='') {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('没有选择记录条目！')));
}
$scope="`user_uid` IN ({$all}) AND `user_yao_User`='{$this->user_array['user_uid']}' AND `user_daili`='0'";
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
if ($select==5) {
$txt=Plug_Set_Post('txt');
if ($txt==='') {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('密码不能为空')));
}
if (��������������������������������������������������������������������������������($txt)) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('密码含有非法字符')));
}
if (strlen($txt) < 2 || strlen($txt) > 14) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('密码长度必须在2-14位')));
}
$hash=����������������������������������������������������������������������������($txt);
Plug_Query("UPDATE `bs_php_user` SET `user_pwd`='{$hash}' WHERE {$scope}");
Plug_Add_AppenLog('od_po_log', Plug_Lang('代理修改用户密码') . ' UID:' . $all, $this->user_array['user_user']);
Plug_Print_Json(array('code'=> 100, 'msg'=> Plug_Lang('密码修改成功')));
}
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('你没有选择操作项目')));
}
}
