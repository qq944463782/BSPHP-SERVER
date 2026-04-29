<?php
/*
 * Feature: 卡通过账号统计
 * Menu ID: card_account_stats
 * 说明: 财务卡账号统计页，统一执行菜单权限校验。
 */
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT') die('Not,This File Not Can in Ie Modules');

class CardAccountStatsFeature
{
    public $Grade,  $user_array, $user_str_log;

    function __construct()
    {
        //开启会话 seesion
        plug_session_open();
        //加载用户语言包
        $this->user_str_log = Plug_Load_Langs_Array('user', 'user_str_log');

        //判断是否开启代理,不是代理就禁止使用
        if (Plug_Get_Configs_Value('sys', 'stop_agent') == 0) {
            Plug_alerts(Plug_Lang('系统维护中'), Plug_Get_Configs_Value('sys', 'stop_agent_info'));
            exit;
        }

        //获取会话中的用户UID
        $USER_UID = Plug_Get_Session_Value('USER_UID');
        //根据用户UID查询用户信息
        $this->user_array = Plug_Query_Array("SELECT * FROM bs_php_user WHERE user_uid = '{$USER_UID}'");
        if (!$this->user_array || $this->user_array['user_daili'] == 0) {
            Plug_Alert(Plug_Lang('你没有权限,请先登录。'));
            Plug_Location('index.php');
            exit;
        }

        //判断用户是否登录
        $login_log = Plug_User_Is_Login_Seesion();
        if ($login_log != 1047) {
            Plug_Alert(Plug_Lang('你没有权限,请先登录。'));
            Plug_Location('index.php');
            exit;
        }

        //判断用户等级
        $this->Grade = Plug_Agent_Detect_Grade($this->user_array);
        //判断用户是否有权限使用卡通过账号统计功能
        Plug_Agent_Assert_Menu('card_account_stats', $this->Grade, false);
    }

    function call_table()
    {
        Plug_Agent_Assert_Menu('card_account_stats', $this->Grade, false);

        $get_agent_appinfo_array = Plug_get_agent_appinfo_array($this->user_array['user_uid']);
        $sql = "SELECT  `app_daihao` ,  `app_name` ,  `app_MoShi` FROM  `bs_php_appinfo` WHERE `bs_php_appinfo`.`app_daihao`{$get_agent_appinfo_array}  LIMIT 0 , 30";
        $db_array_value_app = Plug_Query($sql);

        $carsys_arr = Plug_Load_Langs_Array('applib', 'admin_card');
        $daihao = Plug_Set_Get('daihao');
        $date1 = Plug_Set_Get('date1');
        $date2 = Plug_Set_Get('date2');
        $soso = Plug_Set_Get("soso");
        $soso2 = Plug_Set_Get("soso2");

        if ($daihao > 0) {
            $app_array = call_my_get_appdaihao_info_array($daihao);
            $app_name = $app_array['app_name'];
            $app_daihao = $app_array['app_daihao'];
        }

        include Plug_Load_Default_Path();
    }

    /**
     * 选择代理弹窗
     */
    function call_agent_list()
    {
        Plug_Agent_Assert_Menu('card_account_stats', $this->Grade, false);
        include Plug_Load_Default_Path();
    }

    /**
     * 选择代理弹窗数据
     */
    function call_agent_list_json()
    {
        Plug_Agent_Assert_Menu('card_account_stats', $this->Grade, true);

        $FANYE = (int)Plug_Set_Get('page');
        if ($FANYE > 0) {
            $db_ID = $FANYE - 1;
        } else {
            $db_ID = 0;
        }
        $shu = (int)Plug_Set_Get('limit');
        if ($shu == 0) $shu = 10;
        $db_ID = $db_ID * $shu;

        $soso = Plug_Set_Get('soso');
        $soso_id = (int)Plug_Set_Get('soso_id');
        $DESC_id = (int)Plug_Set_Get('DESC');
        $DESC_id == 1 ? $DESC = 'ASC' : $DESC = 'DESC';

        if ($soso_id == 2) {
            $soso_db_table = 'user_uid';
        } elseif ($soso_id == 5) {
            $soso_db_table = 'user_Zhe';
        } elseif ($soso_id == 7) {
            $soso_db_table = 'user_IsLock';
            $soso = '1';
        } elseif ($soso_id == 8) {
            $soso_db_table = 'user_IsLock';
            $soso = '0';
        } elseif ($soso_id == 15) {
            $soso_db_table = 'user_rmb';
        } elseif ($soso_id == 16) {
            $soso_db_table = 'user_LoGinNum';
        } elseif ($soso_id == 18) {
            $soso_db_table = 'user_anget_beizhu';
        } else {
            $soso_db_table = 'user_user';
        }

        if ($soso_id == 15 || $soso_id == 16) {
            $sql = "SELECT * FROM `bs_php_user` WHERE `user_yao_User`='{$this->user_array['user_uid']}' AND user_daili > 0 AND `{$soso_db_table}`>='{$soso}' ORDER BY `user_uid` {$DESC} LIMIT {$db_ID},{$shu} ;";
            $sql_rows = "SELECT count(*)as'hangshu' FROM `bs_php_user` WHERE `user_yao_User`='{$this->user_array['user_uid']}' AND user_daili > 0 AND `{$soso_db_table}`>='{$soso}';";
        } else {
            $sql = "SELECT * FROM `bs_php_user` WHERE `user_yao_User`='{$this->user_array['user_uid']}' AND user_daili > 0 AND `{$soso_db_table}` LIKE '%{$soso}%' ORDER BY `user_uid` {$DESC} LIMIT {$db_ID},{$shu} ;";
            $sql_rows = "SELECT count(*)as'hangshu' FROM `bs_php_user` WHERE `user_yao_User`='{$this->user_array['user_uid']}' AND user_daili > 0 AND `{$soso_db_table}` LIKE '%{$soso}%';";
        }

        $count_arr = Plug_Query_Array($sql_rows);
        $count = (int)$count_arr['hangshu'];
        $res = Plug_Query($sql);

        $array_s = array('0', Plug_Lang('一'), Plug_Lang('二'), Plug_Lang('三'), Plug_Lang('四'));
        $rows = array();
        while ($v = Plug_Pdo_Fetch_Assoc($res)) {
            if ((int)$v['user_daili'] == 0) {
                $daili_text = Plug_Lang('普通用户');
            } else {
                $daili_text = $array_s[(int)$v['user_daili']] . Plug_Lang('级代理商');
            }
            $rows[] = array(
                'uid' => (int)$v['user_uid'],
                'user' => (string)$v['user_user'],
                'level' => $daili_text,
                'parent' => (string)$v['user_yao_User'],
            );
        }

        Plug_Print_Json(array(
            'code' => 0,
            'msg' => '',
            'count' => $count,
            'data' => $rows
        ));
    }
}
