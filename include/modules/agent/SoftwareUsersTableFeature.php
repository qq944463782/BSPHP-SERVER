<?php
/*
 * Feature: 间接软件用户
 * Menu ID: software_users_table
 * 说明: 展示下级代理关联的软件登录用户列表。
 */
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT') {
    die('Not,This File Not Can in Ie Modules');
}

class SoftwareUsersTableFeature
{
    public $GLOBALS_LANGS, $user_array, $user_str_log, $Grade;

    function __construct()
    {
        plug_session_open();
        $this->user_str_log = Plug_Load_Langs_Array('user', 'user_str_log');

        if (Plug_Get_Configs_Value('sys', 'stop_agent') == 0) {
            Plug_Alerts(Plug_Lang('系统维护'), Plug_Get_Configs_Value('sys', 'stop_agent_info'));
            exit;
        }

        $user_UID = Plug_Get_Session_Value('USER_UID');
        $this->user_array = Plug_Query_Array("SELECT * FROM bs_php_user WHERE user_uid = '{$user_UID}'");
        if (!$this->user_array || $this->user_array['user_daili'] == 0) {
            Plug_Alerts(Plug_Lang('你没有权限,请先登录。'), 'index.php?m=agent');
            Plug_Location('index.php?m=agent');
            exit;
        }

        $login_log = Plug_User_Is_Login_Seesion();
        if ($login_log != 1047) {
            Plug_Alerts(Plug_Lang('你没有权限,请先登录。'), 'index.php?m=agent');
            Plug_Location('index.php');
            exit;
        }

        $this->Grade = Plug_Agent_Detect_Grade($this->user_array);
    }

    function call_table()
    {
        include Plug_Load_Default_Path();
    }

    function call_table_json()
    {
        $FANYE = (int)Plug_Set_Get('page');
        $db_ID = $FANYE > 0 ? $FANYE - 1 : 0;
        $shu = (int)Plug_Set_Get('limit');
        if ($shu == 0) {
            $shu = 10;
        }
        $db_ID = $db_ID * $shu;

        $soso = Plug_Set_Get('soso');
        $soso_id = (int)Plug_Set_Get('soso_id');
        $DESC_id = (int)Plug_Set_Get('DESC');
        $DESC = $DESC_id == 1 ? 'ASC' : 'DESC';

        if ($soso_id == 2) {
            $soso_db_table = 'L_User_uid';
        } elseif ($soso_id == 3) {
            $soso_db_table = 'L_agent_uid';
        } elseif ($soso_id == 4) {
            $soso_db_table = 'L_ip';
        } else {
            $soso_db_table = 'L_ic_name';
        }

        $agent_uid_in = Plug_Get_Agent_Info_In($this->user_array['user_user']);
        $scope_sql = " `L_agent_uid` IN ({$agent_uid_in}) ";

        $sql = "SELECT * FROM `bs_php_pattern_login` WHERE {$scope_sql} AND `{$soso_db_table}` LIKE '%{$soso}%' ORDER BY `L_id` {$DESC} LIMIT {$db_ID},{$shu};";
        $sql_rows = "SELECT count(*) AS 'hangshu' FROM `bs_php_pattern_login` WHERE {$scope_sql} AND `{$soso_db_table}` LIKE '%{$soso}%';";

        $db_array_value = Plug_Query($sql);
        $my_rows_array = Plug_Query_Array($sql_rows);
        $zongshu = (int)$my_rows_array['hangshu'];

        $while_array_list_all = array();
        while ($value = Plug_Pdo_Fetch_Assoc($db_array_value)) {
            $while_array_list = array();
            $while_array_list['id'] = $value['L_id'];
            $while_array_list['uid'] = $value['L_User_uid'];
            $while_array_list['user'] = $value['L_ic_name'];
            $while_array_list['daihao'] = $value['L_daihao'];
            $while_array_list['agent_uid'] = $value['L_agent_uid'];
            $while_array_list['ip'] = $value['L_login_ip'];
            $while_array_list['addtime'] = Plug_Show_Time_Day($value['L_re_date']);
            $while_array_list_all[] = $while_array_list;
        }

        Plug_Print_Json(array(
            'data' => (array)$while_array_list_all,
            'code' => 0,
            'msg' => '',
            'count' => $zongshu
        ));
    }
}
