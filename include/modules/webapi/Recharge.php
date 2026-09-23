<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

$GLOBALS['WEBAPI_META'] = array(
    'id'    => 'Recharge',
    'name'  => '添加网页接口充值',
    'path'  => '/index.php',
    'method'=> 'GET',
    'fixed' => array('m' => 'webapi', 'c' => 'Recharge', 'a' => 'index'),
    'params'=> array(
        array('name' => 'user', 'label' => '账号', 'required' => true),
        array('name' => 'ka', 'label' => '卡号', 'required' => true),
        array('name' => 'mi', 'label' => '密码', 'required' => true)
    )
);

if (defined('WEBAPI_SCAN')) return;

/**
 * 添加网页接口充值 - 访问: index.php?m=webapi&c=Recharge&a=index
 */
class Recharge
{
    private $user_str_log;

    function __construct()
    {
        Plug_Load_Modules_Common('applib', 'appen_inc');
        Plug_Load_Modules_Common('applib', 'appen_appuser');
        $this->user_str_log = Plug_Load_Langs_Array('user', 'user_str_log');
    }

    function call_index()
    {
        $Submitadd = Plug_Set_Post('Submitadd');
        $user_user = Plug_Set_Post('user_user');
        $ka_name = Plug_Set_Post('ka_name');
        $ka_pwd = Plug_Set_Post('ka_pwd');

        $ka_name = trim($ka_name);
        $ka_pwd = trim($ka_pwd);

        $log_name = '';
        if ($Submitadd) {
            if (trim($ka_name) == '')
                $log_name = "充值卡号不能为空";
            $log = Plug_User_Chong($user_user, $ka_name, $ka_pwd);
            $log_name = $this->user_str_log[$log];
        } else {
            $GET_ka_user = Plug_Set_Get('user');
            $GET_ka_name = Plug_Set_Get('ka');
            $GET_ka_pwd = Plug_Set_Get('mi');
            $ka_name = $GET_ka_name;
            $ka_pwd = $GET_ka_pwd;
            $user_user = $GET_ka_user;
        }

        include Plug_Load_Default_Path();
    }
}
