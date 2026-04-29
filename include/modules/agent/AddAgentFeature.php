<?php
/*
 * Feature: 添加新代理
 * Menu ID: add_agent
 * 说明: 添加下级代理入口页，统一执行菜单权限校验。
 */
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT') die('Not,This File Not Can in Ie Modules');

class AddAgentFeature
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
        $user_UID = Plug_Get_Session_Value('USER_UID');
        //根据用户UID查询用户信息
        $this->user_array = Plug_Query_Array("SELECT * FROM bs_php_user WHERE user_uid = '{$user_UID}'");
        if (!$this->user_array) {
            Plug_Alerts(Plug_Lang('你没有权限,请先登录。没有权限请授权使用.'), 'index.php?m=agent');
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
            Plug_Alerts(Plug_Lang('你没有权限,请先登录a。'), 'index.php?m=agent');
            Plug_Location('index.php');
            exit;
        }

        //判断用户是否授权
        if (Plug_Get_Session_Value('USER_UID_IS') == 0) {
            Plug_ShowMsg(Plug_Lang("代理中心未授权,请授权在使用b."), '');
            Plug_Set_Session_Value('USER_UID', 'Not');
            exit;
        }

        //判断用户等级
        $this->Grade = Plug_Agent_Detect_Grade($this->user_array);
        //判断用户是否有权限使用添加新代理功能
        Plug_Agent_Assert_Menu('add_agent', $this->Grade, false);
    }

    function call_table()
    {
        Plug_Agent_Assert_Menu('add_agent', $this->Grade, false);

        $baocun = Plug_Set_Post('appenconfig');
        if ($baocun) {
            if ($this->user_array['user_daili'] == 3) {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("你无权添加代理商。")));
            }

            $user = Plug_Set_Post('user');
            $pwd = Plug_Set_Post('pwd');
            $qq = Plug_Set_Post('qq');
            $mail = Plug_Set_Post('mail');
            $xiaji = (int)Plug_Set_Post('xiaji');
            $mobile = Plug_Set_Post('mobile');

            if (is_numeric($user) == true) {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("不要使用纯数字做为账号.")));
            }

            $yao_user = $this->user_array['user_uid'];
            $log = Plug_User_Add_User($user, $pwd, $pwd, $qq, $mail, $yao_user, $mobile);

            if ($xiaji == 1) {
                $dengji = 3;
            } else {
                $dengji = 2;
            }

            if ($log == 1005 or $log == 1107) {
                $sql = "UPDATE `bs_php_user`SET`user_daili`='{$dengji}',`user_anget_carid`='{$this->user_array['user_anget_carid']}' WHERE `bs_php_user`.`user_user`='{$user}';";
                Plug_Query($sql);
            }

            Plug_Print_Json(array('code' => '1', 'msg' => '[' . $log . ']' . $this->user_str_log[$log]));
        }

        include Plug_Load_Default_Path();
    }
}
