<?php
/*
 * Feature: 卡账号备注统计
 * Menu ID: card_account_note_stats
 * 说明: 财务卡账号备注统计页，统一执行菜单权限校验。
 */
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT') die('Not,This File Not Can in Ie Modules');

class CardAccountNoteStatsFeature
{
    public $Grade, $GLOBALS_LANGS, $user_array, $user_str_log;

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
        //如果用户未登录,则提示没有权限,请先登录。
        if ($login_log != 1047) {
            Plug_Alert(Plug_Lang('你没有权限,请先登录。'));
            Plug_Location('index.php');
            exit;
        }

        //判断用户等级
        $this->Grade = Plug_Agent_Detect_Grade($this->user_array);
        //判断用户是否有权限使用卡账号备注统计功能
        Plug_Agent_Assert_Menu('card_account_note_stats', $this->Grade, false);
    }

    function call_table()
    {
        Plug_Agent_Assert_Menu('card_account_note_stats', $this->Grade, false);

        $soso_id = Plug_Set_Get('soso_id');
        $date1 = Plug_Set_Get('date1');
        $date2 = Plug_Set_Get('date2');
        $date_type = Plug_Set_Get('date_type');
        $soso = Plug_Set_Get('soso');
        $soso_user = Plug_Set_Get('soso_user');
        $daihao = Plug_Set_Get('daihao');
        $soso_beizhu = Plug_Set_Get('soso_beizhu');

        $get_agent_appinfo_array = Plug_get_agent_appinfo_array($this->user_array['user_uid']);
        $sql = "SELECT  `app_daihao` ,  `app_name` ,  `app_MoShi` FROM  `bs_php_appinfo` WHERE `bs_php_appinfo`.`app_daihao`{$get_agent_appinfo_array}  LIMIT 0 , 30";
        $db_array_value_app = Plug_Query($sql);

        include Plug_Load_Default_Path();
    }
}
