<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='AGENT') {
die('Not,This File Not Can in Ie Modules');
}
class InviteFeature
{
public $user_array;
public $Grade;
function __construct()
{
$this->user_array=Plug_Agent_Assert_Api_Login();
$this->Grade=Plug_Agent_Detect_Grade($this->user_array);
}
function call_links()
{
Plug_Agent_Assert_Api_Menu('invite_users', $this->Grade);
$uid=(int) $this->user_array['user_uid'];
$host=rtrim((string) Plug_Get_Configs_Value('sys', 'url'), '/');
if ($host=='') {
$scheme=(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !=='off') ? 'https://' : 'http://';
$hostName=isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '127.0.0.1';
$host=rtrim($scheme . $hostName, '/');
}
$links=array(
array('title'=> '推广注册链接', 'desc'=> 'WEB页面注册（无需激活码）', 'url'=> $host . '/index.php?m=webapi&c=register_free&a=index&u=' . $uid),
array('title'=> '销售卡1', 'desc'=> 'WEB页面直接充值续费', 'url'=> $host . '/index.php?m=webapi&c=salecard_renew&a=list&u=' . $uid),
array('title'=> '销售卡2', 'desc'=> 'WEB页面购买卡类充值', 'url'=> $host . '/index.php?m=webapi&c=salecard_gencard&a=list&u=' . $uid),
array('title'=> '销售卡3', 'desc'=> 'WEB页面购买预制卡充值', 'url'=> $host . '/index.php?m=webapi&c=salecard_salecard&a=list&u=' . $uid),
);
Plug_Print_Json(array('code'=> 100, 'msg'=> 'ok', 'data'=> $links));
}
}
