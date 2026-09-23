<?php
/*
 * Feature: 我的用户
 * Menu ID: my_users_table
 * 说明: 我的用户列表页与 JSON 数据接口，统一执行菜单权限校验。
 */
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT') {
    die('Not,This File Not Can in Ie Modules');
}

class MyUsersTableFeature
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
        //判断用户是否有权限使用我的用户列表功能
        Plug_Agent_Assert_Menu('my_users_table', $this->Grade, false);
    }

    function call_table()
    {
        Plug_Agent_Assert_Menu('my_users_table', $this->Grade, false);

        $Submit_class = Plug_Set_Post('Submit_class');
        $all = Plug_Set_Post('all');
        $select_class = Plug_Set_Post('select_class');

        if ($Submit_class) {
            if ($select_class == 2) {
                $txt = Plug_Set_Post('txt');
                $sql = "UPDATE `bs_php_user` SET `user_anget_beizhu`='{$txt}' WHERE `user_uid` in ({$all}) AND `user_yao_User`='{$this->user_array['user_uid']}' AND `user_daili`='0';";
                Plug_Query($sql);
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang('备注修改成功')));
            } elseif ($select_class == 5) {
                $txt = Plug_Set_Post('txt');
                if ($txt === '' || $txt === null) {
                    Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang('密码不能为空')));
                }
                if (set32($txt)) {
                    Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang('密码含有非法字符')));
                }
                if (strlen($txt) < 2 || strlen($txt) > 14) {
                    Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang('密码长度必须在2-14位')));
                }
                $txt = intelligence_password_md6($txt);
                $sql = "UPDATE `bs_php_user` SET `user_pwd`='{$txt}' WHERE `user_uid` in ({$all}) AND `user_yao_User`='{$this->user_array['user_uid']}' AND `user_daili`='0';";
                Plug_Query($sql);
                Plug_Add_AppenLog('od_po_log', Plug_Lang('代理修改用户密码') . ' UID:' . $all . ' 操作人:' . $this->user_array['user_user'] . '(' . $this->user_array['user_uid'] . ')', $this->user_array['user_user']);
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang('密码修改成功')));
            } elseif ($select_class == 3) {
                $sql = "UPDATE `bs_php_user` SET `user_IsLock`='1' WHERE `user_uid` in ({$all}) AND `user_yao_User`='{$this->user_array['user_uid']}' AND `user_daili`='0';";
                Plug_Query($sql);
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang('冻结成功')));
            } elseif ($select_class == 4) {
                $sql = "UPDATE `bs_php_user` SET `user_IsLock`='0' WHERE `user_uid` in ({$all}) AND `user_yao_User`='{$this->user_array['user_uid']}' AND `user_daili`='0';";
                Plug_Query($sql);
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang('解封成功')));
            } else {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang('你没有选择操作项目')));
            }
        }

        include Plug_Load_Default_Path();
    }

    function call_table_json()
    {
        Plug_Agent_Assert_Menu('my_users_table', $this->Grade, true);

        $FANYE = (int)Plug_Set_Get('page');
        $db_ID = $FANYE > 0 ? $FANYE - 1 : 0;
        $shu = (int)Plug_Set_Get('limit');
        if ($shu == 0) $shu = 10;
        $db_ID = $db_ID * $shu;

        $soso = Plug_Set_Get('soso');
        $soso_id = (int)Plug_Set_Get('soso_id');
        $DESC_id = (int)Plug_Set_Get('DESC');
        $DESC = $DESC_id == 1 ? 'ASC' : 'DESC';

        if ($soso_id == 2) $soso_db_table = 'user_uid';
        elseif ($soso_id == 5) $soso_db_table = 'user_Zhe';
        elseif ($soso_id == 7) {
            $soso_db_table = 'user_IsLock';
            $soso = '1';
        } elseif ($soso_id == 8) {
            $soso_db_table = 'user_IsLock';
            $soso = '0';
        } elseif ($soso_id == 15) $soso_db_table = 'user_rmb';
        elseif ($soso_id == 16) $soso_db_table = 'user_LoGinNum';
        elseif ($soso_id == 18) $soso_db_table = 'user_anget_beizhu';
        else $soso_db_table = 'user_user';

        if ($soso_id == 15 || $soso_id == 16) {
            $sql = "SELECT * FROM `bs_php_user` WHERE `user_yao_User`='{$this->user_array['user_uid']}' AND `user_daili`='0' AND `{$soso_db_table}`>='{$soso}' ORDER BY `user_uid` {$DESC} LIMIT {$db_ID},{$shu};";
            $sql_rows = "SELECT count(*) as 'hangshu' FROM `bs_php_user` WHERE `user_yao_User`='{$this->user_array['user_uid']}' AND `user_daili`='0' AND `{$soso_db_table}`>='{$soso}';";
        } else {
            $sql = "SELECT * FROM `bs_php_user` WHERE `user_yao_User`='{$this->user_array['user_uid']}' AND `user_daili`='0' AND `{$soso_db_table}` LIKE '%{$soso}%' ORDER BY `user_uid` {$DESC} LIMIT {$db_ID},{$shu};";
            $sql_rows = "SELECT count(*) as 'hangshu' FROM `bs_php_user` WHERE `user_yao_User`='{$this->user_array['user_uid']}' AND `user_daili`='0' AND `{$soso_db_table}` LIKE '%{$soso}%';";
        }

        $db_array_value = Plug_Query($sql);
        $my_rows_array = Plug_Query_Array($sql_rows);
        $zongshu = (int)$my_rows_array['hangshu'];
        $user_extra_defs = Plug_User_Extra_Fields_For_List();

        $while_array_list_all = array();
        while ($value = Plug_Pdo_Fetch_Assoc($db_array_value)) {
            if ($value['user_IsLock'] == 1) $test = Plug_Lang('冻结');
            elseif ($value['user_IsLock'] == -2) $test = Plug_Lang('等待管理审核');
            elseif ($value['user_IsLock'] == -3) $test = Plug_Lang('等待邮箱验证');
            else $test = Plug_Lang('正常');

            $zaix = Plug_Show_Time_Day(date('Y-m-d H:i:s', $value['user_CaoShi']));
            if ($value['user_CaoShi'] == 0) $zaix = Plug_Lang('没记录');

            $value['user_re_date'] = Plug_Show_Time_Day($value['user_re_date']);
            $daili_name = $value['user_daili'] == 0 ? Plug_Lang('普通用户') : Plug_Lang('代理用户');

            $while_array_list = array();
            $while_array_list['key'] = $value['user_uid'];
            $while_array_list['uid'] = $value['user_uid'];
            $while_array_list['user'] = $value['user_user'];
            $while_array_list['daili'] = $daili_name;
            $while_array_list['test'] = $test;
            $while_array_list['LoGinNum'] = $value['user_LoGinNum'];
            $while_array_list['rmb'] = $value['user_rmb'];
            $while_array_list['re_date'] = $value['user_re_date'];
            $while_array_list['zhhd'] = $zaix;
            $while_array_list['agent_beizhu'] = $value['user_anget_beizhu'];
            $ue_row = Plug_User_Extra_Parse(isset($value['user_extra']) ? (string)$value['user_extra'] : '');
            foreach ($user_extra_defs as $ue_def) {
                $ue_key = $ue_def['key'];
                $while_array_list['ue_' . $ue_key] = isset($ue_row[$ue_key]) ? (string)$ue_row[$ue_key] : '';
            }
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
