<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

$GLOBALS['WEBAPI_META'] = array(
    'id'    => 'links_car',
    'name'  => '卡模式用户在线管理',
    'path'  => '/index.php',
    'method'=> 'GET',
    'fixed' => array('m' => 'webapi', 'c' => 'links_car', 'a' => 'index'),
    'params'=> array(
        array('name' => 'daihao', 'label' => '软件代号', 'required' => true),
        array('name' => 'BSphpSeSsL', 'label' => 'BSphpSeSsL', 'labelNote' => '验证串,长度64位', 'optional' => true),
        array('name' => 'car_id', 'label' => '卡用户帐户', 'required' => true),
        array('name' => 'car_pwd', 'label' => '用户密码', 'optional' => true),
        array('name' => 'login', 'label' => 'login', 'defaultValue' => 'YES')
    )
);

if (defined('WEBAPI_SCAN')) return;

/**
 * 卡模式用户在线管理 - 访问: index.php?m=webapi&c=links_car&a=index
 */
class links_car
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
        $car_id = Plug_Set_Get('car_id');
        $car_pwd = Plug_Set_Get('car_pwd');
        $daihao = Plug_Set_Get('daihao');
        $login = Plug_Set_Get('login');

        if ($car_id == '') {
            $car_id = Plug_Get_Session_Value('ic_carid');
            $car_pwd = Plug_Get_Session_Value('ic_pwd');
            $daihao = Plug_Get_Session_Value('daihao');
        }

        $log = Plug_App_Is_Login($car_id, $car_pwd, $daihao);
        if ($log == 1080) {
            Plug_Set_Session_Value('ic_carid', $car_id);
            Plug_Set_Session_Value('ic_pwd', $car_pwd);
            Plug_Set_Session_Value('daihao', $daihao);
        } else {
            if ($login) {
                $carinfo = Plug_Get_Card_Info($car_id, $car_pwd, $daihao);
                if (is_array($carinfo)) {
                    Plug_Set_Session_Value('ic_carid', $car_id);
                    Plug_Set_Session_Value('ic_pwd', $car_pwd);
                    Plug_Set_Session_Value('daihao', $daihao);
                } else {
                    $log_name = $this->user_str_log[$log];
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
                    echo 'CODES:' . $log_name;
                    exit;
                }
            } else {
                echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
                echo 'CODE:URL参数错误！';
                exit;
            }
        }

        if ($id > 0) {
            $sql = "UPDATE `bs_php_links_session` SET `links_set` = '-1' WHERE  `links_user_name` = '{$car_id}' AND `links_id` = '{$id}';";
            Plug_Query($sql);
            $param_tmie = PLUG_UNIX();
            Plug_Query("DELETE FROM `bs_php_links_session` WHERE `links_out_time` < '{$param_tmie}' or `links_set` = -1  LIMIT 10");
        }

        if ($daihao <> 0) {
            $daihao_sql = " AND `links_daihao`= '{$daihao}'";
        } else {
            $daihao_sql = '';
        }

        $sql = "SELECT * FROM`bs_php_links_session` WHERE `links_user_name`='{$car_id}' {$daihao_sql} ORDER BY`links_biaoji`DESC";
        $db_array_value = Plug_Query($sql);
        $param_db_array_value = $db_array_value;

        include Plug_Load_Default_Path();
    }
}
