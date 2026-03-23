<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

$GLOBALS['WEBAPI_META'] = array(
    'id'    => 'links_login',
    'name'  => '登录模式用户管理',
    'path'  => '/index.php',
    'method'=> 'GET',
    'fixed' => array('m' => 'webapi', 'c' => 'links_login', 'a' => 'index'),
    'params'=> array(
        array('name' => 'daihao', 'label' => '软件代号', 'optional' => true),
        array('name' => 'BSphpSeSsL', 'label' => 'BSphpSeSsL', 'labelNote' => '验证串,长度64位', 'optional' => true),
        array('name' => 'user', 'label' => '用户帐户', 'required' => true),
        array('name' => 'pwd', 'label' => '用户密码', 'required' => true),
        array('name' => 'login', 'label' => 'login', 'defaultValue' => 'YES')
    )
);

if (defined('WEBAPI_SCAN')) return;

/**
 * 登录模式用户管理 - 访问: index.php?m=webapi&c=links_login&a=index
 */
class links_login
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
        $log_name = '';
        $BSphpSeSsL = Plug_Set_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') {
            Plug_Session_Open();
        } else {
            Plug_Session_Open($BSphpSeSsL);
        }

        $id = Plug_Set_Get('id');
        $user = Plug_Set_Get('user');
        $pwd = Plug_Set_Get('pwd');
        $daihao = Plug_Set_Get('daihao');
        $login = Plug_Set_Get('login');

        if (Plug_User_Is_Login_Seesion() == 1047) {
            $USER_UID = Plug_Get_Session_Value('USER_UID');
            $sql = "SELECT * FROM  `bs_php_user` WHERE  `user_uid` =  '{$USER_UID}'   LIMIT 1;";
            $array = Plug_Query_Assoc($sql);
            $user = $array['user_user'];
            if ($user == '') {
                echo 'CODE:信息读取失败';
                exit;
            }
        } else {
            if ($login) {
                $log = Plug_User_Web_Login($user, $pwd);
                $user_str_log = plug_load_langs_array('user', 'user_str_log');
                if ($log == 1011) {
                } else {
                    $log_name = $user_str_log[$log];
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
                    echo 'CODE:' . $log_name;
                    exit;
                }
            } else {
                echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
                echo 'CODE:URL参数错误！';
                exit;
            }
        }

        if ($id > 0) {
            $sql = "UPDATE `bs_php_links_session` SET `links_set` = '-1' WHERE  `links_user_name` = '{$user}' AND `links_id` = '{$id}';";
            Plug_Query($sql);
            $param_tmie = PLUG_UNIX();
            Plug_Query("DELETE FROM `bs_php_links_session` WHERE `links_out_time` < '{$param_tmie}' or `links_set` = -1  LIMIT 10");
        }

        if ($daihao <> 0) {
            $daihao_sql = " AND `links_daihao`= '$daihao'";
        } else {
            $daihao_sql = '';
        }

        $sql = "SELECT * FROM`bs_php_links_session` WHERE `links_user_name`='{$user}' {$daihao_sql} ORDER BY`links_biaoji`DESC";
        $db_array_value = Plug_Query($sql);

        include Plug_Load_Default_Path();
    }
}
