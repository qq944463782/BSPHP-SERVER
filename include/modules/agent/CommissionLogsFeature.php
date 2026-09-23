<?php
/*
 * Feature: 佣金日志查询
 * Menu ID: commission_logs
 * 说明: 代理佣金日志列表页与 JSON 数据接口，统一执行菜单权限校验。
 */
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT') {
    die('Not,This File Not Can in Ie Modules');
}

class CommissionLogsFeature
{
    public $user_array;
    public $Grade;

    function __construct()
    {
        //开启会话 seesion
        plug_session_open();
        //加载用户语言包
        if (Plug_Get_Configs_Value('sys', 'stop_agent') == 0) {
            Plug_Alerts(Plug_Lang('系统维护'), Plug_Get_Configs_Value('sys', 'stop_agent_info'));
            exit;
        }

        //获取会话中的用户UID
        $user_UID = Plug_Get_Session_Value('USER_UID');
        //根据用户UID查询用户信息
        $this->user_array = Plug_Query_Array("SELECT * FROM bs_php_user WHERE user_uid = '{$user_UID}'");
        //如果用户信息不存在,则提示没有权限,请先登录。
        if (!$this->user_array || $this->user_array['user_daili'] == 0) {
            Plug_Alerts(Plug_Lang('你没有权限,请先登录。'), 'index.php?m=agent');
            Plug_Location('index.php?m=agent');
            exit;
        }

        //如果用户是代理,则提示没有权限,请先登录。
        if ($this->user_array['user_daili'] == 0) {
            Plug_Alerts(Plug_Lang('你没有权限,请先登录。c'), 'index.php?m=agent');
            Plug_Location('index.php');
            exit;
        }

        //判断用户是否登录
        $login_log = Plug_User_Is_Login_Seesion();
        //如果用户未登录,则提示没有权限,请先登录。
        if ($login_log != 1047) {
            Plug_Alerts(Plug_Lang('你没有权限,请先登录。'), 'index.php?m=agent');
            Plug_Location('index.php');
            exit;
        }

        //判断用户等级
        $this->Grade = Plug_Agent_Detect_Grade($this->user_array);
        //判断用户是否有权限使用佣金日志查询功能
        Plug_Agent_Assert_Menu('commission_logs', $this->Grade, false);
    }

    function call_table()
    {
        Plug_Agent_Assert_Menu('commission_logs', $this->Grade, false);
        include Plug_Load_Default_Path();
    }

    function call_table_json()
    {
        Plug_Agent_Assert_Menu('commission_logs', $this->Grade, true);

        $soso = Plug_Set_Get('soso');
        $soso_id = (int)Plug_Set_Get('soso_id');
        $DESC_id = (int)Plug_Set_Get('DESC');
        $source = Plug_Set_Get('source');
        $DESC = $DESC_id == 1 ? 'ASC' : 'DESC';

        if ($soso_id == 2) {
            $soso_db_table = 'log_order';
        } elseif ($soso_id == 3) {
            $soso_db_table = 'log_desc';
        } else {
            $soso_db_table = 'log_remark';
        }

        $source_sql = '';
        if ($source == 'direct') {
            $source_sql = " AND `log_desc` LIKE '%消费%'";
        } elseif ($source == 'renew') {
            $source_sql = " AND `log_desc` LIKE '%续期%'";
        } elseif ($source == 'gencard') {
            $source_sql = " AND `log_desc` LIKE '%制卡购买%'";
        } elseif ($source == 'salecard') {
            $source_sql = " AND `log_desc` LIKE '%现卡购买%'";
        }

        $FANYE = (int)Plug_Set_Get('page');
        $shu = (int)Plug_Set_Get('limit');
        if ($shu == 0) $shu = 10;
        if ($FANYE > 0) {
            $db_ID = ($FANYE - 1) * $shu;
        } else {
            $db_ID = 0;
        }

        $self_user = $this->user_array['user_user'];
        $sql_count = "SELECT count(*) as hangshu, SUM(`log_amount`) as total_amount FROM `bs_php_yao_money_log` WHERE `log_user`='{$self_user}' {$source_sql} AND `{$soso_db_table}` LIKE '%{$soso}%'";
        $count_arr = Plug_Query_Array($sql_count);
        $zongshu = (int)$count_arr['hangshu'];
        $total_amount = isset($count_arr['total_amount']) ? (float)$count_arr['total_amount'] : 0;

        $sql = "SELECT * FROM `bs_php_yao_money_log` WHERE `log_user`='{$self_user}' {$source_sql} AND `{$soso_db_table}` LIKE '%{$soso}%' ORDER BY `id` {$DESC} LIMIT {$db_ID},{$shu}";
        $db_array_value = Plug_Query($sql);

        $rows = array();
        while ($v = Plug_Pdo_Fetch_Assoc($db_array_value)) {
            $row = array();
            $row['id'] = (int)$v['id'];
            $row['log_amount'] = (float)$v['log_amount'];
            $row['log_level'] = $v['log_level'];
            $row['log_order'] = $v['log_order'];
            $row['log_desc'] = $v['log_desc'];
            $row['log_remark'] = $v['log_remark'];
            $row['log_date'] = date('Y-m-d H:i', (int)$v['log_date']);
            $row['log_status_show'] = ((int)$v['log_status'] == 2) ? Plug_Lang('已收回') : Plug_Lang('已经分佣金');
            $rows[] = $row;
        }

        Plug_Print_Json(array(
            'data' => $rows,
            'code' => 0,
            'msg' => '',
            'count' => $zongshu,
            'extra' => array(
                'total_amount' => $total_amount
            )
        ));
    }
}
