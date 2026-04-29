<?php
/*
 * Feature: 余额充值
 * Menu ID: balance_recharge
 * 说明: 代理余额充值入口页，统一执行菜单权限校验。
 */
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT') die('Not,This File Not Can in Ie Modules');

class BalanceRechargeFeature
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
        //判断用户是否有权限使用余额充值功能
        Plug_Agent_Assert_Menu('balance_recharge', $this->Grade, false);
    }

    function call_table()
    {
        Plug_Agent_Assert_Menu('balance_recharge', $this->Grade, false);

        $path = Plug_Get_Bsphp_Dir() . 'include/modules/payment/paycood';
        $dir_array = Plug_Open_List_Dir($path);
        $count = count($dir_array);
        $i = 0;
        $html = '';
        $pay_index = 0;
        while ($i < $count) {
            $file = $path . '/' . $dir_array[$i] . '/form_config.php';
            if (file_exists($file)) {
                $form_array = include($file);
                if (isset($form_array['pay_config'])) {
                    if (Plug_Get_Configs_Value('pay_' . $form_array['pay_config']['name'], 'pay_' . $form_array['pay_config']['name'] . '_set') == 0) {
                        $checked = ($pay_index === 0) ? " checked" : "";
                        $pay_name = $form_array['pay_config']['name'];
                        $pay_label = htmlspecialchars($form_array['pay_config']['label']);
                        $pay_url = htmlspecialchars($form_array['pay_config']['url']);
                        $html .= "<label class='pay-method-card' for='pay_leixing_{$pay_index}' onclick=\"var r=this.querySelector('.pay-method-radio');if(r){r.checked=true;if(document.createEvent){var e=document.createEvent('HTMLEvents');e.initEvent('change',true,false);r.dispatchEvent(e);}else if(r.fireEvent){r.fireEvent('onchange');}}\">
        <input id='pay_leixing_{$pay_index}' class='pay-method-radio' name='pay_leixing' type='radio' value='{$pay_name}'{$checked} />
        <span class='pay-method-logo-wrap'><img class='pay-method-logo' src='{$pay_url}' alt='{$pay_label}' /></span>
        </label>";
                        $pay_index++;
                    }
                }
            }
            $i++;
        }

        include Plug_Load_Default_Path();
    }
}
