<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='AGENT') {
die('Not,This File Not Can in Ie Modules');
}
class PayMethodsFeature
{
public $user_array;
public $Grade;
function __construct()
{
$this->user_array=Plug_Agent_Assert_Api_Login();
$this->Grade=Plug_Agent_Detect_Grade($this->user_array);
}
function call_list()
{
Plug_Agent_Assert_Api_Menu('balance_recharge', $this->Grade);
$path=Plug_Get_Bsphp_Dir() . 'include/modules/payment/paycood';
$dir_array=Plug_Open_List_Dir($path);
$list=array();
if (is_array($dir_array)) {
foreach ($dir_array as $dir) {
$file=$path . '/' . $dir . '/form_config.php';
if (!file_exists($file)) {
continue;
}
$form_array=include($file);
if (!isset($form_array['pay_config'])) {
continue;
}
$name=$form_array['pay_config']['name'];
if (Plug_Get_Configs_Value('pay_' . $name, 'pay_' . $name . '_set') !=0) {
continue;
}
$list[]=array(
'name'=> $name,
'label'=> $form_array['pay_config']['label'],
'url'=> $form_array['pay_config']['url'],
);
}
}
Plug_Print_Json(array(
'code'=> 100,
'msg'=> 'ok',
'data'=> array(
'rmb'=> $this->user_array['user_rmb'],
'methods'=> $list,
),
));
}
function call_create_order()
{
Plug_Agent_Assert_Api_Menu('balance_recharge', $this->Grade);
$amount=(float) Plug_Set_Post('pay_amount');
$lei=preg_replace('/[^a-zA-Z0-9_\-]/', '', (string) Plug_Set_Post('pay_leixing'));
if ($amount <=0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('请输入要充值的金额,请返回！')));
}
if ($lei==='') {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('没有支付方式,请选择支付方式.')));
}
$path=Plug_Get_Bsphp_Dir() . 'include/modules/payment/paycood/' . $lei . '/form_config.php';
if (!file_exists($path)) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('支付接口不存在')));
}
$form=include($path);
if (!isset($form['pay_config'])) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('支付接口不存在')));
}
if (Plug_Get_Configs_Value('pay_' . $lei, 'pay_' . $lei . '_set') !=0) {
Plug_Print_Json(array('code'=> 1, 'msg'=> Plug_Lang('支付方式未启用')));
}
$base=rtrim((string) Plug_Get_Configs_Value('sys', 'url'), '/');
$user=$this->user_array['user_user'];
$qs=http_build_query(array(
'm'=> 'payment',
'c'=> 'Confirmthepayment',
'a'=> 'Confirmthepayment',
'pay_user'=> $user,
'pay_amount'=> $amount,
'pay_leixing'=> $lei,
));
$pay_url=$base . '/agent/index.php?' . $qs;
Plug_Print_Json(array(
'code'=> 100,
'msg'=> 'ok',
'data'=> array(
'pay_url'=> $pay_url,
'pay_amount'=> $amount,
'pay_leixing'=> $lei,
'pay_user'=> $user,
'label'=> isset($form['pay_config']['label']) ? $form['pay_config']['label'] : $lei,
),
));
}
}
