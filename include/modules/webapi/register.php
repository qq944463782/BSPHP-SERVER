<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

$GLOBALS['WEBAPI_META'] = array(
    'id'    => 'register',
    'name'  => '网页注册接口-激活码',
    'path'  => '/index.php',
    'method'=> 'GET',
    'fixed' => array('m' => 'webapi', 'c' => 'register', 'a' => 'index'),
    'params'=> array(
        array('name' => 'u', 'label' => '邀请码', 'optional' => true, 'tip' => '邀请码/推荐人账号，没有不要传留空')
    )
);

if (defined('WEBAPI_SCAN')) return;

/**
 * 网页注册接口-激活码 - 访问: index.php?m=webapi&c=register&a=index
 */
class register
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
            $u_raw = trim((string)$u);
            $u_safe = addslashes($u_raw);
            $resolved = '';

            // 先按 UID 查找
            if (ctype_digit($u_raw) && (int)$u_raw > 0) {
                $sql = "SELECT `user_user` FROM `bs_php_user` WHERE `user_uid` = '{$u_safe}' LIMIT 1";
                $info = Plug_Query_Array($sql);
                if ($info && !empty($info['user_user'])) {
                    $resolved = $info['user_user'];
                }
            }

            // UID 未匹配到，再按账号查找
            if ($resolved === '') {
                $sql = "SELECT `user_user` FROM `bs_php_user` WHERE `user_user` = '{$u_safe}' LIMIT 1";
                $info = Plug_Query_Array($sql);
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
        $key = Plug_Set_Post('key');
        $img = Plug_Set_Post('img');
        $code_ka = Plug_Set_Post('code_ka');
        $log_name = '';
        $Submitadd = Plug_Set_Post('Submitadd');

        if ($Submitadd) {
            $sql = "SELECT * FROM  `bs_php_cardseries` WHERE  `car_name` =  '{$code_ka}'   LIMIT 1;";
            $param_tmp = Plug_Query_Assoc($sql);
            if (!$param_tmp) {
                $log_name = '激活码/充值卡不存在';
            } elseif ($param_tmp['car_IsLock'] == 1) {
                $log_name = '激活码/充值卡已经被激活';
            } else {
                $log = Plug_User_Re_Add($user, $pwda, $pwdb, $qq, $mail, $u, '', '', '');
                if ($log == 1005) {
                    $sql = "SELECT * FROM  `bs_php_user` WHERE  `user_user` =  '{$user}'   LIMIT 1;";
                    $arr = Plug_Query_Assoc($sql);
                    $uid = $arr['user_uid'];
                    $date = HOST_UNIX;
                    Plug_App_Login_Add_Key($uid, $param_tmp['car_DaiHao'], 0, '', $user, $user);
                    Plug_User_Chong($user, $code_ka, '');
                    $log_name = '注册成功 ';
                }
                $log_name = $this->user_str_log[$log] . $log;
            }
        }

        include Plug_Load_Default_Path();
    }
}
