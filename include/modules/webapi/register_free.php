<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

$GLOBALS['WEBAPI_META'] = array(
    'id'    => 'register_free',
    'name'  => '网页注册接口',
    'path'  => '/index.php',
    'method'=> 'GET',
    'fixed' => array('m' => 'webapi', 'c' => 'register_free', 'a' => 'index'),
    'params'=> array(
        array('name' => 'u', 'label' => '邀请码', 'optional' => true, 'tip' => '邀请码/推荐人账号，没有不要传留空')
    )
);

if (defined('WEBAPI_SCAN')) return;

/**
 * 网页注册接口-无需激活码 - 访问: index.php?m=webapi&c=register_free&a=index
 */
class register_free
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
        // 邀请码：优先表单提交，其次 URL 参数
        $u_from_url = Plug_Set_Get('u');
        $u_post = Plug_Set_Post('u');
        $u = $u_post !== '' ? $u_post : $u_from_url;

        // 优先按 UID 查询，再按账号查询，得到标准邀请人账号
        if ($u !== '') {
            $db = bs_lib::intelligence_load_libbsphp_class('mysql', 'mysql');
            $u_raw = trim((string)$u);
            $u_safe = addslashes($u_raw);
            $resolved = '';

            // 先按 UID 查找
            if (ctype_digit($u_raw) && (int)$u_raw > 0) {
                $sql = "SELECT `user_user` FROM `bs_php_user` WHERE `user_uid` = '{$u_safe}' LIMIT 1";
                $info = $db->intelligence_Bsphp_my_array($sql);
                if ($info && !empty($info['user_user'])) {
                    $resolved = $info['user_user'];
                }
            }

            // UID 未匹配到，再按账号查找
            if ($resolved === '') {
                $sql = "SELECT `user_user` FROM `bs_php_user` WHERE `user_user` = '{$u_safe}' LIMIT 1";
                $info = $db->intelligence_Bsphp_my_array($sql);
                if ($info && !empty($info['user_user'])) {
                    $resolved = $info['user_user'];
                }
            }

            if ($resolved !== '') {
                $u = $resolved;
            }
        }

        $user = Plug_Set_Post('user');
        $pwda = Plug_Set_Post('pwda');
        $pwdb = Plug_Set_Post('pwdb');
        $qq = Plug_Set_Post('qq');
        $mail = Plug_Set_Post('mail');
        $log_name = '';
        $Submitadd = Plug_Set_Post('Submitadd');

        if ($Submitadd) {
            $log = Plug_User_Re_Add($user, $pwda, $pwdb, $qq, $mail, $u, '', '', '');
            if ($log == 1005) {
                $log_name = '注册成功 ';
            } else {
                $log_name = $this->user_str_log[$log] . $log;
            }
        }

        include Plug_Load_Default_Path();
    }
}

