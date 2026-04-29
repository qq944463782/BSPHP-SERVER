<?php
/*
 * Feature: 解除用户绑定
 * Menu ID: unbind_user
 * 说明: 账户/卡特征解绑与重绑入口页，统一执行菜单权限校验。
 */
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT') {
    die('Not,This File Not Can in Ie Modules');
}

class UnbindUserFeature
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
        //如果用户信息不存在,则提示没有权限,请先登录。
        if (!$this->user_array) {
            Plug_Alerts(Plug_Lang('你没有权限,请先登录。没有权限请授权使用.'), 'index.php?m=agent');
            Plug_Location('index.php?m=agent');
            exit;
        }

        //如果用户是代理,则提示没有权限,请先登录。
        if ($this->user_array['user_daili'] == 0) {
            Plug_Alerts(Plug_Lang('你没有权限,请先登录。'), 'index.php?m=agent');
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
        //判断用户是否有权限使用解除用户绑定功能
        Plug_Agent_Assert_Menu('unbind_user', $this->Grade, false);
    }

    function call_table()
    {
        Plug_Agent_Assert_Menu('unbind_user', $this->Grade, false);

        $appenconfig = Plug_Set_Post('appenconfig');
        $daihao = (int)Plug_Set_Post('daihao');
        $user = trim(Plug_Set_Post('user'));
        $key = trim(Plug_Set_Post('key'));

        if ($appenconfig) {
            if ($daihao <= 0) {
                Plug_Print_Json(array('code' => 1, 'msg' => Plug_Lang('请选择软件')));
            }
            if ($user == '') {
                Plug_Print_Json(array('code' => 1, 'msg' => Plug_Lang('请输入账户/卡')));
            }

            $app_in = Plug_Get_Agent_Appinfo_Array($this->user_array['user_uid']);
            $app_sql = "SELECT `app_daihao` FROM `bs_php_appinfo` WHERE `app_daihao` = '{$daihao}' AND `app_daihao` {$app_in} LIMIT 1";
            $allow_app = Plug_Query_Array($app_sql);
            if (!$allow_app) {
                Plug_Print_Json(array('code' => 1, 'msg' => Plug_Lang('无权操作该软件')));
            }

            $sql = "SELECT * FROM `bs_php_pattern_login` WHERE `L_daihao` = '{$daihao}' AND (`L_ic_name` = '{$user}' OR `L_User_uid` = '{$user}') LIMIT 1";
            $pattern_login = Plug_Query_Array($sql);
            if (!$pattern_login) {
                Plug_Print_Json(array('code' => 1, 'msg' => Plug_Lang('帐户/卡号不存在')));
            }

            if ($pattern_login['L_key_info'] == '' && $key == '') {
                Plug_Print_Json(array('code' => 1, 'msg' => Plug_Lang('当前没有绑定,无需解绑.')));
            }

            $sql = "UPDATE `bs_php_pattern_login` SET `L_key_info` = '{$key}' WHERE `L_id` = '{$pattern_login['L_id']}'";
            $tmp = Plug_Query($sql);
            if ($tmp) {
                Plug_Print_Json(array('code' => 1, 'msg' => Plug_Lang('操作成功.')));
            } else {
                Plug_Print_Json(array('code' => 1, 'msg' => Plug_Lang('操作失败.')));
            }
        }

        $app_in = Plug_Get_Agent_Appinfo_Array($this->user_array['user_uid']);
        $sql = "SELECT DISTINCT `bs_php_appinfo`.`app_daihao`,`bs_php_appinfo`.`app_name` FROM `bs_php_appinfo` WHERE `bs_php_appinfo`.`app_daihao` {$app_in} ORDER BY `bs_php_appinfo`.`app_daihao` ASC";
        $app_list = Plug_Query($sql);

        include Plug_Load_Default_Path();
    }
}
