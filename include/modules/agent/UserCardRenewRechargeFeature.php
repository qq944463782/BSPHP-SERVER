<?php
/*
 * Feature: 用户卡密续费充值
 * Menu ID: user_card_renew_recharge
 * 说明: 代理用户为账号/卡号执行续费充值，并支持卡号是否需要密码检测。
 */
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT') {
    die('Not,This File Not Can in Ie Modules');
}

class UserCardRenewRechargeFeature
{
    public $Grade, $GLOBALS_LANGS, $user_array, $user_str_log;

    function __construct()
    {
        plug_session_open();
        $this->user_str_log = Plug_Load_Langs_Array('user', 'user_str_log');

        if (Plug_Get_Configs_Value('sys', 'stop_agent') == 0) {
            Plug_alerts(Plug_Lang('系统维护中'), Plug_Get_Configs_Value('sys', 'stop_agent_info'));
            exit;
        }

        $user_UID = Plug_Get_Session_Value('USER_UID');
        $this->user_array = Plug_Query_Array("SELECT * FROM bs_php_user WHERE user_uid = '{$user_UID}'");
        if (!$this->user_array) {
            Plug_Alerts(Plug_Lang('你没有权限,请先登录。没有权限请授权使用.'), 'index.php?m=agent');
            Plug_Location('index.php?m=agent');
            exit;
        }

        if ($this->user_array['user_daili'] == 0) {
            Plug_Alerts(Plug_Lang('你没有权限,请先登录。'), 'index.php?m=agent');
            Plug_Location('index.php');
            exit;
        }

        $login_log = Plug_User_Is_Login_Seesion();
        if ($login_log != 1047) {
            Plug_Alerts(Plug_Lang('你没有权限,请先登录。'), 'index.php?m=agent');
            Plug_Location('index.php');
            exit;
        }

        if (Plug_Get_Session_Value('USER_UID_IS') == 0) {
            Plug_ShowMsg(Plug_Lang("代理中心未授权,请授权在使用."), '');
            Plug_Set_Session_Value('USER_UID', 'Not');
            exit;
        }

        $this->Grade = Plug_Agent_Detect_Grade($this->user_array);
        Plug_Agent_Assert_Menu('user_card_renew_recharge', $this->Grade, false);
    }

    function call_table()
    {
        Plug_Agent_Assert_Menu('user_card_renew_recharge', $this->Grade, false);

        $Submitadd = Plug_Set_Post('Submitadd');
        $ajax_submit = (int)Plug_Set_Post('ajax_submit');
        $user_user = trim((string)Plug_Set_Post('user_user'));
        $ka_name = trim((string)Plug_Set_Post('ka_name'));
        $ka_pwd = trim((string)Plug_Set_Post('ka_pwd'));
        $log_name = '';

        if ($Submitadd) {
            if ($user_user == '') {
                $log_name = Plug_Lang('充值帐户/卡号不能为空');
            } elseif ($ka_name == '') {
                $log_name = Plug_Lang('充值卡号不能为空');
            } else {
                $log = Plug_User_Chong($user_user, $ka_name, $ka_pwd);
                $log_name = isset($this->user_str_log[$log]) ? $this->user_str_log[$log] : Plug_Lang('操作完成');
            }

            if ($ajax_submit === 1) {
                $ok = 0;
                if ($user_user != '' && $ka_name != '') {
                    $ok = 1;
                }
                Plug_Print_Json(array('code' => $ok ? 0 : 1, 'msg' => $log_name));
            }
        }

        include Plug_Load_Default_Path();
    }

    function call_checkcardpwd()
    {
        Plug_Agent_Assert_Menu('user_card_renew_recharge', $this->Grade, false);

        $ka_name = trim((string)Plug_Set_Post('ka_name'));
        if ($ka_name == '') {
            Plug_Print_Json(array('code' => 1, 'exists' => 0, 'need_password' => 0, 'msg' => Plug_Lang('请输入卡号')));
        }

        $sql = "SELECT `car_pwd` FROM `bs_php_cardseries` WHERE `car_name` = '{$ka_name}' LIMIT 1";
        $card = Plug_Query_Array($sql);
        if (!$card) {
            Plug_Print_Json(array('code' => 1, 'exists' => 0, 'need_password' => 0, 'msg' => Plug_Lang('卡号不存在')));
        }

        $need_password = (trim((string)$card['car_pwd']) !== '') ? 1 : 0;
        Plug_Print_Json(array('code' => 0, 'exists' => 1, 'need_password' => $need_password, 'msg' => 'ok'));
    }
}
