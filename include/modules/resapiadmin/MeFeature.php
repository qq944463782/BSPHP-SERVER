<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class MeFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_profile()
{
$qx=json_decode($this->admin_array['Admin_Permission'], true);
if (!is_array($qx)) {
$qx=array();
}
Plug_Print_Json(array(
'code'=> 100,
'msg'=> Plug_Lang('ok'),
'data'=> array(
'uid'=> (int) $this->admin_array['Admin_ID'],
'user'=> $this->admin_array['Admin_AdminUserName'],
'qx'=> $qx,
),
));
}
}
