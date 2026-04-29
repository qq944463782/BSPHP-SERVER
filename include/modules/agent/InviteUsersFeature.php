<?php
/*
 * Feature: 邀请推广用户
 * Menu ID: invite_users
 * 说明: 邀请推广页与用户列表接口，统一执行菜单权限校验。
 */
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT') {
    die('Not,This File Not Can in Ie Modules');
}

class InviteUsersFeature
{
    public $GLOBALS_LANGS, $user_array, $user_str_log, $Grade;

    function __construct()
    {
        //开启会话 seesion
        plug_session_open();
        //加载用户语言包
        $this->user_str_log = Plug_Load_Langs_Array('user', 'user_str_log');

        //判断是否开启代理,不是代理就禁止使用
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
        //判断用户是否有权限使用邀请推广用户功能
        Plug_Agent_Assert_Menu('invite_users', $this->Grade, false);
    }

    function call_table()
    {
        Plug_Agent_Assert_Menu('invite_users', $this->Grade, false);
        include Plug_Load_Default_Path();
    }
}
