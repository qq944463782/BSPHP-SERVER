<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='AGENT') {
die('Not,This File Not Can in Ie Modules');
}
class UnbindFeature
{
public $user_array;
public $Grade;
function __construct()
{
$this->user_array=Plug_Agent_Assert_Api_Login();
$this->Grade=Plug_Agent_Detect_Grade($this->user_array);
}
function call_apps()
{
Plug_Agent_Assert_Api_Menu('unbind_user', $this->Grade);
$app_in=Plug_Get_Agent_Appinfo_Array($this->user_array['user_uid']);
$rs=Plug_Query("SELECT `app_daihao`,`app_name` FROM `bs_php_appinfo` WHERE `app_daihao` {$app_in} ORDER BY `app_daihao` ASC");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=$v;
}
Plug_Print_Json(array('code'=> 100, 'msg'=> 'ok', 'data'=> $list));
}
function call_run()
{
Plug_Agent_Assert_Api_Menu('unbind_user', $this->Grade);
$daihao=(int) Plug_Set_Post('daihao');
$user=trim(Plug_Set_Post('user'));
$key=trim(Plug_Set_Post('key'));
if ($daihao <=0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('请选择软件')));
}
if ($user==='') {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('请输入账户/卡')));
}
$app_in=Plug_Get_Agent_Appinfo_Array($this->user_array['user_uid']);
$allow=Plug_Query_Array("SELECT `app_daihao` FROM `bs_php_appinfo` WHERE `app_daihao`='{$daihao}' AND `app_daihao` {$app_in} LIMIT 1");
if (!$allow) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('无权操作该软件')));
}
$row=Plug_Query_Array("SELECT * FROM `bs_php_pattern_login` WHERE `L_daihao`='{$daihao}' AND (`L_ic_name`='{$user}' OR `L_User_uid`='{$user}') LIMIT 1");
if (!$row) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('账户/卡号不存在')));
}
if (Plug_Bind_Key_Count($row) <=0 && $key=='') {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('当前没有绑定,无需解绑.')));
}
if ($key==='') {
$tmp=Plug_Bind_Key_Clear($row);
} else {
Plug_Bind_Key_Clear($row);
$row['L_key_info']='';
$tmp=Plug_Bind_Key_Add($row, $key);
}
if ($tmp) {
Plug_Print_Json(array('code'=> 100, 'msg'=> Plug_Lang('操作成功.')));
}
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('操作失败.')));
}
}
